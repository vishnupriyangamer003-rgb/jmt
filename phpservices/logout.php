<?php
session_start();

unset($_SESSION['login_user']);
unset($_SESSION['status']);
unset($_SESSION['w_house']);
unset($_SESSION['adcode']);
unset($_SESSION['vdrcode']);

header("Location:index.php");
?>