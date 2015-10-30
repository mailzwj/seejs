<?php
    include_once('./inc/conn.php');
    date_default_timezone_set('UTC');
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if ($id) {
        $art = mysql_query('SELECT * FROM article WHERE id=' . $id . ' AND published=1 AND deleted=0');
        $rs = mysql_fetch_array($art);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEEJS - <?php echo $rs ? $rs['title'] : '文章不存在'; ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/plugins/editormd/editormd.min.css">
    <!-- <link rel="stylesheet" href="assets/plugins/highlight/themes/github.css"> -->
    <link rel="stylesheet" href="assets/css/article.css">
</head>
<body>
<div class="menubar">
    <a href="index.php" target="_self" class="logo">
        &#xe864;
    </a>
    <p class="site-name">
        SEEJS
    </p>
    <div class="menus">
        <ul class="menu-list">
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Home <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Archive <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Works <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    Messages <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <li class="menu">
                <a href="index.php" class="menu-url">
                    About <span class="icons icon-chevron18"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="other-link">
        <a href="http://github.com/mailzwj" target="_blank" class="link">
            <span class="icon-github11"></span>
            <span class="link-name">mailzwj</span>
        </a>
        <a href="http://weibo.com/ys800" target="_blank" class="link">
            <span class="icon-weibo"></span>
            <span class="link-name">OAuth_v2</span>
        </a>
        <a href="#" target="_blank" class="link">
            <span class="icon-speech59"></span>
            <span class="link-name">无痕</span>
        </a>
    </div>
</div>
<div class="sidebar">
    <!-- 敬请期待... -->
</div>
<div class="wrap">
    <div class="article-wrap">
        <h1 class="art-title">
            <?php echo $rs ? $rs['title'] : 'Sorry，文章不存在！'; ?>
        </h1>
        <div class="markdown-body editormd-preview-container content">
            <?php echo $rs ? str_replace('&quot;', "\"", $rs['content']) : ''; ?>
        </div>
        <?php
            if ($rs) {
                $dt = explode(' ', $rs['createtime']);
        ?>
        <div class="art-foot">
            <div class="art-info">
                <span class="pub-date">
                    <span class="icons icon-calendar52"></span>&nbsp;<?php echo $dt[0];?>
                </span>
                <span class="art-cate">
                    <span class="icons icon-four29"></span>&nbsp;<?php echo $rs['category'];?>
                </span>
                <a href="#" class="art-praise">
                    <span class="icons icon-thumbs26"></span>&nbsp;(<?php echo $rs['praise'];?>)
                </a>
            </div>
            <div class="reprint">
                转载请注明原文来自<a href="index.php" target="_self">SEEJS</a>的：<a href="#" target="_self">《<?php echo $rs['title'];?>》</a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/plugins/editormd/prettify.min.js"></script>
<!-- <script src="assets/plugins/highlight/highlight.pack.js"></script> -->
<script src="assets/js/article.js"></script>
</body>
</html>
