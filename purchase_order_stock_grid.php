<?php
header('Access-Control-Allow-Origin: *');
	include_once("phpservices/connection.php");
 
	
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'title', 
	
		
	
);

// getting total number records without any search
$sql = "SELECT stock_id FROM tbl_stock WHERE delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if (($_POST['cond'] ?? '') == "firstbind") {
	
	
	$sql = "SELECT a.product_id,d.design_id,d.design,e.sub_category_id,e.sub_category_name FROM tbl_products a left join  tbl_design d on d.design_id=a.design  
	left join  tbl_sub_category e on e.sub_category_id=a.sub_category_id  WHERE  a.delete_status!='0'";

//$sql = "SELECT a.*,sum(product_rate) as grand_total_amount,c.product_id,c.design,d.category_name,e.sub_category_name FROM tbl_stock  a inner join  tbl_stock_details b on b.stock_id=a.stock_id inner join  tbl_products c on c.product_id=b.product_id inner join  tbl_category d on d.category_id=c.category_id  inner join  tbl_sub_category e on e.sub_category_id=c.sub_category_id WHERE  a.delete_status!='0' and b.delete_status!='0' group by c.design,c.category_id,c.sub_category_id";

}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $stock_id = $_POST['stock_id'];
	
	if (($_POST['stock_id'] ?? '')=='') {
		
		$sql = "SELECT a.*,sum(product_rate) as grand_total_amount,c.product_id,c.design,d.category_name,e.sub_category_name FROM tbl_stock  a 
		inner join  tbl_stock_details b on b.stock_id=a.stock_id 
		inner join  tbl_products c on c.product_id=b.product_id
		left join  tbl_category d on d.category_id=c.category_id  
		left join  tbl_sub_category e on e.sub_category_id=c.sub_category_id WHERE  a.delete_status!='0' and b.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' group by b.product_id";
		
	}	
	else if (($_POST['stock_id'] ?? '')!='') {
		
		$sql = "SELECT a.*,sum(product_rate) as grand_total_amount,c.product_id,c.design,d.category_name,e.sub_category_name FROM tbl_stock  a 
		inner join  tbl_stock_details b on b.stock_id=a.stock_id 
		inner join  tbl_products c on c.product_id=b.product_id
		left join  tbl_category d on d.category_id=c.category_id  
		left join  tbl_sub_category e on e.sub_category_id=c.sub_category_id WHERE  a.delete_status!='0' and b.delete_status!='0' and  d.delete_status!='0' and a.billing_date between '" . $fdate . "' and '" . $tdate . "' and d.stock_id='" . $stock_id . "' group by b.product_id";
		
	}	 

	//print_r($sql);

}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( e.sub_category_name LIKE '%".$requestData['search']['value']."%' OR d.design LIKE '%".$requestData['search']['value']."%' )";
}

$sql.=" group by a.sub_category_id,a.design order by a.product_id   desc ";

$count_query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");
$totalFiltered = mysqli_num_rows($count_query);

if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}


//print_r($sql);

$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 



/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");
$total=0;
$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array


	$nestedData=array(); 


	$gql1="select sum(qty) as dc_count from tbl_dc_details where  model_id='".$row['sub_category_id']."' and design_id='".$row['design_id']."' and delete_status!='0'";
	$exec_gql1=mysqli_query($conn,$gql1);
	$fetch_gql1=mysqli_fetch_array($exec_gql1);


	$gql2="select sum(qty) as stock_count,product_rate from tbl_stock_details where  model_id='".$row['sub_category_id']."' and design_id='".$row['design_id']."' and delete_status!='0'";
	$exec_gql2=mysqli_query($conn,$gql2);
	$fetch_gql2=mysqli_fetch_array($exec_gql2);

	

	$gql3="select sum(qty) as purchase_count,product_rate from tbl_purchase_details where  model_id='".$row['sub_category_id']."' and design_id='".$row['design_id']."' and delete_status!='0'";
	$exec_gql3=mysqli_query($conn,$gql3);
	$fetch_gql3=mysqli_fetch_array($exec_gql3);

	$total= ($fetch_gql2["stock_count"]+$fetch_gql3["purchase_count"])-$fetch_gql1["dc_count"];

	$nestedData[] = "#".$i;

	

	//$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["category_id"]).'</span>';

	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["sub_category_name"]).'</span>';

	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.str_replace("^","'",$row["design"]).'</span>';
	
	$nestedData[] = '<span  style="font-size: 13px;color: red;font-weight: bold;text-transform: uppercase;">'.$total.'</span>';

	if(!empty($fetch_gql3["product_rate"])){
		$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.$fetch_gql3["product_rate"]*$total.'</span>';
	}else{
		$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.$fetch_gql2["product_rate"]*$total.'</span>';
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
	