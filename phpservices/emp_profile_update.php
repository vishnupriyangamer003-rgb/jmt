<?php
include_once "../sessionservices.php";
include_once "connection.php";
date_default_timezone_set('Asia/Kolkata');

$uname = str_replace("'", "^", $_POST['emp_uname']);
$pass = str_replace("'", "^", $_POST['emp_pass']);

$sql = "update tbl_employee_details set uname='" . $uname . "',pass='" . $pass . "' where emp_id='" . $login_id . "'";

$exec_query = mysqli_query($conn, $sql);

if ($exec_query) {
    $result = 1;
} else {
    $result = 0;
}

$json = array("op" => $result);

// send data as json format
header("Content-Type: application/json", true);
echo json_encode($json);
