<?php


namespace Swoft\SwoftAdmin\Model\Data;


class AddView
{
    public $title = "";

    public $method = "GET";

    /** @var array 列表表头 */
    public $listTitle = [];
    /** @var string 添加按钮,链接地址 */
    public $createUrl = '';
    /** @var array 隐藏的提交 */
    public $value = [];

    /**
     * @return \Swoft\Http\Message\Response
     * @throws \Throwable
     */
    public function toView()
    {
        return admin_view('base/add', ["data" => $this]);
    }

    /**
     * @param $key
     * @param $title
     * @param  string  $placeholder
     * @param  string  $verify
     */
    public function addText($key, $title, $placeholder = '',$verify = 'required')
    {
        $this->listTitle[$key] = [
            'verify' => $verify,
            'name' => $key,
            'title' => $title,
            'placeholder' => $placeholder,
        ];
    }


    /**
     * @param $key
     * @param $title
     * @param  string  $value
     */
    public function addValue($key, $value)
    {
        $this->value[$key] = [
            'name' => $key,
            'value' => $value
        ];
    }
}
