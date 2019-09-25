<?php


namespace SwoftAdmin\Tool;


use SwoftAdmin\Tool\Model\CallModel;

class Exec
{
    public static function run(string $route,...$arr)
    {
        $data = [];
        $path = dirname(__DIR__).'/main.php';

        $str = "";
        if ($arr){
            foreach ($arr as $item){
                if( is_array($item) ){
                    $str .= " ".implode(" ",$item);
                }else{
                    $str .= " ".$item;
                }
            }
        }

        exec("php {$path} {$route}{$str}",$data);

        if (!isset($data[0])){
            return [];
        }
        try{
            $res = $data[0];
            $res = unserialize($res);
            return $res;
        }catch (\Exception $exception){
            print_r($data);
        }
    }

    /**
     * Get bean by name
     *
     * @param  string  $class
     * @return object|string|mixed
     */
    public static function bean(string $class)
    {
        $call = new CallModel($class);
        return $call;
    }
}
