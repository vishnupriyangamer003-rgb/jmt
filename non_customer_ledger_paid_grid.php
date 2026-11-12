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
$sql = "SELECT a.dc_id FROM  tbl_non_dc  a 
inner join tbl_non_dc_details b on a.dc_id=b.dc_id 
left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' AND a.billing_date >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) group by a.customer_id ";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;



if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$name_search =" AND (c.customer_name LIKE '%".$requestData['search']['value']."%' )";   

}else{
	$name_search =""; 

}

if (!empty($_POST['week_ww_yyyy'])) {
    $week = $_POST['week_ww_yyyy']; // e.g., "2025-W29"
    
    // Convert to Monday of the week
    $date = new DateTime();
    $date->setISODate(substr($week, 0, 4), substr($week, 6)); // year, week
    $start_date = $date->format('Y-m-d'); // Monday

    // Get end of week (Sunday)
    $end_date = $date->modify('+6 days')->format('Y-m-d');

    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
} else {
    // Default to current week
    $start_date = date('Y-m-d', strtotime('monday this week'));
    $end_date = date('Y-m-d'); // Up to today
    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
}

$sql = "
SELECT 
    
    
    a.customer_id,
    c.customer_name,
    IFNULL(SUM(paid_data.paid), 0) AS paid,
    IFNULL(SUM(total_data.total_amount), 0) AS total_amount,
    IFNULL(SUM(total_data.total_amount), 0) - IFNULL(SUM(paid_data.paid), 0) AS balance

FROM tbl_non_dc a

LEFT JOIN tbl_customer c
    ON c.customer_id = a.customer_id

LEFT JOIN (
    SELECT dc_id, SUM(pay_amount) AS paid
    FROM tbl_non_receipt
    WHERE delete_status!='0'
      AND billing_date BETWEEN '$start_date' AND '$end_date'
    GROUP BY dc_id
) AS paid_data ON paid_data.dc_id = a.dc_id

LEFT JOIN (
    SELECT dc_id, SUM(grand_total_amount) AS total_amount
    FROM tbl_non_dc
    WHERE delete_status!='0'
      AND billing_date BETWEEN '$start_date' AND '$end_date'
    GROUP BY dc_id
) AS total_data ON total_data.dc_id = a.dc_id

WHERE a.delete_status!='0' AND c.delete_status!='0'
-- A quotation must still have at least one non-deleted detail line. This used to be an
-- INNER JOIN to tbl_non_dc_details, but that duplicates this row once per detail line,
-- which then double(or more)-counts total_amount/paid/balance for any quotation with
-- more than one product line. EXISTS filters the same way without duplicating rows.
AND EXISTS (
    SELECT 1 FROM tbl_non_dc_details b
    WHERE b.dc_id = a.dc_id AND b.delete_status!='0'
)
$where_date $name_search

GROUP BY  a.customer_id, c.customer_name
ORDER BY c.customer_name ASC
";

/*$sql="SELECT 
    
    
    a.customer_id,
    c.customer_name,
    IFNULL(SUM(paid_data.paid), 0) AS paid,
    IFNULL(SUM(total_data.total_amount), 0) AS total_amount,
    IFNULL(SUM(total_data.total_amount), 0) - IFNULL(SUM(paid_data.paid), 0) AS balance

FROM tbl_non_dc a

-- Join with non_dc_details to filter only valid rows
INNER JOIN tbl_non_dc_details b 
    ON a.dc_id = b.dc_id AND b.delete_status!='0'

-- Join customer
LEFT JOIN tbl_customer c 
    ON c.customer_id = a.customer_id

-- Pre-aggregated payments per dc_id
LEFT JOIN (
    SELECT dc_id, SUM(pay_amount) AS paid
    FROM tbl_non_receipt
    WHERE delete_status!='0' AND billing_date >=  DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) 
    GROUP BY dc_id
) AS paid_data ON paid_data.dc_id = a.dc_id

-- Pre-aggregated totals per dc_id
LEFT JOIN (
    SELECT dc_id, SUM(grand_total_amount) AS total_amount
    FROM tbl_non_dc
    WHERE delete_status!='0' AND billing_date >=  DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) 
    GROUP BY dc_id
) AS total_data ON total_data.dc_id = a.dc_id

WHERE a.delete_status!='0' AND c.delete_status!='0' AND a.billing_date >=  DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)  $name_search
-- Include $name_search here if applicable

GROUP BY  a.customer_id, c.customer_name
ORDER BY c.customer_name ASC";*/



$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$total_amount='0';
$total_paid='0';
$total_balance='0';

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	/*$gql3 = "select sum(pay_amount) as paid from tbl_non_receipt a inner join tbl_non_dc b on a.dc_id=b.dc_id   where a.delete_status!='0' and a.customer_id='".$row['customer_id']."' ";

		//$gql3 = "SELECT sum(pay_amount) as paid FROM tbl_non_receipt where delete_status!='0' and customer_id='".$row['customer_id']."' ";

		$exec_gql3 = mysqli_query($conn, $gql3);
		$fetch_gql3 = mysqli_fetch_array($exec_gql3);


		$gql4 = "SELECT sum(grand_total_amount) as total_amount FROM tbl_non_dc where delete_status!='0' and customer_id='".$row['customer_id']."'   ";

		$exec_gql4 = mysqli_query($conn, $gql4);
		$fetch_gql4 = mysqli_fetch_array($exec_gql4);*/
			
	

	


	$nestedData[] = "#".$i ;
	
	$nestedData[] = '<a href="non_receipt_preview.php?id='.$row['customer_id'].'"><span style="font-size: 15px;color: #16a34a;font-weight: bold;">'.htmlspecialchars(str_replace("^","'",$row["customer_name"]), ENT_QUOTES, 'UTF-8').'</span></a>';	
	


	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["total_amount"]).'</span>';
	
	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["paid"]).'</span>';

    //$nestedData[] = "<a href='non_receipt_edit_details.php?id=".$row['customer_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;background: red'>".$row["balance"]."</button></a>";

	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",($row["balance"])).'</span>';	
	

    $total_amount=$total_amount+$row["total_amount"];
	$total_paid=$total_paid+$row["paid"];
	$total_balance=$total_balance+$row["balance"];

    //$nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>						<a href='ledger_preview.php?id=".$row['customer_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;</div>";
	
	
	$data[] = $nestedData;
	$i++;
}

$nestedData1=array(); 
	$nestedData1[] = "Total";
	$nestedData1[] = '';
	$nestedData1[] = '';	
	$nestedData1[] = '';	
	
	$nestedData1[]="<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;'>".$total_amount."</span>";
	$nestedData1[]="<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;'>".$total_paid."</span>";
	$nestedData1[]="<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;'>".$total_balance."</span>";
	$nestedData1[]='';
	$data[] = $nestedData1;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


?>
	