<?php
    include_once('./inc/conn.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEEJS - 百码山庄</title>
    <?php
        include_once('./inc/assets-css.php');
    ?>
    <link rel="stylesheet" href="assets/plugins/editormd/editormd.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
<?php
    include_once('./inc/menubar.php');
    include_once('./inc/sidebar.php');

    $pageSize = 5;
    $page = empty($_GET['page']) ? 1 : intval($_GET['page']);
    $arts = mysql_query('SELECT * FROM article WHERE deleted=0 AND published=1 ORDER BY createtime DESC LIMIT ' . ($page - 1) * $pageSize . ',' . $pageSize);
    $rsCount = mysql_query('SELECT count(*) FROM article WHERE deleted=0 AND published=1');
    if ($rsRow = mysql_fetch_array($rsCount)) {
        $count = $rsRow[0];
    } else {
        $count = 0;
    }
    $pageTotal = ceil($count / $pageSize);

    mysql_close($conn);
?>
<div class="wrap">
    <span class="vertical-line"></span>
    <div class="article-wrap" id="J_ArticleWrap">
        <?php
            $rImg = '<img\\s.*?src=[\'\"]?.+\.(png|jpe?g|gif)[\'\"]?.*>';
            $rVideo = '<video\\s.*?>';
            while($a = mysql_fetch_array($arts)) {
                // 将文章的第一段作为摘要
                // 如果没有发现段落标记则使用全文作为摘要
                $pos = strpos($a['content'], '</p>');
                if ($pos) {
                    $abs = substr($a['content'], 0, $pos + 4);
                } else {
                    $abs = $a['content'];
                }
        ?>
        <div class="article">
            <?php
                if (preg_match($rImg, $a['content'])) {
                    $type = 'art-pict';
                    $icon = 'icon-photo33';
                } else if (preg_match($rVideo, $a['content'])) {
                    $type = 'art-video';
                    $icon = 'icon-video91';
                } else {
                    $type = 'art-text';
                    $icon = 'icon-text61';
                }
            ?>
            <div class="art-type <?php echo $type; ?>"><!-- art-pict/art-video -->
                <span class="<?php echo $icon; ?>"></span><!-- icon-photo33/icon-video91 -->
            </div>
            <div class="art-preview">
                <h2 class="art-title">
                    <a href="./article.php?id=<?php echo $a['id']; ?>" target="_blank" class="art-link">
                        <?php echo $a['title']; ?>
                    </a>
                </h2>
                <?php
                    if ($a['banner']) {
                ?>
                <div class="art-theme" style="background-image: url(./assets/image/pict.png);"></div>
                <?php
                    }
                ?>
                <div class="markdown-body editormd-preview-container art-body">
                    <?php // echo $a['content']; ?>
                    <?php echo str_replace('&quot;', "\"", $abs); ?>
                </div>
            </div>
            <div class="art-data">
                <span class="icon-thumbs28"></span>&nbsp;<span class="like-num">(<?php echo $a['praise']; ?>)</span>
                <span class="icon-comment32"></span>&nbsp;<span class="reply-num">(<?php echo $a['comment']; ?>)</span>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="pagination">
        <div class="pagers">
            <?php
                if ($page <= 1) {
            ?>
            <span class="page prev disabled">上一页</span>
            <?php
                } else {
            ?>
            <a href="?page=<?php echo $page - 1; ?>" target="_self" class="page prev">上一页</a>
            <?php } ?>
            <?php
                $p = 1;
                while($p <= $pageTotal) {
            ?>
            <a href="?page=<?php echo $p; ?>" target="_self" class="page<?php echo $p == $page ? ' active' : ''; ?>"><?php echo $p; ?></a>
            <?php
                    $p++;
                }
            ?>
            <!-- <span class="page">...</span> -->
            <?php
                if ($page >= $pageTotal) {
            ?>
            <span class="page next disabled">下一页</span>
            <?php
                } else {
            ?>
            <a href="?page=<?php echo $page + 1; ?>" target="_self" class="page next">下一页</a>
            <?php } ?>
        </div>
        <div class="page-percent">
            <div class="page-track">
                <div class="percent-bar" style="width: <?php echo $page / $pageTotal * 100 . '%'; ?>;"></div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('./inc/assets-js.php');
?>
<script src="assets/plugins/editormd/prettify.min.js"></script>
<script src="./assets/js/index.js"></script>
</body>
</html>