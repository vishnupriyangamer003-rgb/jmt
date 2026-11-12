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
$sql = "SELECT a.id FROM tbl_income_expense_details a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql);
if($query===false){
	header('Content-Type: application/json', true);
	echo json_encode(array("draw"=>intval($_REQUEST['draw'] ?? 1),"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>array()));
	exit;
}
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

if (($_POST['cond'] ?? '') == "firstbind") {

	$sql = "SELECT date_format(a.billing_date,'%d/%m/%Y') as billing_date1,a.billing_date,GROUP_CONCAT(DISTINCT h.income_header_name SEPARATOR ', ') as headers FROM tbl_income_expense_details a LEFT JOIN tbl_income_header h ON h.id=a.header_id WHERE a.delete_status!='0' AND (h.delete_status!='0' OR h.delete_status IS NULL) ";


}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     
		
		$sql = "SELECT date_format(a.billing_date,'%d/%m/%Y') as billing_date1,a.billing_date,GROUP_CONCAT(DISTINCT h.income_header_name SEPARATOR ', ') as headers FROM tbl_income_expense_details a LEFT JOIN tbl_income_header h ON h.id=a.header_id WHERE a.delete_status!='0' AND (h.delete_status!='0' OR h.delete_status IS NULL) and a.billing_date between '" . $fdate . "' and '" . $tdate . "' ";

		 

	//print_r($sql);

}
 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$searchEscaped = mysqli_real_escape_string($conn, $requestData['search']['value']);
	$sql.=" AND ( a.billing_date LIKE '%".$searchEscaped."%' OR h.income_header_name LIKE '%".$searchEscaped."%' )";   

}
 //print_r($sql);
$query=mysqli_query($conn, $sql);
if($query===false){
	header('Content-Type: application/json', true);
	echo json_encode(array("draw"=>intval($_REQUEST['draw'] ?? 1),"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>array()));
	exit;
}

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" group by a.billing_date ";
if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
//print_r($sql);
$query=mysqli_query($conn, $sql);
if($query===false){
	header('Content-Type: application/json', true);
	echo json_encode(array("draw"=>intval($_REQUEST['draw'] ?? 1),"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>array()));
	exit;
}

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$sql11 = "SELECT COALESCE(sum(amount),0) as total_expense FROM tbl_income_expense_details WHERE  delete_status!='0'  and income_expense_type='Expense' and billing_date='" . mysqli_real_escape_string($conn, $row["billing_date"]) . "' ";
	$query11=mysqli_query($conn, $sql11);
	$row11=$query11 ? mysqli_fetch_array($query11) : ['total_expense' => 0];


	$nestedData[] = "#".$i ;
	$nestedData[] = str_replace("^","'",(string)($row["billing_date1"] ?? ''));
	$nestedData[] = htmlspecialchars((string)($row["headers"] ?? '-'), ENT_QUOTES, 'UTF-8');
	
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold">'.str_replace("^","'",(string)($row11["total_expense"] ?? '0')).'</span>';

    
	
	
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
	