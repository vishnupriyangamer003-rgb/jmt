<?php 
header('Access-Control-Allow-Origin: *');
include ('phpservices/connection.php');


if(!empty($_POST['category_id'])){
	$category_id=$_POST['category_id'];
	$sql="SELECT sub_category_id,sub_category_name FROM tbl_sub_category where delete_status='NDL' AND category_id='".$category_id."'  order by sub_category_id desc";
}else{
	$sql="SELECT sub_category_id,sub_category_name FROM tbl_sub_category where delete_status='NDL'   order by sub_category_id desc";
}



$query=mysqli_query($conn,$sql) ;
while($row=mysqli_fetch_array($query)){
	$sub_category_id[]=$row['sub_category_id'];
	$sub_category_name[]=str_replace("^", "'", $row['sub_category_name']);
}

// UNDEF-GUARD: empty tables must still return valid JSON
$sub_category_id = $sub_category_id ?? []; 
$sub_category_name = $sub_category_name ?? []; 
$json =array("sub_category_id"=>$sub_category_id,"sub_category_name"=>$sub_category_name);
header("Content-Type: application/json", true);
echo json_encode($json);
	
?> 