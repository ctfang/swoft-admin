<?php


namespace Swoft\SwoftAdmin\Exec\Console;


use Swoft\SwoftAdmin\Exec\Loader;
use Swoft\SwoftAdmin\Model\Dao\MiddlewareResource;
use Swoft\SwoftAdmin\Model\Dao\ModelResource;
use Swoft\SwoftAdmin\Model\Logic\Directory;

class Model
{
    public function dao()
    {
        $data = Loader::getDir('App\\Model\\Dao');
        $dir = new Directory();
        foreach ($data as $scanDir=>$namespace){
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return (new ModelResource())->scan($dir);
    }

    public function data()
    {
        $data = Loader::getDir('App\\Model\\Data');
        $dir = new Directory();
        foreach ($data as $scanDir=>$namespace){
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return (new ModelResource())->scan($dir);
    }

    public function logic()
    {
        $data = Loader::getDir('App\\Model\\Logic');
        $dir = new Directory();
        foreach ($data as $scanDir=>$namespace){
            $dir->setScanDirectory($scanDir, $namespace);
        }
        return (new ModelResource())->scan($dir);
    }

    /**
     * 新增类文件
     * @param $namespace
     * @param $name
     * @param  string  $title
     * @param $suffix
     */
    public function addClass($namespace,$name,string $title = '' ,string $suffix = '')
    {
        $namespace = str_replace('/','\\',$namespace);
        $data = Loader::getDir($namespace);
        $dir = key($data);

        $className = $name.$suffix;
        $path = $dir.$className.".php";
        if (file_exists($path)){
            return;
        }
        if ($suffix && file_exists(__DIR__."/template/".$suffix)){
            $template = file_get_contents(__DIR__."/template/".$suffix);
        }else{
            $template = file_get_contents(__DIR__."/template/BaseClass");
        }

        $endStr = substr($namespace,-1);
        if ($endStr=="\\"){
            $namespace = substr($namespace,0,-1);
        }
        $template = str_replace(["{title}","{name}","{namespace}","{suffix}","{date}"],[$title,$name,$namespace,$suffix,date("ymdhis")],$template);
        file_put_contents($path,$template);
        return;
    }
}
