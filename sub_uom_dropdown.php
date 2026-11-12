<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT sub_uom_id,sub_uom_name FROM tbl_sub_uom where delete_status='NDL' order by sub_uom_id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$sub_uom_id[]=$row['sub_uom_id'];
	$sub_uom_name[]=str_replace("^", "'", $row['sub_uom_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$sub_uom_id = $sub_uom_id ?? []; 
$sub_uom_name = $sub_uom_name ?? []; 
$json =array("sub_uom_id"=>$sub_uom_id,"sub_uom_name"=>$sub_uom_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 