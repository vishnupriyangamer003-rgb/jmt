<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT emp_id,emp_name FROM tbl_employee_details where delete_status='NDL' and active_status='Y' and emp_type='1' order by emp_id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$emp_id[]=$row['emp_id'];
	$emp_name[]=str_replace("^", "'", $row['emp_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$emp_id = $emp_id ?? []; 
$emp_name = $emp_name ?? []; 
$json =array("emp_id"=>$emp_id,"emp_name"=>$emp_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 