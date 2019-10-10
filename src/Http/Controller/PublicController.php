<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use SwoftAdmin\Tool\Model\LoginModel;
use SwoftAdmin\Tool\View\Login;
use SwoftAdmin\Tool\Http\Middleware\LoginMiddleware;

/**
 * Class PublicController
 * @package SwoftAdmin\Tool\Http\Controller
 * @Controller(prefix="/__admin")
 * @Middleware(LoginMiddleware::class)
 */
class PublicController
{
    /**
     * @Inject()
     * @var LoginModel
     */
    protected $login;

    /**
     * @RequestMapping(route="/__admin",method={RequestMethod::GET})
     * @param  Request  $request
     * @param  Response  $response
     * @return Response|Login
     */
    public function base(Request $request, Response $response)
    {
        if (env('ADMIN_ENABLE_LOGIN', true)) {
            return $response->redirect('/__admin/login');
        }
        return $response->redirect('/__admin/home');
    }

    /**
     * show login
     * @RequestMapping("login",method={RequestMethod::GET})
     * @param  Request  $request
     * @return Response|Login
     */
    public function login(Request $request, Response $response)
    {
        $view = new Login();
        $view->url = 'login';

        return $view->toString();
    }

    /**
     * login
     * @RequestMapping("login",method={RequestMethod::POST})
     * @param  Request  $request
     * @param  Response  $response
     * @return Response
     */
    public function loginPost(Request $request, Response $response)
    {
        $username = $request->post("username");
        $password = $request->post("password");

        if ($this->login->login($username, $password)) {
            $token = $this->login->getToken($username);
            return $response->withCookie($this->login->tokenKey, $token)->redirect('/__admin/home?'.$this->login->tokenKey."=".$token);
        }

        return $response->redirect('login');
    }

    /**
     * 退出登录
     * @RequestMapping("logout")
     * @param  Request  $request
     * @param  Response  $response
     * @return \Swoft\Http\Message\Concern\CookiesTrait|Response
     */
    public function logout(Request $request, Response $response)
    {
        return $response->withCookie($this->login->tokenKey,'')->redirect('/__admin/login');
    }
}
