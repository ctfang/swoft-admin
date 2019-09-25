<?php


namespace SwoftAdmin\Exec\Model\Dao;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use SwoftAdmin\Exec\Model\Data\MiddlewareInfo;
use SwoftAdmin\Exec\Model\Logic\Directory;

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
            try{
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
            }catch (\Throwable $exception){
                continue;
            }
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
        $beanPath = getRootPath()."/app/bean.php";
        $bean = include $beanPath;
        $middlewares = $bean["httpDispatcher"]["middlewares"]??[];

        foreach ($middlewares as $str){
            if( $className ==$str  ){
                return true;
            }
        }
        return false;
    }
}
