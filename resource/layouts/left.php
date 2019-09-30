<?php /** @var array $data */ ?><!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <?php foreach ($data['menu'] as $datum) { ?>
            <li>
                <a href="<?php if (isset($datum["ul"]) && $datum["ul"]) {
                    echo "javascript:;";
                } else {
                    echo $datum["url"] ?? "";
                } ?>">
                    <i class="iconfont left-nav-li" lay-tips="Controller"><?php echo $datum["icon"] ?? ""; ?></i>
                    <cite><?php echo $datum["name"] ?? ""; ?></cite>
                    <?php if (isset($datum["ul"]) && $datum["ul"]) {
                        echo "<i class=\"iconfont nav_right\"></i>";
                    } else {
                        echo "";
                    } ?></a>
                <ul class="sub-menu">
                    <?php foreach ($datum["ul"] ?? [] as $item) { ?>
                    <li>
                        <a
                            <?php if (isset($item["url"])) {
                                echo "onclick=\"xadmin.add_tab('{$item["name"]}','{$item["url"]}')\"";
                            } else {
                                echo "href=\"javascript:;\"";
                            } ?>
                        >
                            <i class="iconfont"><?php echo $item["icon"] ?? ""; ?></i>
                            <cite><?php echo $item["name"] ?? ""; ?></cite>
                            <?php if (isset($item["ul"]) && $item["ul"]) {
                                echo '<i class="iconfont nav_right">&#xe697;</i>';
                            } ?>
                        </a>

                        <?php if (isset($item["ul"]) && $item["ul"]){
                        echo '<ul class="sub-menu">'; ?>
                        <?php foreach ($item["ul"] ?? [] as $item2) { ?>
                    <li>
                        <a onclick="xadmin.add_tab('<?php echo $item2["name"] ?? ""; ?>','<?php admin_url($item2["url"] ?? ""); ?>')">
                            <i class="iconfont"><?php echo $item2["icon"] ?? ""; ?></i>
                            <cite><?php echo $item2["name"] ?? ""; ?></cite>
                        </a>
                    </li>
                <?php } ?>
                </ul>
                <?php echo '</ul>';
                } ?>
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
