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
$sql = "SELECT a.dc_id FROM tbl_gst_invoice a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;
if (($_POST['cond'] ?? '') == "firstbind") {

$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_gst_invoice  a
left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_gst_invoice_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id
left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0'";

}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate']));
     $customer_id = $_POST['customer_id'] ?? '';
     $vehicle_no = trim($_POST['vehicle_no'] ?? '');
     $vehicle_sql = '';
     if ($vehicle_no !== '') {
         $v = mysqli_real_escape_string($conn, $vehicle_no);
         $vehicle_sql = " and (a.vechicle_number LIKE '%".$v."%' OR a.vechicle_id LIKE '%".$v."%' OR a.refrence_name LIKE '%".$v."%') ";
     }

	if (($customer_id ?? '')=='') {

		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_gst_invoice  a
left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_gst_invoice_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id
left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and  a.billing_date between '" . $fdate . "' and '" . $tdate . "' " . $vehicle_sql;



	}
	else if (($customer_id ?? '')!='') {

		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_gst_invoice  a
		left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_gst_invoice_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id
		left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and  a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_id='" . $customer_id . "' " . $vehicle_sql;



	}

}

// Search filter
if (!empty($requestData['search']['value'])) {
    $searchValue = mysqli_real_escape_string($conn, $requestData['search']['value']);

    if (stripos($sql, 'WHERE') === false) {
        $sql .= " WHERE (a.dc_no LIKE '%".$searchValue."%' OR d.customer_name LIKE '%".$searchValue."%' OR a.vechicle_number LIKE '%".$searchValue."%' OR a.refrence_name LIKE '%".$searchValue."%')";
    } else {
        $sql .= " AND (a.dc_no LIKE '%".$searchValue."%' OR d.customer_name LIKE '%".$searchValue."%' OR a.vechicle_number LIKE '%".$searchValue."%' OR a.refrence_name LIKE '%".$searchValue."%')";
    }
}

// For count
$countSql = $sql;
$countQuery = mysqli_query($conn, $countSql) or die("Count Query Failed");
$totalFiltered = mysqli_num_rows($countQuery);

// For actual data
$sql .= " ORDER BY a.billing_date DESC";
if (intval($requestData['length']) != -1) {
	$sql .= " LIMIT ".$requestData['start']." ,".$requestData['length'];
}
$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys 3");



$total_discount=0;
$total_gst=0;
$total_paid=0;
$total_grand_total_amount=0;

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
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
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",(string)($row["customer_name"] ?? '')).'<br> '.str_replace("^","'",(string)($row["mblno"] ?? '')).'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",(string)($row["gst_no"] ?? '')).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",(string)($row["address"] ?? '')).'</span>';

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
		$nestedData[] = '<span  style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",$excess).'</span>';
	} else {
		$nestedData[] = '-';
	}

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",(string)($row["qty"] ?? '')).'</span>';

	
	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",(string)($row["rate"] ?? '')).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round((float)($row["gst_total_amount"] ?? 0), 2)).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round((float)($row["discount"] ?? 0), 2)).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round((float)($row["grand_total_amount"] ?? 0), 2)).'</span>';
	
	//$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["gst_no"]).'</span>';
	//$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["mblno"]).'</span>';	
	

	$total_gst=$total_gst+$row["gst_total_amount"];
	//$total_paid=$total_paid+$paid;
	$total_discount=$total_discount+$row["discount"];
	$total_grand_total_amount=$total_grand_total_amount+$row["grand_total_amount"];

	
	$data[] = $nestedData;
	$i++;
}

	$nestedData1=array(); 
	$nestedData1[] = "Total";
	$nestedData1[] = '';
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]='';
	$nestedData1[]=$total_gst;
	//$nestedData1[]=$total_paid;
	$nestedData1[]=$total_discount;
	$nestedData1[]=$total_grand_total_amount-$total_paid;

	$data[] = $nestedData1;



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


?>
	