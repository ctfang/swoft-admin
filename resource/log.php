<?php /** @var FileContent $data */

use SwoftAdmin\Tool\View\FileContent; ?>
<pre lay-encode="true" class="layui-code" lay-title="<?php echo $data->layTitle; ?>" lay-skin="notepad">
<?php echo $data->layContent; ?>
</pre>
