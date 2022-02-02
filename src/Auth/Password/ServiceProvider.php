<?php


namespace Jtar\Auth\Password;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 *
 * @property \Jtar\Auth\Password\Handle                           $password
 * @package Jtar\Auth\Password
 */
class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @param Container $app
     * @return void
     */
    public function register(Container $app)
    {
        $app['password'] = function ($app) {
            return new Handle($app);
        };
    }
}