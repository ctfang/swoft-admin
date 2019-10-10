<?php


namespace SwoftAdmin\Tool\Http\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use SwoftAdmin\Tool\Http\AdminServer;
use SwoftAdmin\Tool\Model\LoginModel;

/**
 * Class LoginMiddleware
 * @package SwoftAdmin\Tool\Http\Middleware
 * @Bean()
 */
class LoginMiddleware implements MiddlewareInterface
{
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
        if (AdminServer::$enable === null) {
            $enable = env('ADMIN_ENABLE', false);
        } else {
            $enable = AdminServer::$enable;
        }
        // 检查开关
        if (!$enable) {
            return context()->getResponse()->withContent("admin 未开启")->withStatus(404);
        }
        // 检查是否限制IP
        $allow = env("ADMIN_ALLOW","*.*.*.*");
        if ( $allow!=="*.*.*.*" ){
            $remoteAddr = $request->getHeader('x-real-ip');
            $accept = true;
            $allowARR = explode('.',$allow);
            foreach ($remoteAddr as $str){
                $strArr = explode('.',$str);
                foreach ($allowARR as $key=>$item){
                    if ( $item!="*" && $strArr[$key]!=$item ){
                        $accept = false;
                        break 2;
                    }
                }
            }
            if (!$accept){
                return context()->getResponse()->withContent("限制IP访问")->withStatus(404);
            }
        }

        // 检查是否需登录
        if (env('ADMIN_ENABLE_LOGIN', true)) {
            $token = $this->login->getRequestToken($request);

            if (!$token || !$this->login->verifyToken($token)) {
                $path = $request->getUri()->getPath();
                if ($path != admin_url("login", false)) {
                    return context()->getResponse()->redirect(admin_url("login", false));
                }
            }
        }

        return $handler->handle($request);
    }
}
