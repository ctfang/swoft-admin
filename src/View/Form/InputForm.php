<?php


namespace SwoftAdmin\Tool\View\Form;


use SwoftAdmin\Tool\View\BaseButton;

class InputForm extends BaseButton
{
    public $field;
    public $type;
    public $name;
    public $placeholder;
    public $verify;

    /**
     * InputForm constructor.
     * @param  string  $field
     * @param string $name
     * @param  string  $type
     * @param  string  $placeholder
     * @param  string  $verify required
     */
    public function __construct(string $field, $name,$placeholder = "", $verify = "",$type = 'text')
    {
        $this->field = $field;
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->verify = $verify;
    }

    public function toString(): string
    {
        $verify = $this->verify?"<span class=\"x-red\">*</span>":"";
        $str = <<<str
            <div class="layui-form-item">
                <label for="{$this->field}" class="layui-form-label">
                    {$verify}{$this->name}
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="{$this->field}" name="{$this->field}" required="" lay-verify="{$this->verify}"
                           autocomplete="off" class="layui-input" placeholder="{$this->placeholder}">
                </div>
            </div>
str;
        return $str;
    }
}
