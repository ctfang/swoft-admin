<?php


namespace SwoftAdmin\Tool\View;


class Document extends BaseView
{
    public $title = "文档显示&测试";
    /** @var string 提交地址 */
    public $action = "";
    public $method = "post";
    protected $view = 'document';

    public $route;

    /** @var array */
    public $item = [];

    public function __construct($title = "表单提交")
    {
        $this->title = $title;
    }

    public function addButton(BaseButton $button):BaseButton
    {
        $this->item[] = $button;
        return $button;
    }
}
