<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
	//include connection file 
	include_once("sessionservices.php");
	// include_once("header.php");
	 
	
// storing request (ie, get/post) global array to a variable 
$requestData= $_REQUEST;


$booking_type= $_REQUEST['booking_type'] ?? '';
//echo $booking_type2= $_POST['booking_type'];
//echo $booking_type= $_GET['booking_type'];


$columns = array( 
// datatable column index => database column name
	0 =>'title');

// getting total number records without any search
$sql = "SELECT a.dc_id ";
$sql.=" FROM tbl_non_dc a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData; // when there is no search parameter then total number rows = total number filtered rows.
// echo $totalData;

if(($_POST['convert_status'] ?? '')=='1'){
	$convert_status = " and a.convert_status='Y'";
}else if(($_POST['convert_status'] ?? '')=='2'){
	$convert_status = " and (a.convert_status!='Y' or a.convert_status IS NULL ) ";
}else{
	$convert_status = "";
}



if (($_POST['cond'] ?? '') != "searchbind") {

	$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,b.product_rate as product_rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_non_dc a 
	left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate, group_concat(product_rate SEPARATOR ',<br/>') AS product_rate FROM tbl_non_dc_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id 
	left join tbl_customer d on d.customer_id=a.customer_id ";

	//print_r($sql);
 	if( !empty($requestData['search']['value']) ) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
 		$sql.=" WHERE (( a.dc_no LIKE '%".$requestData['search']['value']."%' )
 		OR (d.customer_name LIKE '%".$requestData['search']['value']."%' )
 		OR (a.vechicle_number LIKE '%".$requestData['search']['value']."%' )
 		OR (a.refrence_name LIKE '%".$requestData['search']['value']."%' )) $convert_status";

	}else{

		if(($_POST['convert_status'] ?? '')=='1'){
			$convert_status = " WHERE a.convert_status='Y'";
		}else if(($_POST['convert_status'] ?? '')=='2'){
			$convert_status = " WHERE (a.convert_status!='Y' or a.convert_status IS NULL ) ";
		}else{
			$convert_status = "";
		}

		$sql.=" $convert_status"; 
	}


}
else {

 $fdate = date('Y-m-d', strtotime($_POST['fdate'] ?? ''));
 $tdate = date('Y-m-d', strtotime($_POST['tdate'] ?? ''));
 $customer_id = $_POST['customer_id'] ?? '';
	if (($_POST['customer_id'] ?? '')=='') {
		
		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,b.product_rate as product_rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_non_dc a 
		left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate, group_concat(product_rate SEPARATOR ',<br/>') AS product_rate FROM tbl_non_dc_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id 
		left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND d.delete_status!='0' AND a.billing_date between '" . $fdate . "' and '" . $tdate . "' $convert_status";

		
		
	}	
	else if (($_POST['customer_id'] ?? '')!='') {
		
		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,b.product_rate as product_rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_non_dc a 
		left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate, group_concat(product_rate SEPARATOR ',<br/>') AS product_rate FROM tbl_non_dc_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id 
		left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND d.delete_status!='0' AND a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_id='" . $customer_id . "' $convert_status";

		
		
	}	 

	
 	//print_r($sql);
 	if( !empty($requestData['search']['value']) ) { // if there is a search parameter, $requestData['search']['value'] contains search parameter
 		$sql.=" AND ( ( a.dc_no LIKE '%".$requestData['search']['value']."%' )
 		OR (d.customer_name LIKE '%".$requestData['search']['value']."%' )
 		OR (a.vechicle_number LIKE '%".$requestData['search']['value']."%' )
 		OR (a.refrence_name LIKE '%".$requestData['search']['value']."%' ) )";

	}


}




//print_r($sql);

//print_r($sql);
//$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

//$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


// Virtual split: filter by bill type (goods vs service).
$bill_type = $_POST['bill_type'] ?? $_REQUEST['bill_type'] ?? '';
if ($bill_type === 'service') { $type_cond = "a.is_service_bill=1"; }
else if ($bill_type === 'goods') { $type_cond = "a.is_service_bill=0"; }
else { $type_cond = ""; }
if ($type_cond !== "") {
	if (stripos($sql, 'WHERE') === false) { $sql .= " WHERE " . $type_cond . " "; }
	else { $sql .= " AND " . $type_cond . " "; }
}

$sql.="order by a.dc_id desc ";

$count_query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalFiltered = mysqli_num_rows($count_query);

if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']." ";
}
//print_r($sql);
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc */	

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
// print_r($sql);

$data = array();
$i=1+$requestData['start'];
$total_paid=0;
$total_qty=0;
$total_grand_total_amount=0;

while( $row=mysqli_fetch_array($query) ) { // preparing an array
	$nestedData=array(); 

	$product_list=explode(",<br/>",(string)($row['product_id'] ?? ''));

	$excess=NULL;
		$excess.='';
		
		$j=0;
		foreach($product_list as $product){			
		
			$gql3 = "SELECT * FROM tbl_products where delete_status!='0' and product_id='".$product."' ";

			$exec_gql3 = mysqli_query($conn, $gql3);
			
			//$fetch_gql3["category_name"]."-".
			
			while ($fetch_gql3 = mysqli_fetch_array($exec_gql3)) {
				$excess.= $fetch_gql3["product_name"];
				
			}
			
			//print_r($excess);

			if(!empty($excess)){
				$excess.="<br>";
				
			
			}
			else{
				$excess.='';
				
			}

		$j++;
		}


			$nestedData[] = "#".$i ;
				$days_badge = '';
	if (!empty($row["raw_billing_date"])) {
		$diff_days = (int)floor((strtotime(date('Y-m-d')) - strtotime(substr($row["raw_billing_date"], 0, 10))) / 86400);
		if ($diff_days < 0) {
			$days_badge = '<br><span class="badge badge-secondary" style="font-size:10px;padding:2px 5px;margin-top:2px;">Future</span>';
		} else if ($diff_days === 0) {
			$days_badge = '<br><span class="badge badge-success" style="font-size:10px;padding:2px 5px;margin-top:2px;">Today (0 days)</span>';
		} else if ($diff_days === 1) {
			$days_badge = '<br><span class="badge badge-info" style="font-size:10px;padding:2px 5px;margin-top:2px;">1 day</span>';
		} else {
			$days_badge = '<br><span class="badge badge-primary" style="font-size:10px;padding:2px 5px;margin-top:2px;">' . $diff_days . ' days</span>';
		}
	}
	$nestedData[] = str_replace("^","'",(string)($row["billing_date"] ?? '')) . $days_badge;
			$nestedData[] = str_replace("^","'",(string)($row["dc_no"] ?? ''));
			$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",(string)($row["customer_name"] ?? '')).'<br> '.str_replace("^","'",(string)($row["mblno"] ?? '')).'</span>';

						$v_disp = trim((string)($row["vechicle_number"] ?? ''));
			if ($v_disp === '' && !empty($row["vechicle_id"])) {
				$gql_vechicle = "SELECT vechicle_name FROM tbl_vechicle_details where delete_status!='0' and vechicle_id='".$row["vechicle_id"]."' ";
				$exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
				if ($exec_gql_vechicle && $fetch_gql_vechicle = mysqli_fetch_array($exec_gql_vechicle)) {
					$v_disp = $fetch_gql_vechicle["vechicle_name"] ?? '';
				}
			}
			if ($v_disp === '') {
				$v_disp = trim((string)($row["refrence_name"] ?? ''));
			}
			if ($v_disp === '') {
				$v_disp = '-';
			}
			$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$v_disp).'</span>';
			if($excess!=''){
				$nestedData[] = '<span style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",$excess).'</span>';
			} else {
				$nestedData[] = '-';
			}

			$nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",(string)($row["product_rate"] ?? '')).'</span>';

			$nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",(string)($row["qty"] ?? '')).'</span>';
			
			$gql_rec = "select SUM(pay_amount) as paid from tbl_non_receipt where delete_status!='0' and dc_id='".$row["dc_id"]."' ";


				$exec_gql_rec = mysqli_query($conn, $gql_rec);
				$fetch_gql_rec = mysqli_fetch_array($exec_gql_rec);

				
			if($fetch_gql_rec["paid"]==0 || $fetch_gql_rec["paid"]==''){
				$paid=0;
			}else{
				$paid=$fetch_gql_rec["paid"];
				
			}
			$nestedData[] = '<span style="font-size: 15px;color: green;font-weight: bold">'.str_replace("^","'",$paid).'</span>';

			$nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold;">'.str_replace("^","'",round((float)($row["grand_total_amount"] ?? 0), 2)).'</span>';
			
		$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round((float)($row["grand_total_amount"] ?? 0)-(float)($paid ?? 0), 2)).'</span>';	
		 
		$total_qty=$total_qty+(float)($row["qty"] ?? 0);
	$total_paid=$total_paid+(float)($paid ?? 0);
	$total_grand_total_amount=$total_grand_total_amount+(float)($row["grand_total_amount"] ?? 0);
	
	$data[] = $nestedData;
	$i++;
	
}


	$nestedData1=array(); 
	$nestedData1[] = "Total";
	$nestedData1[] = '';
	$nestedData1[] = '';	
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]=$total_qty;
	$nestedData1[]=$total_paid;
	$nestedData1[]=$total_grand_total_amount;
	$nestedData1[]=$total_grand_total_amount-$total_paid;

	$data[] = $nestedData1;






$json_data = array(
			"draw" => intval( $requestData['draw'] ), // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal" => intval( $totalData ), // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data // total data array
			);

echo json_encode($json_data); // send data as json format


?>
	
