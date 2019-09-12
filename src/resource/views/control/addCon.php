<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <?php use Swoft\SwoftAdmin\Model\Data\MiddlewareInfo;

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
        <form action="<?php admin_url("control/addPost"); ?>" method="post" class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    标题
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="title" name="title" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    类名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
                <label for="Controller" class="layui-form-label">
                    Controller
                </label>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    启用中间件
                </label>
                <table  class="layui-table layui-input-block">
                    <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" lay-skin="primary" lay-filter="father" title="可选中间件">
                        </td>
                        <td>
                            <div class="layui-input-block">
                                <?php /** @var array $mids */  /** @var MiddlewareInfo $mid */  ?>
                                <?php foreach ($mids as $mid){ if ($mid->isGroup) continue; ?>
                                <input name="mids[]" lay-skin="primary" type="checkbox" title="<?php echo $mid->title; ?>" value="<?php echo $mid->path; ?>">
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" lay-skin="primary" lay-filter="father" checked="checked" title="全局展示">
                        </td>
                        <td>
                            <div class="layui-input-block">
                            <?php /** @var array $mids */  /** @var MiddlewareInfo $mid */  ?>
                            <?php foreach ($mids as $mid){ if (!$mid->isGroup) continue; ?>
                                <input lay-skin="primary" type="checkbox" checked="checked" title="<?php echo $mid->title; ?>" value="<?php echo $mid->path; ?>">
                            <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        form.on('checkbox(father)', function(data){

            if(data.elem.checked){
                $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                form.render();
            }else{
                $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                form.render();
            }
        });


    });
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>
