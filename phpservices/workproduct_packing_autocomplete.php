<?php
include "connection.php";

$search = $_POST['search'];
$packing_id = $_POST['packing_id'];
$query = "SELECT a.set_name,a.total_set,a.product_id,a.product_name,a.packing_details_id,a.size,a.sizeid,a.target,a.po_no,b.emp_id FROM tbl_packing_details a inner join tbl_packing b on a.packing_id=b.packing_id and a.delete_status='NDL' and  a.packing_id='$packing_id' and  a.product_name like'%" . $search . "%' group by set_name";
//  print_r($query);
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {
    if(!empty($row))
    {
        $po_no=$row['po_no'];
        $product_id=$row['product_id'];
        $emp_id=$row['emp_id'];
        
        $query1="SELECT a.completed_unit,a.target  FROM tbl_packing_working_details a inner join tbl_packing b on  a.packing_id=b.packing_id  and b.emp_id='$emp_id' and a.po_no='$po_no' and a.product_id='$product_id'  and a.delete_status='NDL' and b.delete_status='NDL'";
        $result1 = mysqli_query($conn,$query1);
        $result_count = mysqli_num_rows($result1);  
        $target_fab=0;   
                
            while($row1 = mysqli_fetch_array($result1) ){
                $target_fab+=$row1['completed_unit'];
            }
            $completed_unit=$target_fab;    
            $product_id_list[]=$row['product_id'];
            $product_name_list[]=$row['product_name'];
    }
    $response[] = array("id" =>   $product_id_list, "label" =>  $product_name_list, "set_name" => $row['set_name'], "completed_unit" => $completed_unit, "packing_details_id" => $row['packing_details_id'], "size" => $row['size'], "sizeid" => $row['sizeid'], "target" => $row['target'],"total_set" => $row['total_set'], "po_no" => $row['po_no']);
}

// encoding array to json format
echo json_encode($response);
