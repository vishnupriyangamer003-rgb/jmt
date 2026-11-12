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

	if (!empty($_POST['expense_header_id'])){
		$where.=" and a.expense_header_id=".$_POST['expense_header_id']."";

	}
	 

}else{
	$fdate='';
	$tdate='';
}



	if ($fdate=='' && $tdate=='') {

		$sql = "SELECT sum(a.amount) as in_total_amount FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status='NDL' and a.pay_type=1";

		$sql1 = "SELECT sum(a.amount) as out_total_amount FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status='NDL' and a.pay_type=2";


	}else{


		$sql = "SELECT sum(a.amount) as in_total_amount FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status='NDL' and a.pay_type=1 and a.billing_date between '" . $fdate . "' and '" . $tdate . "' $where";

		$sql1 = "SELECT sum(a.amount) as out_total_amount FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status='NDL' and a.pay_type=2 and a.billing_date between '" . $fdate . "' and '" . $tdate . "' $where";

		

	}

    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);	


	$exec_query1 = mysqli_query($conn,$sql1);
	$fetch_pql1=mysqli_fetch_array($exec_query1);	

	
	$in_total_amount=$fetch_pql['in_total_amount'];
	$out_total_amount=$fetch_pql1['out_total_amount'];
	
	
$json = array("report_non_pay_total_amount" =>number_format($in_total_amount-$out_total_amount, 2));

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>