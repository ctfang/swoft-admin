<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Exec\Controller\Console;
use SwoftAdmin\Tool\Exec;
use SwoftAdmin\Tool\View\Button\NewWindow;
use SwoftAdmin\Tool\View\Button\ReloadButton;
use SwoftAdmin\Tool\View\Form;
use SwoftAdmin\Tool\View\Table;

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
        $list = Exec::bean(Console::class)->command();

        $listView = new Table();
        $listView->title = "命令应用";
        $listView->listTitle = [
            "name" => '命令',
            "des" => '说明',
            "handel" => '处理',
        ];
        $listView->listHeader[] = new ReloadButton();
        $listView->listHeader[] = new NewWindow('console/addClassShow', '新增命令');

        $listView->listData = is_array($list) ? $list : [];

        return $listView->toString();
    }


    /**
     * 新增命令
     * @RequestMapping("addClassShow")
     * @param  Request  $request
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function addDaoShow(Request $request)
    {
        $view = new Form();
        $view->title = "新增命令类";
        $view->item[] = new Form\InputForm('des','说明');
        $view->item[] = new Form\InputForm('className','类名');
        $view->item[] = new Form\InputForm('pre','命令前缀');
        $view->action = "console/addClass";

        return $view->toString();
    }


    /**
     * 新增类文件
     * @param  Request  $request
     * @RequestMapping("addClass")
     * @return string
     */
    public function addClass(Request $request)
    {
        $name = $request->post('className', '');
        $des = $request->post('des', '');
        $pre = $request->post("pre", '');

        Exec::bean(Console::class)->add($name, $des, $pre);
        return "新增类文件 OK";
    }
}
