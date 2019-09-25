<?php


namespace SwoftAdmin\Exec\Controller;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use SwoftAdmin\Exec\Application;
use Swoft\Validator\Annotation\Mapping\Validate;

class Postmen
{
    /** @var AnnotationReader */
    private $reader;

    public function down()
    {
        $loader = Application::getDirectory('App\\Http\\Controller');

        // Annotation reader
        $this->reader = new AnnotationReader();

        $postmen = [];

        foreach ($loader->scanClass() as $className) {

            // Annotation reader
            $reflectionClass = new \ReflectionClass($className);

            // Fix ignore abstract
            if ($reflectionClass->isAbstract()) {
                continue;
            }
            $postmen['info'] = $this->getInfo();
            $classAnnotations = $this->reader->getClassAnnotations($reflectionClass);
            // 类注解遍历
            foreach ($classAnnotations as $classAnnotation) {
                if ($classAnnotation instanceof Controller) {
                    $postmen['item'][] = $this->getControllerItem($reflectionClass,$classAnnotation);
                }
            }
        }

        return $postmen;
    }

    protected function getInfo()
    {
        return [
            "_postman_id" => uniqid(),
            "name" => "swoft-admin",
            "schema" => "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
        ];
    }

    protected function getControllerItem(\ReflectionClass $reflectionClass,Controller $classAnnotation)
    {
        $itemList = [];
        $itemList['name'] = $this->getTitle($reflectionClass->getDocComment());
        $itemList['item'] = [];

        $reflectionMethods = $reflectionClass->getMethods();
        foreach ($reflectionMethods as $reflectionMethod) {
            $action = [];
            $action['name']        = $this->getTitle($reflectionMethod->getDocComment());
            $action['event']        = $this->getTestEvent();

            $prefix = $classAnnotation->getPrefix();
            $url = [];
            $methodAnnotations = $this->reader->getMethodAnnotations($reflectionMethod);
            if (!empty($methodAnnotations)) {
                foreach ($methodAnnotations as $annotation){
                    $url = [];
                    $body = [];
                    if ($annotation instanceof RequestMapping){
                        $path  = $prefix?$prefix."/".$annotation->getRoute():$annotation->getRoute();
                        $url['raw'] = "{{url}}".$path;
                        $url['host'] = ["{{url}}"];
                        $url['path'] = explode('/',$path);
                        $methods     = $annotation->getMethod();
                        $method = "GET";
                        if ($methods){
                            $method = reset($methods);
                        }
                    }elseif ($annotation instanceof Validate){
                        $body['mode'] = "formdata";
                        $body['formdata'] = [];
                    }
                }

                if ($url){
                    $action["request"]["url"] = $url;
                    $action["request"]["body"] = $body;
                    $action["request"]["method"] = $method;
                    $itemList['item'][] = $action;
                }
            }
        }
        return $itemList;
    }

    /**
     * 是否生成自动测试
     * @return array
     */
    protected function getTestEvent()
    {
        return [
            [
                "listen"=> "test",
                "script"=>[
                    "exec"=>[
                        "var data = JSON.parse(responseBody)",
                        "if(data.code == '0'){",
                        "    tests[\"this code is 0\"] = true",
                        "}else{",
                        "    tests[\"hhas error code \"] = false",
                        "}"
                    ],
                ],
                "type"=> "text/javascript"
            ],
        ];
    }

    /**
     * 第一行注释
     * @param $doc
     * @return string
     */
    protected function getTitle($doc):string
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
}
