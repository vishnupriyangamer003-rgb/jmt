<?php
include "connection.php";

 $search = $_POST['search'];
 $po_no = $_POST['po_no'];
 if(!empty($_POST['sub_department_id']))
 { 
     $sub_department_id = $_POST['sub_department_id'];

 }

 $po=explode(",",$po_no);
 $po_no_split=$po[0];
 $query="SELECT product_id,product_name,sizeid,size,quantity FROM tbl_purchase_details  where delete_status='NDL' and product_name like'%".$search."%' and po_no='$po_no_split'";
 $result = mysqli_query($conn,$query);


 while($row = mysqli_fetch_array($result) ){
    $target_fab=0;

    if(!empty($row))
    {
        if(!empty($sub_department_id)){
            $query1="SELECT t1.target  FROM tbl_packing_details t1 inner join tbl_packing t2 on t2.packing_id=t1.packing_id AND  t1.delete_status='NDL' and t2.delete_status='NDL' and  t1.product_id=".$row['product_id']." and  t2.po_no='$po_no' and t2.sub_department_id='$sub_department_id'";
        }
        else{
            $query1="SELECT t1.target  FROM tbl_packing_details t1 inner join tbl_packing t2 on t2.packing_id=t1.packing_id AND  t1.delete_status='NDL' and t2.delete_status='NDL' and  t1.product_id=".$row['product_id']." and  t2.po_no='$po_no'";
        }
    
// print_r($query1);
        $result1 = mysqli_query($conn,$query1);
      
        while($row1 = mysqli_fetch_array($result1) ){
            $target_fab+=$row1['target'];
        }
    }
    $target= $row['quantity']- $target_fab;
  $response[] = array("id"=>$row['product_id'],"label"=>$row['product_name'],"sizeid"=>$row['sizeid'],"size"=>$row['size'],"target"=>"YOU MUST ENTER THE TARGET:".$target,"target_input"=>$target);
 }

 // encoding array to json format
 echo json_encode($response);
?>