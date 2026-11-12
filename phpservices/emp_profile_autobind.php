<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");	
date_default_timezone_set('Asia/Kolkata');	

$sql= "SELECT * FROM  tbl_employee_details where emp_id='".$_POST['emp_id']."'";
	
$exec_query=mysqli_query($conn, $sql);

$fetch=mysqli_fetch_array($exec_query);
$uname=str_replace("^","'",$fetch['uname']);
$pass=str_replace("^","'",$fetch['pass']);


$json = array("uname" =>$uname,"pass" =>$pass);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
				
?>