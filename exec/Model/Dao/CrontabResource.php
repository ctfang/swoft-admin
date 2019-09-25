<?php


namespace SwoftAdmin\Exec\Model\Dao;

use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Crontab\Annotaion\Mapping\Cron;
use Swoft\Crontab\Annotaion\Mapping\Scheduled;
use SwoftAdmin\Exec\Model\Logic\Directory;

class CrontabResource extends AnnotationResource
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
                if ($classAnnotation instanceof Scheduled) {
                    // 函数遍历
                    $reflectionMethods = $reflectionClass->getMethods();
                    foreach ($reflectionMethods as $reflectionMethod) {
                        $methodName        = $reflectionMethod->getName();
                        $methodAnnotations = $reader->getMethodAnnotations($reflectionMethod);

                        if (!empty($methodAnnotations)) {
                            foreach ($methodAnnotations as $annotation){
                                if ($annotation instanceof Cron){
                                    $info['handel'] = $reflectionClass->getName().'@'.$methodName;
                                    $info['key'] = $reflectionClass->getName().'@'.$methodName;
                                    $info['cron'] = $annotation->getValue();

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
