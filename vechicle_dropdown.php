<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT vechicle_id,vechicle_name FROM tbl_vechicle_details where delete_status='NDL' order by vechicle_id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$vechicle_id[]=$row['vechicle_id'];
	$vechicle_name[]=str_replace("^", "'", $row['vechicle_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$vechicle_id = $vechicle_id ?? []; 
$vechicle_name = $vechicle_name ?? []; 
$json =array("vechicle_id"=>$vechicle_id,"vechicle_name"=>$vechicle_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 