<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <?php /** @var AddView $data */

    use Swoft\SwoftAdmin\Model\Data\AddView;

    $this->include('layouts/meta') ?>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form class="layui-form layui-form layui-form-pane">
            <?php foreach ($data->listTitle as $datum) { ?>
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <?php echo $datum['title'] ?? ""; ?>
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="<?php echo $datum['name'] ?? ""; ?>"
                               name="<?php echo $datum['name'] ?? ""; ?>" required=""
                               lay-verify="<?php echo $datum['verify'] ?? ""; ?>"
                               autocomplete="off" class="layui-input"
                               placeholder="<?php echo $datum['placeholder'] ?? ""; ?>">
                    </div>
                </div>
            <?php } ?>
            <div class="layui-form-item">
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    增加
                </button>
            </div>
        </form>
    </div>
</div>
<script>layui.use(['form', 'layer'],
        function () {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;


            //监听提交
            form.on('submit(add)',
                function (data) {
                    //发异步，把数据提交给php
                    <?php foreach ($data->listTitle as $datum) { ?>
                    <?php echo $datum['name'] ?? ""; ?> = $('input[name="<?php echo $datum['name'] ?? ""; ?>"]').val();
                    <?php } ?>

                    $.ajax({
                        type: "POST",
                        url: "<?php admin_url($data->createUrl); ?>",
                        data: {
                            <?php foreach ($data->listTitle as $datum) { ?>
                            '<?php echo $datum['name'] ?? ""; ?>':<?php echo $datum['name'] ?? ""; ?>,
                            <?php } ?>
                            <?php foreach ($data->value as $datum) { ?>
                            '<?php echo $datum['name'] ?? ""; ?>': "<?php echo $datum['value'] ?? ""; ?>",
                            <?php } ?>
                        },
                        success: function (status) {
                            layer.alert("提交成功", {
                                    icon: 6
                                },
                                function () {
                                    //关闭当前frame
                                    xadmin.close();

                                    // 可以对父窗口进行刷新
                                    xadmin.father_reload();
                                });
                        }
                    })
                    return false;
                });

        });</script>
</body>

</html>
