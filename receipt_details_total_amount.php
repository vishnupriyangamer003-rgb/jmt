<?php
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
$requestData= $_REQUEST;
	
   // $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2'";

$where='';


if(!empty($_POST['fdate'])){
	$fdate = date('Y-m-d', strtotime($_POST['fdate']));
    //$tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
	$tdate = date('Y-m-d', strtotime($_POST['tdate']));

	if (!empty($_POST['customer_id'])){
		$where.=" and a.customer_id=".$_POST['customer_id']."";

	}
	 

}else{
	$fdate='';
	$tdate='';
}



	if ($fdate=='' && $tdate=='') {

		$sql = "SELECT SUM(a.grand_total_amount) as report_grand_total_amount 
		        FROM tbl_gst_invoice a 
		        WHERE a.delete_status = 'NDL' AND EXISTS (SELECT 1 FROM tbl_gst_invoice_details b WHERE b.dc_id = a.dc_id AND b.delete_status = 'NDL')";
		
		$sql1 = "SELECT SUM(a.pay_amount) as pay_total_amount 
		         FROM tbl_receipt a 
		         WHERE a.delete_status = 'NDL'";

	}else{

		$sql = "SELECT SUM(a.grand_total_amount) as report_grand_total_amount 
		        FROM tbl_gst_invoice a 
		        WHERE a.delete_status = 'NDL' AND EXISTS (SELECT 1 FROM tbl_gst_invoice_details b WHERE b.dc_id = a.dc_id AND b.delete_status = 'NDL') $where and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

		$sql1 = "SELECT SUM(a.pay_amount) as pay_total_amount 
		         FROM tbl_receipt a 
		         WHERE a.delete_status = 'NDL' $where and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

	}

	

	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);	

	$exec_query1 = mysqli_query($conn,$sql1);
	$fetch_pql1=mysqli_fetch_array($exec_query1);

	
	$pay_total_amount=$fetch_pql1['pay_total_amount'];
	$report_grand_total_amount=$fetch_pql['report_grand_total_amount'];

	
	$balance_total_amount=$report_grand_total_amount-$pay_total_amount;

	//$report_trip_balance_total_amount=$fetch_pql['report_grand_total_amount']-($pay_row['paid_amount']+$fetch_pql['report_total_discount_amount']);
	
$json = array("report_grand_total_amount" =>number_format((float)$report_grand_total_amount, 2),"pay_total_amount" =>number_format((float)$pay_total_amount, 2),"balance_total_amount" =>number_format((float)$balance_total_amount, 2));

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>