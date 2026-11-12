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
$sql = "SELECT a.dc_id FROM tbl_dc a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

if (($_POST['cond'] ?? '') == "firstbind") {

	$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_dc  a 
	inner join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_dc_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id 
	left join  tbl_customer d on d.customer_id=a.customer_id
	WHERE a.delete_status!='0' AND d.delete_status!='0' ";



}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
	if (($_POST['customer_id'] ?? '')=='') {
		
		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_dc  a 
		inner join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_dc_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id 
		left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND d.delete_status!='0' AND a.billing_date between '" . $fdate . "' and '" . $tdate . "' ";

		
		
	}	
	else if (($_POST['customer_id'] ?? '')!='') {
		
		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_dc  a 
		inner join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_dc_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id 
		left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND d.delete_status!='0' AND a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_id='" . $customer_id . "' ";

		
		
	}	 


}

// Search filter
if (!empty($requestData['search']['value'])) {
    $searchValue = mysqli_real_escape_string($conn, $requestData['search']['value']);

    if (stripos($sql, 'WHERE') === false) {
        $sql .= " WHERE (b.product_id LIKE '%".$searchValue."%' OR d.customer_name LIKE '%".$searchValue."%')";
    } else {
        $sql .= " AND (b.product_id LIKE '%".$searchValue."%' OR d.customer_name LIKE '%".$searchValue."%')";
    }
}

// For count
$countSql = $sql;
$countQuery = mysqli_query($conn, $countSql) or die("Count Query Failed");
$totalFiltered = mysqli_num_rows($countQuery);

// For actual data
$sql .= " ORDER BY a.dc_id DESC";
if (intval($requestData['length']) != -1) {
	$sql .= " LIMIT ".$requestData['start']." ,".$requestData['length'];
}
$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys 3");


$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
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
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["customer_name"]).'<br> '.str_replace("^","'",$row["mblno"]).'</span>';

	if($row["driver_type"]=='1'){

		$gql_driver = "SELECT * FROM tbl_employee_details where delete_status!='0' and emp_id='".$row["driver_id"]."' ";
		$exec_gql_driver = mysqli_query($conn, $gql_driver);
		$fetch_gql_driver = mysqli_fetch_array($exec_gql_driver);

		//$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$fetch_gql_driver["emp_name"]).'</span>';

		$gql_vechicle = "SELECT * FROM tbl_vechicle_details where delete_status!='0' and vechicle_id='".$row["vechicle_id"]."' ";
		$exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
		$fetch_gql_vechicle = mysqli_fetch_array($exec_gql_vechicle);

		$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$fetch_gql_vechicle["vechicle_name"]).'</span>';
		

	}else if($row["driver_type"]=='2'){

		//$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["driver_name"]).'</span>';	

		$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["vechicle_number"]).'</span>';	
		

	}else{
		//$nestedData[] = '-';

		$nestedData[] = '-';
	}
	
	if($excess!=''){
		$nestedData[] = '<span  style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",$excess).'</span>';
	} else {
		$nestedData[] = '-';
	}

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["qty"]).'</span>';

	
	
	//$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round($row["grand_total_amount"], 2)).'</span>';	
	

   
	
	
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
	