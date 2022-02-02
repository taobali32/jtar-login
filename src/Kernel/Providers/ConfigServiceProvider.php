<?php


namespace Jtar\Kernel\Providers;

use Jtar\Kernel\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple
     * @return void
     */
    public function register(Container $pimple)
    {
        !isset($pimple['config']) && $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}