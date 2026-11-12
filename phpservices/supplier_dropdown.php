<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT supplier_id,supplier_name FROM tbl_supplier where delete_status='NDL'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$supplier_id[]=$row['supplier_id'];
	$supplier_name[]=str_replace("^", "'", $row['supplier_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$supplier_id = $supplier_id ?? []; 
$supplier_name = $supplier_name ?? []; 
$json =array("supplier_id"=>$supplier_id,"supplier_name"=>$supplier_name);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 