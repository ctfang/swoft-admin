<?php

use SwoftAdmin\Tool\View\Login;
/** @var Login $data */
$data->link('/css/login.css');
?>

<div class="login layui-anim layui-anim-up">
    <div class="message"><?php echo $data->title;?></div>
    <div id="darkbannerwrap"></div>

    <form method="post" class="layui-form" >
        <input name="username" placeholder="用户名"  type="text" lay-verify="required" value="" class="layui-input" >
        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码"  type="password" value="" class="layui-input">
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20" >
    </form>
</div>
