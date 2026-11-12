<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT products_id,product_name FROM tbl_products where delete_status='NDL'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$s_id[]=$row['products_id'];
	$s_name[]=str_replace("^", "'", $row['product_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$s_id = $s_id ?? []; 
$s_name = $s_name ?? []; 
$json =array("s_id"=>$s_id,"s_name"=>$s_name);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 