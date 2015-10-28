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
    <title>SEEJS-文章列表页</title>
    <link rel="stylesheet" href="../assets/base/normalize.css">
    <link rel="stylesheet" href="../assets/base/common.css">
    <link rel="stylesheet" href="../assets/article/list.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $page = intval($page);
    $pageSize = 15;
    $start = ($page - 1) * $pageSize;
    $end = $start + $pageSize;
    $rs = mysql_query('SELECT * FROM article WHERE deleted=0 ORDER BY createTime DESC LIMIT ' . $start . ',' . $end);
    $rows = mysql_num_rows($rs);
    $rsCount = mysql_query('SELECT count(*) FROM article WHERE deleted=0');
    if ($rsRow = mysql_fetch_array($rsCount)) {
        $count = $rsRow[0];
    } else {
        $count = 0;
    }
?>
<div class="set-wrap">
    <a href="./article-edit.php" target="_self" class="add-article">
        <span class="icon-plus25"></span>新增文章
    </a>
    <div class="art-table">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Publisher</th>
                    <th>Category</th>
                    <th>Praise</th>
                    <th>Comment</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!$rows) {
                ?>
                <tr>
                    <td colspan="7">暂无文章！</td>
                </tr>
                <?php
                    } else {
                        while($row = mysql_fetch_array($rs)) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <a href="../../article.php?id=<?php echo $row['id']; ?>" target="_blank"><?php echo $row['title']; ?></a>
                    </td>
                    <td><?php echo $row['publisher']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['praise']; ?></td>
                    <td><?php echo $row['comment']; ?></td>
                    <td>
                        <a href="./article-edit.php?id=<?php echo $row['id']; ?>" target="_self" class="art-edit"><span class="icon-edit24"></span></a>
                        <a href="./article-del.php?id=<?php echo $row['id']; ?>" target="_self" class="art-del"><span class="icon-remove11"></span></a>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php
        if ($count > $pageSize) {
            $total = ceil($count / $pageSize);
    ?>
    <div class="art-page">
        <?php if ($page == 1) { ?>
        <span class="page">上一页</span>
        <?php } else { ?>
        <a href="?page=<?php echo $page - 1; ?>" target="_self" class="page">上一页</a>
        <?php } ?>
        <?php
            for ($i = 1; $i <= $total; $i++) {
        ?>
        <a href="?page=<?php echo $i; ?>" target="_self" class="page<?php echo ($i==$page ? ' current' : ''); ?>"><?php echo $i; ?></a>
        <?php } ?>
        <?php if ($page == $total) { ?>
        <span class="page">下一页</span>
        <?php } else { ?>
        <a href="?page=<?php echo $page + 1; ?>" target="_self" class="page">下一页</a>
        <?php } ?>
    </div>
    <?php } ?>
<?php mysql_close($conn); ?>
</div>
</body>
</html>