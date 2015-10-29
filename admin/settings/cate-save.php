<?php

    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    include_once('../../inc/conn.php');

    $id = htmlspecialchars($_POST['id']);
    $cate = htmlspecialchars($_POST['category']);

    if ($id) {
        $irs = mysql_query("UPDATE category SET category=\"" . $cate ."\" WHERE id=" . $id);
    } else {
        $irs = mysql_query("INSERT INTO category(category) VALUES(\"" . $cate . "\")");
    }

    mysql_close($conn);

    if ($irs) {
        header('Location: ./cate-config.php');
        exit();
    } else {
        header('Location: ./cate-list.php?err=分类保存失败！');
        exit();
    }

?>
