<!-- 顶部开始 -->
<div class="container">
    <div class="logo">
        <a href="<?php admin_src(); ?>index.html">Swoft - Admin</a></div>
    <div class="left_open">
        <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;"><?php echo $data['username']; ?></a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.open('个人信息','https://github.com/ctfang/swoft-admin')">个人信息</a></dd>
                <dd>
                    <a onclick="xadmin.open('切换帐号','https://github.com/ctfang/swoft-admin')">切换帐号</a></dd>
                <dd>
                    <a href="<?php admin_url("logout"); ?>">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index">
            <a href="https://github.com/ctfang/swoft-admin">GITHUB</a></li>
    </ul>
</div>
<!-- 顶部结束 -->
