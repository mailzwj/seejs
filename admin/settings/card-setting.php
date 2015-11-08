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
    <title>SEEJS-菜单管理</title>
    <link rel="stylesheet" href="../assets/base/normalize.css">
    <link rel="stylesheet" href="../assets/base/common.css">
    <!-- <link rel="stylesheet" href="../assets/card/card.css"> -->
</head>
<body>
<?php
    // include_once('../../inc/conn.php');
?>

<div class="set-wrap card-wrap">
    Developing...
</div>

<?php
    // mysql_close($conn);
?>
</body>
</html>