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
$sql = "SELECT dc_id FROM tbl_dc WHERE delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if (($_POST['cond'] ?? '') == "firstbind") {
	

	

$sql = "SELECT a.*,sum(b.qty) as tot_qty,c.product_name,c.category FROM tbl_dc  a 
left join  tbl_dc_details b on b.dc_id=a.dc_id
left join  tbl_products c on c.product_id=b.product_id
WHERE  a.delete_status!='0' and b.delete_status!='0' group by b.product_id";

}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
	
	if (($_POST['customer_id'] ?? '')=='') {
		
		$sql = "SELECT a.*,sum(b.qty) as tot_qty,c.product_name,c.category FROM tbl_dc  a 
		left join  tbl_dc_details b on b.dc_id=a.dc_id
		left join  tbl_products c on c.product_id=b.product_id
		WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";
		
	}	
	else if (($_POST['customer_id'] ?? '')!='') {
		
		$sql = "SELECT a.*,b.qty,c.product_name,c.category FROM tbl_dc  a 
		left join  tbl_dc_details b on b.dc_id=a.dc_id
		left join  tbl_products c on c.product_id=b.product_id
		WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_id='" . $customer_id . "'";
		
	}	 

	

}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.dc_id LIKE '".$requestData['search']['value']."%' )";   
	
}

//print_r($sql);

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" order by a.dc_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array


	$nestedData=array(); 
	$nestedData[] = "#".$i;
	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",trim(($row["product_name"] ?? '')."  ".($row["category"] ?? '')) ).'</span>';
	
	
	
	$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",($row["tot_qty"] ?? $row["qty"] ?? '')).'</span>';
	
	
	
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
	