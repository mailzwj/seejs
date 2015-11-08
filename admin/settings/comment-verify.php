<?php

    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    include_once('../../inc/conn.php');

    $act = $_GET['act'];
    $id = $_GET['id'];
    $artid = $_GET['artid'];

    if (empty($act) || empty($id)) {
        header('Location: ./comment-review.php?err=缺少参数！');
        exit();
    }

    if ($act == 'through') {
        $irs = mysql_query('UPDATE comments SET deleted=0 WHERE id=' . $id);
        mysql_query('UPDATE article SET comment=comment+1 WHERE id=' . $artid);
    } else if ($act == 'del') {
        $irs = mysql_query('DELETE FROM comments WHERE id=' . $id);
    }

    mysql_close($conn);

    if ($irs) {
        header('Location: ./comment-review.php');
        exit();
    } else {
        header('Location: ./comment-review.php?err=操作失败！');
        exit();
    }
?>