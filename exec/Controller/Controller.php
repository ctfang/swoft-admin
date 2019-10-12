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
use SwoftAdmin\Exec\Model\Logic\ReflectionRoute;

class Controller
{
    /**
     * @param  string  $control
     * @param  string  $action
     * @return array
     * @throws \ReflectionException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function getRouteInfo(string $control, string $action)
    {
        try {
            $reflectionClass = new \ReflectionClass(urldecode($control));
        } catch (\Throwable $exception) {
            return [];
        }

        $contr = new ReflectionRoute();

        return $contr->getParameters($reflectionClass,$reflectionClass->getMethod($action));
    }

    /**
     * 获取所有路由信息
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
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
                $arrT = explode("\\", $mid);
                $midName = end($arrT);
                $use .= "\nuse {$mid};";
                $strMids = $strMids." *      @Middleware(".$midName."::class),\n";
            }
        }
        if ($strMids) {
            $strMids = "\n * @Middlewares({\n".$strMids." * })";
        }

        $template = str_replace(["{title}", "{name}", "{Middlewares}", "{use}"], [$title, $name, $strMids, $use],
            $template);

        file_put_contents($path, $template);
        return;
    }

    /**
     * 生成路由函数
     * @param  string  $con
     * @param  string  $route
     * @param  string  $function
     * @param  string  $title
     * @param  string  $method
     * @return bool|string
     * @throws \ReflectionException
     */
    public function addRoute($con, $route, $function, $title = "无注释", $method = "GET")
    {
        // 格式检查
        $con = urldecode($con);

        $reflector = new \ReflectionClass($con);
        $filePath = $reflector->getFileName();
        $content = file_get_contents($filePath);
        $content = trim($content);
        $strLen = strlen($content);
        $endStr = $content{$strLen - 1};

        if ($endStr != "}") {
            return "不是以 } 结束的类文件";
        }

        if (strlen($function) <= 2 || !preg_match('/^[_0-9a-z]{2,30}$/i', $function)) {
            return "函数名不合法";
        }

        foreach ($reflector->getMethods() as $reflectionMethod) {
            if ($reflectionMethod->getName() == $function) {
                return "函数名已存在";
            }
        }

        $firstStr = substr($content, 0, -1);
        $backups = getRootPath().'/runtime/admin/backups/';
        if (!is_dir($backups)) {
            if (!mkdir($backups, 0755, true)) {
                return false;
            }
        }
        copy($filePath, $backups.'/'.time().'.php');
        $newFunc = file_get_contents(__DIR__.'/../template/Route');

        /**
         * 补全命名空间引用
         * 必须有 use Swoft\Http\Server\Annotation\Mapping\Controller;
         */
        $needController = "use Swoft\Http\Server\Annotation\Mapping\Controller;";
        if (strpos($firstStr, $needController) === false) {
            return false;
        }

        $useArr = [
            "use Swoft\\Http\\Message\\Request;",
            "use Swoft\\Http\\Message\\Response;",
            "use Swoft\\Http\\Server\\Annotation\\Mapping\\RequestMapping;",
            "use Swoft\\Http\\Server\\Annotation\\Mapping\\RequestMethod;",
        ];
        foreach ($useArr as $use) {
            if (strpos($firstStr, $use) === false) {
                $firstStr = str_replace([$needController], [$needController."\n".$use], $firstStr);
            }
        }

        $newFunc = str_replace(["{title}", "{route}", "{function}", "{method}"], [$title, $route, $function, $method],
            $newFunc);

        file_put_contents($filePath, $firstStr.$newFunc);
        return true;
    }
}
