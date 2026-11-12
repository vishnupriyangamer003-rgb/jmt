<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT investor_id,investor_name FROM tbl_investor where delete_status='NDL' order by investor_id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$investor_id[]=$row['investor_id'];
	$investor_name[]=str_replace("^", "'", $row['investor_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$investor_id = $investor_id ?? []; 
$investor_name = $investor_name ?? []; 
$json =array("investor_id"=>$investor_id,"investor_name"=>$investor_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 