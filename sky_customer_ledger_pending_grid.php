<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');

// Recursively replace any byte sequence that isn't valid UTF-8 so json_encode() never
// fails outright on legacy latin1-collated customer data (works on any PHP version,
// unlike the JSON_INVALID_UTF8_SUBSTITUTE flag which needs PHP >= 7.2).
function sky_pending_ledger_utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = sky_pending_ledger_utf8ize($value);
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
        return preg_replace('/[\x80-\xFF]/', '', $mixed);
    }
    return $mixed;
}

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
$sql = "SELECT a.dc_id FROM tbl_sky_gst_invoice a WHERE a.delete_status!='0'";
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




$sql="SELECT * FROM ( SELECT 
    
    
    a.customer_id,
    c.customer_name,
    IFNULL(SUM(paid_data.paid), 0) AS paid,
    IFNULL(SUM(total_data.total_amount), 0) AS total_amount,
    IFNULL(SUM(total_data.total_amount), 0) - IFNULL(SUM(paid_data.paid), 0) AS balance

FROM tbl_sky_gst_invoice a

-- Join customer
LEFT JOIN tbl_customer c
    ON c.customer_id = a.customer_id

-- Pre-aggregated payments per dc_id
LEFT JOIN (
    SELECT dc_id, SUM(pay_amount) AS paid
    FROM tbl_sky_receipt
    WHERE delete_status!='0' AND billing_date < DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
    GROUP BY dc_id
) AS paid_data ON paid_data.dc_id = a.dc_id

-- Pre-aggregated totals per dc_id
LEFT JOIN (
    SELECT dc_id, SUM(grand_total_amount) AS total_amount
    FROM tbl_sky_gst_invoice
    WHERE delete_status!='0' AND billing_date < DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
    GROUP BY dc_id
) AS total_data ON total_data.dc_id = a.dc_id

WHERE a.delete_status != '0' AND a.billing_date < DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
-- An invoice must still have at least one non-deleted detail line. This used to be an
-- INNER JOIN to tbl_sky_gst_invoice_details, but that duplicates this row once per
-- detail line, which then double(or more)-counts total_amount/paid/balance for any
-- invoice with more than one product line. EXISTS filters the same way without
-- duplicating rows.
AND EXISTS (
    SELECT 1 FROM tbl_sky_gst_invoice_details b
    WHERE b.dc_id = a.dc_id AND b.delete_status != '0'
)
$name_search

GROUP BY  a.customer_id, c.customer_name
ORDER BY c.customer_name ASC )	AS derived
WHERE derived.balance > 0";

/*if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$name_search =" AND (d.customer_name LIKE '".$requestData['search']['value']."%' )";   

}else{
	$name_search =""; 

}

$sql="SELECT * FROM ( SELECT 
    
    a.dc_id,
    d.customer_id,
    d.customer_name,
    
   
    IFNULL((
        SELECT SUM(nr.pay_amount)
        FROM tbl_sky_receipt nr
        WHERE nr.delete_status!='0'
          AND nr.customer_id = a.customer_id
    ), 0) AS paid,
    
   
    IFNULL((
        SELECT SUM(ndc.grand_total_amount)
        FROM tbl_sky_gst_invoice ndc
        WHERE ndc.delete_status!='0'
          AND ndc.customer_id = a.customer_id
    ), 0) AS total_amount,
    
    
    (
        IFNULL((
            SELECT SUM(ndc.grand_total_amount)
            FROM tbl_sky_gst_invoice ndc
            WHERE ndc.delete_status!='0'
              AND ndc.customer_id = a.customer_id
        ), 0)
        -
        IFNULL((
            SELECT SUM(nr.pay_amount)
            FROM tbl_sky_receipt nr
            WHERE nr.delete_status!='0'
              AND nr.customer_id = a.customer_id
        ), 0)
    ) AS balance

FROM tbl_sky_gst_invoice a
INNER JOIN tbl_sky_gst_invoice_details b ON a.dc_id = b.dc_id
LEFT JOIN tbl_customer d ON d.customer_id = a.customer_id

WHERE 
    a.delete_status != '0'
    AND b.delete_status != '0' 
    AND a.billing_date < DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) $name_search  group by d.customer_id order by d.customer_name  ASC
)	AS derived  WHERE derived.balance > 0
";


//$sql = "SELECT a.dc_id,d.customer_id,d.customer_name FROM  tbl_sky_gst_invoice  a inner join tbl_sky_gst_invoice_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' AND a.billing_date < DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)";

//$sql = "SELECT *,a.dc_id,a.dc_no,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.customer_id,d.customer_name,e.uom_id,e.uom_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.hsn_code SEPARATOR ',<br/>') as hsn_code,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_gst_invoice  a inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id left join  tbl_uom e on e.uom_id=b.uom_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0'";*/


/* //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( d.customer_id LIKE '%".$requestData['search']['value']."%' ) 
	OR (d.customer_name LIKE '".$requestData['search']['value']."%' )";   

}
// print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.="group by a.customer_id  order by b.dc_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";*/

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$total_amount='0';
$total_paid='0';
$total_balance='0';

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		//$gql3 = "SELECT sum(pay_amount) as paid FROM tbl_non_receipt where delete_status!='0' and customer_id='".$row['customer_id']."' ";

		/*$gql3 = "select sum(pay_amount) as paid from tbl_sky_receipt a inner join tbl_sky_gst_invoice b on a.dc_id=b.dc_id   where a.delete_status!='0' and b.convert_id!='' and a.customer_id='".$row['customer_id']."' ";
		$exec_gql3 = mysqli_query($conn, $gql3);
		$fetch_gql3 = mysqli_fetch_array($exec_gql3);


		$gql4 = "SELECT sum(grand_total_amount) as total_amount FROM tbl_sky_gst_invoice where delete_status!='0'  and customer_id='".$row['customer_id']."' ";

		$exec_gql4 = mysqli_query($conn, $gql4);
		$fetch_gql4 = mysqli_fetch_array($exec_gql4);*/
			
	



  
    
	$nestedData[] = "#".$i ;
	
	$nestedData[] = '<a href="sky_ledger_preview.php?id='.$row['customer_id'].'"><span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["customer_name"]).'</span></a>';	
	
	
	

    $nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["total_amount"]).'</span>';
    
    $nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["paid"]).'</span>';

    // $nestedData[] = "<a href='non_receipt_edit_details.php?id=".$row['customer_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;background: red'>".$balance."</button></a>";

    $nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["balance"]).'</span>';	
    

    //$nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>						<a href='ledger_preview.php?id=".$row['customer_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;</div>";

    $total_amount=$total_amount+$row["total_amount"];
    $total_paid=$total_paid+$row["paid"];
    $total_balance=$total_balance+$row["balance"];
	
	
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

echo json_encode(sky_pending_ledger_utf8ize($json_data));  // send data as json format


?>
	