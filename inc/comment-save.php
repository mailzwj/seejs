<?php
    include_once('./conn.php');
    include_once('./function.php');

    $artid = $_POST['artid'];
    $user = $_POST['nick'];
    $email = $_POST['email'];
    $reply = $_POST['comment'];

    $user = empty($user) ? get_real_ip() : $user;
    if (!$artid) {
        header('Location: ../index.php');
        exit();
    }

    $irs = mysql_query("INSERT INTO comments(articleid,user,email,content) VALUES (" . $artid . ",\"" . $user . "\",\"" . $email . "\",\"" . $reply . "\")");
    mysql_close($conn);
    if ($irs) {
        header('Location: ../article.php?id=' . $artid);
        exit();
    } else {
        header('Location: ../article.php?id=' . $artid . '&err=评论失败！');
        exit();
    }
?>