<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
$raw_material_id = $_POST['raw_material_id'];
$sql="SELECT id,purchase_price,sub_uom_id,uom_id,gst,hsn_code  FROM tbl_raw_material where delete_status='NDL' and id='".$raw_material_id."'";
// print_r($sql);
$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	
	$product_rate[]=str_replace("^", "'", $row['purchase_price']);
	$sub_uom_id[]=str_replace("^", "'", $row['sub_uom_id']);
	$uom_id[]=str_replace("^", "'", $row['uom_id']);
	$gst[]=str_replace("^", "'", $row['gst']);
	$hsn_code[]=str_replace("^", "'", $row['hsn_code']);
}
if(!empty($raw_material_id)){

	$json =array("product_rate"=>$product_rate,"sub_uom_id"=>$sub_uom_id,"uom_id"=>$uom_id,"gst"=>$gst,"hsn_code"=>$hsn_code);
}
else{
	
	$json =array("product_rate"=> '0',"sub_uom_id"=> '0',"uom_id"=> '0',"gst"=> '0',"hsn_code"=> '0');
}
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 