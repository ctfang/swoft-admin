<?php


namespace SwoftAdmin\Tool\View;


class Form extends BaseView
{
    public $title = "表单提交";
    /** @var string 提交地址 */
    public $action = "";
    public $method = "post";
    protected $view = 'table/form';

    /** @var array */
    public $item = [];
}
