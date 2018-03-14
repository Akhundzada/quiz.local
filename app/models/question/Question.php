<?php
namespace Quiz\Question;
use Quiz\Answer\Answer;
use Quiz\Utility\Base;

class Question extends Base
{
    const MAX_QUESTION_PER_QUIZ     = 30;

    public function initialize()
    {
        $this->setSource ('question');
        $this->belongsTo('quiz_id', 'Quiz\Quiz\Quiz', 'id', ['alias' => 'quiz']);
        $this->hasMany ('id', 'Quiz\Answer\Answer', 'question_id', ['alias' => 'answer']);
    }

    public function createFakeQuestion (int $quizId)
    {
        $this->save (['quiz_id' => $quizId, 'name' => 'Some Question']);
        (new Answer())->createFakeAnswers($this->id);
        $this->fakeMarkAnswerAsCorrect($this->id);
        return $this;
    }

    public function fakeMarkAnswerAsCorrect (int $questionId)
    {
        if (!$question = self::findFirst ($questionId)) throw new \QuestionException('Question does not exists');
        if (!empty ($question->correct_answer_id)) throw new \QuestionException('Question already specified correct answer');
        if ($question->answer->count() == 0) throw new \QuestionException('Question does not specified answers');

        $answerIds          = array_map (function ($v){ return $v['id']; }, $question->answer->toArray());
        $correctAnswerId    = $answerIds[array_rand ($answerIds)];

        $question->correct_answer_id    = $correctAnswerId;
        $question->save();
    }
}