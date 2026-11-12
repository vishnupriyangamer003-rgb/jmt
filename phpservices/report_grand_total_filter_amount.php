<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");

if ($_POST['customer_id']=='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";
	
}	
else if ($_POST['customer_id']!='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "'";
	
}
else if ($_POST['customer_id']=='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.booking_type='" . $booking_type . "'";
	
}
else if ($_POST['customer_id']!='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.total_amount) as report_invoice_total_amount,sum(a.grand_total_amount) as report_invoice_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='2' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "' and a.booking_type='" . $booking_type . "'";
	
} 

    $exec_query_1 = mysqli_query($conn,$sql);
	$fetch_sql=mysqli_fetch_array($exec_query_1);
	$report_invoice_grand_total_amount=$fetch_sql['report_invoice_grand_total_amount'];

///////////////////////////////////////////////////Invoice///////////////////////////////////////////////////


	if ($_POST['customer_id']=='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $pql = "SELECT *,sum(a.total_amount) as report_debit_total_amount,sum(a.grand_total_amount) as report_debit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='3' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";
	
}	
else if ($_POST['customer_id']!='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $pql = "SELECT *,sum(a.total_amount) as report_debit_total_amount,sum(a.grand_total_amount) as report_debit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='3' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "'";
	
}
else if ($_POST['customer_id']=='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $pql = "SELECT *,sum(a.total_amount) as report_debit_total_amount,sum(a.grand_total_amount) as report_debit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='3' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.booking_type='" . $booking_type . "'";
	
}
else if ($_POST['customer_id']!='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $pql = "SELECT *,sum(a.total_amount) as report_debit_total_amount,sum(a.grand_total_amount) as report_debit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='3' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "' and a.booking_type='" . $booking_type . "'";
	
} 
	$exec_query_2 = mysqli_query($conn,$pql);
	$fetch_pql=mysqli_fetch_array($exec_query_2);
	$report_debit_grand_total_amount=$fetch_pql['report_debit_grand_total_amount'];
	
///////////////////////////////////////////////DEBIT///////////////////////////////////////


if ($_POST['customer_id']=='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $qql = "SELECT *,sum(a.total_amount) as report_credit_total_amount,sum(a.grand_total_amount) as report_credit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='4' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";
	
}	
else if ($_POST['customer_id']!='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $qql = "SELECT *,sum(a.total_amount) as report_credit_total_amount,sum(a.grand_total_amount) as report_credit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='4' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "'";
	
}
else if ($_POST['customer_id']=='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $qql = "SELECT *,sum(a.total_amount) as report_credit_total_amount,sum(a.grand_total_amount) as report_credit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='4' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.booking_type='" . $booking_type . "'";
	
}
else if ($_POST['customer_id']!='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $qql = "SELECT *,sum(a.total_amount) as report_credit_total_amount,sum(a.grand_total_amount) as report_credit_grand_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_type='4' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "' and a.booking_type='" . $booking_type . "'";
	
} 


	
    $exec_query_3 = mysqli_query($conn,$qql);
	$fetch_qql=mysqli_fetch_array($exec_query_3);
	$report_credit_grand_total_amount=$fetch_qql['report_credit_grand_total_amount'];

//////////////////////////////////////////////////CREDIT/////////////////////////////////////////////////

	
$invoice_plus_debit_minus_credit_total_amount = number_format(($fetch_sql['report_invoice_grand_total_amount'] + $fetch_pql['report_debit_grand_total_amount']) - $fetch_qql['report_credit_grand_total_amount'], 2);
	
	
	
	
$json = array("invoice_plus_debit_minus_credit_total_amount" =>$invoice_plus_debit_minus_credit_total_amount);
header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>