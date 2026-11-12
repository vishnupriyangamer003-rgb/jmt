<?php
session_start(); // Starting Session
date_default_timezone_set('Asia/Kolkata');

$error = ''; // Variable To Store Error Message

if (!empty($_POST['uname'])) {
    include_once "connection.php";
    $username = trim((string)($_POST['uname'] ?? ''));
    $password = (string)($_POST['pass'] ?? '');

    $stmt = mysqli_prepare($conn, "SELECT emp_id, emp_code, pass, password_hash FROM tbl_employee_details WHERE uname=? AND active_status='Y' AND delete_status='NDL' LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    } else {
        $row = null;
    }

if ($row) {
    $ok = false;
    if (!empty($row['password_hash']) && password_verify($password, $row['password_hash'])) {
        $ok = true;
    } elseif (hash_equals((string)($row['pass'] ?? ''), $password)) {
        $ok = true;
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $up = mysqli_prepare($conn, "UPDATE tbl_employee_details SET password_hash=? WHERE emp_id=?");
        if ($up) {
            mysqli_stmt_bind_param($up, "si", $newHash, $row['emp_id']);
            mysqli_stmt_execute($up);
            mysqli_stmt_close($up);
        }
    }
    if ($ok) {
        session_regenerate_id(true);
        $_SESSION['login_user']=$row['emp_code'];
        $_SESSION['login_id']=$row['emp_id'];
        $error='1';
    }
    else{
        $error='* Password is incorrect';
    }
}
else
{
    $error='* Username is incorrect';
}
}
$json = array("op"=>$error);
header("Content-Type: application/json", true);
echo json_encode($json);

?>
