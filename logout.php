<?php
session_start();
session_destroy();

unset($_SESSION['login_user']);
unset($_SESSION['login_id']);
//unset($_SESSION['status']);
//unset($_SESSION['w_house']);
//unset($_SESSION['adcode']);
//unset($_SESSION['vdrcode']);

unset($_COOKIE['login_user']);
unset($_COOKIE['login_id']);

$_SESSION['login_user'] = ''; 
$_SESSION['login_id'] =''; 

$_COOKIE['login_user']='';
$_COOKIE['login_id']='';


 

$log = $_SESSION['login_user'];
$login_id = $_SESSION['login_id'];	


setcookie('login_user', '', time() - 3600); // empty value and old timestamp
setcookie('login_id', '', time() - 3600); // empty value and old timestamp


if(!empty($_COOKIE['login_id'])){?>

<script> window.location.href="dashboard.php"; </script><?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Content-Type: application/xml; charset=utf-8");
    header("Location:dashboard.php");
}else{  
    
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
    header("Location:index.php");
    
    ?><script> window.location.href="index.php"; </script><?php

    
    
}?>