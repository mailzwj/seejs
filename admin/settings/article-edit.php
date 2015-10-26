<?php
    session_start();
    if (!$_SESSION['adminId']) {
        header('Location: ../login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SEEJS-<?php echo isset($_GET['id']) ? '编辑文章' : '创建文章'; ?></title>
    <link rel="stylesheet" href="../assets/base/normalize.css">
    <link rel="stylesheet" href="../assets/base/common.css">
    <link rel="stylesheet" href="../assets/article/edit.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '';
?>
    edit--<?php echo $id; ?>
<?php mysql_close($conn); ?>
</body>
</html>