<?php


namespace Swoft\SwoftAdmin\Model\Logic;


class Directory
{
    private $dirBindNameSpace = [];

    /**
     * 设置遍历的目录
     *
     * @param $directory
     * @param $nameSpace
     */
    public function setScanDirectory($directory, $nameSpace)
    {
        $this->dirBindNameSpace[$directory] = $nameSpace;
    }

    /**
     * 遍历目录下所有类
     *
     * @return \Generator
     */
    public function scanClass()
    {
        $arr = [];
        foreach ($this->dirBindNameSpace as $directory => $nameSpace) {
            foreach ($this->scanNameSpace($directory,$nameSpace) as $class) {
                $arr[] = $class;
            }
        }
        return $arr;
    }

    /**
     * 遍历命名空间
     *
     * @param $directory
     * @param $nameSpace
     * @return \Generator
     */
    private function scanNameSpace($directory,$nameSpace)
    {
        if ($dh = opendir($directory)) {
            while (($file = readdir($dh)) !== false) {
                if (in_array($file, ['.', '..'])) {
                    continue;
                } elseif (is_dir($directory . DIRECTORY_SEPARATOR . $file)) {
                    foreach ($this->scanNameSpace($directory . DIRECTORY_SEPARATOR . $file,$nameSpace.$file."\\") as $arrValue){
                        yield $arrValue;
                    }
                } elseif (substr($file, -4) == '.php') {
                    yield $nameSpace.pathinfo($file,PATHINFO_FILENAME);
                }
            }
            closedir($dh);
        }
    }
}
