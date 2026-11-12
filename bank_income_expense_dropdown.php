<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT id,income_header_name FROM tbl_income_header where delete_status='NDL' order by id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$income_header_id[]=$row['id'];
	$income_header_name[]=str_replace("^", "'", $row['income_header_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$income_header_id = $income_header_id ?? []; 
$income_header_name = $income_header_name ?? []; 
$json =array("income_header_id"=>$income_header_id,"income_header_name"=>$income_header_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 