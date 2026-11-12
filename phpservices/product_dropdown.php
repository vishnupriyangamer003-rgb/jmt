<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT product_id,product_name FROM tbl_products where delete_status='NDL'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$product_id[]=$row['product_id'];
	$product_name[]=str_replace("^", "'", $row['product_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$product_id = $product_id ?? []; 
$product_name = $product_name ?? []; 
$json =array("product_id"=>$product_id,"product_name"=>$product_name);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 