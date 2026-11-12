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
$sql = "SELECT a.purchase_id FROM tbl_purchase a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

$sql = "SELECT *,a.purchase_id,a.dc_no,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.supplier_id,d.supplier_name,e.uom_id,e.uom_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.hsn_code SEPARATOR ',<br/>') as hsn_code,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_purchase  a 
inner join tbl_purchase_details b on a.purchase_id=b.purchase_id 
left join  tbl_uom e on e.uom_id=b.uom_id 
left join  tbl_supplier d on d.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0'";


 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( c.product_id LIKE '%".$requestData['search']['value']."%' ) 
	OR (d.supplier_name LIKE '".$requestData['search']['value']."%' )";   

}
// print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.="group by b.purchase_id  order by b.purchase_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$product_list=explode(",<br/>",$row['product_id']);

	$excess=NULL;
//print_r($product_list);
		$excess.='';
		
		$j=0;
		foreach($product_list as $product){			
		
			$gql3 = "SELECT b.category_name,c.sub_category_name,m.design FROM tbl_products a left join  tbl_category b on b.category_id=a.category_id left join  tbl_sub_category c on c.sub_category_id=a.sub_category_id left join  tbl_design m on m.design_id=a.design left join  tbl_purchase_details d on d.product_id=a.product_id where a.delete_status!='0' and a.product_id='".$product."' and d.purchase_id=".$row['purchase_id']."";

			$exec_gql3 = mysqli_query($conn, $gql3);
			
			while ($fetch_gql3 = mysqli_fetch_array($exec_gql3)) {

				//$fetch_gql3["category_name"]."-".
				
				$excess.= $fetch_gql3["sub_category_name"]."-".$fetch_gql3["design"];
				
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
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["supplier_name"]).'</span>';	
	
	if($excess!=''){
	$nestedData[] = '<span  style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",$excess).'</span>';
	} else {
		$nestedData[] = '-';
	}

	$nestedData[] = str_replace("^","'",$row["dc_no"]);
	$nestedData[] = str_replace("^","'",$row["billing_date"]);

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["hsn_code"]).'</span>';

	
	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["rate"]).'</span>';
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round($row["grand_total_amount"], 2)).'</span>';	
	

    $nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>
						<a href='purchase_preview.php?id=".$row['purchase_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;
						<a href='purchase_edit_details.php?id=".$row['purchase_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;background: green'><i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i></button></a>&nbsp;
						
						<a href='javascript:void(0)' class='purchasedeleteTriger' data-value='".$row['purchase_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;'>
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
	