<?php
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
$requestData= $_REQUEST;
	

$where='';


if(!empty($_POST['fdate'])){
	$fdate = date('Y-m-d', strtotime($_POST['fdate']));
	$tdate = date('Y-m-d', strtotime($_POST['tdate']));

	if (!empty($_POST['customer_id'])){
		$where.=" and a.customer_id=".intval($_POST['customer_id']);

	}
	 

}else{
	$fdate='';
	$tdate='';
}



	// report_grand_total_amount is summed once per bill, straight off
	// tbl_services_non_dc (no details join, which would inflate totals
	// once per product line).
	if ($fdate=='' && $tdate=='') {

		$sql = "SELECT SUM(a.grand_total_amount) as report_grand_total_amount
FROM tbl_services_non_dc a
WHERE a.delete_status = 'NDL'";

		$sql1 = "SELECT SUM(a.pay_amount) as pay_total_amount FROM tbl_services_non_receipt a WHERE a.delete_status = 'NDL'";

	}else{

		$sql = "SELECT SUM(a.grand_total_amount) as report_grand_total_amount
FROM tbl_services_non_dc a
WHERE a.delete_status = 'NDL' $where and a.billing_date  between '" . $fdate . "' and '" . $tdate . "'";

		$sql1 = "SELECT SUM(a.pay_amount) as pay_total_amount FROM tbl_services_non_receipt a WHERE a.delete_status = 'NDL' $where and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

	}

	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=$exec_query ? mysqli_fetch_array($exec_query) : null;

	$exec_query1 = mysqli_query($conn,$sql1);
	$fetch_pql1=$exec_query1 ? mysqli_fetch_array($exec_query1) : null;

	
	$pay_total_amount=(float)($fetch_pql1['pay_total_amount'] ?? 0);
	$report_grand_total_amount=(float)($fetch_pql['report_grand_total_amount'] ?? 0);

	
	$balance_total_amount=$report_grand_total_amount-$pay_total_amount;

	
$json = array("report_grand_total_amount" =>number_format($report_grand_total_amount, 2),"pay_total_amount" =>number_format($pay_total_amount, 2),"balance_total_amount" =>number_format($balance_total_amount, 2));

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>
