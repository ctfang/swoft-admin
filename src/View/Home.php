<?php


namespace SwoftAdmin\Tool\View;


class Home extends BaseView
{
    public $title = "首页";
    protected $view = 'home';
    public $username = 'admin';
    public $token = '';
    public $tokenKey = '__admin_token';

    protected static $merMenu = [];

    public static function addBaseMenu($url, $name, $icon = '&#xe6b4;', $group = null)
    {
        self::$merMenu[$group][$name] = ['icon' => $icon, 'url' => $url];
    }

    public function getLeftMenu()
    {
        $menu = $this->leftMenu;

        foreach (self::$merMenu as $group=>$arr){
            foreach ($arr as $name=>$con){
                $con['name'] = $name;
                if( $group ){
                    $menu[$group]['ul'][] = $con;
                }else{
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
        "Controller"=>[
            'name' => 'Controller',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => '路由列表', 'icon' => '&#xe6b4;', 'url' => 'control/routes'],
                ['name' => '控制器', 'icon' => '&#xe6b4;', 'url' => 'control/list'],
                ['name' => '中间件', 'icon' => '&#xe6b4;', 'url' => 'mid/list'],
            ],
        ],
        "Model"=>[
            'name' => 'Model',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => 'Dao', 'icon' => '&#xe6b4;', 'url' => 'model/dao'],
                ['name' => 'Data', 'icon' => '&#xe6b4;', 'url' => 'model/data'],
                ['name' => 'logic', 'icon' => '&#xe6b4;', 'url' => 'model/logic'],
            ],
        ],
        "Console"=>[
            'name' => 'Console',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => 'Command', 'icon' => '&#xe6b4;', 'url' => 'console/command'],
            ],
        ],
        "Crontab"=>[
            'name' => 'Crontab',
            'icon' => '&#xe6b4;',
            'ul' => [
                ['name' => 'Crontab', 'icon' => '&#xe6b4;', 'url' => 'crontab/lists'],
            ],
        ],
    ];
}
