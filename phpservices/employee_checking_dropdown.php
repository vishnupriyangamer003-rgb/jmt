<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT emp_id,emp_name FROM tbl_employee_details where delete_status='NDL' and emp_status='W' and department_id='4'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$s_id[]=$row['emp_id'];
	$s_name[]=str_replace("^", "'", $row['emp_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$s_id = $s_id ?? []; 
$s_name = $s_name ?? []; 
$json =array("s_id"=>$s_id,"s_name"=>$s_name);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 