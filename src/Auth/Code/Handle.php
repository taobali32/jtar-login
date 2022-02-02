<?php


namespace Jtar\Auth\Code;


use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use HyperfExt\Auth\AuthManager;
use HyperfExt\Hashing\Hash;
use Jtar\Kernel\BaseClient;
use Jtar\Kernel\Event\AfterHandle;
use Jtar\Kernel\Event\BeforeHandle;
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
     * @throws UserNoExistException
     */
    public function login($param,$code = '',$sms_prefix = ''): string
    {
        //  获取配置
        $config = $this->app->config['code'];

        $app = di()->get(EventDispatcherInterface::class);

        $app->dispatch(new BeforeHandle($param));

        if (! $param instanceof $config['model']){

            $user = (new $config['model'])->where($config['username_field'],$param)->first();

            if (empty($user)) throw new UserNoExistException('用户不存在');

            $param = $user;
        }

        $sms = new \Jtar\Sms\DuanXinBao\Handle($this->app);

        if ($sms_prefix == '') $sms_prefix = config('logins.code.sms_prefix');

        $check = $sms->setPrefix($sms_prefix)->check($param->{$config['username_field']},$code);

        if ($check === true){

            $sms->setPrefix($sms_prefix)->delete($param->{$config['username_field']});


        }

        $token = make(AuthManager::class)->guard('api')->login($param);

        $token = "bearer " . $token;

        $app->dispatch(new AfterHandle(['user' => $param,'token' => $token]));

        return $token;
    }
}