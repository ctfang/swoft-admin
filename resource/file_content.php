<?php /** @var FileContent $data */

use SwoftAdmin\Tool\View\FileContent; ?>
<div class="layui-card-body ">
<pre lay-encode="true" class="layui-code">
<?php echo $data->layContent; ?>
</pre>
</div>

<script>
    layui.use(['form','code'], function(){
        form = layui.form;

        layui.code({
            skin: 'notepad', //如果要默认风格，不用设定该key。
            about: false
        });

    });
</script>
