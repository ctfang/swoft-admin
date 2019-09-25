<?php /** @var Welcome $data */

use SwoftAdmin\Tool\View\Welcome; ?>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">系统信息</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <?php foreach ($data->system as $datum){ ?>
                            <tr>
                                <th><?php echo $datum["key"]??""; ?></th>
                                <td><?php echo $datum["value"]??""; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <style id="welcome_style"></style>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">扩展信息</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <?php foreach ($data->ext as $datum){ ?>
                            <tr>
                                <th><?php echo $datum["key"]??""; ?></th>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <style id="welcome_style"></style>
    </div>
</div>
