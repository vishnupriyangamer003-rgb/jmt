<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");	
include_once('employee_services.php');
include_once('../sessionservices.php');
date_default_timezone_set('Asia/Kolkata');	
$objVDS=new employee_services($conn);
$curdate=date('Y-m-d H:i:s');
if($_POST['req']=='INS'){
	$rtnMsg=$objVDS->employee_insert($curdate);
}
else if($_POST['req']=='DEL'){
	$rtnMsg=$objVDS->employee_delete($curdate);
}
else if($_POST['req']=='AUB'){
	$rtnMsg=$objVDS->employee_autobind($curdate);
}
else if($_POST['req']=='UPD'){
	$rtnMsg=$objVDS->employee_update($curdate);
}
else if($_POST['req']=='RAUB'){
	$rtnMsg=$objVDS->employeerightsautobind($curdate);
}
else if($_POST['req']=='ADDRIGHTS'){
	$rtnMsg=$objVDS->employeerightsadd($curdate);
}
else if($_POST['req']=='DELRIGHTS'){
	$rtnMsg=$objVDS->employeerightsdelete($curdate);
}
else if($_POST['req']=='STATUSCHANGE'){
	$rtnMsg=$objVDS->employeestatuschange($curdate);
}
mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>