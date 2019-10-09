<?php /** @var Form $data */

use SwoftAdmin\Tool\View\Form;
 ?>
<form class="layui-fluid layui-form layui-form-pane" action="">
    <?php foreach ($data->item as $item) {
        echo $item->toString();
    } ?>
    <div class="">
        <button class="layui-btn layui-btn-fluid layui-btn-lg" type="submit" lay-submit="" lay-filter="add">增加</button>
    </div>
</form>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //监听提交
        form.on('submit(add)',
            function (data) {
                $.ajax({
                    type: "<?php echo strtoupper($data->method); ?>",
                    url: "<?php admin_url($data->action); ?>",
                    data: data.field,
                    success:function (dta) {
                        if (dta.code===0){
                            layer.alert("增加成功", {icon: 6}, function () {
                                //关闭当前frame
                                xadmin.close();

                                // 可以对父窗口进行刷新
                                xadmin.father_reload();
                            });
                        }else{
                            layer.msg(dta.msg);
                        }
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
                return false;
            });


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
