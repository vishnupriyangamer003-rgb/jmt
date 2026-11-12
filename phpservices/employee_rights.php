<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");	

$sql="select * from tbl_employee_rights where emp_id='".$_POST['empid']."' and module_id='".$_POST['moduleid']."'";
$query=mysqli_query($conn,$sql);
while($row=mysqli_fetch_array($query)){
	$adds=$row['ins'];	
	$upd=$row['upd'];
	$del=$row['del'];
}
if($adds=='Y' && $upd=='Y' && $del=='Y'){
	$rights=1;
}
else if($adds=='N' && $upd=='Y' && $del=='Y'){
	$rights=2;
}
else if($adds=='N' && $upd=='N' && $del=='Y'){
	$rights=3;
}
else if($adds=='N' && $upd=='N' && $del=='N'){
	$rights=4;
}
else if($adds=='Y' && $upd=='N' && $del=='Y'){
	$rights=5;
}
else if($adds=='Y' && $upd=='Y' && $del=='N'){
	$rights=6;
}
else if($adds=='Y' && $upd=='N' && $del=='N'){
	$rights=7;
}
else if($adds=='N' && $upd=='Y' && $del=='N'){
	$rights=8;
}
else{
	$rights=0;
}
$json = array("rights" =>$rights);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
?>