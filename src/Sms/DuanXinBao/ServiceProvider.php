<?php


namespace Jtar\Sms\DuanXinBao;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 *
 * @property \Jtar\Sms\DuanXinBao\Handle                           $sms_dxb
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     * @return void
     */
    public function register(Container $app)
    {
        $app['d_x_b'] = function ($app) {
            return new Handle($app);
        };
    }
}