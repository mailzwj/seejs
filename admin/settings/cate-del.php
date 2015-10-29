<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    $id = $_GET['id'];
    if (!isset($id)) {
        header('Location: ./cate-config.php');
        exit();
    }

    include_once('../../inc/conn.php');

    $rrs = mysql_query('DELETE FROM category WHERE id=' . $id);
    // $rrs = mysql_query('UPDATE article SET deleted=1 WHERE id=' . $id);

    mysql_close($conn);

    if ($rss) {
        header('Location: ./cate-config.php');
        exit();
    } else {
        header('Location: ./cate-config.php?err=记录【' . $id . '】删除失败！');
        exit();
    }
?>
