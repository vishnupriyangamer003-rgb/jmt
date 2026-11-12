<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
	
if ($_POST['customer_id']=='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.grand_total_amount) as report_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";
	
}	
else if ($_POST['customer_id']!='' && $_POST['booking_type']=='0') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.grand_total_amount) as report_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "'";
	
}
else if ($_POST['customer_id']=='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.grand_total_amount) as report_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.booking_type='" . $booking_type . "'";
	
}
else if ($_POST['customer_id']!='' && $_POST['booking_type']!='') {
	
     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	 $sql = "SELECT *,sum(a.grand_total_amount) as report_total_amount FROM tbl_booking a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.customer_id='" . $customer_id . "' and a.booking_type='" . $booking_type . "'";
	
} 


	
    $exec_query = mysqli_query($conn,$sql);
	$fetch_pql=mysqli_fetch_array($exec_query);
	
	$report_total_amount=$fetch_pql['report_total_amount'];
	
$json = array("report_total_amount" =>$report_total_amount);
header("Content-Type: application/json",true);
echo json_encode($json); 	
	
?>