<?php

ini_set('display_errors',1);            //错误信息
ini_set('display_startup_errors',1);    //php启动错误信息
error_reporting(-1);                    //打印出所有的 错误信息

use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Event\ListenerProvider;
use Hyperf\Utils\ApplicationContext;
use Jtar\Kernel\Event\BeforeHandle;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
require  './vendor/autoload.php';


! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));


$container = new Container((new DefinitionSourceFactory(true))());

$container->set(ListenerProviderInterface::class,new ListenerProvider());
$container->set(EventDispatcherInterface::class,(new \Hyperf\Event\EventDispatcherFactory())($container));
$container->set(ConfigInterface::class,new Hyperf\Config\Config([]));

ApplicationContext::setContainer($container);

$listeners = [
    \Jtar\Listener\LoginHandleListener::class
];

$provider = $container->get(ListenerProviderInterface::class);

foreach ($listeners as $listener){

    $instance = $container->get($listener);

    if ($instance instanceof ListenerInterface) {
        foreach ($instance->listen() as $event) {
            $provider->on($event, [$instance, 'process'], 1);
        }
    }
}

$app = ApplicationContext::getContainer()->get(EventDispatcherInterface::class);

$app->dispatch(new BeforeHandle([11]));


var_dump(1111);
//  日志记录
//$arr = [
//    'username'  =>  '13243362307',
//    'password'  =>  123456
//];
//
//$zz = \Jtar\Factory::auth([1,2,3])->password()->login($arr);
