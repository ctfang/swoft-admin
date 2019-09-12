<?php


namespace Swoft\SwoftAdmin\Exec;


class Exec
{
    public static $mainPath;

    public static function run(string $route,...$arr)
    {
        $data = [];
        $path = self::$mainPath;

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
            $data = $data[0];
            $data = unserialize($data);
            return $data;
        }catch (\Exception $exception){
            return [];
        }
    }
}
