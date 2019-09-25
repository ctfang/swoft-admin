# swoft-admin
swoft的web开发辅助工具

## 安装

~~~~
composer require ctfang/swoft-admin
~~~~

## 配置
在 `app/bean.php` 新增
~~~~
    'adminServer'        => [
        'class'    => AdminServer::class,
        'port'     => 18366,
        'on'       => [
            SwooleEvent::REQUEST => bean(RequestListener::class),
        ],
        /* @see HttpServer::$setting 静态文件配置 */
        'setting'  => [
            'enable_static_handler' => true,
            'document_root' => __DIR__."/../vendor/ctfang/swoft-admin/public/",
        ]
    ],
~~~~

## 配置静态文件 修改 .env 配置

默认 `ADMIN_WEB = http://127.0.0.1/public/`
~~~~
ADMIN_WEB="http://127.0.0.1:18366/"
~~~~

## 启动
~~~~
php bin/swoft admin:start
~~~~

如果需要在 `http:start` 也能访问,需要设置 `.env`

````php
ADMIN_ENABLE=1
````

## 访问

http://your.com/__admin/home

