<?php


namespace SwoftAdmin\Tool\Http;

/**
 * Class Msg
 * @package SwoftAdmin\Tool\Http
 */
class Msg
{
    /**
     * @param  array  $data
     * @return array
     */
    public static function success(array $data = []): array
    {
        return [
            "code" => 0,
            "msg" => "OK",
            "data" => $data,
        ];
    }

    /**
     * @param  string  $msg
     * @param  int  $code
     * @return array
     */
    public static function error(string $msg = "", int $code = 1): array
    {
        return [
            "code" => $code,
            "msg" => $msg,
            "data" => [],
        ];
    }
}
