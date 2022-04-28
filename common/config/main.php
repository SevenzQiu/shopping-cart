<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        // 配置DB
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=shoppingCart',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 24*3600,
            'schemaCache' => 'cache',
        ],

        // redis
        'redis'  => [
            'class'    => 'yii\redis\Connection',
//            'hostname' => 'admin',
//            'password' => '',
            'port'     =>6379,//默认的端口  配置其他端口在这里改
            'database' => 0,//使用的第几个DB
        ],
    ],
];
