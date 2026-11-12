<?php
include "connection.php";
date_default_timezone_set('Asia/Kolkata');	

$cname=str_replace("^","'",$_POST['cname']);
$addr=str_replace("^","'",$_POST['addr']);
$adm_state=str_replace("^","'",$_POST['adm_state']);
$gstno=str_replace("^","'",$_POST['gstno']);
$bank=str_replace("^","'",$_POST['bank']);
$branch=str_replace("^","'",$_POST['branch']);
$acc_no=str_replace("^","'",$_POST['acc_no']);
$acc_type=str_replace("^","'",$_POST['acc_type']);
$ifsc=str_replace("^","'",$_POST['ifsc']);
$holder_name=str_replace("^","'",$_POST['holder_name']);
$uname=str_replace("^","'",$_POST['uname']);
$pass=str_replace("^","'",$_POST['pass']);
$suffix=str_replace("^","'",$_POST['suffix']);

$sql= "update tbl_admin set cname='".$cname."',addr='".$addr."',gstno='".$gstno."',adm_state='".$adm_state."',bank='".$bank."',branch='".$branch."',acc_no='".$acc_no."',acc_type='".$acc_type."',ifsc='".$ifsc."',holder_name='".$holder_name."',uname='".$uname."',pass='".$pass."',suffix='".$suffix."' where admin_id='1'";
	
$exec_query=mysqli_query($conn, $sql);

if($exec_query){
	$result=1;
}
else
{
	$result=0;	
}


$json = array("op" =>$result);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
				
?>