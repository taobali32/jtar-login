<?php


namespace Jtar\Kernel\Event;


class AfterHandle
{
    public $param;

    public function __construct($param = [])
    {
        $this->param = $param;
    }
}