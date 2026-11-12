<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
	//include connection file 
	include_once("sessionservices.php");
	// include_once("header.php");
	 
	
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'title', 
	
		
	
);

$id=$_POST['id'] ?? '';
//print_r($id);
// getting total number records without any search
$sql = "SELECT a.purchase_id FROM tbl_raw_purchase a WHERE a.delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT a.id, b.qty as product_qty, a.qty as production_qty, date_format(a.production_date,'%d/%m/%Y') as billing_date FROM tbl_production_details a inner join tbl_product_details b on b.product_id=a.product_id where a.delete_status!='0' and b.delete_status!='0' and b.raw_material_id='$id' ";
if (($_POST['cond'] ?? '') == "firstbind") {

$sql = "SELECT b.qty as product_qty,a.qty as production_qty,date_format(a.production_date,'%d/%m/%Y') as billing_date FROM tbl_production_details a inner join  tbl_product_details b on b.product_id=a.product_id  where a.delete_status!='0' and b.delete_status!='0' and b.raw_material_id='$id' ";

//b.raw_material_id='".$row["id"]."'  and
//and   a.purchase_date between '" . $fdate . "' and '" . $tdate . "'

$purchase_sql_date="";
$gql31_date ="";




}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate'] ?? ''));
     $tdate = date('Y-m-d', strtotime(($_POST['tdate'] ?? '').' +1 day'));

	 $sql = "SELECT a.id,a.name,a.uom_id FROM tbl_raw_material a  where a.delete_status!='0'";
     
	 $purchase_sql_date=" and   a.purchase_date between '" . $fdate . "' and '" . $tdate . "'";

	 $gql31_date =" and   a.production_date between '" . $fdate . "' and '" . $tdate . "'";

		
	//print_r($sql);

}


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.id LIKE '".$requestData['search']['value']."%' )";   
	
}

$sql.=" group by a.id order by a.id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

 //print_r($sql);

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$nestedData[] = "#".$i ;

					
		
		$excess1= $row["product_qty"]*$row['production_qty'];



		if($row['billing_date']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["billing_date"]).'</span>';
			
		}
		


		if($excess1==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = $excess1;
			
		}		

		


				$i++;
				$data[] = $nestedData;
		}
	
					
	


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientsPrpty_Ide , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


?>
	