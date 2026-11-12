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
$sql = "SELECT a.id FROM tbl_production_details a WHERE a.delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if (($_POST['cond'] ?? '') == "firstbind") {
	
	
	$sql = "SELECT *,a.id,a.production_no,a.product_id,a.operator_id,a.qty,group_concat(b.labour_id SEPARATOR ',<br/>') as labour_id,group_concat(c.start_time SEPARATOR ',<br/>') as start_time,group_concat(c.end_time SEPARATOR ',<br/>') as end_time,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.production_date,'%d/%m/%Y') as production_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_production_details  a 
	inner join tbl_production_labour_details b on a.id=b.production_id
	inner join tbl_production_shift_details c on a.id=c.production_id 
	left join  tbl_employee_details e on e.emp_id=b.labour_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and  c.delete_status!='0'";

//$sql = "SELECT a.*,sum(product_rate) as grand_total_amount,c.product_id,c.design,d.category_name,e.sub_category_name FROM tbl_stock  a inner join  tbl_stock_details b on b.stock_id=a.stock_id inner join  tbl_products c on c.product_id=b.product_id inner join  tbl_category d on d.category_id=c.category_id  inner join  tbl_sub_category e on e.sub_category_id=c.sub_category_id WHERE  a.delete_status!='0' and b.delete_status!='0' group by c.design,c.category_id,c.sub_category_id";

}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $operator_id = $_POST['operator_id'];
	
	if (($_POST['operator_id'] ?? '')=='') {
		
		$sql = "SELECT *,a.id,a.production_no,a.product_id,a.operator_id,a.qty,group_concat(b.labour_id SEPARATOR ',<br/>') as labour_id,group_concat(c.start_time SEPARATOR ',<br/>') as start_time,group_concat(c.end_time SEPARATOR ',<br/>') as end_time,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.production_date,'%d/%m/%Y') as production_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_production_details  a 
	inner join tbl_production_labour_details b on a.id=b.production_id
	inner join tbl_production_shift_details c on a.id=c.production_id 
	left join  tbl_employee_details e on e.emp_id=b.labour_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and  c.delete_status!='0' and a.production_date between '" . $fdate . "' and '" . $tdate . "' ";

		
		
	}	
	else if (($_POST['operator_id'] ?? '')!='') {
		
		$sql = "SELECT *,a.id,a.production_no,a.product_id,a.operator_id,a.qty,group_concat(b.labour_id SEPARATOR ',<br/>') as labour_id,group_concat(c.start_time SEPARATOR ',<br/>') as start_time,group_concat(c.end_time SEPARATOR ',<br/>') as end_time,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.production_date,'%d/%m/%Y') as production_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_production_details  a 
	inner join tbl_production_labour_details b on a.id=b.production_id
	inner join tbl_production_shift_details c on a.id=c.production_id 
	left join  tbl_employee_details e on e.emp_id=b.labour_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and  c.delete_status!='0' and a.production_date between '" . $fdate . "' and '" . $tdate . "' and a.operator_id='" . $operator_id . "' ";

		
		
	}	 

	//print_r($sql);

}



if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.production_no LIKE '%".$requestData['search']['value']."%' )";

}

$sql.="group by a.id  order by a.id  desc ";

$count_query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");
$totalFiltered = mysqli_num_rows($count_query);

if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

//print_r($sql);
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");
$total=0;
$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array


	$nestedData=array(); 
/*$product_list=explode(",<br/>",$row['product_id']);

		$excess=NULL;
		$excess.='';
		
		$j=0;
		foreach($product_list as $product){			
		
			$gql3 = "SELECT b.category_name,c.sub_category_name,m.design FROM tbl_products a left join  tbl_category b on b.category_id=a.category_id left join  tbl_sub_category c on c.sub_category_id=a.sub_category_id left join  tbl_design m on m.design_id=a.design left join  tbl_production_details d on d.product_id=a.product_id where a.delete_status!='0' and a.product_id='".$product."' and d.production_id=".$row['production_id']."";

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
		}*/

		
		$pro_gql3 = "SELECT product_name FROM tbl_products where delete_status!='0' and product_id='".$row["product_id"]."' ";
		//print_r($gql3);	
		$pro_exec_query3=mysqli_query($conn, $pro_gql3);
		$pro_rows=mysqli_fetch_array($pro_exec_query3);


		$ope_gql3 = "SELECT emp_name FROM tbl_employee_details where delete_status!='0' and emp_id='".$row["operator_id"]."' ";
		//print_r($gql3);	
		$ope_exec_query3=mysqli_query($conn, $ope_gql3);
		$ope_rows=mysqli_fetch_array($ope_exec_query3);


	$nestedData[] = "#".$i ;
	$nestedData[] = str_replace("^","'",$row["production_date"]);
	$nestedData[] = str_replace("^","'",$row["production_no"]);
	$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",($ope_rows["emp_name"] ?? '')).'</span>';	
	
	$nestedData[] = '<span  style="font-size: 15px;color: #000;font-weight: bold">'.str_replace("^","'",($pro_rows["product_name"] ?? '')).'</span>';

	$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold">'.str_replace("^","'",$row["qty"]).'</span>';
	
	
	
	
		
	
	
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
	