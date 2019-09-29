<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Log\Helper\CLog;
use Swoft\Log\Helper\Log;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;
use SwoftAdmin\Tool\View\Button\NewWindow;
use SwoftAdmin\Tool\View\Button\NewWindowIcon;
use SwoftAdmin\Tool\View\Button\ReloadButton;
use SwoftAdmin\Tool\View\FileContent;
use SwoftAdmin\Tool\View\Logs;
use SwoftAdmin\Tool\View\Table;

/**
 * Class LogsController
 * @package SwoftAdmin\Tool\Http\Controller
 * @Controller(prefix="/__admin/logs")
 * @Middleware(LoginMiddleware::class)
 */
class LogsController
{
    /**
     * 进程文件
     * @RequestMapping("runtime")
     */
    public function runtime()
    {
        $view = new Table();
        $view->title = "运行缓存目录";
        $view->listTitle = [
            "id" => 'ID',
            "path" => 'File',
            "size" => 'Size',
        ];

        $view->listData = $this->getFiles("@runtime/");

        $button = new NewWindowIcon('logs/runtimeFile', '文件内容');
        $button->mix = "true";
        $button->addField(['path' => 'path']);
        $view->addListButton($button);

        $button = new NewWindowIcon('logs/runtimeDown', '文件下载', '&#xe601;');
        $button->addField(['path' => 'path']);
        $view->addListButton($button);

        return $view->toString();
    }

    /**
     * 获取目录下文件列表
     * @param $path
     * @return array
     */
    private function getFiles($path)
    {
        $root = alias($path);
        $list = scandir($root);
        $arr = [];
        foreach ($list as $key => $item) {
            if (in_array($item, ['', '.', '..']) || is_dir($root.$item)) {
                continue;
            }
            $arr[] = [
                'path' => $path.$item,
                'size' => filesize($root.$item),
            ];
        }
        return $arr;
    }

    /**
     * 日记文件
     * @RequestMapping("logs")
     */
    public function logs()
    {
        $view = new Table();
        $view->title = "运行缓存目录";
        $view->listTitle = [
            "id" => 'ID',
            "path" => 'File',
            "size" => 'Size',
        ];

        $view->listData = $this->getFiles("@runtime/logs/");

        $button = new NewWindowIcon('logs/runtimeFile', "日志内容,倒序300行,如果多于300行,需要另行下载");
        $button->mix = "true";
        $button->addField(['path' => 'path']);
        $view->addListButton($button);

        $button = new NewWindowIcon('logs/runtimeDown', '文件下载', '&#xe601;');
        $button->addField(['path' => 'path']);
        $view->addListButton($button);

        return $view->toString();
    }


    /**
     * 查看文件
     * @RequestMapping("runtimeFile")
     * @param  Request  $request
     * @return FileContent
     */
    public function runtimeFile(Request $request)
    {
        $path = $request->get("path");
        $path = $this->getPath($path);

        $view = new Logs();
        $view->title = "显示控制器内容";
        $view->layContent = $this->getLastLines($path, 300);
        return $view->toString();
    }

    /**
     * 过滤不安全的路径
     * @param $path
     * @return string
     */
    private function getPath($path)
    {
        $path = str_replace('..', '', $path);
        if ( $path{0}!="@" ){
            Log::error("不能使用非 @ 开头路径");
            CLog::error("不能使用非 @ 开头路径");
            return "";
        }
        return alias($path);
    }

    /**
     * 下载日记文件
     * @RequestMapping("runtimeDown")
     * @param  Request  $request
     * @param  Response  $response
     * @return Response
     */
    public function runtimeDown(Request $request, Response $response)
    {
        $path = $request->get("path");
        $path = $this->getPath($path);
        $fileName = pathinfo($path,PATHINFO_BASENAME);

        $response->getCoResponse()->header('Content-Disposition',"attachment; filename={$fileName}");

        return $response->file($path, "application/octet-stream");
    }

    /**
     * 读取文件尾数行数
     * @param $file
     * @param  int  $line
     * @return string
     */
    public function getLastLines($file, $line = 1)
    {
        if (!$fp = fopen($file, 'r')) {
            Log::error("不能打开文件{$file}");
            CLog::error("不能打开文件{$file}");
            return "不能打开文件{$file}";
        }
        $pos = -2;
        $eof = "";
        $str = "";
        $head = false;
        while ($line > 0) {
            while ($eof != "\n") {
                if (!fseek($fp, $pos, SEEK_END)) {
                    $eof = fgetc($fp);
                    $pos--;
                } else {
                    fseek($fp, 0, SEEK_SET);
                    $head = true;
                    break;
                }
            }
            $str .= fgets($fp);
            if ($head) {
                break;
            }
            $eof = "";
            $line--;
        }
        return $str;
    }
}
