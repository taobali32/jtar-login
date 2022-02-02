<?php


namespace Jtar\Kernel\Contract;


use Psr\Container\ContainerInterface;

interface ServiceProviderInterface
{
    public function register(ContainerInterface $app);
}