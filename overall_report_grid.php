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
$sql = "SELECT booking_id FROM tbl_booking WHERE delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if (($_POST['cond'] ?? '') == "firstbind") {
	
$sql = "SELECT a.*,a.booking_type,b.customer_id,b.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_booking  a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' group by a.booking_id";

} 

else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
     $booking_type = $_POST['booking_type'];
	
	if (($_POST['customer_id'] ?? '')=='' && ($_POST['booking_type'] ?? '')=='0') {
		
		$sql = "SELECT a.*,b.customer_id,b.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_booking  a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' group by a.booking_id";
		
	}	
	else if (($_POST['customer_id'] ?? '')!='' && ($_POST['booking_type'] ?? '')=='0') {
		
		$sql = "SELECT a.*,d.customer_id,d.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_booking  a inner join tbl_booking_details b on a.booking_id=b.booking_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and  d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and d.customer_id='" . $customer_id . "' group by a.booking_id";
		
	}
	else if (($_POST['customer_id'] ?? '')=='' && ($_POST['booking_type'] ?? '')!='') {
		
		$sql = "SELECT a.*,d.customer_id,d.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_booking  a inner join tbl_booking_details b on a.booking_id=b.booking_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and  d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.booking_type='" . $booking_type . "' group by a.booking_id";
		
	}
	else if (($_POST['customer_id'] ?? '')!='' && ($_POST['booking_type'] ?? '')!='') {
		
		$sql = "SELECT a.*,d.customer_id,d.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_booking  a inner join tbl_booking_details b on a.booking_id=b.booking_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and  d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and d.customer_id='" . $customer_id . "' and a.booking_type='" . $booking_type . "' group by a.booking_id";
		
	} 

	//print_r($sql);

}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.billing_no LIKE '".$requestData['search']['value']."%' )";   
	
}
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" order by a.booking_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array


	$nestedData=array(); 
	$nestedData[] = "#".$i ;
	$nestedData[] = '<span  style="font-size: 14px;color: black;font-weight: bold;">'.str_replace("^","'",$row["billing_date"]).'</span>';
	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["customer_name"]).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold;">'.str_replace("^","'",$row["billing_no"]).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: orange;font-weight: bold;">'.str_replace("^","'",$row["booking_type"]).'</span>';
	
	if($row['billing_type']=='2'){
		$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",$row["total_amount"]).'</span>';
	} else {
		$nestedData[] = '-';
	}
	
	if($row['billing_type']=='3'){
		$nestedData[] = '<span  style="font-size: 15px;color: #d600d6;font-weight: bold;">'.str_replace("^","'",$row["total_amount"]).'</span>';
	} else {
		$nestedData[] = '-';
	}
	
	if($row['billing_type']=='4'){
		$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",$row["total_amount"]).'</span>';
	} else {
		$nestedData[] = '-';
	}
	
	
	$nestedData[] = '<span  style="font-size: 14px;font-weight: bold;color: #0fbcac;">'.str_replace("^","'",$row["gst_total_amount"]).'</span>';
	$nestedData[] = '<span  style="font-size: 14px;color: red;font-weight: bold;">'.str_replace("^","'",$row["grand_total_amount"]).'</span>';
	
	
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
	