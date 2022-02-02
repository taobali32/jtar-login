
```
hyperf下登陆封装，支持短信，密码登陆
composer require jtar/login
```


```php
        $con = "【凑聊】您的验证码为123456，在10分钟内有效。";

        Factory::sms([])->d_x_b->setPrefix('aa')->send(13243362307,$con);

			  Factory::sms([])->d_x_b->delete(13243362307);
			  Factory::sms([])->d_x_b->check('13243362307','123');





//	账号//或者模型  // 验证码， 验证码前缀	
$zz = Factory::auth([])->code->login(1,123456);





        try {
          
          //        $config = [
//            'password'  =>  [
//                'model'                 =>  \App\Model\UserModel::class,
//                'username_field'        =>  'username',
//                'password_field'        =>  'password',
//            ]
//        ];
            $zz = Factory::auth($config)->password->login($arr);

            var_dump($zz);
        }catch (\Exception $exception){
            var_dump($exception->getMessage());
        }





```
