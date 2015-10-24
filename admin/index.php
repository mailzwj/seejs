<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ./login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEEJS.Admin</title>
</head>
<body>
    <a href="./exit.php" class="exit">退出登录</a>
</body>
</html>