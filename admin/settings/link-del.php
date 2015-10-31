<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    $id = $_GET['id'];
    if (empty($id)) {
        header('Location: ./link-setting.php');
        exit();
    }

    include_once('../../inc/conn.php');

    $rs = mysql_query('DELETE FROM link WHERE id=' . $id);

    mysql_close($conn);
    if ($rs) {
        header('Location: ./link-setting.php');
        exit();
    } else {
        header('Location: ./link-setting.php?err=链接删除失败！');
        exit();
    }
?>