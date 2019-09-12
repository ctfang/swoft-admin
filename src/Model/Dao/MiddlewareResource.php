<?php


namespace Swoft\SwoftAdmin\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\SwoftAdmin\Model\Data\MiddlewareInfo;
use Swoft\SwoftAdmin\Model\Logic\Directory;

class  MiddlewareResource extends AnnotationResource
{
    public $list = [];

    /**
     * 扫描
     * @param  Directory  $loader
     * @return array
     * @throws \ReflectionException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function scan(Directory $loader): array
    {
        foreach ($loader->scanClass() as $className) {

            // Annotation reader
            $reflectionClass = new \ReflectionClass($className);

            // Fix ignore abstract
            if ($reflectionClass->isAbstract()) {
                continue;
            }

            $this->list[$className] = new MiddlewareInfo();
            $this->set($className)->title = $this->getTitle($reflectionClass->getDocComment());
            $this->set($className)->path = $className;

            // Annotation reader
            $reader = new AnnotationReader();

            $classAnnotations = $reader->getClassAnnotations($reflectionClass);
            // 类注解遍历
            foreach ($classAnnotations as $classAnnotation) {
                if ($classAnnotation instanceof Bean) {
                    $this->set($className)->bean = true;
                }
            }
            $this->set($className)->isGroup = $this->isGroup($className);
        }

        return $this->list;
    }

    /**
     * @param $className
     * @return MiddlewareInfo
     */
    public function set($className):MiddlewareInfo
    {
        return $this->list[$className];
    }

    /**
     * 全局中间件
     * @param $className
     * @return bool
     */
    public function isGroup($className):bool
    {
        $bean = include ROOT_PATH."/app/bean.php";
        $middlewares = $bean["httpDispatcher"]["middlewares"]??[];

        foreach ($middlewares as $str){
            if( $className ==$str  ){
                return true;
            }
        }
        return false;
    }
}
