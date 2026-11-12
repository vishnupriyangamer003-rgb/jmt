<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
// Production-safe: log errors, never print into JSON responses
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

header('Access-Control-Allow-Origin: *');

// Recursively replace any byte sequence that isn't valid UTF-8 so json_encode() never
// fails outright on legacy latin1-collated data (works on any PHP version, unlike the
// JSON_INVALID_UTF8_SUBSTITUTE flag which needs PHP >= 7.2).
function sky_report_grid_utf8ize($mixed) {
 if (is_array($mixed)) {
 foreach ($mixed as $key => $value) {
 $mixed[$key] = sky_report_grid_utf8ize($value);
 }
 return $mixed;
 }
 if (is_string($mixed)) {
 if (function_exists('mb_convert_encoding')) {
 return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8');
 }
 if (function_exists('iconv')) {
 $clean = @iconv('UTF-8', 'UTF-8//IGNORE', $mixed);
 if ($clean !== false) {
 return $clean;
 }
 }
 // Last-resort fallback with no extension dependency: strip anything outside
 // printable ASCII rather than let the whole response fail to encode.
 return preg_replace('/[\x80-\xFF]/', '', $mixed);
 }
 return $mixed;
}

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
$sql = "SELECT a.dc_id FROM tbl_sky_gst_invoice a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData; // when there is no search parameter then total number rows = total number filtered rows.
// echo $totalData;
if (($_POST['cond'] ?? '') == "firstbind") {

$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.qty SEPARATOR ',<br/>') as qty,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_sky_gst_invoice a
inner join tbl_sky_gst_invoice_details b on a.dc_id=b.dc_id
left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND b.delete_status!='0' AND d.delete_status!='0'";

	//print_r($sql);

}
else if (($_POST['cond'] ?? '') == "searchbind") {

 $fdate = date('Y-m-d', strtotime($_POST['fdate']));
 $tdate = date('Y-m-d', strtotime($_POST['tdate']));
 $customer_id = $_POST['customer_id'];
	
	if (($_POST['customer_id'] ?? '')=='') {
		
		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.qty SEPARATOR ',<br/>') as qty,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_sky_gst_invoice a
inner join tbl_sky_gst_invoice_details b on a.dc_id=b.dc_id
left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND b.delete_status!='0' AND d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' ";



	}
	else if (($_POST['customer_id'] ?? '')!='') {

		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.qty SEPARATOR ',<br/>') as qty,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_sky_gst_invoice a
		inner join tbl_sky_gst_invoice_details b on a.dc_id=b.dc_id
		left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND b.delete_status!='0' AND d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_id='" . $customer_id . "' ";

		
		
	}	 


}

if (!empty($requestData['search']['value'])) {
 $searchValue = mysqli_real_escape_string($conn, $requestData['search']['value']);

 if (stripos($sql, 'WHERE') === false) {
 $sql .= " WHERE ( d.customer_name LIKE '%".$searchValue."%')";
 } else {
 $sql .= " AND ( d.customer_name LIKE '%".$searchValue."%')";
 }
}

$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys 2");
// For actual data
$sql .= " GROUP BY a.dc_id ORDER BY a.dc_id DESC";
if (intval($requestData['length']) != -1) {
	$sql .= " LIMIT ".$requestData['start']." ,".$requestData['length'];
}
$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys 3");

$total_paid=0;
$total_balance=0;
$total_discount=0;
$total_gst=0;
$total_grand_total_amount=0;

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) { // preparing an array
	$nestedData=array(); 

	$product_list=explode(",<br/>",$row['product_id']);

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
	$nestedData[] = str_replace("^","'",$row["billing_date"]) . $days_badge;
	$nestedData[] = str_replace("^","'",$row["dc_no"]);
	$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["customer_name"]).'<br> '.str_replace("^","'",$row["mblno"]).'</span>';

	$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["gst_no"]).'</span>';
	
	$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["address"]).'</span>';
	



	$vechicle_display = '';
	if (!empty($row["vechicle_number"])) {
		$vechicle_display = $row["vechicle_number"];
	} else if (!empty($row["vechicle_id"])) {
		$gql_vechicle = "SELECT * FROM tbl_vechicle_details where delete_status!='0' and vechicle_id='".mysqli_real_escape_string($conn, $row["vechicle_id"])."' ";
		$exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
		$fetch_gql_vechicle = $exec_gql_vechicle ? mysqli_fetch_array($exec_gql_vechicle) : null;
		if (!empty($fetch_gql_vechicle["vechicle_name"])) {
			$vechicle_display = $fetch_gql_vechicle["vechicle_name"];
		} else {
			$vechicle_display = $row["vechicle_id"];
		}
	} else if (!empty($row["refrence_name"])) {
		$vechicle_display = $row["refrence_name"];
	}

	if (!empty($vechicle_display)) {
		$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",(string)$vechicle_display).'</span>';
	} else {
		$nestedData[] = '-';
	}
	
	if($excess!=''){
		$nestedData[] = '<span style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",$excess).'</span>';
	} else {
		$nestedData[] = '-';
	}

	$nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["qty"]).'</span>';

	
	$nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["rate"]).'</span>';
	$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round($row["gst_total_amount"], 2)).'</span>';
	$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round($row["discount"], 2)).'</span>';
	$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round($row["grand_total_amount"], 2)).'</span>';
	
	
	//$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["mblno"]).'</span>';	
	
	$total_discount=$total_discount+$row["discount"];
	$total_gst=$total_gst+$row["gst_total_amount"];
	$total_grand_total_amount=$total_grand_total_amount+$row["grand_total_amount"];
	
	$data[] = $nestedData;
	$i++;
}

$nestedData1=array(); 
	$nestedData1[] = "Total";
	$nestedData1[] = '';
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[]=$total_gst;
	$nestedData1[]=$total_discount;
	$nestedData1[]=$total_grand_total_amount;
	
	$nestedData1[]='';
	$data[] = $nestedData1;


$json_data = array(
			"draw" => intval( $requestData['draw'] ), // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal" => intval( $totalData ), // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data" => $data // total data array
			);

echo json_encode(sky_report_grid_utf8ize($json_data)); // send data as json format


?>
	
