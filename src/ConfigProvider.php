<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Jtar;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'logins',
                    'description' => '登陆配置.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/logins.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/logins.php',
                ],
                [
                    'id' => 'hashing',
                    'description' => 'hash配置.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/hashing.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/hashing.php',
                ],
                [
                    'id' => 'auth',
                    'description' => 'auth配置.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/auth.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/auth.php',
                ],
                [
                    'id' => 'jwt',
                    'description' => 'jwt配置.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/jwt.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/jwt.php',
                ],
                [
                    'id' => 'sms',
                    'description' => '短信配置.', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/sms.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/config/autoload/sms.php',
                ],
                [
                    'id' => 'userModel',
                    'description' => 'Model', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/UserModel.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/app/Model/UserModel.php',
                ],
                [
                    'id' => 'traitApiResponse',
                    'description' => '接口辅助用', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/ApiResponse.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/app/Traits/ApiResponse.php',
                ],
                [
                    'id' => 'traitLook',
                    'description' => 'redis锁', // 描述
                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
                    'source' => __DIR__ . '/../publish/Look.php',  // 对应的配置文件路径
                    'destination' => BASE_PATH . '/app/Traits/Look.php',
                ],
            ],
        ];
    }
}
