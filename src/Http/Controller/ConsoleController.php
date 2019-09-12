<?php


namespace Swoft\SwoftAdmin\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\SwoftAdmin\Exec\Exec;
use Swoft\SwoftAdmin\Model\Data\AddView;
use Swoft\SwoftAdmin\Model\Data\ListView;

/**
 * Class Console
 * @package Swoft\SwoftAdmin\Http\Controller
 * @Controller(prefix="/__admin/console")
 */
class ConsoleController
{
    /**
     * @RequestMapping("command")
     */
    public function command()
    {
        $list = Exec::run("console/command");

        $listView = new ListView();
        $listView->title = "命令应用";
        $listView->listTitle = [
            "name" => '命令',
            "des" => '说明',
            "handel" => '处理',
        ];
        $listView->createUrl = 'console/addClassShow';

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
        $addView = new AddView();
        $addView->title = "命令行应用";
        $addView->addText('des',"说明",'');
        $addView->addText('className',"类名","自动加 Command 后缀");
        $addView->addText('pre',"命令前缀","");

        $addView->createUrl = 'console/addClass';
        return $addView->toView();
    }


    /**
     * 新增类文件
     * @param  Request  $request
     * @RequestMapping("addClass")
     */
    public function addClass(Request $request)
    {
        $name = $request->post('className','');
        $des = $request->post('des','');
        $pre = $request->post("pre",'');

        Exec::run("console/add", $name, $des, $pre);
    }
}
