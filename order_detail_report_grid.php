<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
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
$sql = "SELECT a.dc_id FROM tbl_dc a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

if (($_POST['cond'] ?? '') != "searchbind") {

	$fdate = date('Y-m-d');
   // $tdate = date('Y-m-d +1 day');

	//$date = "04-15-2013";
	//$date1 = str_replace('-', '/', $date);
	$tdate = date('Y-m-d',strtotime($fdate . "-1 days"));



	$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,b.product_rate,a.grand_total_amount,d.customer_id,d.customer_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.qty SEPARATOR ',<br/>') as qty,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_dc  a 
	inner join tbl_dc_details b on a.dc_id=b.dc_id 
	left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

}
else {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'] ?? '';
	
     $sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,b.product_rate,a.grand_total_amount,d.customer_id,d.customer_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.qty SEPARATOR ',<br/>') as qty,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_dc a 
     inner join tbl_dc_details b on a.dc_id=b.dc_id 
     left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";
     if (!empty($customer_id)) {
         $sql .= " and a.customer_id='" . mysqli_real_escape_string($conn, $customer_id) . "'";
     }
}


//print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND (( c.product_id LIKE '%".$requestData['search']['value']."%' ) 
	OR (d.customer_name LIKE '".$requestData['search']['value']."%' ))";   

}

//print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.="group by a.dc_id  order by a.dc_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
// print_r($sql);

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = "#".$i ;
	$nestedData[] = str_replace("^","'",$row["billing_date"]);
	$nestedData[] = str_replace("^","'",$row["dc_no"]);
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["customer_name"]).'</span>';	

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["qty"]).'</span>';	
	
	//$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round($row["grand_total_amount"], 2)).'</span>';	  
	
	
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
	