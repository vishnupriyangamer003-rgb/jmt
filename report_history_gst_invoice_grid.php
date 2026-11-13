<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
if (!headers_sent()) { header('Access-Control-Allow-Origin: *'); }
	//include connection file 
	include_once("sessionservices.php");
	// include_once("header.php");
	 
	
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$booking_type= $_REQUEST['booking_type'] ?? '';
//echo $booking_type2= $_POST['booking_type'];
//echo $booking_type= $_GET['booking_type'];


$columns = array( 
// datatable column index  => database column name
	0 =>'title', 
	
		
	
);

// getting total number records without any search
$sql = "SELECT a.dc_id FROM tbl_gst_invoice a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

$sql = "SELECT a.dc_id,d.customer_id,d.customer_name,d.mblno FROM tbl_gst_invoice  a 
inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id 
left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0'";


 //print_r($sql);
 if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND (( d.customer_id LIKE '%".$requestData['search']['value']."%' ) 
	OR (d.customer_name LIKE '%".$requestData['search']['value']."%' )
	OR (d.mblno LIKE '%".$requestData['search']['value']."%' ))";   

}
// print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" group by a.customer_id  order by b.dc_id  desc ";
if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$gql3 = "SELECT sum(pay_amount) as paid FROM tbl_receipt where delete_status!='0' and customer_id='".$row['customer_id']."' ";

		$exec_gql3 = mysqli_query($conn, $gql3);
		$fetch_gql3 = mysqli_fetch_array($exec_gql3);


		$gql4 = "SELECT sum(total_amount-discount) as total_amount FROM tbl_gst_invoice where delete_status!='0' and customer_id='".$row['customer_id']."' ";

		$exec_gql4 = mysqli_query($conn, $gql4);
		$fetch_gql4 = mysqli_fetch_array($exec_gql4);


	
			
			

	$nestedData[] = "#".$i ;
	$nestedData[] = '<a href="ledger_preview.php?id='.$row['customer_id'].'"><span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",($row["customer_name"] ?? '')).' <br>'.str_replace("^","'",($row["mblno"] ?? '')).'</span></a>';
	//$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["customer_name"]).' <br>'.str_replace("^","'",$row["mblno"]).'</span>';	
	

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",($fetch_gql4["total_amount"] ?? '')).'</span>';
	
	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",($fetch_gql3["paid"] ?? '')).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",(($fetch_gql4["total_amount"])-($fetch_gql3["paid"]))).'</span>';	
	
	
	
	$data[] = $nestedData;
	$i++;
}

//<a href='receipt_preview.php?id=".$row['customer_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


?>
	