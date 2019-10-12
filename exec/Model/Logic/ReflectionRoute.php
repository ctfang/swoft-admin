<?php


namespace SwoftAdmin\Exec\Model\Logic;


use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Validator\Annotation\Mapping\Type;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Validator\Annotation\Mapping\Validator;
use SwoftAdmin\Exec\Application;
use function Swlib\Http\str;

/**
 * 路由信息
 * @package SwoftAdmin\Exec\Model\Logic
 */
class ReflectionRoute
{
    protected $reader;

    protected $validators = [];

    public function __construct()
    {
        // Annotation reader
        $this->reader = new AnnotationReader();
    }

    /**
     * 获取ALL路由参数
     * @param  string  $className
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function scanRoutes(string $className)
    {
        try {
            $reflectionClass = new \ReflectionClass($className);
        } catch (\Throwable $exception) {
            return [];
        }

        // Fix ignore abstract
        if ($reflectionClass->isAbstract()) {
            return [];
        }
        $routes = [];

        $classAnnotations = $this->reader->getClassAnnotations($reflectionClass);
        // 类注解遍历
        foreach ($classAnnotations as $classAnnotation) {
            $con = [];
            if ($classAnnotation instanceof Controller) {

                $con["title"] = $this->getTitle($reflectionClass->getDocComment());
                $con["path"] = $className;
                $con["prefix"] = $classAnnotation->getPrefix();
                if ($con["prefix"] && $con["prefix"]{0} != "/") {
                    $con["prefix"] = "/".$con["prefix"];
                }

                foreach ($reflectionClass->getMethods() as $reflectionMethod) {
                    $routeInfo = $this->getParameters($reflectionClass,$reflectionMethod);

                    if (isset($routeInfo["path"])) {
                        // 合并代码调用的参数和验证器参数
                        if ($con["prefix"]) {
                            $routeInfo["path"] = $con["prefix"].'/'.$routeInfo["path"];
                        }

                        $con["routes"][$routeInfo["path"]] = $routeInfo;
                    }

                }
            }
            if ($con) {
                $routes[$reflectionClass->getName()] = $con;
            }
        }
        return $routes;
    }

    /**
     * 获取单个路由信息
     * @param  \ReflectionClass  $reflectionClass
     * @param  \ReflectionMethod  $reflectionMethod
     * @return array
     */
    public function getParameters(\ReflectionClass $reflectionClass,\ReflectionMethod $reflectionMethod)
    {
        $routeInfo = $this->getDocParams($reflectionMethod);

        if (isset($routeInfo["path"])) {
            // 合并代码调用的参数和验证器参数
            $tem = $this->getCodeParams($reflectionMethod);
            foreach ($tem as $type => $arr) {
                foreach ($arr as $key => $postItem) {
                    if (!isset($routeInfo["params"][$key])) {
                        $routeInfo["params"][$key] = $postItem;
                    }else{
                        $routeInfo["params"][$key]['getType'] = $type;
                        if ( $postItem['default'] ){
                            $routeInfo["params"][$key]['default'] = $postItem['default'];
                        }
                    }
                }
            }
        }
        return $routeInfo;
    }

    /**
     * 根据注释获取参数
     * @param  \ReflectionMethod  $reflectionMethod
     * @return array
     */
    protected function getDocParams(\ReflectionMethod $reflectionMethod)
    {
        $routeInfo = [];
        $methodAnnotations = $this->reader->getMethodAnnotations($reflectionMethod);
        foreach ($methodAnnotations as $annotation) {
            if ($annotation instanceof RequestMapping) {
                $routeInfo["path"] = $annotation->getRoute();
                $routeInfo["title"] = $this->getTitle($reflectionMethod->getDocComment());
                if (!$routeInfo["path"]) {
                    // 使用默认路由
                    $arr = explode('\\', $reflectionMethod->getDeclaringClass()->getName());
                    $arr = explode('Controller', end($arr));
                    $routeInfo["path"] = strtolower(reset($arr)).'/'.$reflectionMethod->getName();
                }

                $routeInfo["method"] = $annotation->getMethod();
            } elseif ($annotation instanceof Validate) {
                $validator = $annotation->getValidator();
                $validator = $this->getValidator($validator);

                $validatorClass = $validator->getName();
                $validatorClass = new $validatorClass();
                foreach ($validator->getProperties() as $property) {
                    $property->setAccessible(true);

                    $routeInfo["params"][$property->getName()] = [
                        'key' => $property->getName(),
                        'title' => $this->getTitle($property->getDocComment()),
                        'default' => $property->getValue($validatorClass),
                        'ParamsType' => $this->getParamsType($property->getDocComment()),// 参数类型
                    ];
                }
            }
        }
        return $routeInfo;
    }

    /**
     * @param  string  $validator
     * @return \ReflectionClass
     */
    protected function getValidator(string $validator)
    {
        if (!isset($this->validators[$validator])) {
            $dir = Application::getDirectory("App\\Validator");
            foreach ($dir->scanClass() as $className) {
                try {
                    $reflectionClass = new \ReflectionClass($className);
                } catch (\Throwable $exception) {
                    continue;
                }
                // Fix ignore abstract
                if ($reflectionClass->isAbstract()) {
                    continue;
                }

                $classAnnotations = $this->reader->getClassAnnotations($reflectionClass);
                foreach ($classAnnotations as $classAnnotation) {
                    if ($classAnnotation instanceof Validator) {
                        $this->validators[$classAnnotation->getName()] = $reflectionClass;
                    }
                }
            }
        }
        return $this->validators[$validator];
    }

    /**
     * 从代码里面获取参数
     * @param  \ReflectionMethod  $reflectionMethod
     * @return array
     */
    protected function getCodeParams(\ReflectionMethod $reflectionMethod)
    {
        $startLine = $reflectionMethod->getStartLine();
        $endLine = $reflectionMethod->getEndLine();

        $contents = [];
        $lines = file($reflectionMethod->getFileName());
        foreach ($lines as $key => $line) {
            if ($key >= $startLine && $key <= $endLine) {
                $contents[] = $line;
            }
        }

        $scanFunc = [
            'get',
            'post',
            'parsedBody',
            'parsedQuery',
        ];

        $params = [];
        foreach ($contents as $line=>$content) {
            foreach ($scanFunc as $func) {
                $scanStr = "\$request->{$func}(";
                if (strpos($content, $scanStr) !== false) {
                    $content = substr($content, strpos($content, $scanStr) + strlen($scanStr), -1);
                    $match = [];
                    $pattern = "/[^\)]+\)/is"; // 以 ")" 结束前部分,保证必须是一行的代码
                    if (preg_match_all($pattern, $content, $match)) {
                        if (!isset($match[0][0])) {
                            continue;
                        }
                        $content = $match[0][0];
                        $content = substr($content, 0, -1);
                        $arr = explode(',', $content);
                        if (count($arr) == 2 || count($arr) == 1) {
                            // 必须是普通 string int 无换行,无特殊字符的默认值
                            if (isset($arr[1])) {
                                $default = $arr[1];
                                if ($default{0} == "'" || $default{0} == "\"") {
                                    $default = str_replace(["'", "\""], ["", ""], $arr[1]);
                                }
                            } else {
                                $default = null;
                            }
                            if (isset($contents[$line-1])){
                                $pre = trim($contents[$line-1]);
                                if ($pre && $pre{0}=="/"){
                                    $doc = $pre;
                                }
                            }


                            $key = str_replace(["'", "\""], ["", ""], $arr[0]);
                            $params[$func][$key] = [
                                'key' => $key,
                                'default' => $default,
                                'ParamsType' => $this->getParamsType($doc??""),// 参数类型
                                'title' => $this->getTitle($doc??""),
                                'getType' => $func,// 获取参数类型
                            ];
                        }
                    }
                }
            }
        }

        return $params;
    }

    /**
     * 从注释获取变量类型
     * @param  string  $doc
     */
    protected function getParamsType(string $doc)
    {
        $title = "";
        $arr = explode(PHP_EOL, $doc);
        foreach ($arr as $str) {
            $str = trim($str);
            $str = str_replace(["/", "*","  "], ["",""," "], $str);
            $str = trim($str);

            if ( $str && strpos($str,'@var')===0 ) {
                $exArr = explode(' ',$str);
                $title = $exArr[1]??"";
                break;
            }
        }

        return $title;
    }

    /**
     * 获取命名空间下的路由
     * @param  string  $namespace
     * @return array
     */
    public function getControllers($namespace = "App\\Http\\Controller")
    {
        $dir = Application::getDirectory($namespace);

        $data = [];
        foreach ($dir->scanClass() as $class) {
            $data[] = $class;
        }
        return $data;
    }

    /**
     * 扫描命名空间下字段
     * @param  string  $namespace
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function scanContr($namespace = "App\\Http\\Controller")
    {
        $data = [];
        foreach ($this->getControllers($namespace) as $controller) {
            $tem = $this->scanRoutes($controller);
            if ($tem) {
                $data = $tem + $data;
            }
        }
        return $data;
    }

    /**
     * 获取注释@前部分
     * @param $doc
     * @return string
     */
    protected function getTitle($doc): string
    {
        $title = "";

        $arr = explode(PHP_EOL, $doc);

        foreach ($arr as $str) {
            $str = str_replace(["/", "*"], "", $str);
            $str = trim($str);

            if (strlen($str) > 0 && $str{0} != "@") {
                $title = $title.$str;
            }elseif (strlen($str) > 0 && $str{0} == "@"){
                break;
            }
        }

        if(!$title && isset($str) && $str && $str{0} == "@"){
            $str = trim($str);
            $str = str_replace(["/", "*","  "], ["",""," "], $str);
            $str = trim($str);
            $exArr = explode(' ',$str);
            $title = $exArr[3]??"";
        }
        return $title;
    }
}
