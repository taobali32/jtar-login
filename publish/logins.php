<?php
return [
    'password'  =>  [
        'model'                 =>  \App\Model\UserModel::class,
        'username_field'        =>  'username',
        'password_field'        =>  'password',
    ],
    'code'      =>  [
        'model'                 =>  \App\Model\UserModel::class,
        'username_field'        =>  'username',
        'code_cache_name'       =>  'login_code',
        'sms_prefix'            =>  'sms_'
    ]
];