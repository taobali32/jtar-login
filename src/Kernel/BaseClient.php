<?php


namespace Jtar\Kernel;

class BaseClient
{
    /**
     * @var \Jtar\Kernel\ServiceContainer
     */
    protected $app;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }
}