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
$sql = "SELECT a.pay_id FROM tbl_pay_entry a WHERE a.delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if (($_POST['cond'] ?? '') == "firstbind") {
	

$sql = "SELECT a.amount,a.billing_date,a.pay_type,a.
remarks,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status!='0'";


}
else if(($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $expense_header_id = $_POST['expense_header_id'];
	
	if (($_POST['expense_header_id'] ?? '')=='') {
		
		$sql = "SELECT a.amount,a.billing_date,a.pay_type,a.
remarks,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

		//$sql = "SELECT a.gate_pass_id,c.customer_name,e.emp_name,v.vechicle_name,b.product_name,a.qty,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.create_date,'%d/%m/%Y') as create_date1,date_format(a.update_date,'%d/%m/%Y %r') as update_date ,a.created_by,a.updated_by FROM tbl_gate_pass a inner join tbl_products b on a.product_name=b.product_id inner join tbl_customer c on a.customer_name=c.customer_id inner join tbl_employee_details e on a.driver_name=e.emp_id left join tbl_vechicle_details v on a.vechicle_number=v.vechicle_id where a.delete_status!='0' and a.create_date between '" . $fdate . "' and '" . $tdate . "' ";

		
		
	}	
	else if(($_POST['expense_header_id'] ?? '')!='') {
		

		$sql = "SELECT a.amount,a.billing_date,a.pay_type,a.
remarks,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.expense_header_id='" . $expense_header_id . "'";

		//$sql = "SELECT a.gate_pass_id,c.customer_name,e.emp_name,v.vechicle_name,b.product_name,a.qty,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.create_date,'%d/%m/%Y') as create_date1,date_format(a.update_date,'%d/%m/%Y %r') as update_date ,a.created_by,a.updated_by FROM tbl_gate_pass a inner join tbl_products b on a.product_name=b.product_id inner join tbl_customer c on a.customer_name=c.customer_id inner join tbl_employee_details e on a.driver_name=e.emp_id left join tbl_vechicle_details v on a.vechicle_number=v.vechicle_id where a.delete_status!='0' and a.create_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_name='" . $customer_id . "' ";

		
		
	}	 

	//print_r($sql);

}


 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( b.income_header_name LIKE '%".$requestData['search']['value']."%' OR a.remarks LIKE '%".$requestData['search']['value']."%' )";

}

//print_r($sql);

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys1");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" order by a.pay_id  desc ";
if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	




$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	

	$nestedData[] = "#".$i ;
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
		$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["income_header_name"]).'</span>';	
		
	}
	if($row['remarks']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["remarks"]).'</span>';	
		
	}

	

	if($row['pay_type']==1){
		
		$nestedData[] ='<span  style="font-size: 15px;color: green;font-weight: bold">'.str_replace("^","'",$row["amount"]).'</span>';
	}else{
		$nestedData[] ='-';
	}


	if($row['pay_type']==2){
		$nestedData[] ='<span  style="font-size: 15px;color: red;font-weight: bold">'.str_replace("^","'",$row["amount"]).'</span>';
	}else{
		$nestedData[] ='-';
	}

	
	
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
	