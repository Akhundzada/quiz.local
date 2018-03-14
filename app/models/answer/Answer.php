<?php
namespace Quiz\Answer;
use Quiz\Utility\Base;

class Answer extends Base
{
    const MIN_POSSIBLE_ANSWERS = 2;
    const MAX_POSSIBLE_ANSWERS = 5;

    public function initialize()
    {
        $this->setSource ('answer');
    }

    private function answerCodes(): array
    {
        return [
            'numeric'       => [1, 2, 3, 4, 5],
            'alpha'         => ['A', 'B', 'C', 'D', 'E'],
            'boolean'       => ['T', 'F'],
        ];
    }

    private function getAnswerCodeRandomCategory()
    {
        return $this->answerCodes()[array_rand($this->answerCodes())];
    }

    private function getRandomAnswerCode (array $category)
    {
        $length     = mt_rand (self::MIN_POSSIBLE_ANSWERS, self::MAX_POSSIBLE_ANSWERS);
        if (count ($category) == 2) return $category; // There can not be more than 2 answer in boolean category
        //if ($category != 'boolean' && $length == 2) return $this->answerCodes()['boolean']; // If there are only 1, 2 or A, B maybe turn them to True False?

        return array_slice ($category, 0, $length);
    }

    public function createFakeAnswers (int $questionId): bool
    {
        $answers    = $this->getRandomAnswerCode($this->getAnswerCodeRandomCategory());
        if (is_array ($answers) && count ($answers) > 0)
        {
            foreach ($answers as $answer)
            {
                (new Answer())->save (['question_id' => $questionId, 'name' => $answer]);
            }
        }
        return true;
    }
}