<?php


namespace SwoftAdmin\Exec\Controller;


use Swoft\Console\Annotation\Mapping\CommandMapping;
use SwoftAdmin\Exec\Application;
use SwoftAdmin\Exec\Loader;
use SwoftAdmin\Exec\Model\Dao\ConsoleResource;
use SwoftAdmin\Exec\Model\Dao\ModelResource;

/**
 * Class Console
 * @package SwoftAdmin\Exec\Controller
 */
class Console
{
    /**
     * 命令列表
     * @return array
     * @CommandMapping(name="cmd")
     */
    public function command()
    {
        $dir = Application::getDirectory('App\\Console\\Command');
        return (new ConsoleResource())->scan($dir);
    }

    /**
     * 新增命令
     * @param $name
     * @param $des
     * @param $pre
     * @CommandMapping(name="cmd/add")
     */
    public function add($name, $des, $pre)
    {
        $namespace = "App\\Console\\Command\\";
        $data = Application::getDirs($namespace);
        $dir = key($data);

        $className = $name."Command";
        $path = $dir.$className.".php";
        if (file_exists($path)){
            return;
        }

        $template = file_get_contents(Application::getTemplate("Command"));
        $template = str_replace(["{name}","{des}","{pre}"],[$name,$des,$pre],$template);
        file_put_contents($path,$template);
        return;
    }
}
