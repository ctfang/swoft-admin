<?php


namespace SwoftAdmin\Exec\Controller;

use SwoftAdmin\Exec\Application;
use SwoftAdmin\Exec\Model\Dao\CrontabResource;

/**
 * Class Crontab
 * @package SwoftAdmin\Exec\Controller
 */
class Crontab
{
    /**
     * 获取定时列表
     */
    public function getTasks()
    {
        $dir = Application::getDirectory('App\\Crontab');
        return (new CrontabResource())->scan($dir);
    }
}
