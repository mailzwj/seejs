<?php

    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    include_once('../../inc/conn.php');

    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $cate = htmlspecialchars($_POST['category']);
    $banner = htmlspecialchars($_POST['banner']);
    $source = htmlspecialchars($_POST['source']);
    $content = str_replace("\"", "&quot;", $_POST['content']);

    $crs = mysql_query("SELECT category FROM category WHERE id=" . $cate);
    if ($row = mysql_fetch_array($crs)) {
        $category = $row['category'];
    } else {
        $category = '未分类';
    }

    if ($id) {
        $irs = mysql_query("UPDATE article SET title=\"" . $title ."\",sourcecontent=\"" . $source . "\",content=\"" . $content . "\",category=\"" . $category . "\",banner=\"" . $banner . "\" WHERE id=" . $id);
    } else {
        $irs = mysql_query("INSERT INTO article(title,sourcecontent,content,publisher,category,banner,published) VALUES(\"" . $title . "\",\"" . $source . "\",\"" . $content . "\",\"" . $_SESSION['administrator'] . "\",\"" . $category . "\",\"" . $banner . "\",1)");
    }

    mysql_close($conn);

    if ($irs) {
        header('Location: ./article-list.php');
        exit();
    } else {
        header('Location: ./article-list.php?err=文章保存失败！');
        exit();
    }

?>
