<?php

use Swoft\Context\Context;
use Swoft\Http\Message\Response;
use Swoft\View\Renderer;

if (!function_exists('admin_url')) {
    function admin_url(string $url)
    {
        echo "/__admin/".$url;
    }
}

if (!function_exists('admin_src')) {
    function admin_src()
    {
        echo env('ADMIN_WEB',"http://admin.com/web/");
    }
}

if (!function_exists('admin_view')) {
    /**
     * @param string            $template
     * @param array             $data
     * @param string|null|false $layout
     *
     * @return Response
     * @throws Throwable
     */
    function admin_view(string $template, array $data = [], $layout = null)
    {
        $viewPath = dirname(__DIR__)."/resource/views/";
        /**
         * @var Renderer $renderer
         * @var Response $response
         */
        $renderer = Swoft::getSingleton('view');
        $renderer->setViewsPath($viewPath);
        $response = Context::get()->getResponse();
        $content  = $renderer->render($viewPath.$template, $data, $layout);

        return $response
            ->withContent($content)
            ->withHeader('Content-Type', 'text/html');
    }
}
