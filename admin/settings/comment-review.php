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
    <link rel="stylesheet" href="../assets/comment/list.css">
</head>
<body>
<?php
    include_once('../../inc/conn.php');

    $rs = mysql_query('SELECT * FROM comments WHERE deleted=1 ORDER BY reply_time DESC');
    $rows = mysql_num_rows($rs);
?>
<div class="set-wrap">
    <a href="./comment-list.php" target="_self" class="add-article">
        管理评论
    </a>
    <div class="art-table">
        <table class="art-list">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>文章ID</th>
                    <th>用户</th>
                    <th>邮箱</th>
                    <th>评论</th>
                    <th>评论时间</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!$rows) {
                ?>
                <tr>
                    <td colspan="7">暂无待审评论！</td>
                </tr>
                <?php
                    } else {
                        while($row = mysql_fetch_array($rs)) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['articleid']; ?></td>
                    <td><?php echo htmlspecialchars($row['user']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['content']); ?></td>
                    <td><?php echo $row['reply_time']; ?></td>
                    <td>
                        <a href="./comment-verify.php?act=through&id=<?php echo $row['id']; ?>&artid=<?php echo $row['articleid']; ?>" target="_self" class="art-edit">通过</a>
                        <a href="./comment-verify.php?act=del&id=<?php echo $row['id']; ?>" target="_self" class="art-edit">彻底删除</a>
                        <!-- <a href="./comment-del.php?id=<?php echo $row['id']; ?>" target="_self" class="art-del"><span class="icon-remove11"></span></a> -->
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php mysql_close($conn); ?>
</div>
</body>
</html>