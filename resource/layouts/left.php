<?php/** @var array $data */?><!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <?php foreach ($data as $datum){ ?>
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="Controller">&#xe6b4;</i>
                    <cite><?php echo $datum["name"]??""; ?></cite>
                    <i class="iconfont nav_right"><?php echo $datum["icon"]??""; ?></i></a>
                <ul class="sub-menu">
                    <?php foreach ($datum["ul"] as $item){ ?>
                    <li>
                        <a onclick="xadmin.add_tab('<?php echo $item["name"]??""; ?>','<?php admin_url($item["url"]??""); ?>')">
                            <i class="iconfont"><?php echo $item["icon"]??""; ?></i>
                            <cite><?php echo $item["name"]??""; ?></cite></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
