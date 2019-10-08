<?php


namespace SwoftAdmin\Tool\View\Form;


use SwoftAdmin\Tool\View\BaseButton;

class SelectForm extends BaseButton
{
    public $label;
    public $field;
    public $options;

    /**
     * SelectForm constructor.
     * @param $field
     * @param $label
     */
    public function __construct(string $field, string $label)
    {
        $this->field = $field;
        $this->label = $label;
    }

    /**
     * @param  string  $title
     * @param $value
     * @param  int  $default
     */
    public function addOption(string $title,$value,$default = 0)
    {
        $this->options[$value] = ['title'=>$title,'default'=>$default];
    }

    /**
     * 输出html
     * @return string
     */
    public function toString(): string
    {
        $select = "";
        foreach ($this->options as $value=>$arr){

            if (!$arr['default']){
                $default = "";
            }else{
                $default = "selected";
            }
            $select .= "<option value=\"{$value}\" {$default}>{$arr['title']}</option>";
        }

        return <<<str
                    <div class="layui-form-item">
                        <label for="{$this->field}" class="layui-form-label">
                            <span class="x-red">*</span>{$this->label}
                        </label>
                        <div class="layui-input-block">
                            <select name="{$this->field}">
                                {$select}
                            </select>
                        </div>
                    </div>
str;
    }
}
