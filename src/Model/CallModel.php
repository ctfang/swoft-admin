<?php


namespace SwoftAdmin\Tool\Model;


use SwoftAdmin\Tool\Exec;

/**
 * 代理执行 SwoftAdmin\Exec 命名空间下的代码
 * @package SwoftAdmin\Tool\Model
 */
class CallModel
{
    public $handel;

    public function __construct(string $class)
    {
        $arr = explode('\\',$class);
        $this->handel = end($arr);
    }

    public function __call($name, $arguments)
    {
        $rule = $this->handel."@".$name;
        $callArr[] = $rule;
        if ($arguments){
            foreach ($arguments as $name=>$argument){
                $callArr[] = $argument;
            }
        }

        return call_user_func_array([Exec::class,"run"],$callArr);
    }
}
