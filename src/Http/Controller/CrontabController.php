<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Exec\Controller\Crontab;
use SwoftAdmin\Tool\Exec;
use SwoftAdmin\Tool\View\Button\ReloadButton;
use SwoftAdmin\Tool\View\Table;

/**
 * Class CrontabController
 * @package SwoftAdmin\Tool\Http\Controller
 * @Controller(prefix="/__admin/crontab")
 */
class CrontabController
{
    /**
     * 定时任务
     * @RequestMapping("lists")
     */
    public function getTable()
    {
        $view = new Table();
        $view->title = "定时任务";

        $view->listHeader[] = new ReloadButton();
        $view->listTitle["id"] = "ID";
        $view->listTitle["handel"] = "处理";
        $view->listTitle["cron"] = "设置";

        $view->listData = Exec::bean(Crontab::class)->getTasks();

        return $view->toString();
    }
}
