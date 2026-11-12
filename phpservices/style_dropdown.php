<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT style_id,style_name FROM tbl_style where delete_status='NDL'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$style_id[]=$row['style_id'];
	$style_name[]=str_replace("^", "'", $row['style_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$style_id = $style_id ?? []; 
$style_name = $style_name ?? []; 
$json =array("style_id"=>$style_id,"style_name"=>$style_name);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 