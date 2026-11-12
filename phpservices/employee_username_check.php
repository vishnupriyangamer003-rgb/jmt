<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");	
date_default_timezone_set('Asia/Kolkata');	

$sql= "SELECT * FROM tbl_employee_details where uname='".$_POST['uname']."' and delete_status='NDL' and active_status='Y' and emp_id<>'".$_POST['emp_id']."'";
	
$exec_query=mysqli_query($conn, $sql);
$rows=mysqli_num_rows($exec_query);

$json = array("op" =>$rows);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
				
?>