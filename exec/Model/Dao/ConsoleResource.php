<?php


namespace SwoftAdmin\Exec\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use SwoftAdmin\Exec\Model\Logic\Directory;

/**
 * Class ConsoleResource
 * @package SwoftAdmin\Exec\Model\Dao
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
