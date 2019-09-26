<?php


namespace SwoftAdmin\Tool\Model;

use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * 登录控制
 * @package SwoftAdmin\Tool\Model
 * @Bean()
 */
class LoginModel
{
    private $config;

    /**
     * 获取配置
     * @return array
     */
    public function getConfig(): array
    {
        if (!$this->config) {
            $path = alias("@config/__admin.php");
            if (!file_exists($path)) {
                $path = __DIR__."/../Config/user.config.php";
            }
            $config = include $path;

            $this->config = (array) $config;
        }

        return $this->config;
    }

    /**
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
        $config = $this->getConfig();
        $users = $config["users"] ?? [];
        if (!isset($users[$username])) {
            return "";
        }
        $password = $users[$username];
        $time = time();

        $str = $time.".".$username;
        return $str.".".md5($str.$password);
    }

    public function verifyToken($str): bool
    {
        $arr = explode('.', $str);
        if (count($arr) != 3) {
            return false;
        }

        $username = $arr[1];
        $time = $arr[0];

        if ( $time<(time()-3600*8) ){
            return false;
        }

        $sign = $arr[2];

        $config = $this->getConfig();
        $users = $config["users"] ?? [];
        if (!isset($users[$username])) {
            return false;
        }
        $password2 = $users[$username];
        $str = $time.".".$username;
        $sign2 = md5($str.$password2);
        return $sign2 == $sign;
    }
}
