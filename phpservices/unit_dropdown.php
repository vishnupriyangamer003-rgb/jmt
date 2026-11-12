<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT unit_id,unit_name FROM tbl_unit where delete_status='NDL'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$unit_id[]=$row['unit_id'];
	$unit_name[]=str_replace("^", "'", $row['unit_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$unit_id = $unit_id ?? []; 
$unit_name = $unit_name ?? []; 
$json =array("unit_id"=>$unit_id,"unit_name"=>$unit_name);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 