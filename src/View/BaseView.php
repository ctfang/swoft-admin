<?php


namespace SwoftAdmin\Tool\View;

use Swoft;
use Swoft\Context\Context;
use Swoft\Http\Message\Response;
use Swoft\View\Renderer;

class BaseView
{
    public $title = "模板使用X-admin,感谢 X-admin 开源者";
    protected $view;
    protected $layout = "layouts/base";
    protected $viewLink = [];
    protected $viewScript = [];

    /**
     * CSS资源
     * @param  string  $href
     * @param  string  $rel
     */
    public function link(string $href, string $rel = 'stylesheet')
    {
        $href = admin_src(false).$href;
        $this->viewLink[] = "<link rel=\"{$rel}\" href=\"{$href}\">";
    }

    /**
     * js脚本地址
     * @param  string  $src
     */
    public function script(string $src)
    {
        $this->viewScript[] = "<script src=\"".$src."\"></script>";
    }

    public function toString()
    {
        $viewPath = dirname(dirname(__DIR__))."/resource/";
        /**
         * @var Renderer $renderer
         * @var Response $response
         */
        $renderer = Swoft::getSingleton('view');
        $renderer->setViewsPath($viewPath);
        $response = Context::get()->getResponse();

        $data['data'] = $this;

        $output = $renderer->fetch($viewPath.$this->view, $data);

        $data['viewLink'] = $this->viewLink;
        $data['viewScript'] = $this->viewScript;
        $content = $renderer->renderContent($output, $data, $this->layout);


        return $response
            ->withContent($content)
            ->withHeader('Content-Type', 'text/html');
    }
}
