<?php /** @var Welcome $data */

use SwoftAdmin\Tool\View\Welcome;

$data->script("terminal/js/jquery-1.7.1.min.js");
$data->script("terminal/js/jquery.mousewheel-min.js");
$data->script("terminal/js/jquery.terminal.min.js");
$data->script("https://unpkg.com/js-polyfills/keyboard.js");
$data->link("terminal/css/jquery.terminal.min.css");
?>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-sm12 layui-col-md6">

            <div class="layui-card">
                <div class="layui-card-header">Terminal</div>
                <div class="layui-card-body" id="terminal" style="min-height: 580px;max-height: 580px">

                </div>
            </div>

            <div class="layui-card">
                <div class="layui-card-header">常用功能</div>
                <div class="layui-card-body layui-btn-container">
                    <button type="button" class="layui-btn" lay-filter="restart">重启服务</button>
                    <button type="button" class="layui-btn layui-btn-normal" lay-filter="entity">生成实体</button>
                    <button type="button" class="layui-btn layui-btn-warm" lay-filter="authReload">自动重启</button>
                    <button type="button" class="layui-btn layui-btn-danger" lay-filter="stopAdmin">禁用Admin</button>
                    <button type="button" class="layui-btn layui-btn-primary" lay-filter="stop">停止服务</button>
                </div>
            </div>
        </div>

        <div class="layui-col-sm12 layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">系统信息</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <?php foreach ($data->system as $datum) { ?>
                            <tr>
                                <th><?php echo $datum["key"] ?? ""; ?></th>
                                <td><?php echo $datum["value"] ?? ""; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header">扩展信息</div>
                <div class="layui-card-body layui-btn-container">
                    <?php foreach ($data->ext as $datum) { ?>
                        <button type="button" class="layui-btn"><?php echo $datum["key"]; ?></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use('form', function(){
        var form = layui.form;

        form.on("",function (data) {

        });

    });
</script>
<script>
    var term;
    jQuery(function ($) {
        term = $('#terminal').terminal(function (command, term) {
            if (command == '') {
            } else if (command == 'su') {
                term.push(function (command, term) {
                    if (command == 'quit') {
                        term.pop()
                    }
                    if (command == '') {
                    } else {
                        data = pushCmd(command)
                        term.echo(data);
                    }
                }, {
                    prompt: 'sys> ',
                    name: 'sys'
                });
            } else {
                data = pushCmd("php bin/swoft " + command)
                term.echo(data);
            }
        }, {
            greetings: "命令行执行辅助,不支持柱塞运行\n\n默认在命令行加[php bin/swoft]\n\n切换sys模式 : su\n退出sys模式 : quit\n清除屏幕    : clear\n",
            prompt: 'bin/swoft>',
            onBlur: function () {
                // prevent loosing focus
                return false;
            }
        });
    });

    function pushCmd(cmd) {
        var str = "无返回"
        $.ajax({
            url: "<?php echo admin_url("terminal/run");?>",
            data: {
                'run': cmd,
            },
            type: "post",
            dataType: 'json',
            async: false,
            success: function (data) {
                console.log(data);
                str = data.data
            }
        })
        return str
    }

</script>
