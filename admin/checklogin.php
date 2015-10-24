<?php
    include_once('../inc/conn.php');

    session_start();
    $admin = $_POST['adminname'];
    $pass = $_POST['password'];

    $rs = mysql_query('SELECT id,adminname,password FROM managers WHERE adminname="' . $admin . '" AND password="' . md5($pass) . '"');

    $rsArr = mysql_fetch_array($rs);

    if (is_array($rsArr)) {
        $_SESSION['adminId'] = $rsArr['id'];
        $_SESSION['administrator'] = $rsArr['adminname'];
        header('Location: ./index.php');
    } else {
        header('Location: ./login.php');
    }
?>