<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    include_once('../../inc/conn.php');
    $id = empty($_POST['id']) ? '' : $_POST['id'];
    $link = htmlspecialchars($_POST['linkname']);
    $ld = htmlspecialchars($_POST['link']);
    $li = htmlspecialchars(empty($_POST['icon']) ? 'icon-link15' : $_POST['icon']);

    if ($id) {
        $irs = mysql_query('UPDATE link SET linkname="' . $link . '",linkaddr="' . $ld . '",linkicon="' . $li . '" WHERE id=' . $id);
    } else {
        $irs = mysql_query('INSERT INTO link(linkname,linkaddr,linkicon) VALUES ("' . $link . '","' .$ld . '","' . $li . '")');
    }

    mysql_close($conn);

    if ($irs) {
        header('Location: ./link-setting.php');
        exit();
    } else {
        header('Location: ./link-setting.php?err=链接保存失败！');
        exit();
    }
?>