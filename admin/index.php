<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ./login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEEJS.Admin</title>
    <link rel="stylesheet" href="assets/base/normalize.css">
    <link rel="stylesheet" href="assets/base/common.css">
    <link rel="stylesheet" href="assets/index/index.css">
</head>
<body>
<div class="wrap">
    <div class="left-bar">
        <h2 class="logo">SEEJS.Admin</h2>
        <div class="left-menu-wrap">
            <div class="left-menu">
                <ul class="menus-list" id="J_ManageMenus">
                    <li class="menu active">
                        <a href="./settings/blog-info.php" target="J_AdminIframe" class="menu-link">编辑博客信息</a>
                    </li>
                    <li class="menu">
                        <a href="./settings/cate-config.php" target="J_AdminIframe" class="menu-link">分类管理</a>
                    </li>
                    <li class="menu">
                        <a href="./settings/menu-setting.php" target="J_AdminIframe" class="menu-link">菜单管理</a>
                    </li>
                    <li class="menu">
                        <a href="./settings/link-setting.php" target="J_AdminIframe" class="menu-link">链接管理</a>
                    </li>
                    <li class="menu">
                        <a href="./settings/article-list.php" target="J_AdminIframe" class="menu-link">文章管理</a>
                    </li>
                    <li class="menu">
                        <a href="./settings/comment-review.php" target="J_AdminIframe" class="menu-link">评论管理</a>
                    </li>
                    <li class="menu">
                        <a href="./settings/card-setting.php" target="J_AdminIframe" class="menu-link">站长名片</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-wrap">
        <div class="right-title" id="J_RightTitle">
            您好，<?php echo $_SESSION['administrator']; ?>！<a href="./exit.php" target="_self" class="logout">退出</a>
        </div>
        <div class="right-body">
            <iframe src="./settings/blog-info.php" frameborder="0" class="settings" id="J_AdminIframe" name="J_AdminIframe"></iframe>
        </div>
    </div>
</div>
<script src="assets/jquery-1.11.3.min.js"></script>
<script src="assets/index/index.js"></script>
</body>
</html>