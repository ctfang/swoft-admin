<?php


namespace Swoft\SwoftAdmin\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\SwoftAdmin\Model\Data\RouteInfo;
use Swoft\SwoftAdmin\Model\Logic\Directory;
use Swoft\Validator\Annotation\Mapping\Validate;

class RoutesResource extends AnnotationResource
{
    /**
     * 扫描路由信息
     * @param  Directory  $loader
     * @return array
     * @throws \ReflectionException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function scanRoutes(Directory $loader): array
    {
        $routes = [];

        foreach ($loader->scanClass() as $className) {

            // Annotation reader
            $reflectionClass = new \ReflectionClass($className);

            // Fix ignore abstract
            if ($reflectionClass->isAbstract()) {
                continue;
            }

            // Annotation reader
            $reader = new AnnotationReader();
            $className = $reflectionClass->getName();

            $classAnnotations = $reader->getClassAnnotations($reflectionClass);
            // 类注解遍历
            foreach ($classAnnotations as $classAnnotation) {
                if ($classAnnotation instanceof Controller) {
                    // 函数遍历
                    $reflectionMethods = $reflectionClass->getMethods();
                    foreach ($reflectionMethods as $reflectionMethod) {
                        $methodName        = $reflectionMethod->getName();
                        $methodAnnotations = $reader->getMethodAnnotations($reflectionMethod);

                        if (!empty($methodAnnotations)) {
                            $oneClassAnnotation['methods'][$methodName]['annotation'] = $methodAnnotations;
                            $oneClassAnnotation['methods'][$methodName]['reflection'] = $reflectionMethod;
                            $routeInfo = new RouteInfo();
                            $routeInfo->title = $this->getTitle($reflectionMethod->getDocComment());
                            $routeInfo->controller = $className;
                            $routeInfo->action = $reflectionMethod->getName();

                            foreach ($methodAnnotations as $annotation){
                                if ($annotation instanceof RequestMapping){
                                    $routeInfo->path  = $classAnnotation->getPrefix()?
                                        $classAnnotation->getPrefix()."/".$annotation->getRoute():$annotation->getRoute();
                                    $routeInfo->method  = $annotation->getMethod();
                                }elseif ($annotation instanceof Validate){
                                    $routeInfo->validator  = $annotation;
                                }
                            }

                            $routes[] = $routeInfo;
                        }
                    }
                }
            }
        }
        return $routes;
    }

}
