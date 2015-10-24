<?php
    session_start();
    session_destroy();
    unset($_SESSION['adminId']);
    unset($_SESSION['administrator']);
    header('Location: ./login.php');
?>