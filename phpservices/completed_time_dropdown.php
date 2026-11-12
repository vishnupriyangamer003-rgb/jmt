<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT id,completed_time FROM tbl_completed_time where delete_status='NDL'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$s_id[]=$row['id'];
	$s_name[]=str_replace("^", "'", $row['completed_time']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$s_id = $s_id ?? []; 
$s_name = $s_name ?? []; 
$json =array("s_id"=>$s_id,"s_name"=>$s_name);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 