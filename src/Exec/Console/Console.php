<?php


namespace Swoft\SwoftAdmin\Exec\Console;


use Swoft\SwoftAdmin\Exec\Loader;
use Swoft\SwoftAdmin\Model\Dao\ConsoleResource;
use Swoft\SwoftAdmin\Model\Dao\ModelResource;
use Swoft\SwoftAdmin\Model\Logic\Directory;

class Console
{
    public function command()
    {
        $data = Loader::getDir('App\\Console\\Command');
        $dir = new Directory();
        foreach ($data as $scanDir=>$namespace){
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return (new ConsoleResource())->scan($dir);
    }

    public function add($name, $des, $pre)
    {
        $namespace = "App\\Console\\Command\\";
        $data = Loader::getDir($namespace);
        $dir = key($data);

        $className = $name."Command";
        $path = $dir.$className.".php";
        if (file_exists($path)){
            return;
        }

        $template = file_get_contents(__DIR__."/template/Command");
        $template = str_replace(["{name}","{des}","{pre}"],[$name,$des,$pre],$template);
        file_put_contents($path,$template);
        return;
    }
}
