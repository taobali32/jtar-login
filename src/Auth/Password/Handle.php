<?php


namespace Jtar\Auth\Password;


use HyperfExt\Auth\AuthManager;
use HyperfExt\Hashing\Hash;
use Jtar\Kernel\Event\AfterHandle;
use Jtar\Kernel\Event\BeforeHandle;
use Jtar\Kernel\BaseClient;
use Jtar\Kernel\Exceptions\PasswordErrorException;
use Jtar\Kernel\Exceptions\UserNoExistException;
use Psr\EventDispatcher\EventDispatcherInterface;

class Handle extends BaseClient
{
    /**
     * @param $param | model
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws PasswordErrorException
     * @throws UserNoExistException
     */
    public function login($param): string
    {
        //  获取配置
        $config = $this->app->config['password'];

        $app = di()->get(EventDispatcherInterface::class);

        $app->dispatch(new BeforeHandle($param));

        if (is_array($param)){

            $user = (new $config['model'])->where($config['username_field'],$param['username'])->first();

            if (empty($user)) throw new UserNoExistException('用户不存在');

            if (Hash::check((string)$param['password'],$user->{$config['password_field']}) != true){
                throw new PasswordErrorException('密码错误');
            }

            $param = $user;
        }

        $token = make(AuthManager::class)->guard('api')->login($param);

        $token = "bearer " . $token;

        $app->dispatch(new AfterHandle(['user' => $param,'token' => $token]));

        return $token;
    }
}