<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
//$product_id = $_POST['product_id'];
$sql="SELECT color_id,color_name FROM tbl_color where delete_status='NDL'";
// print_r($sql);
$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$color_id[]=$row['color_id'];
	$color_name[]=str_replace("^", "'", $row['color_name']);
	
}
if(!empty($color_id)){

	// UNDEF-GUARD: empty tables must still return valid JSON
$color_id = $color_id ?? []; 
$color_name = $color_name ?? []; 
$json =array("color_id"=>$color_id,"color_name"=>$color_name);
}
else{
	
	$json =array("color_id"=>"select Color","color_name"=>"select Color");
}
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 