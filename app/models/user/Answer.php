<?php
namespace Quiz\User;
use Quiz\Utility\Base;

class Answer extends Base
{
    public function initialize()
    {
        $this->setSource ('user_answer');
        $this->belongsTo ('quiz_id', 'Quiz\Quiz\Quiz', 'id', ['alias' => 'quiz']);
        $this->belongsTo ('question_id', 'Quiz\Question\Question', ['alias' => 'question']);
        $this->belongsTo ('user_answer_id', 'Quiz\Answer\Answer', ['alias' => 'answer']);
    }
}