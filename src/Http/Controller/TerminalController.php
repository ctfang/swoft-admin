<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Server\HttpServer;
use Swoft\Log\Helper\Log;
use SwoftAdmin\Tool\Http\AdminServer;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;
use SwoftAdmin\Tool\View\TerminalView;

/**
 * Class RouteController
 * @package App\Http\Console
 * @Controller(prefix="/__admin/terminal")
 * @Middleware(LoginMiddleware::class)
 */
class TerminalController
{
    /**
     * @RequestMapping("index")
     */
    public function index()
    {
        $view = new TerminalView();

        return $view->toString();
    }

    /**
     * 运行命令
     * @RequestMapping("run",method={RequestMethod::POST})
     * @param  Request  $request
     * @return string
     */
    public function runCmd(Request $request)
    {
        $cmd = $request->post("run");

        if (!$cmd) {
            return "\n";
        }

        $str = $this->run($cmd);
        $str = str_replace("]", "\]", $str);
        return "[[;darkgreen;]{$str}]";
    }

    /**
     * buttonEvent运行命令
     * @RequestMapping("button/run",method={RequestMethod::POST})
     * @param  Request  $request
     * @return string
     */
    public function buttonEvent(Request $request)
    {
        $cmd = $request->post("run");

        if (!$cmd) {
            return "\n";
        }

        switch ($cmd) {
            case "restart":
                return $this->button_restart();
                break;
            case "stopAdmin":
                $this->run("php bin/swoft admin:stop&");
                if (AdminServer::$enable===1){
                    bean('adminServer')->stop();
                    return "[[;red;]已经发生异步处理]";
                }else{
                    AdminServer::$enable = 0;
                    return "[[;darkgreen;]已经禁用admin]";
                }
                break;
            default:
                $str = $this->run($cmd);
                $str = str_replace("]", "\]", $str);
                return "[[;darkgreen;]{$str}]";
        }
    }

    private function button_restart()
    {
        if (AdminServer::$enable===1){
            // 由admin启动的,可以隔离启动
            $str = $this->run("php bin/swoft http:restart");
            $str = str_replace("]", "\]", $str);
            return "[[;darkgreen;]{$str}]";
        }else{
            // http:start 内部启动admin
            $str = $this->run("php bin/swoft http:restart&");
            return "[[;red;]已经发生异步处理]";
        }
    }

    private function run($cmd):string
    {
        $root = alias("@app");
        $root = dirname($root);

        $command = "cd {$root};".$cmd;
        Log::info($command);
        exec($command, $arr);

        return implode("\n", $arr);
    }
}
