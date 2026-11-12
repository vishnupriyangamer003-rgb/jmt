<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
 

$sql="SELECT order_id,order_no FROM tbl_order where delete_status='NDL'  order by order_id desc";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$order_id[]=$row['order_id'];
	$order_no[]=str_replace("^", "'", $row['order_no']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$order_id = $order_id ?? []; 
$order_no = $order_no ?? []; 
$json =array("order_id"=>$order_id,"order_no"=>$order_no);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 