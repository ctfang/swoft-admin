<?php


namespace SwoftAdmin\Tool\View;


class Home extends BaseView
{
    public $title = "首页";
    protected $view = 'home';

    public $leftMenu = [
        [
            'name' => 'Controller',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => '路由列表', 'icon' => '&#xe6b4;', 'url' => 'control/routes'],
                ['name' => '控制器', 'icon' => '&#xe6b4;', 'url' => 'control/list'],
                ['name' => '中间件', 'icon' => '&#xe6b4;', 'url' => 'mid/list'],
            ],
        ],
        [
            'name' => 'Model',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => 'Dao', 'icon' => '&#xe6b4;', 'url' => 'model/dao'],
                ['name' => 'Data', 'icon' => '&#xe6b4;', 'url' => 'model/data'],
                ['name' => 'logic', 'icon' => '&#xe6b4;', 'url' => 'model/logic'],
            ],
        ],
        [
            'name' => 'Console',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => 'Command', 'icon' => '&#xe6b4;', 'url' => 'console/command'],
            ],
        ],
        [
            'name' => 'Crontab',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => 'Crontab', 'icon' => '&#xe6b4;', 'url' => 'crontab/lists'],
            ],
        ],
    ];
}
