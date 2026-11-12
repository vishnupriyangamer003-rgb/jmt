<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

	
    $sql = "SELECT *,sum(a.grand_total_amount) as report_invoice_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2' group by a.booking_id";
	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_sql=mysqli_fetch_array($exec_query);
	$report_invoice_total_amount=$fetch_sql['report_invoice_total_amount'];
	
	
	$pql = "SELECT *,sum(a.grand_total_amount) as report_debit_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='3'";
	
    $exec_query = mysqli_query($conn,$pql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	$report_debit_total_amount=$fetch_pql['report_debit_total_amount'];
	
	
	$qql = "SELECT *,sum(a.grand_total_amount) as report_credit_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='4'";
	
    $exec_query = mysqli_query($conn,$qql);
	$fetch_qql=mysqli_fetch_array($exec_query);
	$report_credit_total_amount=$fetch_qql['report_credit_total_amount'];
	
	
	$invoice_plus_debit_minus_credit_total_amount = 
	
				number_format(($fetch_sql['report_invoice_total_amount'] + $fetch_pql['report_debit_total_amount']) - $fetch_qql['report_credit_total_amount'], 2);
	
	
	
	
$json = array("invoice_plus_debit_minus_credit_total_amount" =>$invoice_plus_debit_minus_credit_total_amount);
header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>