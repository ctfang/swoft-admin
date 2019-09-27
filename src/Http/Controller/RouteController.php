<?php


namespace SwoftAdmin\Tool\Http\Controller;


use Swoft\Context\Context;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Exec\Controller\Middleware;
use SwoftAdmin\Exec\Controller\Postmen;
use SwoftAdmin\Tool\Exec;
use SwoftAdmin\Tool\View\Button\NewWindow;
use SwoftAdmin\Tool\View\Button\NewWindowIcon;
use SwoftAdmin\Tool\View\Button\ReloadButton;
use SwoftAdmin\Tool\View\FileContent;
use SwoftAdmin\Tool\View\Form;
use SwoftAdmin\Tool\View\Table;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;

/**
 * Class RouteController
 * @package App\Http\Console
 * @Controller(prefix="/__admin/control")
 * @\Swoft\Http\Server\Annotation\Mapping\Middleware(LoginMiddleware::class)
 */
class RouteController
{
    /**
     * 路由列表
     * @RequestMapping(route="routes")
     */
    public function httpRoutes()
    {
        $view = new Table();
        $view->listTitle['id'] = "ID";
        $view->listTitle['title'] = "标题说明";
        $view->listTitle['path'] = "路由";
        $view->listTitle['method'] = "约束";
        $view->listTitle['controller'] = "控制器";
        $view->listTitle['action'] = "函数";

        $view->listData = Exec::bean(\SwoftAdmin\Exec\Controller\Controller::class)->getRoutes();

        $view->listHeader[] = new ReloadButton();
        $view->listHeader[] = new NewWindow('control/addRoute', '新增路由');
        $view->listHeader[] = new NewWindow('control/setPostmen', '导出postmen');

        $button = new NewWindowIcon('file/show', '文件内容');
        $button->mix = "true";
        $button->addField(['controller'=>'path']);
        $view->addListButton($button);

        return $view->toString();
    }

    /**
     * @RequestMapping(route="setPostmen")
     */
    public function setPostmen()
    {
        $routes = Exec::bean(Postmen::class)->down();

        $json = json_encode($routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return Context::get()
            ->getResponse()
            ->withContent($json)
            ->withHeader('Content-Type', "application/octet-stream")
            ->withHeader('Content-Disposition', 'attachment; filename=admin-api.json');
    }

    /**
     * 新增控制器
     * @RequestMapping(route="addControl")
     */
    public function addController()
    {
        $list = Exec::bean(Middleware::class)->getMiddleware();

        $mids = [];
        foreach ($list as $item) {
            $item = (array) $item;
            if ($item['isGroup']) {
                continue;
            }
            $mids[] = [
                'field' => 'mids',
                'title' => $item['title'],
                'value' => $item['path'],
            ];
        }

        $view = new Form();
        $view->action = 'control/addControlPost';

        $view->item[] = new Form\InputForm('name', "类名", '控制器名称', 'required');
        $view->item[] = new Form\InputBlockForm("选择非全局中间件", $mids);
        $view->item[] = new Form\TextareaForm('title', "标题", '类的首行注释');

        return $view->toString();
    }

    /**
     * 新增控制器
     * @RequestMapping(route="addControlPost")
     */
    public function addControllers()
    {
        $post = Context::get()->getRequest()->post();

        $title = $post['title'];
        $name = $post['name'];
        $mids = $post['mids'] ?? [];

        foreach ((array) $mids as $key => $mid) {
            $mids[$key] = urlencode($mid);
        }

        $data = Exec::bean(\SwoftAdmin\Exec\Controller\Controller::class)->addControllers($name, $title, $mids);

        return $data;
    }

    /**
     * 控制器列表
     * @RequestMapping(route="list")
     */
    public function httpController()
    {
        $view = new Table();
        $view->listTitle['id'] = "ID";
        $view->listTitle['title'] = "标题说明";
        $view->listTitle['path'] = "Path";
        $view->listTitle['mid'] = "中间件";
        $view->listTitle['prefix'] = "路由前缀";

        $view->listData = Exec::bean(\SwoftAdmin\Exec\Controller\Controller::class)->getControllers();

        $view->listHeader[] = new ReloadButton();
        $view->listHeader[] = new NewWindow('control/addControl', '新增控制器');

        $button = new NewWindowIcon('file/show', '文件内容');
        $button->mix = "true";
        $button->addField(['path']);
        $view->addListButton($button);

        return $view->toString();
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
