<!DOCTYPE html>
<html class="x-admin-sm">

<head>
  <?php use Swoft\SwoftAdmin\Model\Data\RouteInfo;

  $this->include('layouts/meta') ?>
  <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a href="">控制器</a>
                <a>
                    <cite>路由</cite></a>
            </span>
  <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()"
     title="刷新">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
  </a>
</div>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">
          <button class="layui-btn layui-btn-danger" onclick="location.reload()">
            <i class="layui-icon layui-icon-refresh"></i>遍历代码
          </button>
          <button class="layui-btn" onclick="xadmin.open('添加控制器','<?php echo admin_url('control/add'); ?>',800,600)">
            <i class="layui-icon"></i>添加
          </button>
            <button class="layui-btn" onclick="xadmin.open('导出postmen','<?php echo admin_url('control/setPostmen'); ?>',800,600)">
                <i class="layui-icon"></i>导出postmen
            </button>
        </div>
        <div class="layui-card-body ">
          <table class="layui-table layui-form">
            <thead>
            <tr>
              <th>id</th>
              <th>标题</th>
              <th>path</th>
              <th>method</th>
              <th>controller</th>
              <th>handler</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var RouteInfo $route */ ?>
            <?php /** @var array $routes */ ?>
            <?php foreach ($routes as $key => $route) { ?>
              <tr>
                <td><?php echo $key; ?></td>
                <td><?php echo $route->title ?? "无注释"; ?></td>
                <td><?php echo $route->path; ?></td>
                <td><?php echo implode(',',$route->method); ?></td>
                <td><?php echo $route->controller; ?></td>
                <td><?php echo $route->action; ?></td>
                <td class="td-manage">
                  <a title="查看" onclick="xadmin.open('编辑','<?php echo admin_url('control/route')."?".$route->controller."@".$route->action; ?>')" href="javascript:;">
                    <i class="layui-icon">&#xe63c;</i></a>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<script>layui.use(['laydate', 'form'],
        function () {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });

    /*用户-停用*/
    function member_stop(obj, id) {
        layer.confirm('确认要停用吗？',
            function (index) {

                if ($(obj).attr('title') == '启用') {

                    //发异步把用户状态进行更改
                    $(obj).attr('title', '停用');
                    $(obj).find('i').html('&#xe62f;');

                    $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                    layer.msg('已停用!', {
                        icon: 5,
                        time: 1000
                    });

                } else {
                    $(obj).attr('title', '启用');
                    $(obj).find('i').html('&#xe601;');

                    $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                    layer.msg('已启用!', {
                        icon: 5,
                        time: 1000
                    });
                }

            });
    }

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？',
            function (index) {
                //发异步删除数据
                $(obj).parents("tr").remove();
                layer.msg('已删除!', {
                    icon: 1,
                    time: 1000
                });
            });
    }

    function reloadCode(argument) {


    }</script>

</html>
