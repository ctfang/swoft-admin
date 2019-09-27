<?php /** @var FileContent $data */

use SwoftAdmin\Tool\View\FileContent; ?>
<div class="layui-card-body ">
<pre lay-encode="true" class="layui-code" lay-title="<?php echo $data->layTitle; ?>" lay-skin="notepad">
<?php echo $data->layContent; ?>
</pre>
</div>

<script>
    layui.use(['form','code'], function(){
        form = layui.form;

        layui.code();

    });
</script>
