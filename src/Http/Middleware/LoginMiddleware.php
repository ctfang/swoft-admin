<?php


namespace SwoftAdmin\Tool\Http\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class LoginMiddleware
 * @package SwoftAdmin\Tool\Http\Middleware
 * @Bean()
 */
class LoginMiddleware implements MiddlewareInterface
{
    public static $enable = null;

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     * @throws \Swoft\Exception\SwoftException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (self::$enable === null) {
            $enable = env('ADMIN_ENABLE', false);
        } else {
            $enable = self::$enable;
        }
        if ($enable) {
            return $handler->handle($request);
        }
        return context()->getResponse()->withContent("admin 未开启")->withStatus(404);
    }
}
