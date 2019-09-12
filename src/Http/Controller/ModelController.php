<?php


namespace Swoft\SwoftAdmin\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\SwoftAdmin\Exec\Exec;
use Swoft\SwoftAdmin\Model\Data\AddView;
use Swoft\SwoftAdmin\Model\Data\ListView;

/**
 * Class ModelController
 * @package Swoft\SwoftAdmin\Http\Controller
 * @Controller(prefix="/__admin/model")
 */
class ModelController
{
    /**
     * Dao列表
     * @RequestMapping("dao")
     */
    public function dao()
    {
        $list = Exec::run("model/dao");

        $listView = new ListView();
        $listView->title = "Dao";
        $listView->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $listView->createUrl = 'model/addClassShow';

        $listView->listData = is_array($list) ? $list : [];

        return $listView->toView();
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
        $list = Exec::run("model/data");

        $listView = new ListView();
        $listView->title = "Data";
        $listView->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $listView->createUrl = 'model/addClassShow?title=Data&namespace=App/Model/Data/&suffix=Data';

        $listView->listData = is_array($list) ? $list : [];

        return $listView->toView();
    }

    /**
     * @RequestMapping("logic")
     */
    public function logic()
    {
        $list = Exec::run("model/logic");

        $listView = new ListView();
        $listView->title = "Logic";
        $listView->listTitle = [
            "title" => '标题',
            "path" => '类名',
            "bean" => '拥有Bean',
        ];
        $listView->createUrl = 'model/addClassShow?title=Logic&namespace=App/Model/Logic/&suffix=Logic';

        $listView->listData = is_array($list) ? $list : [];

        return $listView->toView();
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

        Exec::run("model/addClass", $namespace, $name, $title, $suffix);
    }
}
