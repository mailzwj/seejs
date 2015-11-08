<?php

    session_start();
    if (!$_SESSION['adminId']) {
        echo '{"result": false, "message": "Login first please!"}';
        exit();
    }

    $file = $_FILES['image'];
    $upload = 'content/upload/';
    $tail = '/admin.*$/';
    $uploadDir = preg_replace($tail, '', dirname(__FILE__)) . $upload;
    $rNotImg = '/^\.(exe|bat|sh|dll|php|class|py|rb)$/';

    $fArr = explode('.', $file['name']);
    $fname = $fArr[0];
    $ext = '.' . $fArr[1];

    if (preg_match($rNotImg, $ext)) {
        echo '{"result": false, "message": "' . $file['type'] . ' was not surported."}';
        exit();
    }

    $suffix = time();
    $remoteName = $fname . '-' . $suffix . $ext;
    $path = preg_replace($tail, '', $_SERVER['REQUEST_URI']);
    $src = "http://" . $_SERVER['HTTP_HOST'] . $path . $upload . $remoteName;
    $move = move_uploaded_file($file['tmp_name'], $uploadDir . $remoteName);

    if ($move) {
        echo '{"result": true, "message": "", "file": {"path": "' . $src . '"}}';
    } else {
        echo '{"result": false, "message": "System error."}';
    }

?>