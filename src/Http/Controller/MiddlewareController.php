<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use SwoftAdmin\Exec\Controller\Middleware;
use SwoftAdmin\Tool\Exec;
use SwoftAdmin\Tool\Http\Msg;
use SwoftAdmin\Tool\View\Button\NewWindow;
use SwoftAdmin\Tool\View\Button\NewWindowIcon;
use SwoftAdmin\Tool\View\Button\ReloadButton;
use SwoftAdmin\Tool\View\Form;
use SwoftAdmin\Tool\View\Table;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;

/**
 * Class MiddlewareController
 * @package App\Http\Controller
 * @Controller(prefix="/__admin/mid")
 * @\Swoft\Http\Server\Annotation\Mapping\Middleware(LoginMiddleware::class)
 */
class MiddlewareController
{
    /**
     * 中间件列表
     * @RequestMapping(route="list")
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function mid()
    {
        $list = Exec::bean(Middleware::class)->getMiddleware();

        $view = new Table();
        $view->title = "中间件列表";
        $view->listTitle['id'] = "ID";
        $view->listTitle['title'] = "标题";
        $view->listTitle['path'] = "Path";
        $view->listTitle['isGroup'] = "全局";
        $view->listTitle['bean'] = "Bean";

        $arr = [];
        foreach ($list as $item){
            $arr[] = (array)$item;
        }
        $view->listData = $arr;

        $view->listHeader[] = new ReloadButton();
        $view->listHeader[] = new NewWindow('mid/create','创建中间件');

        $button = new NewWindowIcon('file/show', '文件内容');
        $button->mix = "true";
        $button->addField(['path'=>'path']);
        $view->addListButton($button);

        return $view->toString();
    }

    /**
     * 创建中间件显示界面
     * @RequestMapping(route="create",method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function create()
    {
        $view = new Form();
        $view->title = '创建中间件';
        $view->action = 'mid/add';

        $view->item[] = new Form\InputForm('classTitle','标题');
        $view->item[] = new Form\InputForm('className','类名',"类名,自带Middleware");

        return $view->toString();
    }

    /**
     * 创建中间件
     * @RequestMapping(route="add")
     */
    public function createPost()
    {
        $className = Context::get()->getRequest()->post("className");
        $classTitle = Context::get()->getRequest()->post("classTitle");
        if (!$className) {
            return Msg::error("失败");
        }

        Exec::bean(Middleware::class)->addMiddleware($className,$classTitle);

        return Msg::success();
    }
}
