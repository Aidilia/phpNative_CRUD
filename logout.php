<?php
    session_start();
    $_SESSION = [];
    //agar yakin untuk sessionnya hilang
    session_unset();
    session_destroy();

    setcookie('id', '', time() - 3600);
    setcookie('key', '', time() - 3600);
    
 
    header("Location: login.php");
    exit;
?>