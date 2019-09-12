<?php


namespace Swoft\SwoftAdmin\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\SwoftAdmin\Model\Data\RouteInfo;
use Swoft\SwoftAdmin\Model\Logic\Directory;
use Swoft\Validator\Annotation\Mapping\Validate;

/**
 * Class ConsoleResource
 * @package Swoft\SwoftAdmin\Model\Dao
 */
class ConsoleResource extends AnnotationResource
{
    public function scan(Directory $loader)
    {
        $list = [];

        foreach ($loader->scanClass() as $className) {
            $info = [];
            // Annotation reader
            $reflectionClass = new \ReflectionClass($className);

            // Fix ignore abstract
            if ($reflectionClass->isAbstract()) {
                continue;
            }

            // Annotation reader
            $reader = new AnnotationReader();

            $classAnnotations = $reader->getClassAnnotations($reflectionClass);
            // 类注解遍历
            foreach ($classAnnotations as $classAnnotation) {
                if ($classAnnotation instanceof Command) {
                    // 函数遍历
                    $reflectionMethods = $reflectionClass->getMethods();
                    foreach ($reflectionMethods as $reflectionMethod) {
                        $methodName        = $reflectionMethod->getName();
                        $methodAnnotations = $reader->getMethodAnnotations($reflectionMethod);

                        if (!empty($methodAnnotations)) {
                            foreach ($methodAnnotations as $annotation){
                                if ($annotation instanceof CommandMapping){
                                    $info['handel'] = $reflectionClass->getName().'@'.$methodName;
                                    $info['key'] = $reflectionClass->getName().'@'.$methodName;
                                    $info['des'] = $annotation->getDesc();
                                    $info['name'] = $classAnnotation->getName().":".$annotation->getName();

                                    $list[] = $info;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $list;
    }
}
