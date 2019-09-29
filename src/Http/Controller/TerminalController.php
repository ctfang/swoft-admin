<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Log\Helper\Log;
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

        $root = alias("@app");
        $root = dirname($root);

        $command = "cd {$root};".$cmd;
        Log::info($command);
        exec($command, $arr);

        $str = implode("\n", $arr);
        return $str;
    }
}
