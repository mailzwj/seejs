<?php
    include_once('../inc/conn.php');

    $admin = $_POST['adminname'];
    $pass = $_POST['password'];

    $rs = mysql_query('SELECT adminname,password FROM managers WHERE adminname="' . $admin . '" AND password="' . md5($pass) . '"');

    if (is_array(mysql_fetch_array($rs))) {
        echo 'Login success.';
    } else {
        echo 'Login failed.';
    }
?>