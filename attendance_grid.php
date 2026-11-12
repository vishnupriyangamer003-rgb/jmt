<?php
header('Access-Control-Allow-Origin: *');
	include_once("phpservices/connection.php");
 
	
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'title', 
	
		
	
);

// getting total number records without any search
$sql = "SELECT t1.attendance_id FROM tbl_attendance t1 WHERE t1.delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


 $sql = "select t1.*,date_format(t1.attendance_date,'%d-%m-%Y') as attendance_date,t2.emp_name from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where t1.delete_status!='0' and t2.delete_status!='0'";



// print_r($sql);
if( !empty($requestData['search']['value']) ) {
	$search = mysqli_real_escape_string($conn, $requestData['search']['value']);
	$sql.=" AND ( t1.attendance_status LIKE '".$search."%' OR t2.emp_name LIKE '".$search."%' )";
}
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" order by t1.attendance_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $i ;
	if($row['emp_name']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["emp_name"]);
	}
	if($row['attendance_date']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["attendance_date"]);
	}
	if($row['attendance_date']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = '<span class="badge badge-info">'.str_replace("^","'",$row["attendance_status"]).'</span>';
	}
	// $nestedData[] = "<img src='userdata/images/banner/".str_replace("^","'",$row["imgname"])."' style='width:100px'>";
	
    // $nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>
	// 																<a href='update_category.php?id=".$row['attendance_id']."'><button type='button' class='btn btn-success' style='padding:6px 8px;margin-right:5px'>
	// 																	<i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
	// 																</button></a>
	// 																<a href='javascript:void(0)' class='deleteTriger' data-value='".$row['attendance_id']."'><button type='button' class='btn btn-danger' style='padding:6px 8px;'>
	// 																	<i class='fa fa-trash' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
	// 																</button></a>
	// 															</div>";
	
	
	$data[] = $nestedData;
	$i++;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


?>
	