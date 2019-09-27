<?php


namespace SwoftAdmin\Tool\Model;

use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * 登录控制
 * @package SwoftAdmin\Tool\Model
 * @Bean()
 */
class LoginModel
{
    private $config;

    public $tokenKey = '__admin_token';

    public function __construct()
    {
        $path = alias("@config/__admin.php");
        if (!file_exists($path)) {
            $path = __DIR__."/../Config/user.config.php";
        }
        $config = include $path;

        $this->config = (array) $config;
    }

    public function getRequestToken(ServerRequestInterface $request)
    {
        $cookie = $request->getCookieParams();
        $token = $cookie[$this->tokenKey] ?? "";
        if (!$token) {
            $token = $request->get($this->tokenKey);
        }

        return $token;
    }

    /**
     * 获取配置
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * 检查登录
     * @param $username
     * @param $password
     * @return bool
     */
    public function login($username, $password): bool
    {
        $config = $this->getConfig();
        $users = $config["users"] ?? [];
        if (!isset($users[$username])) {
            return false;
        }
        if (!password_verify($password, $users[$username])) {
            return false;
        }
        return true;
    }

    /**
     * 登录成功生成token
     * @param $username
     * @return string
     */
    public function getToken($username): string
    {
        return $this->getSign($username, time());
    }

    /**
     * 检查是否有效
     * @param $str
     * @return bool
     */
    public function verifyToken($str): bool
    {
        $arr = explode('.', $str);
        if (count($arr) != 3) {
            return false;
        }
        $username = $arr[1];
        $time = $arr[0];

        if ($time < (time() - 3600 * 8)) {
            return false;
        }
        $str2 = $this->getSign($username, $time);
        $eq = ($str == $str2);
        return $eq;
    }

    private function getSign($username, $time)
    {
        $config = $this->getConfig();
        $users = $config["users"] ?? [];
        if (!isset($users[$username])) {
            return "";
        }
        $password = $users[$username];
        $str = $time.".".$username;
        return $str.".".md5($str.$password);
    }
}
