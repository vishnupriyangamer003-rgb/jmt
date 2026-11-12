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


$sql = "SELECT a.purchase_id, b.uom_id, b.total_qty, date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_raw_purchase a inner join tbl_raw_purchase_details b on b.purchase_id=a.purchase_id where a.delete_status!='0' and b.raw_material_id='$id' ";
if (($_POST['cond'] ?? '') == "firstbind") {

$sql = "SELECT b.uom_id,b.total_qty,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_raw_purchase a inner join  tbl_raw_purchase_details b on b.purchase_id=a.purchase_id  where a.delete_status!='0' and b.raw_material_id='$id' ";

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

		//$purchase_sql = "SELECT sum(b.qty) as purchase_qty FROM  tbl_raw_purchase a inner join tbl_raw_purchase_details b on a.purchase_id=b.purchase_id  where b.raw_material_id='".$row["id"]."'  and a.delete_status!='0' and   a.purchase_date between '" . $fdate . "' and '" . $tdate . "' ";

		//$gql31 = "SELECT sum(a.qty) as product_qty,sum(b.qty) as production_qty FROM tbl_production_details a inner join tbl_product_details b on a.product_id=b.product_id where a.delete_status!='0' and b.delete_status!='0' and b.raw_material_id='".$row["id"]."' and  a.production_date between '" . $fdate . "' and '" . $tdate . "' ";


		
		

	//print_r($sql);

}


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.purchase_id LIKE '".$requestData['search']['value']."%' )";   
	
}

$sql.=" group by a.purchase_id order by a.purchase_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

 //print_r($sql);

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$nestedData[] = "#".$i ;

		/*$purchase_sql = "SELECT sum(b.total_qty) as purchase_qty FROM  tbl_raw_purchase a inner join tbl_raw_purchase_details b on a.purchase_id=b.purchase_id  where b.raw_material_id='".$row["id"]."'  and a.delete_status!='0' $purchase_sql_date ";

		$purchase_query=mysqli_query($conn, $purchase_sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys4");
		$purchase_row=mysqli_fetch_array($purchase_query);


		
		//echo $purchase_sql;

		$gql31 = "SELECT sum(a.qty) as product_qty,sum(b.qty) as production_qty FROM tbl_production_details a inner join tbl_product_details b on a.product_id=b.product_id where a.delete_status!='0' and b.delete_status!='0' and b.raw_material_id='".$row["id"]."' $gql31_date ";

		//echo $gql31;

		$exec_gql31 = mysqli_query($conn, $gql31);
		$fetch_gql31 = mysqli_fetch_array($exec_gql31);

		$excess1= $fetch_gql31["product_qty"]*$fetch_gql31['production_qty'];*/
			
		
		$uom_sql = "SELECT * FROM  tbl_uom   where uom_id='".$row["uom_id"]."' and delete_status!='0'";

		$uom_query=mysqli_query($conn, $uom_sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys4");
		$uom_row=mysqli_fetch_array($uom_query);



		if($row['billing_date']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["billing_date"]).'</span>';
			
		}

		
		if($uom_row['uom_name']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold;">'.str_replace("^","'",$uom_row['uom_name']).'</span>';
			
		}


		if($row['total_qty']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold;"><a href="javascript:void(0)" class="innerid" id="color_add_but" data-toggle="modal" data-target="#exampleModalCenter6" data-dc_id='.$row["total_qty"].'>'.str_replace("^","'",$row["total_qty"]).'</a></span>';
			
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
	