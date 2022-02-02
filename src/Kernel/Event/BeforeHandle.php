<?php

namespace Jtar\Kernel\Event;


class BeforeHandle
{
    public $param;

    public function __construct($param = [])
    {
        $this->param = $param;
    }
}