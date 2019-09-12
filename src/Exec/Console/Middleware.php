<?php


namespace Swoft\SwoftAdmin\Exec\Console;


use Swoft\SwoftAdmin\Exec\Loader;
use Swoft\SwoftAdmin\Model\Dao\MiddlewareResource;
use Swoft\SwoftAdmin\Model\Logic\Directory;

class Middleware
{
    /**
     * 获取中间件列表
     */
    public function getMiddleware()
    {
        $data = Loader::getDir('App\\Http\\Middleware');
        $dir = new Directory();
        foreach ($data as $scanDir=>$namespace){
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return (new MiddlewareResource())->scan($dir);
    }

    /**
     * 新增一个中间件
     * @param $name
     * @param $title
     */
    public function addMiddleware($name,$title = "无标题")
    {
        $data = Loader::getDir('App\\Http\\Middleware');
        $dir = key($data);

        $className = $name."Middleware";
        $path = $dir.$className.".php";
        if (file_exists($path)){
            return;
        }
        $template = file_get_contents(__DIR__."/template/Middleware");
        $template = str_replace(["{title}","{name}"],[$title,$name],$template);

        file_put_contents($path,$template);
        return;
    }
}
