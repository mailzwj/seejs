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
    <link rel="stylesheet" href="../assets/menu/menu.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $menus = mysql_query('SELECT * FROM menu ORDER BY id ASC');
    if ($id) {
        $one = mysql_query('SELECT * FROM menu WHERE id=' . $id);
        $oneArr = mysql_fetch_array($one);
    }
    $rows = mysql_num_rows($menus);
?>

<div class="set-wrap menu-wrap">
    <form action="./menu-save.php" method="post" id="J_MenuForm">
        <input type="hidden" name="id" value="<?php echo isset($oneArr) ? $oneArr['id'] : ''; ?>">
        <div class="ed-row">
            <label for="J_MenuTitle" class="label">菜单名称</label><input type="text" name="menu" id="J_MenuTitle" class="input" placeholder="请输入菜单名称" value="<?php echo isset($oneArr) ? $oneArr['menu'] : ''; ?>">
        </div>
        <div class="ed-row">
            <label for="J_MenuLink" class="label">链接地址</label><input type="text" name="link" id="J_MenuLink" class="input" placeholder="请输入链接地址" value="<?php echo isset($oneArr) ? $oneArr['menulink'] : ''; ?>">
        </div>
        <div class="ed-row">
            <label for="J_MenuParent" class="label">父级菜单
            </label><select name="parent" id="J_MenuParent" class="select">
                <option value="0">无父级</option>
                <?php
                    while ($p = mysql_fetch_array($menus)) {
                        if (isset($oneArr) && $p['id'] == $oneArr['parent']) {
                            echo '<option value="' . $p['id'] . '" selected>' . $p['menu'] . '</option>';
                        } else {
                            echo '<option value="' . $p['id'] . '">' . $p['menu'] . '</option>';
                        }
                    }
                ?>
            </select><span class="inline-help">"无父级"即：一级菜单</span>
        </div>
        <div class="ed-row btn-row">
            <input type="submit" value="<?php echo $id ? '保 存' : '添 加'; ?>" id="J_SaveMenu" class="button"><?php echo $id ? '<a href="./menu-setting.php" class="button cancel">返回新增</a>' : ''; ?>
        </div>
    </form>
    <table class="menu-list">
        <thead>
            <tr>
                <th>Id</th>
                <th>菜单名称</th>
                <th>链接地址</th>
                <th>父级菜单</th>
                <th>管理</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($rows) {
                    mysql_data_seek($menus, 0);
                    while($row = mysql_fetch_array($menus)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['menu']; ?></td>
                <td><?php echo $row['menulink']; ?></td>
                <td><?php echo $row['parent']; ?></td>
                <td>
                    <a href="./menu-setting.php?id=<?php echo $row['id']; ?>" target="_self" class="menu-edit"><span class="icon-edit24"></span></a>
                    <!-- <a href="./menu-move.php?id=<?php echo $row['id']; ?>&sort=up" target="_self" class="menu-edit"><span class="icon-arrow467"></span></a>
                    <a href="./menu-move.php?id=<?php echo $row['id']; ?>&sort=down" target="_self" class="menu-edit"><span class="icon-arrow466"></span></a> -->
                    <a href="./menu-del.php?id=<?php echo $row['id']; ?>" target="_self" class="menu-del"><span class="icon-remove11"></span></a>
                </td>
            </tr>
            <?php
                    }
                } else {
            ?>
            <tr>
                <td colspan="5">暂无菜单！</td>
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