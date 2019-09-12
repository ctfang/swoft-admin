<?php


namespace Swoft\SwoftAdmin\Http\Controller;

use Swoft\Context\Context;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\SwoftAdmin\Exec\Exec;

/**
 * Class MiddlewareController
 * @package App\Http\Controller
 * @Controller(prefix="/__admin/mid")
 */
class MiddlewareController
{
    /**
     * 中间件列表
     * @RequestMapping(route="list")
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function mid()
    {
        $list = Exec::run("mids");

        $data['lists'] = array_values($list);

        return admin_view('mid/list', $data);
    }

    /**
     * 创建中间件显示界面
     * @RequestMapping(route="create",method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function create()
    {
        return admin_view('mid/create');
    }

    /**
     * 创建中间件
     * @RequestMapping(route="add")
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function createPost()
    {
        $className = Context::get()->getRequest()->post("className");
        $classTitle = Context::get()->getRequest()->post("classTitle");
        if (!$className) {
            return;
        }

        Exec::run('mids/add',$className,$classTitle);
    }
}
