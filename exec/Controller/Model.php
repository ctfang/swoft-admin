<?php


namespace SwoftAdmin\Exec\Controller;


use SwoftAdmin\Exec\Application;
use SwoftAdmin\Exec\Model\Dao\ModelResource;
use SwoftAdmin\Exec\Model\Logic\Directory;

class Model
{
    public function dao()
    {
        $dir = Application::getDirectory('App\\Model\\Dao');
        return (new ModelResource())->scan($dir);
    }

    public function data()
    {
        $dir = Application::getDirectory('App\\Model\\Data');
        return (new ModelResource())->scan($dir);
    }

    public function logic()
    {
        $dir = Application::getDirectory('App\\Model\\Logic');
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
        $data = Application::getDirs($namespace);
        $dir = key($data);

        $className = $name.$suffix;
        $path = $dir.$className.".php";
        if (file_exists($path)){
            return;
        }
        if ($suffix && file_exists(Application::getTemplate($suffix))){
            $template = file_get_contents(Application::getTemplate($suffix));
        }else{
            $template = file_get_contents(Application::getTemplate('BaseClass'));
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
