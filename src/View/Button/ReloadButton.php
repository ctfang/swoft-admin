<?php


namespace SwoftAdmin\Tool\View\Button;


use SwoftAdmin\Tool\View\BaseButton;

class ReloadButton extends BaseButton
{
    public function toString(): string
    {
        return <<<button
                    <button class="layui-btn layui-btn-danger" onclick="location.reload()">
                        <i class="layui-icon layui-icon-refresh"></i>遍历代码
                    </button>
button;

    }
}
