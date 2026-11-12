<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 


$sql="SELECT * FROM tbl_products where delete_status='NDL'   order by product_id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$product_id[]=$row['product_id'];
	$product_name[]=str_replace("^", "'", $row['product_name']);
	$sale_price[]=str_replace("^", "'", $row['sale_price']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$product_id = $product_id ?? []; 
$product_name = $product_name ?? []; 
$sale_price = $sale_price ?? []; 
$json =array("product_id"=>$product_id,"product_name"=>$product_name,"sale_price"=>$sale_price);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 