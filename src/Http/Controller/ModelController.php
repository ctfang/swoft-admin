<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Exec\Controller\Model;
use SwoftAdmin\Tool\Exec;
use SwoftAdmin\Tool\View\Button\NewWindow;
use SwoftAdmin\Tool\View\Button\ReloadButton;
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

        $listView = new Table();
        $listView->title = "Dao";
        $listView->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $listView->listHeader[] = new ReloadButton();
        $listView->listHeader[] = new NewWindow('model/addClassShow','新增Dao');

        $listView->listData = is_array($list) ? $list : [];

        return $listView->toString();
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

        $addView = new AddView();
        $addView->title = $title;
        $addView->addText('title',"标题",'注释第一行说明');
        $addView->addText('className',"类名","自动加 {$suffix} 后缀");
        $addView->addValue('namespace',$namespace);
        $addView->addValue('suffix',$suffix);

        $addView->createUrl = 'model/addClass';
        return $addView->toView();
    }

    /**
     * Data目录
     * @RequestMapping("data")
     */
    public function data()
    {
        $list = Exec::bean(Model::class)->data();

        $listView = new Table();
        $listView->title = "Data目录";
        $listView->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $listView->listHeader[] = new ReloadButton();
        $listView->listHeader[] = new NewWindow('model/addClassShow?title=Data&namespace=App/Model/Data/&suffix=Data','新增Data');

        $listView->listData = is_array($list) ? $list : [];

        return $listView->toString();
    }

    /**
     * Logic目录
     * @RequestMapping("logic")
     */
    public function logic()
    {
        $list = Exec::bean(Model::class)->logic();

        $listView = new Table();
        $listView->title = "Logic目录";
        $listView->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $listView->listHeader[] = new ReloadButton();
        $listView->listHeader[] = new NewWindow('model/addClassShow?title=Logic&namespace=App/Model/Logic/&suffix=Logic','新增Logic');

        $listView->listData = is_array($list) ? $list : [];

        return $listView->toString();
    }

    /**
     * 新增类文件
     * @param  Request  $request
     * @RequestMapping("addClass")
     */
    public function addClass(Request $request)
    {
        $namespace = $request->post('namespace','');
        $name = $request->post('className','');
        $title = $request->post('title','');
        $suffix = $request->post("suffix",'');

        Exec::bean(Model::class)->addClass($namespace, $name, $title, $suffix);
    }
}
