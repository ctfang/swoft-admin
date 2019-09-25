<?php


namespace SwoftAdmin\Tool\View;


class Welcome extends BaseView
{
    public $title = "系统信息";
    protected $view = 'home/welcome';

    public $system = [];
    public $ext = [];
}
