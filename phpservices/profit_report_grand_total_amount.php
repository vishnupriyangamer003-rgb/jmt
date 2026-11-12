<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

	
    $sql = "SELECT *,sum(a.expanse_amt) as report_invoice_total_amount FROM tbl_booking a  WHERE  a.delete_status!='0'";
	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_sql=mysqli_fetch_array($exec_query);
	$report_invoice_total_amount=$fetch_sql['report_invoice_total_amount'];
	

	$isql = "SELECT *,sum(amount) as report_income_total_amount,sum(amount) as report_income_grand_total_amount FROM tbl_income WHERE  delete_status!='0' and income_type='Income'";
	
    $iexec_query = mysqli_query($conn,$isql);
	$ifetch_pql=mysqli_fetch_array($iexec_query);
	
	$report_income_total_amount=$ifetch_pql['report_income_total_amount'];
	$report_income_grand_total_amount=$ifetch_pql['report_income_grand_total_amount'];


	$esql = "SELECT *,sum(amount) as report_expense_total_amount,sum(amount) as report_expense_grand_total_amount FROM tbl_income WHERE  delete_status!='0' and income_type='Expense'";
	
    $eexec_query = mysqli_query($conn,$esql);
	$efetch_pql=mysqli_fetch_array($eexec_query);
	
	$report_expense_total_amount=$efetch_pql['report_expense_total_amount'];
	$report_expense_grand_total_amount=$efetch_pql['report_expense_grand_total_amount'];
	
	/*$pql = "SELECT *,sum(a.grand_total_amount) as report_debit_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='3'";
	
    $exec_query = mysqli_query($conn,$pql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	$report_debit_total_amount=$fetch_pql['report_debit_total_amount'];
	
	
	$qql = "SELECT *,sum(a.grand_total_amount) as report_credit_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='4'";
	
    $exec_query = mysqli_query($conn,$qql);
	$fetch_qql=mysqli_fetch_array($exec_query);
	$report_credit_total_amount=$fetch_qql['report_credit_total_amount'];*/
	
	if(empty($fetch_sql['report_invoice_total_amount'])){
		$report_invoice_total_amount='0';
	}

	if(empty($ifetch_pql['report_income_total_amount'])){
		$report_income_total_amount='0';
	}

	if(empty($efetch_pql['report_expense_total_amount'])){
		$report_expense_total_amount='0';
	}
	
	$invoice_plus_debit_minus_credit_total_amount = number_format(($report_invoice_total_amount + $report_income_total_amount) - $report_expense_total_amount, 2);
	
	
	
	
$json = array("invoice_plus_debit_minus_credit_total_amount" =>$invoice_plus_debit_minus_credit_total_amount);
header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>