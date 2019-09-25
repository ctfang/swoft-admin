<?php


namespace SwoftAdmin\Exec\Controller;


use Swoft\Console\Annotation\Mapping\CommandMapping;
use SwoftAdmin\Exec\Application;
use SwoftAdmin\Exec\Loader;
use SwoftAdmin\Exec\Model\Dao\AnnotationResource;
use SwoftAdmin\Exec\Model\Dao\ControllerResource;
use SwoftAdmin\Exec\Model\Dao\MiddlewareResource;
use SwoftAdmin\Exec\Model\Dao\RoutesResource;
use SwoftAdmin\Exec\Model\Logic\Directory;

class Controller
    {
    /**
     * 获取所有路由信息
     * @return array
     * @CommandMapping(name="routes")
     */
    public function getRoutes()
    {
        $dir = Application::getDirectory('App\\Http\\Controller');
        return (new RoutesResource())->scanRoutes($dir);
    }

    /**
     * 获取控制器列表
     */
    public function getControllers()
    {
        $dir = Application::getDirectory('App\\Http\\Controller');
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
        $data = Application::getDirs('App\\Http\\Controller');
        $dir = key($data);

        $className = $name."Controller";
        $path = $dir.$className.".php";
        if (file_exists($path)) {
            return;
        }
        $template = file_get_contents(Application::getTemplate("Controller"));

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
