<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

	
    $sql = "SELECT *,sum(a.grand_total_amount) as report_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0'";
	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	
	$report_total_amount=number_format ($fetch_pql['report_total_amount'], 2);
	
$json = array("report_total_amount" =>$report_total_amount);
header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>