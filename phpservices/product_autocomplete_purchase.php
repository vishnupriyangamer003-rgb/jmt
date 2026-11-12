<?php
include "connection.php";

 $search = $_POST['search'];

 $query="SELECT a.product_id,a.product_name,b.design,a.design_id,c.size,c.size_id FROM tbl_products a inner join tbl_design b  on b.design_id=a.design_id  inner join tbl_size c  on c.size_id=a.size_id  where a.delete_status='NDL' and b.delete_status='NDL' and  c.delete_status='NDL' and a.product_name like'%".$search."%'";
 //$query = "SELECT *,sum(t3.box_qty) as box_qty,t1.design_id as design_id FROM tbl_design t1 inner join tbl_category t2 on t1.cat_id=t2.cat_id left join tbl_products_import_details t3 on t3.design_id=t1.design_id and t3.delete_status='NDL' WHERE design_name like'%".$search."%' and t1.delete_status='NDL' and t2.delete_status='NDL' group by t1.design_id";
 
//  print_r($query);
 $result = mysqli_query($conn,$query);
 
 while($row = mysqli_fetch_array($result) ){
  $response[] = array("id"=>$row['product_id'],"label"=>$row['product_name'],"design"=>$row['design'],"design_id"=>$row['design_id'],"size"=>$row['size'],"size_id"=>$row['size_id']);
 }

 // encoding array to json format
 echo json_encode($response);
?>