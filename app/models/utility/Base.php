<?php
namespace Quiz\Utility;
use Phalcon\Mvc\Model;

class Base extends Model
{
    const DEFAULT_PAGE_LIMIT    = 10;

    final public function getDb()
    {
        return $this->getDI()->get('db');
    }
}