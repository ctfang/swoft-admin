<?php


namespace Swoft\SwoftAdmin\Exec;


use Doctrine\Common\Annotations\AnnotationRegistry;

$dirStart = __DIR__;
$while = true;
while ($while){
    if( is_dir($dirStart."/vendor") ){
        $root = $dirStart;
        $while = false;
    }
    $dirStart = dirname($dirStart);
}
if( !isset($root) ){
    die("找不到 vendor 目录");
}

define("ROOT_PATH", $root);
Loader::$loader = require_once ROOT_PATH."/vendor/autoload.php";
AnnotationRegistry::registerLoader(array(Loader::$loader, "loadClass"));

class Loader
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    public static $loader;

    protected static $routes;

    /**
     * @param  string  $name
     * @param callable $fun
     */
    public static function addRoute(string $name,$fun)
    {
        self::$routes[$name] = $fun;
    }

    public static function run(array $argv)
    {
        if (isset($argv[1]) && isset(Loader::$routes[$argv[1]])) {
            $route = $argv[1];
            $call = Loader::$routes[$route];

            $class = $call[0];
            $class = new $class();
            $action = $call[1];

            $params = [];
            foreach ($argv as $key=>$item){
                $key>1 and $params[] = $item;
            }

            $data = call_user_func_array([$class,$action],$params);

            echo serialize($data);
            return;
        }
    }

    public static function getDir($namespace):array
    {
        $psr = self::$loader->getPrefixesPsr4();
        $arr = explode("\\",$namespace);
        foreach ($arr as $name){
            $base = isset($base)?$base.$name."\\":$name."\\";
            if(isset($psr[$base])){
                $temp = explode($base,$namespace);
                $find = end($temp);
                $find = str_replace("\\","/",$find);
                break;
            }
        }

        if(!isset($find) || !isset($psr[$base])){
            return [];
        }

        $data = [];
        foreach ($psr[$base] as $dir){
            $dir = realpath($dir);
            $is  = $dir."/".$find."/";
            if (is_dir($is)){
                $data[$is] = $namespace."\\";
            }
        }
        return $data;
    }
}
