<?php
    session_start();
    if ($_SESSION['adminId']) {
        header('Location: ./index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录博客管理后台</title>
    <link rel="stylesheet" href="./assets/base/normalize.css">
    <link rel="stylesheet" href="./assets/base/common.css">
    <link rel="stylesheet" href="./assets/login/index.css">
</head>
<body>
    <div class="login-wrap">
        <h2 class="login-title">SEEJS.Admin</h2>
        <div class="login-body">
            <form action="./checklogin.php" class="login-form" method="post">
                <div class="form-group">
                    <label for="J_AdminName" class="input-label"><span class="icon-user77"></span></label>
                    <input type="text" name="adminname" id="J_AdminName" class="login-input" placeholder="Administrator" autofocus>
                </div>
                <div class="form-group">
                    <label for="J_AdminPass" class="input-label"><span class="icon-vintage27"></span></label>
                    <input type="password" name="password" id="J_AdminPass" class="login-input" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="submit" value="登 录" class="admin-submit">
                    <a href="../index.php" target="_self" class="back-home">返回首页？</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>