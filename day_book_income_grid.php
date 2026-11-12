<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
	//include connection file 
	include_once("sessionservices.php");
	// include_once("header.php");
	 
	
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'title', 
	
		
	
);

// getting total number records without any search
$sql = "SELECT id FROM tbl_income_expense_details WHERE delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT a.amount,a.income_expense_type,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_income_expense_details  a 
inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Income'";




 //print_r($sql);
 if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( b.income_header_name LIKE '%".$requestData['search']['value']."%' OR a.amount LIKE '%".$requestData['search']['value']."%' )";

}
// print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.="  order by a.amount  desc ";
if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();

$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		if($row['billing_date']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = str_replace("^","'",$row["billing_date"]);
		}

		if($row['income_header_name']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = str_replace("^","'",$row["income_header_name"]);
		}

		if($row['amount']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = str_replace("^","'",$row["amount"]);
		}

	
		

    	
		}
	
					
	
	$data[] = $nestedData;
	$i++;



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


?>
	