<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    $id = $_GET['id'];
    if (!isset($id)) {
        header('Location: ./article-list.php');
        exit();
    }

    include_once('../../inc/conn.php');

    // $rrs = mysql_query('DELETE FROM article WHERE id=' . $id);
    $rrs = mysql_query('UPDATE article SET deleted=0 WHERE id=' . $id);

    mysql_close($conn);

    if ($rss) {
        header('Location: ./article-list.php');
        exit();
    } else {
        header('Location: ./article-list.php?err=记录【' . $id . '】删除失败！');
        exit();
    }
?>
