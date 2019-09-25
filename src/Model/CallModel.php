<?php


namespace SwoftAdmin\Tool\Model;


use SwoftAdmin\Tool\Exec;

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
