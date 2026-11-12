<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
$product_id = $_POST['product_id'];
$sql="SELECT product_id,hsn_code,uom_id FROM tbl_products where delete_status='NDL' and product_id='".$product_id."'";
// print_r($sql);
$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	
	$hsn_code[]=str_replace("^", "'", $row['hsn_code']);
	
	$sql1="SELECT uom_id,uom_name FROM tbl_uom where delete_status='NDL' and uom_id='".$row['uom_id']."'";
	$row1=mysqli_fetch_array(mysqli_query($conn,$sql1));
	$uom_id[]=str_replace("^", "'", $row1['uom_id']);
}
if(!empty($product_id)){

	$json =array("hsn_code"=>$hsn_code,"uom_id"=>$uom_id);
}
else{
	
	$json =array("hsn_code"=> '0',"uom_id"=>'0');
}
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 