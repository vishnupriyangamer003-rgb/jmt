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

$sql = "SELECT a.pay_id,a.amount,a.billing_date,a.pay_type,a.
remarks,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status!='0'";

}
else if(($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate'] ?? ''));
     $tdate = date('Y-m-d', strtotime(($_POST['tdate'] ?? '').' +1 day'));
     $expense_header_id = $_POST['expense_header_id'] ?? '';
	
	if (($_POST['expense_header_id'] ?? '')=='') {
		
		$sql = "SELECT a.pay_id,a.amount,a.billing_date,a.pay_type,a.
remarks,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";	
		
	}	
	else if(($_POST['expense_header_id'] ?? '')!='') {		

		$sql = "SELECT a.pay_id,a.amount,a.billing_date,a.pay_type,a.
remarks,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_pay_entry a inner join tbl_income_header b on a.expense_header_id=b.id  where a.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.expense_header_id='" . $expense_header_id . "'";

		
		
	}	
}


 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( b.income_header_name LIKE '".$requestData['search']['value']."%' )";   
	
}



$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys1");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" order by a.pay_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";




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


	if($row['pay_type']==1){
		$pay_type='INWARD';
	}else if($row['pay_type']==2){
		$pay_type='OUTWARD';
	}else{
		$pay_type='-';
	}

	
	$nestedData[] = str_replace("^","'",$pay_type);
	

	

	
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

	if($row['remarks']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["remarks"]);
	}

	
		// $nestedData[] = "<img src='userdata/images/banner/".str_replace("^","'",$row["imgname"])."' style='width:100px'>";
		if(($row['update_date'] ?? '')!=''){
			if(($row['updated_by'] ?? '')=='admin' || ($row['updated_by'] ?? '')=='Admin' || ($row['updated_by'] ?? '')=='1'){
				$nestedData[]='<span class="badge badge-info">Updated by Admin  on '.($row['update_date'] ?? '').'</span>';
			}
			else{
				$gql="select emp_name from tbl_employee_details where delete_status!='0' and emp_code='".($row['updated_by'] ?? '')."'";
				$exec_gql=mysqli_query($conn,$gql);
				$fetch_gql=mysqli_fetch_array($exec_gql);
				$nestedData[]='<span class="badge badge-info">Updated by '.($fetch_gql['emp_name'] ?? '').' on '.($row['create_date'] ?? '').'</span>';
			}
		}
		else{
			if(($row['created_by'] ?? '')=='admin' || ($row['created_by'] ?? '')=='Admin' || ($row['created_by'] ?? '')=='1'){
				$nestedData[]='<span class="badge badge-success">Created by Admin on '.($row['create_date'] ?? '').'</span>';
			}
			else{
				$gql="select emp_name from tbl_employee_details where delete_status!='0' and emp_code='".($row['created_by'] ?? '')."'";
				$exec_gql=mysqli_query($conn,$gql);
				$fetch_gql=mysqli_fetch_array($exec_gql);
				$nestedData[]='<span class="badge badge-success">Created by '.($fetch_gql['emp_name'] ?? '').' on '.($row['create_date'] ?? '').' </span>';
			}
		}

    	$nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>
																	<a href='non_pay_entry_update.php?id=".$row['pay_id']."'><button type='button' class='btn btn-success' style='padding:6px 8px;margin-right:5px'>
																		<i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
																	</button></a>
																	<a href='javascript:void(0)' class='deleteTriger' data-value='".$row['pay_id']."'><button type='button' class='btn btn-danger' style='padding:6px 8px;'>
																		<i class='fa fa-trash' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
																	</button></a>
																</div>";
	
	
					
	
	
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
	