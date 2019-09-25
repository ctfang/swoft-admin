<?php


namespace SwoftAdmin\Exec\Model\Data;


use Swoft\Validator\Annotation\Mapping\Validate;

class RouteInfo
{
    public $title;
    public $path;
    /** @var Validate */
    public $validator;
    public $method;
    public $controller;
    public $action;
}
