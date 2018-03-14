<?php
trait Timestampable
{
    public $created_at, $updated_at;

    public function beforeCreate()
    {
        $this->created_at           = time();
    }

    public function beforeUpdate()
    {
        $this->updated_at           = time();
    }
}