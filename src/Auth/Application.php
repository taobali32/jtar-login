<?php


namespace Jtar\Auth;


use Jtar\Auth\Password\ServiceProvider;
use Jtar\Kernel\ServiceContainer;

/**
 * Class Application
 * @property \Jtar\Auth\Password\Handle                        $password
 * @property \Jtar\Auth\Code\Handle                            $code
 * @package Jtar\Auth
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        ServiceProvider::class,
        \Jtar\Auth\Code\ServiceProvider::class
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