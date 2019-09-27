<?php /** @var Table $data */

use SwoftAdmin\Tool\View\BaseButton;
use SwoftAdmin\Tool\View\Table; ?>
<div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a><cite><?php echo $data->title; ?></cite></a>
            </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       onclick="location.reload()"
       title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
    </a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    <?php foreach ($data->listHeader as $button) {
                        echo $button->toString();
                    } ?>
                </div>
                <div class="layui-card-body ">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <?php foreach ($data->listTitle as $name) { ?>
                                <th><?php echo $name; ?></th>
                            <?php } ?>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /** @var array $info */ ?>
                        <?php foreach ($data->listData as $key => $info) { ?>
                            <tr>
                                <?php foreach ($data->listTitle as $name => $title) { ?>
                                    <td><?php if (!isset($info[$name]) || !$info[$name]) {
                                            if ($name == "id") {
                                                if (!isset($__listId)) {
                                                    $__listId = 0;
                                                }
                                                echo ++$__listId;
                                            } else {
                                                echo "";
                                            }
                                        } elseif (!is_array($info[$name])) {
                                            echo $info[$name];
                                        } else {
                                            echo implode(',', $info[$name]);
                                        }; ?></td>
                                <?php } ?>
                                <td class="td-manage">
                                    <?php /** @var BaseButton $button */foreach ($data->listButton as $button) {
                                        $arr = [];
                                        $url = $button->url;
                                        foreach ($button->tableListFields as $field=>$param){
                                            $field = is_numeric($field)?$param:$field;
                                            $arr[] = $param."=".urlencode($info[$field]??"");
                                        }
                                        $button->url = $button->url."?".implode('&',$arr);
                                        echo $button->toString();
                                        $button->url = $url;
                                    } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
