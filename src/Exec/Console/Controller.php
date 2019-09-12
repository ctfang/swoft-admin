<?php


namespace Swoft\SwoftAdmin\Exec\Console;


use Swoft\SwoftAdmin\Exec\Loader;
use Swoft\SwoftAdmin\Model\Dao\AnnotationResource;
use Swoft\SwoftAdmin\Model\Dao\ControllerResource;
use Swoft\SwoftAdmin\Model\Dao\MiddlewareResource;
use Swoft\SwoftAdmin\Model\Dao\RoutesResource;
use Swoft\SwoftAdmin\Model\Logic\Directory;

class Controller
{
    /**
     * 获取所有路由信息
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public function getRoutes()
    {
        $data = Loader::getDir('App\\Http\\Controller');
        $dir = new Directory();
        foreach ($data as $scanDir => $namespace) {
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return (new RoutesResource())->scanRoutes($dir);
    }

    /**
     * 获取控制器列表
     */
    public function getControllers()
    {
        $data = Loader::getDir('App\\Http\\Controller');
        $dir = new Directory();
        foreach ($data as $scanDir => $namespace) {
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return (new ControllerResource())->scanController($dir);
    }

    /**
     * 创建控制器
     * @param $name
     * @param $title
     * @param $mids
     */
    public function addControllers($name, $title = "无标题", ...$mids)
    {
        $data = Loader::getDir('App\\Http\\Controller');
        $dir = key($data);

        $className = $name."Controller";
        $path = $dir.$className.".php";
        if (file_exists($path)) {
            return;
        }
        $template = file_get_contents(__DIR__."/template/Controller");

        $strMids = "";
        $use = "";
        if (is_array($mids) && $mids) {
            $use .= "\nuse Swoft\\Http\\Server\\Annotation\\Mapping\\Middlewares;";
            $use .= "\nuse Swoft\\Http\\Server\\Annotation\\Mapping\\Middleware;";
            foreach ($mids as $mid) {
                $mid = urldecode($mid);
                $arrT = explode("\\",$mid);
                $midName = end($arrT);
                $use .= "\nuse {$mid};";
                $strMids = $strMids." *      @Middleware(".$midName."::class),\n";
            }
        }
        if ($strMids){
            $strMids = "\n * @Middlewares({\n".$strMids." * })";
        }

        $template = str_replace(["{title}", "{name}", "{Middlewares}","{use}"], [$title, $name,$strMids,$use], $template);

        file_put_contents($path, $template);
        return;
    }
}
