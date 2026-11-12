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
$sql = "SELECT a.id FROM tbl_bank_income_expense_details a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

if (($_POST['cond'] ?? '') == "firstbind") {
	$sql = "SELECT date_format(a.billing_date,'%d/%m/%Y') as billing_date1,a.billing_date  FROM tbl_bank_income_expense_details  a WHERE  a.delete_status!='0' ";
}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     
		
		$sql = "SELECT date_format(a.billing_date,'%d/%m/%Y') as billing_date1,a.billing_date  FROM tbl_bank_income_expense_details  a WHERE  a.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' ";

		 

	//print_r($sql);

}

 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.billing_date LIKE '%".$requestData['search']['value']."%' )";   

}
 //print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" group by a.billing_date ";
if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
//print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$sql1 = "SELECT sum(amount) as total_income FROM tbl_bank_income_expense_details WHERE  delete_status!='0' and income_expense_type='Income' and billing_date='" . $row["billing_date"] . "' ";
	$query1=mysqli_query($conn, $sql1) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");
	$row1=mysqli_fetch_array($query1);


	$sql11 = "SELECT sum(amount) as total_expense FROM tbl_bank_income_expense_details WHERE  delete_status!='0'  and income_expense_type='Expense' and billing_date='" . $row["billing_date"] . "' ";
	$query11=mysqli_query($conn, $sql11) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");
	$row11=mysqli_fetch_array($query11);


	$nestedData[] = "#".$i ;
	$nestedData[] = str_replace("^","'",$row["billing_date1"]);
	$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",$row1["total_income"]).'</span>';	
	
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold">'.str_replace("^","'",$row11["total_expense"]).'</span>';

    
	
	
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
	