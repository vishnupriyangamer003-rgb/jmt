<?php
include "connection.php";

$search = $_POST['search'];
$stitching_id = $_POST['stitching_id'];

$query = "SELECT a.product_id,c.product_name,a.stitching_details_id,d.size,a.sizeid,f.color,a.color_id,a.target,a.po_no,b.emp_id FROM tbl_stitching_details a inner join tbl_stitching b on a.stitching_id=b.stitching_id inner join tbl_products c on c.product_id=a.product_id  inner join tbl_size d on d.size_id=a.sizeid inner join tbl_color f on f.color_id=a.color_id and  a.delete_status='NDL' and  a.stitching_id='$stitching_id' and  c.product_name like'%" . $search . "%' ";
//  print_r($query);

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {    
    // print_r($row);
    // $completed_unit=0;
    if(!empty($row))
    {
        $po_no=$row['po_no'];
        $product_id=$row['product_id'];
        $color_id=$row['color_id'];
        $emp_id=$row['emp_id'];
        
        $query1="SELECT a.completed_unit,a.target  FROM tbl_stitching_working_details a inner join tbl_stitching b on  a.stitching_id=b.stitching_id  and b.emp_id='$emp_id' and a.po_no='$po_no' and a.product_id='$product_id' and a.color_id='$color_id' and  a.stitching_id='$stitching_id'  and a.delete_status='NDL' and b.delete_status='NDL'";

        //  print_r($query1);
        $result1 = mysqli_query($conn,$query1);
        $result_count = mysqli_num_rows($result1);
        $target_fab=0;
        while($row1 = mysqli_fetch_array($result1) ){
            $target_fab+=$row1['completed_unit'];
        }
        $completed_unit=$target_fab;
        
        
    }

    $response[] = array("id" => $row['product_id'], "label" => $row['product_name'].$row['color'], "completed_unit" => $completed_unit, "stitching_details_id" => $row['stitching_details_id'], "color" => $row['color'], "color_id" => $row['color_id'],  "size" => $row['size'], "sizeid" => $row['sizeid'], "target" => $row['target'], "po_no" => $row['po_no']);
}

// encoding array to json format
echo json_encode($response);
