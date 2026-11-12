<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT id,name FROM tbl_staff_salary where delete_status='NDL' order by id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$emp_salary_id[]=$row['id'];
	$emp_salary_name[]=str_replace("^", "'", $row['name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$emp_salary_id = $emp_salary_id ?? []; 
$emp_salary_name = $emp_salary_name ?? []; 
$json =array("emp_salary_id"=>$emp_salary_id,"emp_salary_name"=>$emp_salary_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 