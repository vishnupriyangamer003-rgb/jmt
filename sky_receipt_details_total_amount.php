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
		$where.=" and a.customer_id=".$_POST['customer_id'];

	}
	 

}else{
	$fdate='';
	$tdate='';
}



	// Invoice-level amounts (discount/total/grand total/gst) must be summed once per
	// invoice, and paid amounts once per receipt. Both used to join straight to
	// tbl_sky_gst_invoice_details, which duplicates rows once per product line and
	// double(or more)-counts everything for any invoice with more than one line item.
	// Qty is genuinely detail-level, so it's pre-aggregated per dc_id before joining,
	// keeping the join 1-to-1 with the invoice. The paid query needs no join to the
	// details table at all.
	if ($fdate=='' && $tdate=='') {

		$sql = "SELECT sum(a.discount) as report_total_discount_amount,sum(a.total_amount) as report_total_amount,sum(a.grand_total_amount) as report_grand_total_amount,sum(qty_data.total_qty) as report_total_qty,sum(a.gst_total_amount) as report_gst_total_amount FROM tbl_sky_gst_invoice  a
left join (select dc_id, sum(qty) as total_qty from tbl_sky_gst_invoice_details where delete_status!='0' group by dc_id) qty_data on qty_data.dc_id=a.dc_id
WHERE  a.delete_status!='0' ";

		$sql1 = "SELECT sum(a.pay_amount) as pay_total_amount FROM tbl_sky_receipt a WHERE  a.delete_status!='0' ";


	}else{


		$sql = "SELECT sum(a.discount) as report_total_discount_amount,sum(a.total_amount) as report_total_amount,sum(a.grand_total_amount) as report_grand_total_amount,sum(qty_data.total_qty) as report_total_qty,sum(a.gst_total_amount) as report_gst_total_amount FROM tbl_sky_gst_invoice  a
left join (select dc_id, sum(qty) as total_qty from tbl_sky_gst_invoice_details where delete_status!='0' group by dc_id) qty_data on qty_data.dc_id=a.dc_id
WHERE  a.delete_status!='0' $where and a.billing_date  between '" . $fdate . "' and '" . $tdate . "' ";

		$sql1 = "SELECT sum(a.pay_amount) as pay_total_amount FROM tbl_sky_receipt a WHERE  a.delete_status!='0' $where and a.billing_date  between '" . $fdate . "' and '" . $tdate . "' ";



	}

	

	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);	

	$exec_query1 = mysqli_query($conn,$sql1);
	$fetch_pql1=mysqli_fetch_array($exec_query1);

	
	$pay_total_amount=$fetch_pql1['pay_total_amount'];
	$report_grand_total_amount=$fetch_pql['report_grand_total_amount'];

	
	$balance_total_amount=$report_grand_total_amount-$pay_total_amount;

	//$report_trip_balance_total_amount=$fetch_pql['report_grand_total_amount']-($pay_row['paid_amount']+$fetch_pql['report_total_discount_amount']);
	
$json = array("report_grand_total_amount" =>number_format($report_grand_total_amount, 2),"pay_total_amount" =>number_format($pay_total_amount, 2),"balance_total_amount" =>number_format($balance_total_amount, 2));

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>