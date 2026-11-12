<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
include ('sessionservices.php');
include ('phpservices/connection.php');

$requestData= $_REQUEST;
	
 // $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join karurchambers.tbl_customer b on b.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2'";

$where='';
$where1='';

if(($_POST['convert_status'] ?? '')=='1'){
	$convert_status = " and a.convert_status='Y'";
}else if(($_POST['convert_status'] ?? '')=='2'){
	$convert_status = " and (a.convert_status!='Y' or a.convert_status IS NULL ) ";
}else{
	$convert_status = "";
}


 	


if(!empty($_POST['fdate'])){
	$fdate = date('Y-m-d', strtotime($_POST['fdate']));
 //$tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
	$tdate = date('Y-m-d', strtotime($_POST['tdate']));

	

}else{
	$fdate='';
	$tdate='';
	
}




	if ($fdate=='' && $tdate=='') {	


		if (!empty($_POST['customer_id'])){
			$where.=" where a.customer_id=".$_POST['customer_id']." ";
			$where1.=" and a.customer_id=".$_POST['customer_id']." ";

		}


		$sql = "SELECT 
 COUNT(DISTINCT a.dc_id) as tot_row,
 SUM(DISTINCT a.grand_total_amount) as report_grand_total_amount,
 SUM(b.qty) as report_total_qty,
 SUM(b.product_rate) as report_product_total_amount 
FROM tbl_services_non_dc a 
INNER JOIN tbl_services_non_dc_details b ON a.dc_id = b.dc_id $where $convert_status";

		//$gql_rec = "select sum(pay_amount) as paid from tbl_services_non_receipt where delete_status='NDL' $where1 ";
		$gql_rec = "select sum(pay_amount) as paid from tbl_services_non_receipt b inner join tbl_services_non_dc a on ab.dc_id=a.dc_id where b.delete_status='NDL' and b.billing_date between '" . $fdate . "' and '" . $tdate . "' $where1 ";	


	}else{

		if (!empty($_POST['customer_id'])){
			$where.=" and a.customer_id=".$_POST['customer_id']." ";

			$where1.=" and a.customer_id=".$_POST['customer_id']." ";

		}
	 


		$sql = "SELECT 
 COUNT(DISTINCT a.dc_id) as tot_row,
 SUM(DISTINCT a.grand_total_amount) as report_grand_total_amount,
 SUM(b.qty) as report_total_qty,
 SUM(b.product_rate) as report_product_total_amount 
FROM tbl_services_non_dc a 
INNER JOIN tbl_services_non_dc_details b ON a.dc_id = b.dc_id WHERE a.billing_date between '" . $fdate . "' and '" . $tdate . "' $where $convert_status ";

		$gql_rec = "select sum(pay_amount) as paid from tbl_services_non_receipt b inner join tbl_services_non_dc a on b.dc_id=a.dc_id where b.delete_status='NDL' and b.billing_date between '" . $fdate . "' and '" . $tdate . "' $where1 ";
		
	//and a.billing_date between '" . $fdate . "' and '" . $tdate . "'

	}

 $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);	

	$exec_gql_rec = mysqli_query($conn, $gql_rec);
	$fetch_gql_rec = mysqli_fetch_array($exec_gql_rec);

	
	$report_grand_total_amount=$fetch_pql['report_grand_total_amount'];
	$report_total_qty=$fetch_pql['report_total_qty'];	
	$report_product_total_amount=$fetch_pql['report_product_total_amount'];


	$report_paid_total_amount=$fetch_gql_rec['paid'];

	$report_balance_total_amount=$fetch_pql['report_grand_total_amount']-$report_paid_total_amount;
	
$json = array("report_balance_total_amount" =>number_format($report_balance_total_amount, 2),"report_grand_total_amount" =>number_format($report_grand_total_amount, 2),"report_total_qty" =>number_format($report_total_qty, 2),"report_paid_total_amount" =>number_format($report_paid_total_amount, 2),"report_product_total_amount" =>number_format($report_product_total_amount, 2)/$fetch_pql['tot_row']);

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>

