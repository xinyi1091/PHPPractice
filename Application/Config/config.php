<?php

return [
    //数据库配置
    'database' => [
        'user'   => 'root',
        'pwd'    => 'root123',
        'host'   => '192.168.33.10',
        'dbname' => 'test_0616',
    ],
    //应用程序配置
    'app'      => [
        'dp'   => 'Admin',        //默认平台
        'dc'   => 'Products',     //默认控制器
        'da'   => 'list',          //默认方法
        'salt' => 'itcast',       //加密秘钥
    ],
];
 