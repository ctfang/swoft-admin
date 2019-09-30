<?php


namespace SwoftAdmin\Tool\View;

/**
 * 首页
 * @package SwoftAdmin\Tool\View
 */
class Home extends BaseView
{
    public $title = "首页";
    protected $view = 'home';
    public $username = 'admin';
    public $token = '';
    public $tokenKey = '__admin_token';

    protected static $merMenu = [];

    /**
     * @param $url
     * @param $name
     * @param  string  $icon
     * @param  null  $group  分组名称
     */
    public static function addBaseMenu($url, $name, $icon = '&#xe6b4;', $group = null)
    {
        self::$merMenu[$group][$name] = ['icon' => $icon, 'url' => $url];
    }

    /**
     * 获取菜单
     * @return array
     */
    public function getLeftMenu()
    {
        $menu = $this->leftMenu;

        foreach (self::$merMenu as $group => $arr) {
            foreach ($arr as $name => $con) {
                $con['name'] = $name;
                if ($group) {
                    $menu[$group]['ul'][] = $con;
                } else {
                    $menu[$name] = $con;
                }
            }
        }
        return $menu;
    }

    /**
     * @var array 基础菜单
     */
    public $leftMenu = [
        "Http" => [
            'name' => 'Http',
            'icon' => '&#xe828;',
            'ul' => [
                ['name' => '路由列表', 'icon' => '&#xe6fa;', 'url' => 'control/routes'],
                ['name' => '控制器', 'icon' => '&#xe6fa;', 'url' => 'control/list'],
                ['name' => '中间件', 'icon' => '&#xe6fa;', 'url' => 'mid/list'],
            ],
        ],
        "Model" => [
            'name' => 'Model',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => 'Dao', 'icon' => '&#xe6fa;', 'url' => 'model/dao'],
                ['name' => 'Data', 'icon' => '&#xe6fa;', 'url' => 'model/data'],
                ['name' => 'logic', 'icon' => '&#xe6fa;', 'url' => 'model/logic'],
            ],
        ],
        "Console" => [
            'name' => 'Console',
            'icon' => '&#xe723;',
            'ul' => [
                ['name' => 'Command', 'icon' => '&#xe6fa;', 'url' => 'console/command'],
            ],
        ],
        "Crontab" => [
            'name' => 'Crontab',
            'icon' => '&#xe829;',
            'ul' => [
                ['name' => 'Crontab', 'icon' => '&#xe70c;', 'url' => 'crontab/lists'],
            ],
        ],
        "Logs" => [
            'name' => 'Logs',
            'icon' => '&#xe83c;',
            'ul' => [
                ['name' => 'Logs', 'icon' => '&#xe724;', 'url' => 'logs/logs'],
                ['name' => 'Runtime', 'icon' => '&#xe724;', 'url' => 'logs/runtime'],
            ],
        ],
    ];
}
