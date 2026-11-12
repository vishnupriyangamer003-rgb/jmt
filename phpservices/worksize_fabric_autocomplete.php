<?php
include "connection.php";

 $search = $_POST['search'];
 $fabric_id = $_POST['fabric_id'];

 $query="SELECT product_id,product_name,fabric_details_id,size,sizeid,target FROM tbl_fabric_details where delete_status='NDL' and  fabric_id='$fabric_id' and  size like'%".$search."%' ";
 //$query = "SELECT *,sum(t3.box_qty) as box_qty,t1.design_id as design_id FROM tbl_design t1 inner join tbl_category t2 on t1.cat_id=t2.cat_id left join tbl_products_import_details t3 on t3.design_id=t1.design_id and t3.delete_status='NDL' WHERE design_name like'%".$search."%' and t1.delete_status='NDL' and t2.delete_status='NDL' group by t1.design_id";
 $result = mysqli_query($conn,$query);
 
 while($row = mysqli_fetch_array($result) ){
  $response[] = array("product_id"=>$row['product_id'],"product_name"=>$row['product_name'],"fabric_details_id"=>$row['fabric_details_id'],"label"=>$row['size'],"id"=>$row['sizeid'],"target"=>$row['target']);
 }

 // encoding array to json format
 echo json_encode($response);
?>