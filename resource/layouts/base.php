<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>Swoft-WebTool</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="<?php admin_src(); ?>css/font.css">
    <link rel="stylesheet" href="<?php admin_src(); ?>css/xadmin.css"><?php /** @var array $viewLink */
    foreach ($viewLink??[] as $str) {
        echo $str;
    }
    /** @var array $viewScript */
    foreach ($viewScript??[] as $str) {
        echo $str;
    }
    ?>
    <!-- <link rel="stylesheet" href="<?php admin_src(); ?>css/theme5.css"> -->
    <script src="<?php admin_src(); ?>lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php admin_src(); ?>js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">
{_CONTENT_}
</body>
</html>
