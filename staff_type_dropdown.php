<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT id,name FROM tbl_staff_type where delete_status='NDL' order by id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$emp_type_id[]=$row['id'];
	$emp_type_name[]=str_replace("^", "'", $row['name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$emp_type_id = $emp_type_id ?? []; 
$emp_type_name = $emp_type_name ?? []; 
$json =array("emp_type_id"=>$emp_type_id,"emp_type_name"=>$emp_type_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 