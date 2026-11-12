<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT uom_id,uom_name FROM tbl_uom where delete_status='NDL' order by uom_id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$uom_id[]=$row['uom_id'];
	$uom_name[]=str_replace("^", "'", $row['uom_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$uom_id = $uom_id ?? []; 
$uom_name = $uom_name ?? []; 
$json =array("uom_id"=>$uom_id,"uom_name"=>$uom_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 