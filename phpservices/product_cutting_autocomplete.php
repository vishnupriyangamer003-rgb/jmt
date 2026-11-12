<?php
include "connection.php";

 $search = $_POST['search'];
 $po_no = $_POST['po_no'];
 $po=explode(",",$po_no);
 $po_no_split=$po[0]; 
 if(!empty($_POST['sub_department_id'])){
    $sub_department_id = $_POST['sub_department_id'];
    }

//  $query="SELECT product_id,product_name,sizeid,size,quantity FROM tbl_purchase_details  where delete_status='NDL' and product_name like'%".$search."%' and po_no='$po_no_split'";
 
 
 $query = "SELECT t1.purchase_details_id,t1.purchase_id,t3.product_name,t1.product_id,t1.sizeid,t4.size,t1.quantity,t1.color_id,t5.color  FROM tbl_fabric_purchase_details t1 INNER join tbl_fabric_purchase t2 on t1.purchase_id=t2.purchase_id  INNER join tbl_products t3 on t1.product_id=t3.product_id INNER join tbl_size t4 on t1.sizeid=t4.size_id  INNER join tbl_color t5 on t5.color_id=t1.color_id  where t1.delete_status='NDL' and  t2.delete_status='NDL'  and  t3.delete_status='NDL' and t2.po_no='$po_no_split' and  t3.product_name like'%".$search."%'";

 $result = mysqli_query($conn,$query);


 while($row = mysqli_fetch_array($result) ){
    $target_fab=0;

    if(!empty($row))
    {
        if(!empty($sub_department_id)){
            $query1="SELECT sum(t1.target) as target  FROM tbl_cutting_details t1 inner join tbl_cutting t2 on t2.cutting_id=t1.cutting_id AND  t1.delete_status='NDL' and t2.delete_status='NDL' and  t1.product_id=".$row['product_id']." and  t2.po_no='$po_no' and t2.sub_department_id='$sub_department_id'";
        }
        else{
            $query1="SELECT sum(t1.target) as target  FROM tbl_cutting_details t1 inner join tbl_cutting t2 on t2.cutting_id=t1.cutting_id AND  t1.delete_status='NDL' and t2.delete_status='NDL' and  t1.product_id=".$row['product_id']." and  t2.po_no='$po_no'";
        }

        $result1 = mysqli_query($conn,$query1);
      
    $row1 = mysqli_fetch_array($result1);
            $target_fab=$row1['target'];
        
    }
    $target= $row['quantity']- $target_fab;
  $response[] = array("id"=>$row['product_id'],"label"=>$row['product_name'],"sizeid"=>$row['sizeid'],"size"=>$row['size'],"color_id"=>$row['color_id'],"color"=>$row['color'],"target"=>"YOU MUST ENTER THE TARGET:".$target,"target_input"=>$target);
 }

 // encoding array to json format
 echo json_encode($response);
?>