<?php


namespace SwoftAdmin\Tool\View\Form;


use SwoftAdmin\Tool\View\BaseButton;

class TextareaForm extends BaseButton
{
    public $title = "";
    public $field = "";
    public $placeholder = "";

    public function __construct($field,$title,$placeholder)
    {
        $this->title = $title;
        $this->field = $field;
        $this->placeholder = $placeholder;
    }

    public function toString(): string
    {
        $str = <<<str
            <div class="layui-form-item layui-form-text">
                <label for="desc" class="layui-form-label">
                    {$this->title}
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="{$this->placeholder}" id="desc" name="{$this->field}" class="layui-textarea"></textarea>
                </div>
            </div>
str;
        return $str;
    }
}
