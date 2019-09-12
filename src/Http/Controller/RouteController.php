<?php


namespace Swoft\SwoftAdmin\Http\Controller;


use Swoft\Context\Context;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\SwoftAdmin\Exec\Exec;

/**
 * Class RouteController
 * @package App\Http\Console
 * @Controller(prefix="/__admin/control")
 */
class RouteController
{
    /**
     * 路由列表
     * @RequestMapping(route="routes")
     */
    public function httpRoutes()
    {
        $routes = Exec::run("routes");

        $data['routes'] = $routes;

        return admin_view('control/routes', $data);
    }

    /**
     * @RequestMapping(route="setPostmen")
     */
    public function setPostmen()
    {
        $routes = Exec::run("postmen");

        $json   = json_encode($routes,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        return Context::get()
            ->getResponse()
            ->withContent($json)
            ->withHeader('Content-Type',"application/octet-stream")
            ->withHeader('Content-Disposition','attachment; filename=admin-api.json');
    }

    /**
     * 新增控制器
     * @RequestMapping(route="add")
     */
    public function addController()
    {
        $routes = Exec::run("mids");
        // 所有中间件
        $data['mids'] = $routes;
        return admin_view('control/addCon', $data);
    }

    /**
     * 新增控制器
     * @RequestMapping(route="addPost")
     */
    public function addControllers()
    {
        $post = Context::get()->getRequest()->post();

        $title = $post['title'];
        $name = $post['name'];
        $mids = $post['mids']??[];

        foreach ((array)$mids as $key=>$mid){
            $mids[$key] = urlencode($mid);
        }

        Exec::run("control/add",$name,$title,$mids);

        return admin_view('close');
    }

    /**
     * 控制器列表
     * @RequestMapping(route="list")
     */
    public function httpController()
    {
        $routes = Exec::run("control/list");

        $data['list'] = $routes;

        return admin_view('control/control', $data);
    }

    /**
     * @RequestMapping(route="addRoute")
     * @param  Request  $request
     * @return array
     */
    public function addRoute(Request $request)
    {
        return ["todo"];
    }
}
