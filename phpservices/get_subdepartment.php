<?php 
header('Access-Control-Allow-Origin: *');
include_once("connection.php");
$department_id = $_POST['department_id'];
$sql="SELECT sub_department_id,sub_department FROM tbl_subdepartment where delete_status='NDL' and department_id='$department_id'";
// print_r($sql);
$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$s_id[]=$row['sub_department_id'];
	$s_name[]=str_replace("^", "'", $row['sub_department']);
}
if(!empty($s_id)){

	$json =array("s_id"=>$s_id,"s_name"=>$s_name);
}
else{
	
$json =array("s_id"=>"select sub department","s_name"=>"select sub department");
}
header("Content-Type: application/json", true);
		echo json_encode($json);
	
?> 