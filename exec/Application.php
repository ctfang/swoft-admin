<?php


namespace SwoftAdmin\Exec;


use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use SwoftAdmin\Exec\Model\Logic\Directory;

class Application
{
    /** @var ClassLoader */
    private $loader;

    protected $routes;

    protected static $myself;

    public function __construct($loader)
    {
        $this->loader = $loader;

        $controlNamespace = "SwoftAdmin\\Exec\\Controller";
        $dir = new Directory();
        foreach ($this->getDir($controlNamespace) as $scanDir => $namespace) {
            $dir->setScanDirectory($scanDir, $namespace);
        }

        foreach ($dir->scanClass() as $className) {
            // Annotation reader
            $reflectionClass = new \ReflectionClass($className);

            // Fix ignore abstract
            if ($reflectionClass->isAbstract()) {
                return;
            }
            $arr = explode('\\',$className);
            $handel = end($arr);

            $cmd = new $className();
            // Annotation reader
            $reader = new AnnotationReader();
            $reflectionMethods = $reflectionClass->getMethods();
            foreach ($reflectionMethods as $reflectionMethod) {
                $methodAnnotations = $reader->getMethodAnnotations($reflectionMethod);
                $this->addRoute($handel."@".$reflectionMethod->getName(),[$cmd,$reflectionMethod->getName()]);
                if (!empty($methodAnnotations)) {
                    foreach ($methodAnnotations as $annotation) {
                        if ($annotation instanceof CommandMapping) {
                            $this->addRoute($annotation->getName(),[$cmd,$reflectionMethod->getName()]);
                        }
                    }
                }
            }
        }

        self::$myself = $this;
    }

    /**
     * @param  string  $name
     * @param  callable  $fun
     */
    public function addRoute(string $name, $fun)
    {
        $this->routes[$name] = $fun;
    }

    /**
     * 运行命令
     * @param  array  $argv
     */
    public function run(array $argv)
    {
        if (isset($argv[1]) && isset($this->routes[$argv[1]])) {
            $route = $argv[1];
            $call = $this->routes[$route];

            $class = $call[0];
            $class = new $class();
            $action = $call[1];

            $params = [];
            foreach ($argv as $key => $item) {
                $key > 1 and $params[] = $item;
            }

            $data = call_user_func_array([$class, $action], $params);

            echo serialize($data);
            return;
        }
    }

    /**
     * 获取目录
     * @param $namespace
     * @return array
     */
    public function getDir($namespace): array
    {
        $psr = $this->loader->getPrefixesPsr4();
        $arr = explode("\\", $namespace);
        foreach ($arr as $name) {
            $base = isset($base) ? $base.$name."\\" : $name."\\";
            if (isset($psr[$base])) {
                $temp = explode($base, $namespace);
                $find = end($temp);
                $find = str_replace("\\", "/", $find);
                break;
            }
        }

        if (!isset($find) || !isset($psr[$base])) {
            return [];
        }
        $data = [];
        foreach ($psr[$base] as $dir) {
            $dir = realpath($dir);
            $is = $dir."/".$find."/";
            if (is_dir($is)) {
                $data[$is] = $namespace."\\";
            }
        }

        return $data;
    }

    /**
     * 获取目录对象
     * @param $namespace
     * @return Directory
     */
    public static function getDirectory($namespace):Directory
    {
        $dirList = self::$myself->getDir($namespace);

        $dir = new Directory();
        foreach ($dirList as $scanDir=>$namespace){
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return $dir;
    }


    /**
     * 获取目录对象
     * @param $namespace
     * @return array
     */
    public static function getDirs($namespace)
    {
        return self::$myself->getDir($namespace);
    }

    public static function getTemplate(string $name):string
    {
        return __DIR__."/template/".$name;
    }
}
