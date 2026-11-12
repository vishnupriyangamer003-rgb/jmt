<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

	
	$fdate = date('Y-m-d', strtotime($_POST['fdate']));
	$tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
	$customer_id = $_POST['customer_id'];
	$billing_type = $_POST['billing_type'];
	$process_type = $_POST['process_type'];


	$sql = "SELECT *,sum(amount) as report_income_total_amount,sum(amount) as report_income_grand_total_amount FROM tbl_income WHERE  delete_status!='0' and income_type='Income' and select_date between '" . $fdate . "' and '" . $tdate . "'";
	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	
	$report_income_total_amount=$fetch_pql['report_income_total_amount'];
	$report_income_grand_total_amount=$fetch_pql['report_income_grand_total_amount'];

	if(empty($fetch_pql['report_income_total_amount'])){
		$report_income_total_amount='0';
	}

	if(empty($fetch_pql['report_income_grand_total_amount'])){
		$report_income_grand_total_amount='0';
	}

	
$json = array("report_income_total_amount" =>$report_income_total_amount,"report_income_grand_total_amount" =>$report_income_grand_total_amount);
header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>