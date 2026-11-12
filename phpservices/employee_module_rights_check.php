<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");	

$sql="select module_status from tbl_employee_rights where emp_id='".$_POST['empid']."' and module_id='".$_POST['moduleid']."'";
$query=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($query);
if($row['module_status']=='Y'){
	$result=1;
}
else{
	$result=0;
}

$json = array("op" =>$result);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
?>