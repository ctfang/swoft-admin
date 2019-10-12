<?php /** @var Document $data */

use SwoftAdmin\Tool\View\Document;

?>
<div class="layui-container">
    <br>
    <br>

    <fieldset class="layui-elem-field layui-field-title">
        <legend>简要描述：</legend>
        <div class="layui-field-box">
            <?php echo $data->route['title']??""; ?>
        </div>
    </fieldset>

    <br>
    <br>
    <div class="layui-fluid">
        <div class="layui-row">
            <div class="layui-col-md12">
                <fieldset class="layui-elem-field">
                    <legend>请求地址</legend>
                    <div class="layui-field-box">
                        <table class="layui-table">
                            <colgroup>
                                <col width="150">
                                <col width="200">
                                <col>
                            </colgroup>
                            <thead>
                            <tr>
                                <th>地址</th>
                                <th>请求方式</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $data->route['path']??""; ?></td>
                                <td><?php echo isset($data->route['method'])?implode(' | ',$data->route['method']):""; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <br>
    <hr class="layui-bg-red">
    <br>

    <fieldset class="layui-elem-field layui-field-title">
        <legend>请求参数</legend>
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>字段名</th>
                <th>类型</th>
                <th>默认值</th>
                <th>必选</th>
                <th>备注</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data->route["params"]??[] as $field=>$item){ ?>
            <tr>
                <td><?php echo $field??""; ?></td>
                <td><?php echo $item['ParamsType']??"通用"; ?></td>
                <td><?php echo $item['default']??""; ?></td>
                <td><?php echo $item['default']?"否":"是"; ?></td>
                <td><?php echo $item['title']??""; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </fieldset>


</div>
