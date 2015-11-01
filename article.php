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
    <?php
        include_once('./inc/assets-css.php');
    ?>
    <link rel="stylesheet" href="assets/plugins/editormd/editormd.min.css">
    <!-- <link rel="stylesheet" href="assets/plugins/highlight/themes/github.css"> -->
    <link rel="stylesheet" href="assets/css/article.css">
</head>
<body>
<?php
    include_once('./inc/menubar.php');
    include_once('./inc/sidebar.php');
?>
<input type="hidden" id="J_ArtId" value="<?php echo $id; ?>">
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
                <a href="./apis/praise.php?id=<?php echo $id; ?>" class="J_ArtPraise art-praise">
                    <span class="icons icon-thumbs26"></span>&nbsp;(<span class="J_PraiseNum"><?php echo $rs['praise'];?></span>)
                </a>
            </div>
            <div class="reprint">
                转载请注明原文来自<a href="./index.php" target="_self">SEEJS</a>的：<a href="?id=<?php echo $id; ?>" target="_self">《<?php echo $rs['title'];?>》</a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php
    include_once('./inc/assets-js.php');
?>
<script src="assets/plugins/editormd/prettify.min.js"></script>
<!-- <script src="assets/plugins/highlight/highlight.pack.js"></script> -->
<script src="assets/js/article.js"></script>
</body>
</html>
