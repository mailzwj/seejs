<?php

    include_once('../inc/conn.php');
    include_once('../inc/function.php');
    $ip = get_real_ip();
    $id = $_GET['id'];
    $cb = empty($_GET['callback']) ? 'callback' : $_GET['callback'];

    if (empty($id)) {
        echo $cb . '({"result": false, "responseCode": "0001", "ip": "' . get_real_ip() . '", "message": "缺少参数id"})';
        exit();
    }

    $prs = mysql_query('SELECT status FROM praise WHERE ip="' . $ip . '" AND articleid=' . $id);
    $record = mysql_fetch_array($prs);
    if ($record) {
        if ($record['status'] == 1) {
            mysql_query('UPDATE praise SET status=0 WHERE ip="' . $ip . '" AND articleid=' . $id);
            mysql_query('UPDATE article SET praise=praise-1 WHERE id=' . $id);
            $pn = mysql_query('SELECT praise FROM article WHERE id=' . $id);
            $pnRow = mysql_fetch_array($pn);
            echo $cb . '({"result": true, "responseCode": "0002", "ip": "' . get_real_ip() . '", "message": "成功取消赞", "count": ' . ($pnRow ? $pnRow['praise'] : 0) . '})';
            exit();
        } else {
            mysql_query('UPDATE praise SET status=1 WHERE ip="' . $ip . '" AND articleid=' . $id);
            mysql_query('UPDATE article SET praise=praise+1 WHERE id=' . $id);
            $pn = mysql_query('SELECT praise FROM article WHERE id=' . $id);
            $pnRow = mysql_fetch_array($pn);
            echo $cb . '({"result": true, "responseCode": "0000", "ip": "' . get_real_ip() . '", "message": "成功添加赞", "count": ' . ($pnRow ? $pnRow['praise'] : 0) . '})';
            exit();
        }
    } else {
        mysql_query("INSERT INTO praise(articleid,ip,status) VALUES (" . $id . ",\"" . $ip . "\",1)");
        mysql_query('UPDATE article SET praise=praise+1 WHERE id=' . $id);
            $pn = mysql_query('SELECT praise FROM article WHERE id=' . $id);
            $pnRow = mysql_fetch_array($pn);
        echo $cb . '({"result": true, "responseCode": "0000", "ip": "' . get_real_ip() . '", "message": "成功添加赞", "count": ' . ($pnRow ? $pnRow['praise'] : 0) . '})';
        exit();
    }
?>