<?php


namespace SwoftAdmin\Tool\View;


abstract class BaseButton
{
    public $url;

    public $tableListFields = [];

    /**
     * 使用在列表视图时,url拼接的key
     * @param  array  $fields
     */
    public function addField(array $fields)
    {
        $this->tableListFields = $fields;
    }

    /**
     * 输出html
     * @return string
     */
    abstract public function toString(): string;
}
