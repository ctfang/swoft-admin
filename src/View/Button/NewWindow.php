<?php


namespace SwoftAdmin\Tool\View\Button;


use SwoftAdmin\Tool\View\BaseButton;

class NewWindow extends BaseButton
{
    public $url;
    public $name;

    public function __construct(string $url, $name = "添加")
    {
        $this->url = admin_url($url, false);
        $this->name = $name;
    }

    public function toString(): string
    {
        $str = <<<button
                        <button class="layui-btn"
                                onclick="xadmin.open('{$this->name}','{$this->url}',800,600)">
                            <i class="layui-icon"></i>{$this->name}
                        </button>
button;
        return $str;
    }
}
