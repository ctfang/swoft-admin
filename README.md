# swoft-admin
swoft的web开发辅助工具

## 安装

~~~~
composer require ctfang/swoft-admin 
~~~~

下载主干 composer require ctfang/swoft-admin dev-master 

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

## 访问,默认账号密码 `username = admin ; password = 123456`

http://your.com/__admin/login

## 修改密码

复制文件 `vendor/ctfang/swoft-admin/src/Config/user.config.php` 到 `@config/__admin.php@config/__admin.php`


## 计划

- [x] [控制器展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller/RouteController.php) 
- [x] [中间件展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller/RouteController.php) 
- [x] [路由导出postmen](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller/RouteController.php) 
- [x] [Model目录展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [x] [定时器展示](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [x] [命令展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [x] [Web Terminal](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [x] [控制器代码查看](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [x] [Logs查看](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [ ] 第三方登录模拟
- [ ] 启动&关闭http
- [ ] 界面创建路由(空函数)
- [ ] 配置查看
- [ ] 进程信息
