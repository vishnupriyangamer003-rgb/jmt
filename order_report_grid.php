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
$sql = "SELECT order_id FROM tbl_order WHERE delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if (($_POST['cond'] ?? '') == "firstbind") {

$sql = "SELECT a.order_id,a.order_no,a.customer_id,c.customer_name,c.mblno,date_format(a.order_date,'%d/%m/%Y') as order_date,date_format(a.delivery_date,'%d/%m/%Y') as delivery_date,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date ,a.created_by,a.updated_by FROM tbl_order a inner join tbl_order_details b on a.order_id=b.order_id inner join tbl_customer c on a.customer_id=c.customer_id where a.delete_status!='0' and b.delete_status!='0'";



}
else if (($_POST['cond'] ?? '') == "searchbind") {

     $fdate = date('Y-m-d', strtotime($_POST['fdate']));
     $tdate = date('Y-m-d', strtotime($_POST['tdate'].' +1 day'));
     $customer_id = $_POST['customer_id'];
	
	if (($_POST['customer_id'] ?? '')=='') {
		
		$sql = "SELECT a.order_id,a.order_no,a.customer_id,c.customer_name,c.mblno,date_format(a.order_date,'%d/%m/%Y') as order_date,date_format(a.delivery_date,'%d/%m/%Y') as delivery_date,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date ,a.created_by,a.updated_by FROM tbl_order a inner join tbl_order_details b on a.order_id=b.order_id inner join tbl_customer c on a.customer_id=c.customer_id where a.delete_status!='0' and b.delete_status!='0' and  a.order_date between '" . $fdate . "' and '" . $tdate . "' ";

		
		
	}	
	else if (($_POST['customer_id'] ?? '')!='') {
		
		$sql = "SELECT a.order_id,a.order_no,a.customer_id,c.customer_name,c.mblno,date_format(a.order_date,'%d/%m/%Y') as order_date,date_format(a.delivery_date,'%d/%m/%Y') as delivery_date,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date ,a.created_by,a.updated_by FROM tbl_order a inner join tbl_order_details b on a.order_id=b.order_id inner join tbl_customer c on a.customer_id=c.customer_id where a.delete_status!='0' and b.delete_status!='0' and  a.order_date between '" . $fdate . "' and '" . $tdate . "' and a.customer_id='" . $customer_id . "' ";

		
		
	}	 

	//print_r($sql);

}

// print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.order_no LIKE '%".$requestData['search']['value']."%' OR c.customer_name LIKE '%".$requestData['search']['value']."%' )";

}

$sql.=" group by a.order_id order by a.order_id  desc ";

$count_query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalFiltered = mysqli_num_rows($count_query);

if (intval($requestData['length']) != -1) {
	$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$nestedData[] = "#".$i ;

		if($row['order_date']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["order_date"]).'</span>';
			
		}

		if($row['delivery_date']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold;">'.str_replace("^","'",$row["delivery_date"]).'</span>';
			
		}

		if($row['order_no']==''){
			$nestedData[] = "-";
		}
		else{

			$nestedData[] = '<span  style="font-size: 15px;color: green;font-weight: bold;">'.str_replace("^","'",$row["order_no"]).'</span>';
			
		}

		if($row['customer_name']==''){
			$nestedData[] = "-";
		}
		else{

			$nestedData[] = '<span  style="font-size: 15px;color: blue;font-weight: bold;">'.str_replace("^","'",$row["customer_name"].'</br>'.$row["mblno"]).'</span>';
			
		}


		// $nestedData[] = "<img src='userdata/images/banner/".str_replace("^","'",$row["imgname"])."' style='width:100px'>";
		if($row['update_date']!=''){
			if($row['updated_by']=='admin' || $row['updated_by']=='Admin' || $row['updated_by']=='1'){
				$nestedData[]='<span class="badge badge-info">Updated by Admin  on '.$row['update_date'].'</span>';
			}
			else{
				$gql="select emp_name from tbl_employee_details where delete_status!='0' and emp_code='".$row['updated_by']."'";
				$exec_gql=mysqli_query($conn,$gql);
				$fetch_gql=mysqli_fetch_array($exec_gql);
				$nestedData[]='<span class="badge badge-info">Updated by '.$fetch_gql['emp_name'].' on '.$row['create_date'].'</span>';
			}
		}
		else{
			if($row['created_by']=='admin' || $row['created_by']=='Admin' || $row['created_by']=='1'){
				$nestedData[]='<span class="badge badge-success">Created by Admin on '.$row['create_date'].'</span>';
			}
			else{
				$gql="select emp_name from tbl_employee_details where delete_status!='0' and emp_code='".$row['created_by']."'";
				$exec_gql=mysqli_query($conn,$gql);
				$fetch_gql=mysqli_fetch_array($exec_gql);
				$nestedData[]='<span class="badge badge-success">Created by '.$fetch_gql['emp_name'].' on '.$row['create_date'].' </span>';
			}
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
	