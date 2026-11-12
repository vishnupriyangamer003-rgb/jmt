<?php
session_start(); // Starting Session
ob_start(); // Defensive: capture any stray output so the JSON response stays clean.
date_default_timezone_set('Asia/Kolkata');

$error=''; // Variable To Store Error Message

if ( ! empty( $_POST['uname'] ) ) {
try {
include_once("connection.php");
$username=trim((string)($_POST['uname'] ?? ''));
$password=(string)($_POST['pass'] ?? '');

// Prepared statement: prevents SQL injection (PHP 8.3 safe).
$stmt = mysqli_prepare($conn, "SELECT admin_id, pass FROM tbl_admin WHERE uname=? LIMIT 1");
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
    // Plain-text password check only (no hashing).
    $ok = hash_equals((string)($row['pass'] ?? ''), $password);
    if ($ok) {
        session_regenerate_id(true);
        $_SESSION['login_user']='admin';
        $_SESSION['login_id']=$row['admin_id'];
        $error='1';
    } else {
        $error='Password is incorrect';
    }
}
else
{
    $error='Username is incorrect';
}
} catch (Throwable $e) {
    // Echo the holding error to the login page instead of a blank 500.
    error_log('login failed: '.$e->getMessage());
    $error='Server error: '.$e->getMessage();
}
} else {
    $error='Username is required';
}
$json = array("op"=>$error);
$extra = trim((string)ob_get_clean());
if ($extra !== '') {
    error_log('login php_output: '.$extra);
    $json['php_output'] = substr($extra, 0, 200);
}
header("Content-Type: application/json", true);
echo json_encode($json);

?>
