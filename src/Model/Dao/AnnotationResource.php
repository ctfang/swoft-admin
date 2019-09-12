<?php


namespace Swoft\SwoftAdmin\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Stdlib\Helper\DirectoryHelper;
use Swoft\SwoftAdmin\Model\Data\RouteInfo;
use Swoft\SwoftAdmin\Model\Logic\Directory;
use Swoft\Validator\Annotation\Mapping\Validate;
use function Swlib\Http\str;

/**
 * Class AnnotationResource
 * @package Swoft\SwoftAdmin\Model\Dao
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
        if( $title{0}=="@" ){
            return "";
        }
        return $title;
    }

    /**
     * 扫描命名空间下的注解
     * @param  Directory  $loader
     * @throws \ReflectionException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function scanAnnotation(Directory $loader): void
    {
        foreach ($loader->scanClass() as $className) {
            // Annotation reader
            $reflectionClass = new \ReflectionClass($className);

            // Fix ignore abstract
            if ($reflectionClass->isAbstract()) {
                return;
            }

            // Annotation reader
            $reader = new AnnotationReader();
            $className = $reflectionClass->getName();

            $classAnnotations = $reader->getClassAnnotations($reflectionClass);
            // Register annotation parser
            foreach ($classAnnotations as $classAnnotation) {
                if ($classAnnotation instanceof AnnotationParser) {
                    print_r($classAnnotation);

                    echo "\n";
                }
            }
        }
    }
}
