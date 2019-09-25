<?php /** @var Form $data */

use SwoftAdmin\Tool\View\Form;
$data->script("https://cdn.staticfile.org/html5shiv/r29/html5.min.js");
$data->script("https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js");
 ?>
<div class="layui-fluid">
    <div class="layui-row">
        <form action="<?php admin_url($data->action) ?>" method="<?php echo $data->method ?>" class="layui-form layui-form-pane">
            <?php foreach ($data->item as $item){ echo $item->toString(); } ?>
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
