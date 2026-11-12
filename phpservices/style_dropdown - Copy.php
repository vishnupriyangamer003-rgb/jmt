<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
 
$sql="SELECT style_id,style FROM tbl_style where delete_status='NDL'";

$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$style_id[]=$row['style_id'];
	$style[]=str_replace("^", "'", $row['style']);
}

$json =array("style_id"=>$style_id,"style"=>$style);
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 