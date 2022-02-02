<?php


namespace Jtar;

use Jtar\Kernel\Support\Str;


/**
 * Class Factory
 * @package Jtar\Auth
 * @method static \Jtar\Auth\Application auth(array $config)
 * @method static \Jtar\Sms\Application sms(array $config)
 */
class Factory{
    /**
     * @param $name
     * @param array $config
     *
     * @return mixed
     */
    public static function make($name, array $config)
    {
        $namespace = Str::studly($name);
        $application = "\\Jtar\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}