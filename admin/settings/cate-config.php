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
    <title>SEEJS-分类管理</title>
    <link rel="stylesheet" href="../assets/base/normalize.css">
    <link rel="stylesheet" href="../assets/base/common.css">
    <link rel="stylesheet" href="../assets/category/cate.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $cates = mysql_query('SELECT * FROM category ORDER BY id ASC');
    if ($id) {
        $one = mysql_query('SELECT * FROM category WHERE id=' . $id);
        $oneArr = mysql_fetch_array($one);
    }
    $rows = mysql_num_rows($cates);
?>

<div class="set-wrap cate-wrap">
    <form action="./cate-save.php" method="post" id="J_CateForm">
        <input type="hidden" name="id" value="<?php echo isset($oneArr) ? $oneArr['id'] : ''; ?>">
        <div class="ed-row">
            <label for="J_CateTitle" class="label">分类名称</label><input type="text" name="category" id="J_CateTitle" class="input" placeholder="请输入分类名称" value="<?php echo isset($oneArr) ? $oneArr['category'] : ''; ?>">
        </div>
        <div class="ed-row btn-row">
            <input type="submit" value="<?php echo $id ? '保 存' : '添 加'; ?>" id="J_SaveCategory" class="button"><?php echo $id ? '<a href="./cate-config.php" class="button cancel">返回新增</a>' : ''; ?>
        </div>
    </form>
    <table class="cate-list">
        <thead>
            <tr>
                <th>Id</th>
                <th>分类名称</th>
                <th>管理</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($rows) {
                    while($row = mysql_fetch_array($cates)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td>
                    <a href="./cate-config.php?id=<?php echo $row['id']; ?>" target="_self" class="art-edit"><span class="icon-edit24"></span></a>
                    <a href="./cate-del.php?id=<?php echo $row['id']; ?>" target="_self" class="art-del"><span class="icon-remove11"></span></a>
                </td>
            </tr>
            <?php
                    }
                } else {
            ?>
            <tr>
                <td colspan="3">暂无分类！</td>
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
