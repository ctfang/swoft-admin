<?php


namespace SwoftAdmin\Exec\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use SwoftAdmin\Exec\Model\Logic\Directory;
use function Swlib\Http\str;

/**
 * Class AnnotationResource
 * @package SwoftAdmin\Exec\Model\Dao
 */
class AnnotationResource
{
    public function getTitle($doc):string
    {
        $title = "";

        $arr = explode(PHP_EOL,$doc);

        foreach ($arr as $str){
            $str = str_replace(["/","*"],"",$str);
            $str = trim($str);

            if (strlen($str)>0){
                $title = $str;
                break;
            }
        }
        if( strlen($title)<1 || $title{0}=="@" ){
            return "";
        }
        return $title;
    }
}
