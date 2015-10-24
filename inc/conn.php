<?php
    // echo md5("seejscom");
    $host = 'localhost';
    $prot = '3306';
    $user = 'root';
    $pwd = 'admin';
    $dbName = 'seejs';

    // 创建MySQL连接，并返回连接实例。若连接失败，打印失败提示信息
    $conn = mysql_connect($host . ':' . $port, $user, $pwd) or die('Unable to connect to the MySQL!');
    // 选择使用的MySQL数据库
    mysql_select_db($dbName, $conn);
?>