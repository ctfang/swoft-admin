<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <?php $this->include('layouts/meta') ?>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>中文标题
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="className" name="classTitle" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>中间件类名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="className" name="className" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="username" class="layui-form-label">
                </label>
                <div class="layui-input-block">
                    已存在不会覆盖,将会在名字后面自动加字符串Middleware
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
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
                    className = $('input[name="className"]').val();
                    classTitle = $('input[name="classTitle"]').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php admin_url("mid/add"); ?>",
                        data: {
                            'className': className,
                            'classTitle': classTitle,
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
