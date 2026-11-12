<?php
include "connection.php";

$search = $_POST['search'];
$packing_id = $_POST['packing_id'];
$query = "SELECT distinct(a.set_name) as set_name,a.product_id,a.total_set,a.product_name,a.packing_details_id,a.size,a.sizeid,a.target,a.po_no,b.emp_id FROM tbl_packing_details a inner join tbl_packing b on a.packing_id=b.packing_id and a.delete_status='NDL' and  a.packing_id='$packing_id' and  a.set_name like'%" . $search . "%'  group by a.set_name";
//  print_r($query);
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {
    // $arr = array($row['set_name']);

    // $arr=array_unique($arr, SORT_REGULAR);

    // $arr = array_map("unserialize", array_unique(array_map("serialize", $arr)));
    if(!empty($row))
    {
        $po_no=$row['po_no'];
        $product_id=$row['product_id'];
        $emp_id=$row['emp_id'];
        
        $query1="SELECT a.completed_unit,a.target  FROM tbl_packing_working_details a inner join tbl_packing b on  a.packing_id=b.packing_id  and b.emp_id='$emp_id' and a.po_no='$po_no'  and a.delete_status='NDL'  and a.packing_id='$packing_id' and  a.set_name='".$row['set_name']."' and b.delete_status='NDL' group by b.sub_department_id";
        //  print_r($query1);
        $result1 = mysqli_query($conn,$query1);
        $result_count = mysqli_num_rows($result1);  
        $target_fab=0;   
                
            while($row1 = mysqli_fetch_array($result1) ){
                $target_fab+=$row1['completed_unit'];
            }
            $completed_unit=$target_fab;    

    }

    $query_set="SELECT a.product_id,a.product_name,a.packing_details_id,a.size,a.sizeid,a.target,a.po_no,b.emp_id FROM tbl_packing_details a inner join tbl_packing b on a.packing_id=b.packing_id and a.delete_status='NDL' and  a.packing_id='$packing_id' and  a.set_name='".$row['set_name']."'";
    $result_set = mysqli_query($conn,$query_set);
    $product_id_list=array();
    $product_name_list=array();
    // $setname1=array();
    while($row_set = mysqli_fetch_array($result_set))
    {
        
        $packing_details_id[]=$row_set['packing_details_id'];
        // $setname1[]=$row_set['set_name'];

        $product_id_list[]=$row_set['product_id'];
        $product_name_list[]=$row_set['product_name'];

    //    $checkvalue=$row_set['set_name'];
        
    //  if (in_array($checkvalue, $setname1))
    //  {
    //     // $setname1[]=$row_set['set_name'];
    //     $setname1=$row_set['set_name'];
    //  }
    //  else{
    //     $setname1[]=$checkvalue;
    //  }



    

    }
//   print_r($setname1);





//     foreach($setname1 as $el) {
//         $pageno = $el;
//         //  echo $el;
//         $a = array($setname1);

// if (!in_array($el, $a)) {
// // echo $el;
//     array_push($setname1 ,$el);
// //    echo  $setname=array_push($el);
// }
    //  }


// print_r($arr);

 $response[] = array("id" => $product_id_list, "label" => $row['set_name'],"product_name" => $product_name_list, "completed_unit" => $completed_unit, "packing_details_id" => $row['packing_details_id'], "size" => $row['size'], "sizeid" => $row['sizeid'], "target" => $row['target'], "total_set" => $row['total_set'],"po_no" => $row['po_no']);
}

// encoding array to json format
echo json_encode($response);
