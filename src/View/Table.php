<?php


namespace SwoftAdmin\Tool\View;


class Table extends BaseView
{
    public $title = "table";
    protected $view = 'table/lists';

    /** @var array 列表表头 */
    public $listTitle = [];
    /** @var array 列表数据 */
    public $listData = [];
    public $listPage = [];
    /** @var array 导航 ["href","title"] */
    public $nac = [];
    /** @var array 添加按钮 */
    public $listHeader = [];

    public $listButton = [];

    /**
     * 操作字段使用的按钮
     * @param  BaseButton  $baseButton
     * @return Table
     */
    public function addListButton(BaseButton $baseButton)
    {
        $this->listButton[] = $baseButton;
    }
}
