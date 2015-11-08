<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    $id = $_GET['id'];
    $artid = $_GET['artid'];
    if (empty($id)) {
        header('Location: ./comment-list.php');
        exit();
    }

    include_once('../../inc/conn.php');

    // $rrs = mysql_query('DELETE FROM article WHERE id=' . $id);
    $rrs = mysql_query('UPDATE comments SET deleted=1 WHERE id=' . $id);
    mysql_query('UPDATE article SET comment=comment-1 WHERE id=' . $artid);

    mysql_close($conn);

    if ($rss) {
        header('Location: ./comment-list.php');
        exit();
    } else {
        header('Location: ./comment-list.php?err=评论【' . $id . '】删除失败！');
        exit();
    }
?>