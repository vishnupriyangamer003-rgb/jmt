<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
$product_id = $_POST['product_id'];
$sql="SELECT product_id,product_name,style_id,hsn_code,rate FROM tbl_products where delete_status='NDL' and product_id='".$product_id."'";
// print_r($sql);
$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	
	$hsn_code[]=str_replace("^", "'", $row['hsn_code']);
	$rate[]=str_replace("^", "'", $row['rate']);
	$style_id[]=str_replace("^", "'", $row['style_id']);
	$sql1="SELECT style_id,style_name FROM tbl_style where delete_status='NDL' and style_id='".$row['style_id']."'";
	$row1=mysqli_fetch_array(mysqli_query($conn,$sql1));
	$style_name[]=str_replace("^", "'", $row1['style_name']);
}
if(!empty($product_id)){

	$json =array("hsn_code"=>$hsn_code,"rate"=>$rate,"style_id"=>$style_id,"style_name"=>$style_name);
}
else{
	
	$json =array("hsn_code"=> '0',"rate"=>'0');
}
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 