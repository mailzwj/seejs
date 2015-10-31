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
    <title>SEEJS-博客基本信息</title>
    <link rel="stylesheet" href="../assets/base/normalize.css">
    <link rel="stylesheet" href="../assets/base/common.css">
    <link rel="stylesheet" href="../assets/info/info.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');
    $info = mysql_query('SELECT * FROM siteinfo WHERE used=1');
    $data = mysql_fetch_array($info);
?>

<div class="set-wrap info-wrap">
    <form action="./info-save.php" method="post" id="J_InfoForm">
        <input type="hidden" name="id" value="<?php echo $data ? $data['id'] : ''; ?>">
        <div class="ed-row">
            <label for="J_InfoLogo" class="label">分类名称</label><input type="text" name="logo" id="J_InfoLogo" class="input" placeholder="请上传博客LOGO(推荐：150x165)" value="<?php echo $data ? $data['logo'] : ''; ?>">
            <div class="button upload">
                <span class="icon-upload40"></span>
                <input type="file" name="image" id="J_UploadLogo" class="up-image">
            </div>
        </div>
        <div class="ed-row">
            <label for="J_InfoName" class="label">分类名称</label><input type="text" name="sitename" id="J_InfoName" class="input" placeholder="请输入博客名称" value="<?php echo $data ? $data['sitename'] : ''; ?>">
        </div>
        <div class="ed-row">
            <label for="J_InfoSub" class="label">分类名称</label><input type="text" name="subname" id="J_InfoSub" class="input" placeholder="请输入副标题" value="<?php echo $data ? $data['subname'] : ''; ?>">
        </div>
        <div class="ed-row btn-row">
            <input type="submit" value="保 存" id="J_SaveInfo" class="button">
        </div>
    </form>
</div>
<?php mysql_close($conn); ?>
<script src="../assets/jquery-1.11.3.min.js"></script>
<script src="../assets/info/info.js"></script>
</body>
</html>
