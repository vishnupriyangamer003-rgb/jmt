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

// getting total number records without any search
$sql = "SELECT a.product_id FROM tbl_products a WHERE a.delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$production_sql_date='';
$dc_date='';
$dc_sql_date='';
if (($_POST['cond'] ?? '') == "firstbind") {

$sql = "SELECT a.product_id,a.product_name FROM tbl_products a  where a.delete_status!='0'";

$production_sql_date="";
$dc_date ="";




}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate'] ?? ''));
     $tdate = date('Y-m-d', strtotime(($_POST['tdate'] ?? '').' +1 day'));

	 $sql = "SELECT a.product_id,a.product_name FROM tbl_products a  where a.delete_status!='0'";
     
	 $production_sql_date=" and   a.production_date between '" . $fdate . "' and '" . $tdate . "'";

	 $dc_date =" and   a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

		
	//print_r($sql);

}
$dc_sql_date = $dc_date ?? '';

 // print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.product_name LIKE '%".$requestData['search']['value']."%' )";

}

$sql.=" group by a.product_id order by a.product_id  desc ";

$count_query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalFiltered = mysqli_num_rows($count_query);

if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$nestedData[] = "#".$i ;

		$dc_sql = "SELECT sum(b.qty) as dc_qty FROM  tbl_non_dc a inner join tbl_non_dc_details b on a.dc_id=b.dc_id  where b.product_id='".$row["product_id"]."'  and a.delete_status!='0' $dc_sql_date ";

		$dc_query=mysqli_query($conn, $dc_sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys4");
		$dc_row=mysqli_fetch_array($dc_query);


		

		$production_sql = "SELECT sum(a.qty) as production_qty FROM tbl_production_details a where a.delete_status!='0'  and a.product_id='".$row["product_id"]."' $production_sql_date ";

		//echo $gql31;
		$exec_gql31 = mysqli_query($conn, $production_sql);
		$fetch_gql31 = mysqli_fetch_array($exec_gql31);

			$excess1=$fetch_gql31['production_qty'];
			
		


		if($row['product_name']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["product_name"]).'</span>';
			
		}

		if($excess1==''){
			$nestedData[] = "-";
		}
		else{

			$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",$excess1).'</span>';
			
		}

		if($dc_row['dc_qty']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold;">'.str_replace("^","'",$dc_row["dc_qty"]).'</span>';
			
		}

		

		

			$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",$excess1-$dc_row["dc_qty"]).'</span>';
			
		

		

		


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
	