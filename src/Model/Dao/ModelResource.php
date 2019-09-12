<?php


namespace Swoft\SwoftAdmin\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\SwoftAdmin\Model\Data\ClassInfo;
use Swoft\SwoftAdmin\Model\Logic\Directory;

class ModelResource extends AnnotationResource
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

            $info['title'] = $this->getTitle($reflectionClass->getDocComment());
            $info['path'] = $className;
            $info['key'] = $className;
            $info['bean'] = "否";

            // Annotation reader
            $reader = new AnnotationReader();

            $classAnnotations = $reader->getClassAnnotations($reflectionClass);
            // 类注解遍历
            foreach ($classAnnotations as $classAnnotation) {
                if ($classAnnotation instanceof Bean) {
                    $info['bean'] = "是";
                }
            }
            $list[] = $info;
        }

        return $list;
    }
}
