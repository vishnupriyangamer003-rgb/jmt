<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT id,name FROM tbl_raw_material where delete_status='NDL' order by id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$id[]=$row['id'];
	$name[]=str_replace("^", "'", $row['name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$id = $id ?? []; 
$name = $name ?? []; 
$json =array("raw_material_id"=>$id,"raw_material_name"=>$name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 