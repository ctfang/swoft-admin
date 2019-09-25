<?php


namespace SwoftAdmin\Tool\View\Form;


use SwoftAdmin\Tool\View\BaseButton;

class InputBlockForm extends BaseButton
{
    public $name = '';
    public $inputs = [];

    public function __construct($name,array $inputs)
    {
        $this->name = $name;
        $this->inputs = $inputs;
    }

    public function toString(): string
    {
        $inputs = '';
        foreach ($this->inputs as $input){
            $inputs .= "<input name=\"{$input['field']}[]\" lay-skin=\"primary\" type=\"checkbox\" title=\"{$input['title']}\" value=\"{$input['value']}\">";
        }

        $str = <<<str
<div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    {$this->name}
                </label>
                <table  class="layui-table layui-input-block">
                    <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" name="like1[write]" lay-skin="primary" lay-filter="father" title="全选">
                        </td>
                        <td>
                            <div class="layui-input-block">
                                {$inputs}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
str;
        return $str;
    }
}
