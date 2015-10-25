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
                    <li class="menu">
                        <a href="/" target="J_AdminIframe" class="menu-link">Edit blog information</a>
                    </li>
                    <li class="menu">
                        <a href="/" target="J_AdminIframe" class="menu-link">Menu settings</a>
                    </li>
                    <li class="menu">
                        <a href="/" target="J_AdminIframe" class="menu-link">Master links</a>
                    </li>
                    <li class="menu active">
                        <a href="/" target="J_AdminIframe" class="menu-link">Article manage</a>
                    </li>
                    <li class="menu">
                        <a href="/" target="J_AdminIframe" class="menu-link">Master card</a>
                    </li>
                    <li class="menu">
                        <a href="/" target="J_AdminIframe" class="menu-link">Category manage</a>
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
            <iframe src="./settings/article-list.php" frameborder="0" class="settings" id="J_AdminIframe" name="J_AdminIframe"></iframe>
        </div>
    </div>
</div>
<script src="assets/jquery-1.11.3.min.js"></script>
<script src="assets/index/index.js"></script>
</body>
</html>