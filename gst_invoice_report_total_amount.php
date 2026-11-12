<?php
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');
$requestData= $_REQUEST;
	
   // $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2'";

$where='';


if(!empty($_POST['fdate'])){
	$fdate = date('Y-m-d', strtotime($_POST['fdate']));
    $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
	//$tdate = date('Y-m-d', strtotime($_POST['tdate']));

	if (!empty($_POST['customer_id'])){
		$where.=" and a.customer_id=".$_POST['customer_id']."";

	}
	 

}else{
	$fdate='';
	$tdate='';
}



	if ($fdate=='' && $tdate=='') {

		$sql = "SELECT sum(a.discount) as report_total_discount_amount,sum(a.total_amount) as report_total_amount,sum(a.grand_total_amount) as report_grand_total_amount,sum(b.qty) as report_total_qty,sum(a.gst_total_amount) as report_gst_total_amount FROM tbl_gst_invoice  a 
inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' ";
		


	}else{


		$sql = "SELECT sum(a.discount) as report_total_discount_amount,sum(a.total_amount) as report_total_amount,sum(a.grand_total_amount) as report_grand_total_amount,sum(b.qty) as report_total_qty,sum(a.gst_total_amount) as report_gst_total_amount FROM tbl_gst_invoice  a 
inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' $where and a.billing_date  between '" . $fdate . "' and '" . $tdate . "' ";

		//$sql = "SELECT sum(a.discount) as report_total_discount_amount,sum(a.total_amount) as report_total_amount,sum(a.grand_total) as report_grand_total_amount,sum(a.advance) as report_advance_total_amount FROM tbl_trip a WHERE  a.delete_status!='0' $where and a.trip_date  between '" . $fdate . "' and '" . $tdate . "' ";

		

	}

	

	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);	

	
	$report_total_amount=$fetch_pql['report_total_amount'];
	$report_grand_total_amount=$fetch_pql['report_grand_total_amount'];
	$report_gst_total_amount=$fetch_pql['report_gst_total_amount'];
	$report_total_qty=$fetch_pql['report_total_qty'];
	$report_total_discount_amount=$fetch_pql['report_total_discount_amount'];
	//$paid_amount=$pay_row['paid_amount'];

	//$report_trip_balance_total_amount=$fetch_pql['report_grand_total_amount']-($pay_row['paid_amount']+$fetch_pql['report_total_discount_amount']);
	
$json = array("report_total_amount" =>number_format($report_total_amount, 2),"report_grand_total_amount" =>number_format($report_grand_total_amount, 2),"report_total_qty" =>number_format($report_total_qty, 2),"report_gst_total_amount" =>number_format($report_gst_total_amount, 2),"report_total_discount_amount" =>number_format($report_total_discount_amount, 2));

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>