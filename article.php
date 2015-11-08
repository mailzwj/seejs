<?php
    include_once('./inc/conn.php');
    include_once('./inc/function.php');
    date_default_timezone_set('UTC');
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if ($id) {
        $art = mysql_query('SELECT * FROM article WHERE id=' . $id . ' AND published=1 AND deleted=0');
        $rs = @mysql_fetch_array($art);
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
    <?php if ($rs) { ?>
    <div class="comment-form">
        <?php
            $coms = mysql_query('SELECT * FROM comments WHERE articleid=' . $id . ' AND deleted=0');
            $comCount = @mysql_num_rows($coms);
        ?>
        <div class="com-form">
            <h3 class="com-title">大家都在说</h3>
            <div class="com-list">
                <?php
                    if ($comCount) {
                ?>
                <ul class="rep-list">
                    <?php
                        while($rep = mysql_fetch_array($coms)) {
                            if ($rep['user'] == get_real_ip()) {
                                $user = '我';
                            } else {
                                $user = preg_replace("/(^[^.]+\.).*(\..+$)/", "$1*.*$2", $rep['user']);
                            }
                    ?>
                    <li class="rep">
                        <p class="rep-hd"><?php echo htmlspecialchars($user); ?>于<?php echo $rep['reply_time']; ?>说：</p>
                        <div class="rep-bd">
                            <?php echo htmlspecialchars($rep['content']); ?>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
                <?php
                    } else {
                ?>
                <span class="no-reply">还没人发言，快来抢沙发~~</span>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="comment-form">
        <div class="com-form">
            <h3 class="com-title">我要说</h3>
            <form class="com-main" action="./inc/comment-save.php" method="post">
                <input type="hidden" name="artid" value="<?php echo $id; ?>">
                <div class="com-group">
                    <label class="com-label" for="J_UserNick">昵称</label>
                    <div class="com-field">
                        <input type="text" class="com-inp" id="J_UserNick" name="nick" placeholder="<?php echo get_real_ip(); ?>">
                    </div>
                </div>
                <div class="com-group">
                    <label class="com-label" for="J_UserEmail">邮箱</label>
                    <div class="com-field">
                        <input type="text" class="com-inp" id="J_UserEmail" name="email" placeholder="请填写真实的邮箱地址">
                    </div>
                </div>
                <div class="com-group">
                    <label class="com-label" for="J_ComContent">评论</label>
                    <div class="com-field">
                        <textarea name="comment" id="ComContent" cols="30" rows="10" class="com-inp com-textarea"></textarea>
                    </div>
                </div>
                <div class="com-group">
                    <!-- <label class="com-label" for="J_UserEmail">邮箱</label> -->
                    <div class="com-field">
                        <input type="submit" class="com-button" id="J_UserComment" name="combtn" value="发 布">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
</div>
<?php
    mysql_close($conn);
    include_once('./inc/assets-js.php');
?>
<script src="assets/plugins/editormd/prettify.min.js"></script>
<!-- <script src="assets/plugins/highlight/highlight.pack.js"></script> -->
<script src="assets/js/article.js"></script>
</body>
</html>
