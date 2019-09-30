<div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a><cite><?php echo $data->title ?? ""; ?></cite></a>
            </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       onclick="location.reload()"
       title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
    </a>
</div>

<div class="layui-fluid">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">入口文件</label>
            <div class="layui-input-block">
                <input type="text" name="binFile" required lay-verify="required" placeholder="swoft入口文件" autocomplete="off"
                       class="layui-input" value="bin/swoft">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">监控间隔时间</label>
            <div class="layui-input-block">
                <input type="text" name="interval" required lay-verify="required" placeholder="3秒" autocomplete="off"
                       class="layui-input" value="3">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">php执行文件</label>
            <div class="layui-input-block">
                <input type="text" name="runPHP" required lay-verify="required" placeholder="全局" autocomplete="off"
                       class="layui-input" value="php">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">要监控的目录</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required" placeholder="指定要监控的目录，相对于应用目录。默认监控 app,config 里的文件变动" autocomplete="off"
                       class="layui-input" value="@app">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

</div>
<script>
    //Demo
    layui.use('form', function () {
        var form = layui.form;

        //监听提交
        form.on('submit(formDemo)', function (data) {
            layer.msg(JSON.stringify(data.field));

            $.ajax({
                url: "<?php echo admin_url("app/test");?>",
                data: data.field,
                type: "post",
                dataType: 'json',
                async: false,
                success: function (data) {
                    console.log(data);
                    str = data.data
                }
            })


            return false;
        });
    });
</script>
