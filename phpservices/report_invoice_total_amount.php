<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

	
   // $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2'";

	$sql = "SELECT *,sum(total_amount) as report_invoice_total_amount,sum(grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking WHERE  delete_status!='0'  and billing_type='2'";
	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	
	$report_invoice_total_amount=$fetch_pql['report_invoice_total_amount'];
	$report_invoice_grand_total_amount=$fetch_pql['report_invoice_grand_total_amount'];
	
$json = array("report_invoice_total_amount" =>$report_invoice_total_amount,"report_invoice_grand_total_amount" =>$report_invoice_grand_total_amount);

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>