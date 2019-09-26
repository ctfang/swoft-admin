<?php


namespace SwoftAdmin\Tool\Http\Controller;

use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use SwoftAdmin\Tool\Model\LoginModel;
use SwoftAdmin\Tool\View\Login;

/**
 * Class PublicController
 * @package SwoftAdmin\Tool\Http\Controller
 * @Controller(prefix="/__admin")
 */
class PublicController
{
    /**
     * @Inject()
     * @var LoginModel
     */
    protected $login;

    /**
     * show login
     * @RequestMapping("login",method={RequestMethod::GET})
     */
    public function login()
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
    public function loginPost(Request $request,Response $response)
    {
        $username = $request->post("username");
        $password = $request->post("password");

        if ( $this->login->login($username,$password) ){
            $token = $this->login->getToken($username);
            return $response->withCookie("__admin_token",$token)->redirect('/__admin/home');
        }

        return $response->redirect('login');
    }
}
