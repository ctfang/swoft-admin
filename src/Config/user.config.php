<?php
return [
    /**
     * 如果swoft项目下,没有 __admin.php 文件,将会采用本文件配置
     * 如果存在 __admin.php 文件,会优先使用,不使用本文件
     * 默认账号 admin
     * 默认密码 123456
     */
    "users" => [
        // 账号=>密码
        'admin' => password_hash("123456", PASSWORD_DEFAULT),
    ],
];
