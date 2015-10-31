<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    include_once('../../inc/conn.php');
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $menu = htmlspecialchars($_POST['menu']);
    $ml = htmlspecialchars($_POST['link']);
    $parent = $_POST['parent'];

    if ($id) {
        $irs = mysql_query('UPDATE menu SET menu="' . $menu . '",menulink="' . $ml . '",parent=' . $parent . ' WHERE id=' . $id);
    } else {
        $irs = mysql_query('INSERT INTO menu(menu,menulink,parent) VALUES ("' . $menu . '","' .$ml . '",' . $parent . ')');
    }

    mysql_close($conn);

    if ($irs) {
        header('Location: ./menu-setting.php');
        exit();
    } else {
        header('Location: ./menu-setting.php?err=菜单保存失败！');
        exit();
    }
?>