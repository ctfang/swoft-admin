<?php


namespace Swoft\SwoftAdmin\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\SwoftAdmin\Model\Data\ControllerInfo;
use Swoft\SwoftAdmin\Model\Logic\Directory;

class ControllerResource extends AnnotationResource
{
    /**
     * 扫描控制器
     * @param  Directory  $loader
     * @return array
     * @throws \ReflectionException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function scanController(Directory $loader): array
    {
        $list = [];

        foreach ($loader->scanClass() as $className) {

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
                if ($classAnnotation instanceof Controller) {
                    $con = new ControllerInfo();
                    $con->title = $this->getTitle($reflectionClass->getDocComment());
                    $con->path = $className;
                    $con->prefix = $classAnnotation->getPrefix();
                    $list[] = $con;
                }
            }
        }
        return $list;
    }
}
