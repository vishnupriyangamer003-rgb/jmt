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
$sql = "SELECT a.purchase_id FROM tbl_raw_purchase a WHERE a.delete_status!='0'";
// echo $sql;
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
//  echo $totalData;

$sql = "SELECT *,a.purchase_id,a.dc_no,a.total_amount,a.grand_total_amount,d.supplier_id,d.supplier_name,group_concat(b.uom_id SEPARATOR ',<br/>') as uom_id,group_concat(b.qty SEPARATOR ',<br/>') as qty,group_concat(b.raw_material_id SEPARATOR ',<br/>') as raw_material_id,group_concat(b.hsn_code SEPARATOR ',<br/>') as hsn_code,group_concat(b.rate_tax SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_raw_purchase  a 
inner join tbl_raw_purchase_details b on a.purchase_id=b.purchase_id 
left join  tbl_uom e on e.uom_id=b.uom_id 
left join  tbl_supplier d on d.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0'";


 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.purchase_id LIKE '%".$requestData['search']['value']."%' ) 
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

	
	$product_list=explode(",<br/>",$row['raw_material_id']);

		$excess=NULL;
		$excess.='';
		
		$j=0;
		foreach($product_list as $product){			
		
			$gql3 = "SELECT * FROM tbl_raw_material where delete_status!='0' and id='".$product."' ";

			$exec_gql3 = mysqli_query($conn, $gql3);
			
			//$fetch_gql3["category_name"]."-".
			
			while ($fetch_gql3 = mysqli_fetch_array($exec_gql3)) {
				$excess.= $fetch_gql3["name"];
				
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



		$uom_list=explode(",<br/>",$row['uom_id']);

		$excess1=NULL;
		$excess1.='';
		
		$j=0;
		foreach($uom_list as $uom){			
		
			$gql3 = "SELECT * FROM tbl_uom where delete_status!='0' and uom_id='".$uom."' ";

			$exec_gql3 = mysqli_query($conn, $gql3);
			
			//$fetch_gql3["category_name"]."-".
			
			while ($fetch_gql3 = mysqli_fetch_array($exec_gql3)) {
				$excess1.= $fetch_gql3["uom_name"];
				
			}
			
			//print_r($excess);

			if(!empty($excess1)){
				$excess1.="<br>";
				
			
			}
			else{
				$excess1.='';
				
			}

		$j++;
		}

	$nestedData[] = "#".$i ;
	$nestedData[] = str_replace("^","'",$row["billing_date"]);
	$nestedData[] = str_replace("^","'",$row["dc_no"]);
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["supplier_name"]).'</span>';		

	if($excess!=''){
		$nestedData[] = '<span  style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",$excess).'</span>';
	} else {
		$nestedData[] = '-';
	}
	
	
	

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["hsn_code"]).'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$excess1).'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["qty"]).'</span>';
	
	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["rate"]).'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",round($row["grand_total_amount"], 2)).'</span>';

	$paid='0';
	
	$gql3 = "SELECT sum(pay_amount) as paid FROM tbl_payment where delete_status!='0' and purchase_id='".$row['purchase_id']."' ";

	$exec_gql3 = mysqli_query($conn, $gql3);
	$fetch_gql3 = mysqli_fetch_array($exec_gql3);
	
	if($fetch_gql3['paid']==0){

		$nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>
						<a href='raw_material_purchase_preview.php?id=".$row['purchase_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;
						<a href='raw_material_purchase_edit_details.php?id=".$row['purchase_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;background: green'><i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i></button></a>&nbsp;
						
						<a href='javascript:void(0)' class='raw_material_purchasedeleteTriger' data-value='".$row['purchase_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;'>
							<i class='fa fa-trash' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
						</button></a>
					</div>";

		
	}else{

		$nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>
						<a href='raw_material_purchase_preview.php?id=".$row['purchase_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;
						<a href='raw_material_purchase_edit_details.php?id=".$row['purchase_id']."'><button type='button' class='btn btn-danger' style='padding:4px 5px; 5px; 2px;background: green'><i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i></button></a>
					</div>";
		
	}


    
	
	
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
	