<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
$product_id = $_POST['product_id'] ?? '';
$hasId = ($product_id !== '' && $product_id !== null);
$product_rate = []; $uom_id = [];
if($hasId){
$sql="SELECT product_id,IFNULL(sale_price,0) AS sale_price,IFNULL(uom_id,0) AS uom_id FROM tbl_products where delete_status='NDL' and product_id='".mysqli_real_escape_string($conn,$product_id)."'";
// print_r($sql);
$query=mysqli_query($conn,$sql) ;
if($query === false){
	header("Content-Type: application/json", true);
	echo json_encode(array("error"=>"Product rate lookup failed"));
	return;
}
while($row=mysqli_fetch_array($query)){
	
	$product_rate[]=str_replace("^", "'", $row['sale_price']);
	$uom_id[]=str_replace("^", "'", $row['uom_id']);
}
}
if($hasId){

	$json =array("product_rate"=>$product_rate,"uom_id"=>$uom_id);
}
else{
	
	$json =array("product_rate"=> '0',"uom_id"=> '0');
}
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 