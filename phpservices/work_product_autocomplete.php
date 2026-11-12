<?php
include "connection.php";

 $search = $_POST['search'];
 $cutting_id = $_POST['cutting_id'];

 $query="SELECT product_id,product_name,cutting_details_id,size,sizeid FROM tbl_cutting_details where delete_status='NDL' and  cutting_id='$cutting_id' and  product_name like'%".$search."%' ";
 $result = mysqli_query($conn,$query);
 
 while($row = mysqli_fetch_array($result) ){
  $response[] = array("id"=>$row['product_id'],"label"=>$row['product_name'],"cutting_details_id"=>$row['cutting_details_id'],"size"=>$row['size'],"sizeid"=>$row['sizeid']);
 }

 // encoding array to json format
 echo json_encode($response);
?>