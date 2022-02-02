<?php


namespace Jtar\Auth\Code;



use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 *
 * @property \Jtar\Auth\Code\Handle                           $code
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
        $app['code'] = function ($app) {
            return new Handle($app);
        };
    }
}