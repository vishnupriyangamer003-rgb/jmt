<?php
header('Access-Control-Allow-Origin: *');
include "connection.php";
date_default_timezone_set('Asia/Kolkata');	

$sql= "SELECT * FROM  tbl_admin where admin_id='1'";
	
$exec_query=mysqli_query($conn, $sql);

$fetch=mysqli_fetch_array($exec_query);

$cname=str_replace("^","'",$fetch['cname']);
$addr=str_replace("^","'",$fetch['addr']);
$adm_state=str_replace("^","'",$fetch['adm_state']);
$gstno=str_replace("^","'",$fetch['gstno']);
$bank=str_replace("^","'",$fetch['bank']);
$branch=str_replace("^","'",$fetch['branch']);
$acc_no=str_replace("^","'",$fetch['acc_no']);
$acc_type=str_replace("^","'",$fetch['acc_type']);
$ifsc=str_replace("^","'",$fetch['ifsc']);
$holder_name=str_replace("^","'",$fetch['holder_name']);
$uname=str_replace("^","'",$fetch['uname']);
$pass=str_replace("^","'",$fetch['pass']);
$suffix=str_replace("^","'",$fetch['suffix']);


$json = array("cname" =>$cname,"addr" =>$addr,"gstno" =>$gstno,"adm_state" =>$adm_state,"bank" =>$bank,"branch" =>$branch,"acc_no" =>$acc_no,"acc_type" =>$acc_type,"ifsc" =>$ifsc,"holder_name" =>$holder_name,"uname" =>$uname,"pass" =>$pass,"suffix" =>$suffix);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
				
?>