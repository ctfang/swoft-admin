<?php


namespace Swoft\SwoftAdmin\Model\Data;


class ListView
{
    public $title = "";
    /** @var array 列表表头 */
    public $listTitle = [];
    /** @var array 列表数据 */
    public $listData = [];
    public $listPage = [];
    /** @var array 导航 ["href","title"] */
    public $nac = [];
    /** @var string 添加按钮,链接地址 */
    public $createUrl = '';

    public function toView()
    {
        return admin_view('base/lists',["data"=>$this]);
    }
}
