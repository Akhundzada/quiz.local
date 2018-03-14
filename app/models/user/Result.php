<?php
namespace Quiz\User;
use Quiz\Utility\Base;

class Result extends Base
{
    public function initialize()
    {
        $this->setSource ('user_result');
        $this->belongsTo ('quiz_id', 'Quiz\Quiz\Quiz', 'id', ['alias' => 'quiz']);
    }
}