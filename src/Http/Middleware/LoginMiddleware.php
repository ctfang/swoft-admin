<?php


namespace SwoftAdmin\Tool\Http\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use SwoftAdmin\Tool\Model\LoginModel;

/**
 * Class LoginMiddleware
 * @package SwoftAdmin\Tool\Http\Middleware
 * @Bean()
 */
class LoginMiddleware implements MiddlewareInterface
{
    public static $enable = null;

    /**
     * @Inject()
     * @var LoginModel
     */
    protected $login;

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
        if (!$enable) {
            return context()->getResponse()->withContent("admin 未开启")->withStatus(404);
        }

        $token    = $this->login->getRequestToken($request);

        if ( !$token || !$this->login->verifyToken($token) ){
            $path = $request->getUri()->getPath();
            if ( $path!=admin_url("login",false) ){
                return context()->getResponse()->redirect(admin_url("login",false));
            }
        }

        return $handler->handle($request);
    }
}
