<?php
    SESSION_START();
    if(isset($_COOKIE['user'])){
        setcookie('user', '', time() - 3600, '/');
    }
    session_destroy();
    header('Location: /');
    exit();
?>