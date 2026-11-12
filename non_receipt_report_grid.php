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
$sql = "SELECT e.dc_id ";
$sql.=" FROM  tbl_non_receipt  e WHERE  e.delete_status!='0' ";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

 
if (($_POST['cond'] ?? '') == "firstbind" || empty($_POST['cond'])) {

	$sql = "SELECT e.receipt_id,e.pay_amount,date_format(e.billing_date,'%d/%m/%Y') as billing_date,e.dc_no,e.payment_mode,e.bank_id,e.dc_id,a.customer_id,d.customer_name FROM tbl_non_receipt e left join tbl_non_dc a on e.dc_id=a.dc_id left join tbl_non_dc_details b on e.dc_id=b.dc_id left join tbl_customer d on a.customer_id=d.customer_id WHERE e.delete_status!='0'  ";

} else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate']));

	 $sql = "SELECT e.receipt_id,e.pay_amount,date_format(e.billing_date,'%d/%m/%Y') as billing_date,e.dc_no,e.payment_mode,e.bank_id,e.dc_id,a.customer_id,d.customer_name FROM tbl_non_receipt e left join tbl_non_dc a on e.dc_id=a.dc_id left join tbl_non_dc_details b on e.dc_id=b.dc_id left join tbl_customer d on a.customer_id=d.customer_id  WHERE e.delete_status!='0' and  e.billing_date between '" . $fdate . "' and '" . $tdate . "' ";
}

//$sql = "SELECT a.dc_id,d.customer_id,d.customer_name FROM tbl_non_dc  a inner join tbl_non_dc_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' ";

//$sql = "SELECT *,a.dc_id,a.dc_no,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,e.uom_id,e.uom_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.hsn_code SEPARATOR ',<br/>') as hsn_code,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_non_dc  a inner join tbl_non_dc_details b on a.dc_id=b.dc_id left join  tbl_uom e on e.uom_id=b.uom_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0'";


 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( (d.customer_name LIKE '%".$requestData['search']['value']."%' ) )";

}
$sql .= " GROUP BY e.receipt_id
          ORDER BY e.billing_date ASC, e.receipt_id ASC";
if (intval($requestData['length']) != -1) {
	$sql .= " LIMIT ".$requestData['start'].",".$requestData['length'];
}
// print_r($sql);
//$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

//$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


// $sql.=" group by e.receipt_id  ORDER BY e.receipt_id ASC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
//print_r($sql);

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$total_paid=0;
$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 


	/*$gql3 = "select sum(pay_amount) as paid from tbl_non_receipt a inner join tbl_non_dc b on a.dc_id=b.dc_id   where a.delete_status!='0'  and a.customer_id='".$row['customer_id']."' ";

		//$gql3 = "SELECT sum(pay_amount) as paid FROM tbl_non_receipt where delete_status!='0' and customer_id='".$row['customer_id']."' ";

		$exec_gql3 = mysqli_query($conn, $gql3);
		$fetch_gql3 = mysqli_fetch_array($exec_gql3);


		$gql4 = "SELECT sum(grand_total_amount) as total_amount FROM tbl_non_dc where delete_status!='0'    and customer_id='".$row['customer_id']."' ";

		$exec_gql4 = mysqli_query($conn, $gql4);
		$fetch_gql4 = mysqli_fetch_array($exec_gql4);*/

	
			
			

	$nestedData[] = "#".$i ;
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["billing_date"]).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["customer_name"]).'</span>';	
	
	

	//$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["dc_no"]).'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["pay_amount"]).'</span>';
	
	
	$total_paid=$total_paid+$row["pay_amount"];	
	
	$data[] = $nestedData;
	$i++;
}

	$nestedData1=array(); 
	$nestedData1[] = "Total";
	$nestedData1[] = '';
	$nestedData1[] = '';	
	$nestedData1[]='';
	//$nestedData1[]='';
	$nestedData1[]="<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;'>".$total_paid."</span>";

	$data[] = $nestedData1;




$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


?>
	