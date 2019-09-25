<?php

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * 获取vendor目录
 * @return string
 */
function getRootPath(): string
{
    if (defined('ADMIN_ROOT_PATH')){
        return ADMIN_ROOT_PATH;
    }
    $root = '';
    $dirStart = __DIR__;
    $while = true;
    while ($while) {
        if (is_dir($dirStart."/vendor")) {
            $root = $dirStart;
            $while = false;
        }
        $dirStart = dirname($dirStart);
    }
    define('ADMIN_ROOT_PATH',$root);
    return $root;
}

/**
 * 覆盖框架的函数
 * @param  string  $name
 * @return string
 */
function bean(string $name){
    return $name;
}

function alias(string $name){
    return $name;
}

$vendor = getRootPath()."/vendor/autoload.php";
/** @var ClassLoader $loader */
$loader = require_once $vendor;
// 注解加载器
AnnotationRegistry::registerLoader(array($loader, "loadClass"));

return new SwoftAdmin\Exec\Application($loader);
