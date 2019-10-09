<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Exec\Controller\Model;
use SwoftAdmin\Tool\Exec;
use SwoftAdmin\Tool\Http\Msg;
use SwoftAdmin\Tool\View\Button\NewWindow;
use SwoftAdmin\Tool\View\Button\NewWindowIcon;
use SwoftAdmin\Tool\View\Button\ReloadButton;
use SwoftAdmin\Tool\View\Form;
use SwoftAdmin\Tool\View\Table;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;

/**
 * Class ModelController
 * @package Swoft\SwoftAdmin\Http\Controller
 * @Controller(prefix="/__admin/model")
 * @Middleware(LoginMiddleware::class)
 */
class ModelController
{
    /**
     * Dao列表
     * @RequestMapping("dao")
     */
    public function dao()
    {
        $list = Exec::bean(Model::class)->dao();

        $view = new Table();
        $view->title = "Dao";
        $view->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $view->listHeader[] = new ReloadButton();
        $view->listHeader[] = new NewWindow('model/addClassShow','新增Dao');

        $view->listData = is_array($list) ? $list : [];

        $button = new NewWindowIcon('file/show', '文件内容');
        $button->mix = "true";
        $button->addField(['path'=>'path']);
        $view->addListButton($button);

        return $view->toString();
    }

    /**
     * 新增Dao
     * @RequestMapping("addClassShow")
     * @param  Request  $request
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function addDaoShow(Request $request)
    {
        $title = $request->get('title', "add Dao");
        $namespace = $request->get('namespace', "App/Model/Dao/");
        $suffix = $request->get('suffix', "Dao");

        $addView = new Form();
        $addView->title = $title;
        $addView->item[] = new Form\InputForm('title',"标题",'注释第一行说明');
        $addView->item[] = new Form\InputForm('className',"类名","自动加 {$suffix} 后缀");
        $addView->item[] = (new Form\InputForm('namespace','命名空间'))->setValue($namespace);
        $addView->item[] = (new Form\InputForm('suffix','后缀'))->setValue($suffix);

        $addView->action = 'model/addClass';
        return $addView->toString();
    }

    /**
     * Data目录
     * @RequestMapping("data")
     */
    public function data()
    {
        $list = Exec::bean(Model::class)->data();

        $view = new Table();
        $view->title = "Data目录";
        $view->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $view->listHeader[] = new ReloadButton();
        $view->listHeader[] = new NewWindow('model/addClassShow?title=Data&namespace=App/Model/Data/&suffix=Data','新增Data');

        $view->listData = is_array($list) ? $list : [];

        $button = new NewWindowIcon('file/show', '文件内容');
        $button->mix = "true";
        $button->addField(['path'=>'path']);
        $view->addListButton($button);

        return $view->toString();
    }

    /**
     * Logic目录
     * @RequestMapping("logic")
     */
    public function logic()
    {
        $list = Exec::bean(Model::class)->logic();

        $view = new Table();
        $view->title = "Logic目录";
        $view->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $view->listHeader[] = new ReloadButton();
        $view->listHeader[] = new NewWindow('model/addClassShow?title=Logic&namespace=App/Model/Logic/&suffix=Logic','新增Logic');

        $view->listData = is_array($list) ? $list : [];

        $button = new NewWindowIcon('file/show', '文件内容');
        $button->mix = "true";
        $button->addField(['path'=>'path']);
        $view->addListButton($button);

        return $view->toString();
    }

    /**
     * 新增类文件
     * @param  Request  $request
     * @RequestMapping("addClass")
     * @return array
     */
    public function addClass(Request $request)
    {
        $namespace = $request->post('namespace','');
        $name = $request->post('className','');
        $title = $request->post('title','');
        $suffix = $request->post("suffix",'');

        Exec::bean(Model::class)->addClass($namespace, $name, $title, $suffix);
        return Msg::success();
    }
}
