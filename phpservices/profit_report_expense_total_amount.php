<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

	
   // $sql = "SELECT *,sum(a.total_amount) as report_debit_total_amount,sum(a.grand_total_amount) as report_debit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='3'";

   $sql = "SELECT *,sum(amount) as report_expense_total_amount,sum(amount) as report_expense_grand_total_amount FROM tbl_income WHERE  delete_status!='0' and income_type='Expense'";
	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	
	$report_expense_total_amount=$fetch_pql['report_expense_total_amount'];
	$report_expense_grand_total_amount=$fetch_pql['report_expense_grand_total_amount'];

    if(empty($fetch_pql['report_expense_total_amount'])){
		$report_expense_total_amount='0';
	}

	if(empty($fetch_pql['report_expense_grand_total_amount'])){
		$report_expense_grand_total_amount='0';
	}

	
$json = array("report_expense_total_amount" =>$report_expense_total_amount,"report_expense_grand_total_amount" =>$report_expense_grand_total_amount);

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>