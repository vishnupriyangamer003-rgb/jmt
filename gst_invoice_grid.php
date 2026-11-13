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

if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate']));
     $customer_id = $_POST['customer_id'];

	if (($_POST['customer_id'] ?? '')=='') {

		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.product_rates as product_rates,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_gst_invoice  a  left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(product_rate SEPARATOR ',<br/>') AS product_rates, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_gst_invoice_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id
left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND d.delete_status!='0' and  a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

	}
	else if (($_POST['customer_id'] ?? '')!='') {

		$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.discount,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.product_rates as product_rates,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_gst_invoice  a
left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(product_rate SEPARATOR ',<br/>') AS product_rates, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_gst_invoice_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id
left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND d.delete_status!='0' and  a.billing_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_id='" . $customer_id . "'";

	}


} else {
	$sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,b.product_id as product_id,b.product_rates as product_rates,b.qty as qty,b.rate as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,a.billing_date as raw_billing_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_gst_invoice  a
left join (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(product_rate SEPARATOR ',<br/>') AS product_rates, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_gst_invoice_details WHERE delete_status!='0' GROUP BY dc_id) b on b.dc_id=a.dc_id
left join  tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' AND d.delete_status!='0'";
}

// Search filter
if (!empty($requestData['search']['value'])) {
    $searchValue = mysqli_real_escape_string($conn, $requestData['search']['value']);

    if (stripos($sql, 'WHERE') === false) {
        $sql .= " WHERE ( a.dc_no  LIKE '%".$searchValue."%' OR d.customer_name LIKE '%".$searchValue."%')";
    } else {
        $sql .= " AND ( a.dc_no  LIKE '%".$searchValue."%' OR d.customer_name LIKE '%".$searchValue."%')";
    }
}


// print_r($sql);
//$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

//$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY a.billing_date DESC, b.dc_id DESC 
        LIMIT ".$requestData['start']." ,".$requestData['length'];
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

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
	$nestedData[] = str_replace("^","'",(string)($row["billing_date"] ?? '')). $days_badge;
	$nestedData[] = str_replace("^","'",(string)($row["dc_no"] ?? ''));
	$nestedData[] = '<a href="gst_invoice_preview.php?id='.$row['dc_id'].'"><span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",(string)($row["customer_name"] ?? '')).'<br> '.str_replace("^","'",(string)($row["mblno"] ?? '')).'</span></a>';

	$v_disp = trim((string)($row["vechicle_number"] ?? ''));
	if ($v_disp === '' && !empty($row["vechicle_id"])) {
		$gql_vechicle = "SELECT vechicle_name FROM tbl_vechicle_details where delete_status!='0' and vechicle_id='".mysqli_real_escape_string($conn, $row["vechicle_id"])."' ";
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
		$nestedData[] = '<span  style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",$excess).'</span>';
	} else {
		$nestedData[] = '-';
	}

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",(string)($row["product_rates"] ?? '')).'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",(string)($row["qty"] ?? '')).'</span>';

	
	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",(string)($row["rate"] ?? '')).'</span>';

	// Live totals: recompute from detail lines so grid never shows stale stored math.
	$live_rates = array_map('floatval', explode(",<br/>", (string)($row["rate"] ?? '')));
	$live_total = round(array_sum($live_rates), 2);
	$live_cgst = (float)($row["cgst"] ?? 0);
	$live_sgst = (float)($row["sgst"] ?? 0);
	$live_discount = (float)($row["discount"] ?? 0);
	$live_gst = round($live_total * ($live_cgst + $live_sgst) / (100 + $live_cgst + $live_sgst), 2);
	$live_grand = round($live_total - $live_discount, 2);

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.number_format($live_gst, 2, '.', '').'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.number_format($live_discount, 2, '.', '').'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.number_format($live_grand, 2, '.', '').'</span>';	
	

    $nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>
						<a href='gst_invoice_preview.php?id=".$row['dc_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;
						<a href='gst_invoice_edit_details.php?id=".$row['dc_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;background: green'><i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i></button></a>&nbsp;
						
						<a href='javascript:void(0)' class='gstinvoicedeleteTriger' data-value='".$row['dc_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;'>
							<i class='fa fa-trash' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
						</button></a>&nbsp;

						<a target='_blank' href='gst_invoice_download_preview.php?id=".$row['customer_id']."' class='gstinvoiceddownloadTriger' ><button type='button' class='btn btn-primary' style='padding:4px 5px; 5px; 2px;'>
							<i class='fa fa-download' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
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
	