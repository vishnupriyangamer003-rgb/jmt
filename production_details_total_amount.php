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

	if (!empty($_POST['operator_id'])){
		$where.=" and a.operator_id=".$_POST['operator_id']."";

	}
	 

}else{
	$fdate='';
	$tdate='';
}



	if ($fdate=='' && $tdate=='') {

		$sql = "SELECT sum(a.qty) as report_grand_total FROM tbl_production_details  a  WHERE  a.delete_status!='0'  ";
		
		

	}else{

		$sql = "SELECT sum(a.qty) as report_grand_total FROM tbl_production_details  a  WHERE  a.delete_status!='0'   $where and a.production_date  between '" . $fdate . "' and '" . $tdate . "' ";
				

	}

	

	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);	

	
	
$json = array("report_grand_total" =>number_format($fetch_pql['report_grand_total'], 0));

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>