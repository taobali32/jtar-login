<?php


namespace Jtar\Kernel;

use Jtar\Kernel\Providers\ConfigServiceProvider;
use Pimple\Container;

/**
 * Class ServiceContainer
 * @package Jtar\Kernel
 */
abstract class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $providers = [];


    /**
     * Constructor.
     *
     * @param array       $config
     * @param array       $prepends
     * @param string|null $id
     */
    public function __construct(array $config = [], array $prepends = [])
    {
        $this->config = $config;

        parent::__construct($prepends);

        $this->registerProviders($this->getProviders());
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        $base = config('logins');
        return array_replace_recursive($base, $this->config,[]);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param string $id
     * @param mixed  $value
     */
    public function rebind($id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class,
        ],$this->providers);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}