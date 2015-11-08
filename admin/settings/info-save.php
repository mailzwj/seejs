<?php

    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }

    include_once('../../inc/conn.php');
    $id = $_POST['id'];
    $logo = $_POST['logo'];
    $name = htmlspecialchars($_POST['sitename']);
    $sname = htmlspecialchars($_POST['subname']);
    $rImg = '/\.(png|jpe?g|gif)$/';

    if (!preg_match($rImg, $logo)) {
        header('Location: ./blog-info.php?err=LOGO不是合法的图片链接！');
        exit();
    }
    if (empty($id)) {
        $rrs = mysql_query('INSERT INTO siteinfo(logo,sitename,subname,used) VALUES ("' . $logo . '","' . $name . '","' . $sname . '",1)');
    } else {
        $rrs = mysql_query('UPDATE siteinfo SET logo="' . $logo . '",sitename="' . $name . '",subname="' . $sname . '" WHERE id=' . $id . ' AND used=1');
    }

    mysql_close($conn);

    if ($rrs) {
        header('Location: ./blog-info.php');
        exit();
    } else {
        header('Location: ./blog-info.php?err=博客信息更新失败！');
        exit();
    }

?>