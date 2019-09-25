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

## 访问

http://your.com/__admin/home


## 计划

- [x] [控制器展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller/RouteController.php) 
- [x] [中间件展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller/RouteController.php) 
- [x] [路由导出postmen](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller/RouteController.php) 
- [x] [Model目录展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [x] [定时器展示](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [x] [命令展示&创建](https://github.com/ctfang/swoft-admin/blob/master/src/Http/Controller) 
- [ ] 路由导出自动生成参数
- [ ] 启动&关闭http
- [ ] 界面创建路由(空函数)
- [ ] 配置查看
- [ ] 控制器代码查看
