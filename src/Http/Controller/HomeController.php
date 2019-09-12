<?php


namespace Swoft\SwoftAdmin\Http\Controller;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * Class HomeController
 * @package Swoft\SwoftAdmin\Http\Controller
 * @Controller()
 */
class HomeController
{
    /**
     * @RequestMapping("/__admin")
     */
    public function home()
    {
        return admin_view("home");
    }

    /**
     * @RequestMapping("/__admin/welcome")
     */
    public function welcome()
    {
        return admin_view("home/welcome");
    }
}
