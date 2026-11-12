<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
//$product_id = $_POST['product_id'];
$sql="SELECT product_id,product_name FROM tbl_products where delete_status='NDL'";
// print_r($sql);
$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$product_id[]=$row['product_id'];
	$product_name[]=str_replace("^", "'", $row['product_name']);
	
}
if(!empty($product_id)){

	$json =array("product_id"=>$product_id,"product_name"=>$product_name);
}
else{
	
	$json =array("product_id"=>"select Product","product_name"=>"select Product");
}
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 