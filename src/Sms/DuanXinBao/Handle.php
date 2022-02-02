<?php


namespace Jtar\Sms\DuanXinBao;

use Hyperf\Guzzle\ClientFactory;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;
use Jtar\Kernel\BaseClient;
use Jtar\Kernel\Exceptions\SmsCheckErrorException;
use Jtar\Kernel\Exceptions\SmsSendErrorException;
use Jtar\Kernel\ServiceContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Hyperf\AsyncQueue\Annotation\AsyncQueueMessage;

class Handle extends BaseClient
{
    public function __construct(ServiceContainer $app)
    {
        $this->setPrefix(config('sms.duan_xin_bao.prefix'));
        parent::__construct($app);
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix(string $prefix = ''): Handle
    {
        if ($prefix != ''){
            Context::set('sms_prefix',$prefix);
        }
        return $this;
    }

    public function getPrefix(){
        return Context::get('sms_prefix');
    }

    /**
     * @AsyncQueueMessage()
     * @param $mobile
     * @param string $content
     * @param int $code
     * @return bool|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws SmsSendErrorException
     */
    public function send($mobile, string $content = '',$code = 123456)
    {
        $smsapi = "http://api.smsbao.com/";

        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );

        $user = config('sms.duan_xin_bao.user'); //短信平台帐号
        $pass = md5(config('sms.duan_xin_bao.pass')); //短信平台密码

        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$mobile."&c=".urlencode($content);

        $clientFactory = make(ClientFactory::class);

        $response = $clientFactory->create()->get($sendurl)->getBody();
        $result = json_decode($response,true);

        if ($result == 0){
            $this->set($mobile,$code);
            return true;
        }

        throw new SmsSendErrorException( $statusStr[$result] ?? '');
    }

    /**
     * @param $phone
     * @param $code
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function set($phone,$code)
    {
        ApplicationContext::getContainer()->get(Redis::class)->set($this->getPrefix() . $phone,$code,config('sms.duan_xin_bao.timeout'));
    }


    /**
     * @param string $account
     * @param string $input_code
     * @return bool|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws SmsCheckErrorException
     */
    public function check(string $account = '', string $input_code = '')
    {
        if (empty($account) || empty($input_code)) throw new SmsCheckErrorException('验证码错误');

        $default = config('sms.duan_xin_bao.sms_default_code');

        if ($input_code == $default) return true;

        $code = ApplicationContext::getContainer()->get(Redis::class)->get($this->getPrefix() . $account);

        if ($code == false || (string)$code !== (string)$input_code){
            throw new SmsCheckErrorException('验证码错误 -1');
        }

        return true;
    }

    /**
     * @param $phone
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function delete($phone): bool
    {
        ApplicationContext::getContainer()->get(Redis::class)->del($this->getPrefix() . $phone);

        return true;
    }
}