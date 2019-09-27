<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Tool\View\FileContent;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;

/**
 * Class Console
 * @package Swoft\SwoftAdmin\Http\Controller
 * @Controller(prefix="/__admin/file")
 * @Middleware(LoginMiddleware::class)
 */
class FilesController
{
    /**
     * @RequestMapping("show")
     * @param  Request  $request
     * @return FileContent
     */
    public function show(Request $request)
    {
        $namespace = $request->get("path");

        $arr = explode('App\\', $namespace);

        if ( count($arr)==2 ){
            $file = end($arr);
            $path = alias('@app/'.$file.'.php');
        }else{
            unset($arr[0]);
            $file = implode('/',$arr);
            $path = alias('@app/'.$file.'.php');
        }

        $path = str_replace(['\\'],['/'],$path);

        $view = new FileContent();
        $view->title = "显示控制器内容";
        $view->layContent = file_get_contents($path);
        return $view->toString();
    }
}
