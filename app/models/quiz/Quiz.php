<?php
namespace Quiz\Quiz;
use Phalcon\Mvc\Model;
use Quiz\Question\Question;
use Quiz\User\Answer;
use Quiz\User\Result;
use Quiz\Utility\Base;

class Quiz extends Base
{

    public function initialize()
    {
        $this->setSource ('quiz');
        $this->hasMany ('id', 'Quiz\Question\Question', 'quiz_id', ['alias' => 'question']);
    }

    public function createQuiz (array $data): bool {}

    /**
     * @param array $data
     * @return bool
     * @throws \QuizException
     * We are not using Phalcon's Validation system because of that there are too few fields for this.
     */

    public function createFakeQuiz (array $data): bool
    {
        if (!empty ($data['question_count']) && is_numeric ($data['question_count']) && $data['question_count'] > 0 && !empty ($data['name']))
        {
            if ($data['question_count'] > Question::MAX_QUESTION_PER_QUIZ) throw new \QuizException('You can not specify more than ' . Question::MAX_QUESTION_PER_QUIZ . ' questions per quiz');

            $this->save (['name' => $data['name']]);

            for ($i = 0; $i < $data['question_count']; $i++)
            {
                $question   = new Question();
                $question->createFakeQuestion ($this->id);
            }
            return true;
        }
        throw new \QuizException('Unknown or incorrect question_count');
    }
    public function deleteQuiz (int $quizId): bool
    {

    }

    public function getQuizById (int $quizId): Model
    {
        if (!$quiz = self::findFirst ($quizId)) throw new \QuizException('Quiz does not exists');
        if ($quiz->question->count() == 0) throw new \QuizException('Quiz does not has any questions');

        return $quiz;
    }

    public function getQuizList(): array
    {
        $quizList       = self::find();
        $return         = [];

        if ($quizList && $quizList->count() > 0)
        {
            foreach ($quizList as $quiz)
            {
                $return[] = $quiz; // Generator might be better, but wanted to use Phalcon's Paginator
            }
        }

        return $return;
    }

    public function examination (int $quizId, array $userAnswers)
    {
        if (!$quiz = self::findFirst ($quizId)) throw new \QuizException('Quiz does not exists');
        $correctAnswers = 0;

        foreach ($quiz->question as $question)
        {
            if ($question->correct_answer_id == $userAnswers[$question->id]) $correctAnswers++;
            (new Answer())->save (
                [
                    'quiz_id'           => $quizId,
                    'question_id'       => $question->id,
                    'user_answer_id'    => $userAnswers[$question->id],
                ]
            );
        }

        $score = $correctAnswers / $quiz->question->count() * 100;

        (new Result())->save (
            [
                'user_id'           => 1,
                'quiz_id'           => $quizId,
                'correct'           => $correctAnswers,
                'total'             => $quiz->question->count(),
                'score'             => $correctAnswers / $quiz->question->count() * 100,
            ]
        );

        return $score;

    }

    public function getUserScore(int $userId = 1)
    {
        if (!$result = Result::findFirst (['quiz_id = ?0 and user_id = ?1', 'bind' => [$this->id, $userId]])) return false;
        return ['correct' => $result->correct, 'total' => $result->total, 'score' => $result->score];
    }

    public function renderQuiz (int $quizId)
    {
        $quiz   = $this->getQuizById($quizId);
        $render = [];

        foreach ($quiz->question as $question)
        {
            foreach ($question->answer as $answer)
            {
                $render[$question->id][] = ['id' => $answer->id, 'name' => $answer->name];
            }
        }

        return $render;
    }


}