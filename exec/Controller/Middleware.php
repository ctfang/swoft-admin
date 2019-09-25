<?php


namespace SwoftAdmin\Exec\Controller;


use SwoftAdmin\Exec\Application;
use SwoftAdmin\Exec\Loader;
use SwoftAdmin\Exec\Model\Dao\MiddlewareResource;
use SwoftAdmin\Exec\Model\Logic\Directory;

class Middleware
{
    /**
     * 获取中间件列表
     */
    public function getMiddleware()
    {
        $dir = Application::getDirectory('App\\Http\\Middleware');
        return (new MiddlewareResource())->scan($dir);
    }

    /**
     * 新增一个中间件
     * @param $name
     * @param $title
     */
    public function addMiddleware($name,$title = "无标题")
    {
        $data = Application::getDirs('App\\Http\\Middleware');
        $dir = key($data);

        $className = $name."Middleware";
        $path = $dir.$className.".php";
        if (file_exists($path)){
            return;
        }
        $template = file_get_contents(Application::getTemplate("Middleware"));
        $template = str_replace(["{title}","{name}"],[$title,$name],$template);

        file_put_contents($path,$template);
        return;
    }
}
