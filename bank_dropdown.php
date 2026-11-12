<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT id,bank_name FROM tbl_bank_details where delete_status='NDL' order by id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$bank_id[]=$row['id'];
	$bank_name[]=str_replace("^", "'", $row['bank_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$bank_id = $bank_id ?? []; 
$bank_name = $bank_name ?? []; 
$json =array("bank_id"=>$bank_id,"bank_name"=>$bank_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 