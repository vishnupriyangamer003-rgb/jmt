<?php
include "connection.php";

 $search = $_POST['search'];
 $product = $_POST['product'];
 $query="SELECT t1.size_id,t1.size FROM tbl_size t1 inner join  tbl_products t2 on t1.size_id=t2.size_id where t1.delete_status='NDL' and t2.product_id='$product' and  t1.size like'%".$search."%'";
 //$query = "SELECT *,sum(t3.box_qty) as box_qty,t1.design_id as design_id FROM tbl_design t1 inner join tbl_category t2 on t1.cat_id=t2.cat_id left join tbl_products_import_details t3 on t3.design_id=t1.design_id and t3.delete_status='NDL' WHERE design_name like'%".$search."%' and t1.delete_status='NDL' and t2.delete_status='NDL' group by t1.design_id";
//    print_r($query);
 $result = mysqli_query($conn,$query);
 
 while($row = mysqli_fetch_array($result) ){
  $response[] = array("id"=>$row['size_id'],"label"=>$row['size']);
 }

 // encoding array to json format
 echo json_encode($response);
?>