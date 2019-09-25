<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;
use SwoftAdmin\Tool\View\Home;
use SwoftAdmin\Tool\View\Welcome;

/**
 * Class HomeController
 * @package Swoft\SwoftAdmin\Http\Controller
 * @Controller()
 * @Middleware(LoginMiddleware::class)
 */
class HomeController
{
    /**
     * 首页
     * @RequestMapping("/__admin/home")
     */
    public function home()
    {
        return (new Home())->toString();
    }

    /**
     * 启动页
     * @RequestMapping("/__admin/welcome")
     * @param  Request  $request
     * @return Welcome
     */
    public function welcome(Request $request)
    {
        $view = new Welcome();

        $root = dirname(\Swoft::getAlias("@app"));
        $size = round(disk_free_space($root) / 1073741824 * 100) / 100 . ' GB';

        $view->system[] = ['key'=>'监听端口','value'=>$request->getServerParams()['server_port']];
        $view->system[] = ['key'=>'操作系统','value'=>\PHP_OS];
        $view->system[] = ['key'=>'PHP版本','value'=>\PHP_VERSION];
        $view->system[] = ['key'=>'Swoole版本','value'=>\SWOOLE_VERSION];
        $view->system[] = ['key'=>'Swoft 版本','value'=>\Swoft::VERSION];
        $view->system[] = ['key'=>'ROOT目录','value'=>dirname($root)];
        $view->system[] = ['key'=>'ROOT可用','value'=>$size];

        foreach (\get_loaded_extensions() as $extension){
            $view->ext[] = ['key'=>$extension];
        }

        return $view->toString();
    }
}
