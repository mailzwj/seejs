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
    <link rel="stylesheet" href="../assets/link/link.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $links = mysql_query('SELECT * FROM link ORDER BY id ASC');
    if ($id) {
        $one = mysql_query('SELECT * FROM link WHERE id=' . $id);
        $oneArr = mysql_fetch_array($one);
    }
    $rows = mysql_num_rows($links);
?>

<div class="set-wrap link-wrap">
    <form action="./link-save.php" method="post" id="J_LinkForm">
        <input type="hidden" name="id" value="<?php echo isset($oneArr) ? $oneArr['id'] : ''; ?>">
        <div class="ed-row">
            <label for="J_LinkTitle" class="label">链接名称</label><input type="text" name="linkname" id="J_LinkTitle" class="input" placeholder="请输入链接名称" value="<?php echo isset($oneArr) ? $oneArr['linkname'] : ''; ?>"><span class="inline-help">(例: Github)</span>
        </div>
        <div class="ed-row">
            <label for="J_LinkAddr" class="label">链接地址</label><input type="text" name="link" id="J_LinkAddr" class="input" placeholder="请输入链接地址" value="<?php echo isset($oneArr) ? $oneArr['linkaddr'] : ''; ?>">
        </div>
        <div class="ed-row">
            <label for="J_LinkIcon" class="label">链接地址</label><input type="text" name="icon" id="J_LinkIcon" class="input" placeholder="请输入链接ICON" value="<?php echo isset($oneArr) ? $oneArr['linkicon'] : ''; ?>"><span class="inline-help">(默认: "icon-link15")</span>
        </div>
        <div class="ed-row btn-row">
            <input type="submit" value="<?php echo $id ? '保 存' : '添 加'; ?>" id="J_SaveLink" class="button"><?php echo $id ? '<a href="./link-setting.php" class="button cancel">返回新增</a>' : ''; ?>
        </div>
    </form>
    <table class="link-list">
        <thead>
            <tr>
                <th>Id</th>
                <th>链接名称</th>
                <th>链接地址</th>
                <th>链接图标</th>
                <th>管理</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($rows) {
                    while($row = mysql_fetch_array($links)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['linkname']; ?></td>
                <td><?php echo $row['linkaddr']; ?></td>
                <td><?php echo $row['linkicon']; ?></td>
                <td>
                    <a href="./link-setting.php?id=<?php echo $row['id']; ?>" target="_self" class="link-edit"><span class="icon-edit24"></span></a>
                    <!-- <a href="./link-move.php?id=<?php echo $row['id']; ?>&sort=up" target="_self" class="link-edit"><span class="icon-arrow467"></span></a>
                    <a href="./link-move.php?id=<?php echo $row['id']; ?>&sort=down" target="_self" class="link-edit"><span class="icon-arrow466"></span></a> -->
                    <a href="./link-del.php?id=<?php echo $row['id']; ?>" target="_self" class="link-del"><span class="icon-remove11"></span></a>
                </td>
            </tr>
            <?php
                    }
                } else {
            ?>
            <tr>
                <td colspan="5">暂无链接！</td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>

<?php mysql_close($conn); ?>
</body>
</html>