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
$sql = "SELECT purchase_id FROM tbl_purchase WHERE delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if (($_POST['cond'] ?? '') == "firstbind") {
	
$sql = "SELECT a.*,b.supplier_id,b.supplier_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_purchase  a inner join  tbl_supplier b on b.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and b.delete_status!='0' group by a.purchase_id";

}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $supplier_id = $_POST['supplier_id'];
	
	if (($_POST['supplier_id'] ?? '')=='') {
		
		$sql = "SELECT a.*,b.supplier_id,b.supplier_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_purchase  a inner join  tbl_supplier b on b.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' group by a.purchase_id";
		
	}	
	else if (($_POST['supplier_id'] ?? '')!='') {
		
		$sql = "SELECT a.*,b.supplier_id,b.supplier_name,date_format(a.billing_date,'%d-%m-%Y') as billing_date FROM tbl_purchase  a inner join  tbl_supplier b on b.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and b.supplier_id='" . $supplier_id . "' group by a.purchase_id";
		
	}	 

	//print_r($sql);

}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.purchase_id LIKE '".$requestData['search']['value']."%' )";   
	
}
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" order by a.purchase_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array


	$nestedData=array(); 
	$nestedData[] = "#".$i;

	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["billing_date"]).'</span>';

	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["supplier_name"]).'</span>';

	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["dc_no"]).'</span>';

	//$nestedData[] = "#".$i;
	
	$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",$row["grand_total_amount"]).'</span>';
	
	
	
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
	