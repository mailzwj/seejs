<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEEJS-<?php echo isset($_GET['id']) ? '编辑文章' : '创建文章'; ?></title>
    <link rel="stylesheet" href="../assets/base/normalize.css">
    <link rel="stylesheet" href="../assets/plugins/editormd/css/editormd.min.css">
    <link rel="stylesheet" href="../assets/base/common.css">
    <link rel="stylesheet" href="../assets/article/edit.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $cates = mysql_query('SELECT * FROM category ORDER BY id ASC');
    $article = '';
    if ($id) {
        $art = mysql_query('SELECT * FROM article WHERE id=' . $id);
        $article = mysql_fetch_array($art);
    }
?>

<div class="set-wrap">
    <form action="./article-save.php" method="post" id="J_ArticleForm">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="content" id="J_HtmlContent" value="">
        <div class="ed-row">
            <label for="J_ArticleTitle" class="label">标题</label><br>
            <input type="text" name="title" id="J_ArticleTitle" class="input" placeholder="请输入文章标题" value="<?php echo $article ? $article['title'] : ''; ?>">
        </div>
        <div class="ed-row">
            <label for="J_ArticleCate" class="label">分类</label><br>
            <select name="category" id="J_ArticleCate" class="select">
                <?php
                    if ($article) {
                        if ($article['category'] == '未分类') {
                            echo '<option value="0" selected>未分类</option>';
                        } else {
                            echo '<option value="0">未分类</option>';
                        }
                        while($cate = mysql_fetch_array($cates)) {
                            if ($article['category'] == $cate['category']) {
                                echo '<option value="' . $cate['id'] .'" selected>' . $cate['category'] . '</option>';
                            } else {
                                echo '<option value="' . $cate['id'] .'">' . $cate['category'] . '</option>';
                            }
                        }
                    } else {
                        echo '<option value="0">未分类</option>';
                        while($cate = mysql_fetch_array($cates)) {
                            echo '<option value="' . $cate['id'] .'">' . $cate['category'] . '</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div class="ed-row">
            <label for="J_ArticleSource" class="label">正文</label><br>
            <div id="J_ArticleMain" class="input editor">
                <textarea name="source" id="J_ArticleSource" class="hidden"><?php echo $article ? $article['sourcecontent'] : ''; ?></textarea>
            </div>
        </div>
        <div class="ed-row">
            <input type="submit" value="发 布" id="J_SaveArticle" class="button"><input type="button" id="J_BackList" value="取 消" class="button cancel">
        </div>
    </form>
</div>
<?php mysql_close($conn); ?>
<script src="../assets/jquery-1.11.3.min.js"></script>
<script src="../assets/plugins/editormd/editormd.min.js"></script>
<script src="../assets/article/edit.js"></script>
</body>
</html>
