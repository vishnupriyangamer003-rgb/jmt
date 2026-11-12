<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

	//$sql = "SELECT *,sum(expanse_amt) as report_invoice_total_amount,sum(grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking WHERE  delete_status!='0'  and billing_type='2'";

		$fdate = date('Y-m-d', strtotime($_POST['fdate']));
		$tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
		$customer_id = $_POST['customer_id'];
		$billing_type = $_POST['billing_type'];
		$process_type = $_POST['process_type'];

		

		//and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "' and a.booking_type='" . $booking_type . "'

		$where=' ';

		if(!empty($fdate) || !empty($tdate) ){

			
			$where.=" AND  a.billing_date  between '" .$fdate. "' and '" .$tdate."' ";

		}

		if(!empty($customer_id) && $customer_id!='0'){

			$where.=" AND   b.customer_id='" . $customer_id . "'";

		}

		if(!empty($billing_type) && $billing_type!='0'){

			$where.=" AND   a.billing_type='" . $billing_type . "'";
			
		}

		if(!empty($process_type) && $process_type!='0'){

			$where.=" AND   a.booking_type='" . $process_type . "'";
			
		}

		$sql = "SELECT *,sum(a.expanse_amt) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2' $where ";

	

	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	
	$report_invoice_total_amount=$fetch_pql['report_invoice_total_amount'];
	$report_invoice_grand_total_amount=$fetch_pql['report_invoice_grand_total_amount'];

	if(empty($fetch_pql['report_invoice_total_amount'])){
		$report_invoice_total_amount='0';
	}

	if(empty($fetch_pql['report_invoice_grand_total_amount'])){
		$report_invoice_grand_total_amount='0';
	}
	
$json = array("report_invoice_total_amount" =>$report_invoice_total_amount,"report_invoice_grand_total_amount" =>$report_invoice_grand_total_amount);

header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>