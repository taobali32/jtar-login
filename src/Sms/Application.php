<?php


namespace Jtar\Sms;


use Jtar\Kernel\ServiceContainer;
use Jtar\Sms\DuanXinBao\ServiceProvider;

/**
 * Class Application
 * @property \Jtar\Sms\DuanXinBao\Handle                        $d_x_b
 * @package Jtar\Auth
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        ServiceProvider::class
    ];

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this['base'],$name],$arguments);
    }
}