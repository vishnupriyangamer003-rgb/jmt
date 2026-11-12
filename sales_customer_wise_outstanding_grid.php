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
	

	

$sql = "SELECT a.*,0 as print,0 as packing,0 as advance,0 as dis,sum(a.grand_total_amount) as grand,a.customer_id,b.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_dc  a inner join  tbl_customer b on b.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' group by a.customer_id";

}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
	
	if (($_POST['customer_id'] ?? '')=='') {
		
		$sql = "SELECT a.*,d.customer_id,d.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_dc  a inner join tbl_dc_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and  d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'  group by a.customer_id";
		
	}	
	else if (($_POST['customer_id'] ?? '')!='') {
		
		$sql = "SELECT a.*,d.customer_id,d.customer_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_dc  a inner join tbl_dc_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and b.delete_status!='0' and  d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and d.customer_id='" . $customer_id . "' group by a.customer_id";
		
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

	$gql3 = "SELECT sum(pay_amount) as pay_amount1 FROM tbl_receipt where delete_status!='0' and customer_id='".$row['customer_id']."' ";
	$exec_query3=mysqli_query($conn, $gql3);
	$row3=mysqli_fetch_array($exec_query3);

	$nestedData=array(); 
	$nestedData[] = "#".$i;
	//$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["billing_date"]).'</span>';
	
	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["customer_name"]).'</span>';

	//$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["dc_no"]).'</span>';
	
	$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;"><a href="receipt_preview.php?id='.$row["customer_id"].'">'.str_replace("^","'",(($row["grand"] ?? 0)+($row["print"] ?? 0)+($row["packing"] ?? 0))-(($row["advance"] ?? 0)+($row["dis"] ?? 0)+($row3["pay_amount1"] ?? 0))).'</a></span>';
	
	
	
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
	