<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="Controller">&#xe6b4;</i>
                    <cite>Controller</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('路由列表','<?php admin_url("control/routes"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>路由列表</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('控制器','<?php admin_url("control/list"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>控制器</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('中间件','<?php admin_url("mid/list"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>中间件</cite></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="Model">&#xe6b4;</i>
                    <cite>Model</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('Dao','<?php admin_url("model/dao"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>Dao</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('Data','<?php admin_url("model/data"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>Data</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('Login','<?php admin_url("model/logic"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>Login</cite></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="Controller">&#xe6b4;</i>
                    <cite>Console</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('Command','<?php admin_url("console/command"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>Command</cite></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="Controller">&#xe6b4;</i>
                    <cite>Crontab</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('Crontab','<?php admin_url("crontab/lists"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>Crontab</cite></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="Controller">&#xe6b4;</i>
                    <cite>Validator</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('Validator-list','<?php admin_url("validator/lists"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>List</cite></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="Controller">&#xe6b4;</i>
                    <cite>Setting</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('Validator-list','<?php admin_url("setting/http"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>http</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('Validator-list','<?php admin_url("setting/websocket"); ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>websocket</cite></a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
