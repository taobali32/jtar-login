<?php


namespace Jtar\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Jtar\Kernel\Event\AfterHandle;
use Jtar\Kernel\Event\BeforeHandle;

class LoginHandleListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            BeforeHandle::class,
            AfterHandle::class
        ];
    }

    public function process(object $event)
    {
        var_dump($event);
    }
}