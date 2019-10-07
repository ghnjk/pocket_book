<?php
header("Content-Type: text/html;charset=utf-8");
include_once("data/config.php");
include_once("inc/function.php");
// 登录状态判断
loginchk($userid);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo siteName;?></title>
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo SiteURL;?>img/apple-touch-icon.png"><link rel="icon" type="image/png" sizes="32x32" href="<?php echo SiteURL;?>img/favicon-32x32.png"><link rel="icon" type="image/png" sizes="16x16" href="<?php echo SiteURL;?>img/favicon-16x16.png">
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/itlu.style.css?<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/all.js?<?php echo $version;?>"></script>
</head>

<body><div id="itlu-wrap">
        <div class="table-responsive">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#example-navbar-collapse">
                            <span class="sr-only">导航</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="overview.php">我的账本</a>
                    </div>
                    <div class="collapse navbar-collapse" id="example-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="overview.php?type=in" <?php show_menu_cur("overview.php?type=in");?>>收入概览</a></li>
                            <li><a href="overview.php?type=out" <?php show_menu_cur("overview.php?type=out");?>>支出概览</a></li>
                            <li><a href="stat.php" <?php show_menu_cur("stat.php");?>>近期统计</a></li>
                            <li><a href="annual_stat.php" <?php show_menu_cur("annual_stat.php");?>>全年统计</a></li>
                            <li><a href="classify.php" <?php show_menu_cur("classify.php");?>>分类编辑</a></li>
                            <li><a href="int_out.php" <?php show_menu_cur("int_out.php");?>>导入导出</a></li>
                           <!--
                                 <li><a href="show.php" <?php show_menu_cur("show.php");?>>查询修改</a></li>
                                 -->
                            <li><a href="bank.php" <?php show_menu_cur("bank.php");?>>账户管理</a></li>
                            <li><a href="users.php" <?php show_menu_cur("users.php");?>><?php if(isset($_SESSION['new_name'])){echo "扮演：".$_SESSION['new_name'];}else{echo "帐号：".$userinfo['username'];}?></a></li>                         
                            <li><a href="login.php?action=loginout">退出</a></li>
                        </ul>
                    </div>
                </div>
            </nav>