<?php
header('Access-Control-Allow-Origin: *');
	//include connection file 
	include_once("sessionservices1.php");
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


$sql = "SELECT a.order_id,a.order_no,a.customer_id,c.customer_name,date_format(a.order_date,'%d/%m/%Y') as order_date,date_format(a.delivery_date,'%d/%m/%Y') as delivery_date,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date ,a.created_by,a.updated_by FROM tbl_order a inner join tbl_order_details b on a.order_id=b.order_id inner join tbl_customer c on a.customer_id=c.customer_id where a.delete_status!='0' and b.delete_status!='0' and c.delete_status!='0'";


// print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( a.order_id LIKE '".$requestData['search']['value']."%' )";   
	
}

$sql.=" group by a.order_id order by a.order_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();
$dc_id='';
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array


	

	$nestedData=array(); 

		$nestedData[] = "#".$i ;

		if($row['order_date']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = str_replace("^","'",$row["order_date"]);
		}

		if($row['delivery_date']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = str_replace("^","'",$row["delivery_date"]);
		}

		if($row['order_no']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = str_replace("^","'",$row["order_no"]);
		}

		if($row['customer_name']==''){
			$nestedData[] = "-";
		}
		else{
			$nestedData[] = str_replace("^","'",$row["customer_name"]);
		}
	
		$sql1="SELECT * FROM tbl_non_dc WHERE delete_status!='0' and order_id='".$row['order_id']."'";
		$exec_sql1=mysqli_query($conn,$sql1);
		$fetch_sql1=mysqli_fetch_array($exec_sql1);


		if(($fetch_sql1['order_id'] ?? '')==$row['order_id']){

			$nestedData[] = '<span class="btn btn-success" style="padding:6px 8px;margin-right:5px; color:black"> Completed </span>';
			

		}
		else{

			$nestedData[] = "<a href='non_order_sales_add_details.php?id=".$row['order_id']."'><button type='button' class='btn btn-warning' style='padding:6px 8px;margin-right:5px; color:white'>
			Convert
		</button></a>";	
			
		}


		

		

	
		/*// $nestedData[] = "<img src='userdata/images/banner/".str_replace("^","'",$row["imgname"])."' style='width:100px'>";
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
		}*/


		if(($fetch_sql1['order_id'] ?? '')==$row['order_id']){

			$sql2="SELECT * FROM tbl_non_dc WHERE delete_status!='0' and order_id='".$row['order_id']."'";
		$exec_sql2=mysqli_query($conn,$sql2);
		$fetch_sql2=mysqli_fetch_array($exec_sql2);
		 $dc_id=($fetch_sql2['dc_id'] ?? '');

			$nestedData[] = "<div class='btn-group' role='group' aria-label='Basic example'>

			<a href='non_sales_preview.php?id=".$dc_id."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;

			<a href='order_update.php?id=".$row['order_id']."'><button type='button' class='btn btn-success' style='padding:6px 8px;margin-right:5px'>
																		<i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
																	</button></a>
			<a href='javascript:void(0)' class='orderdeleteTriger' data-value='".$row['order_id']."'><button type='button' class='btn btn-danger' style='padding:6px 8px;'>
																		<i class='fa fa-trash' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
																	</button></a>
																</div>";
		
		}
		else{


			
		

			$nestedData[] = "<div class='btn-group' role='group' aria-label='Basic example'>
			

			<a href='order_update.php?id=".$row['order_id']."'><button type='button' class='btn btn-success' style='padding:6px 8px;margin-right:5px'>
																		<i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
																	</button></a>
			<a href='javascript:void(0)' class='orderdeleteTriger' data-value='".$row['order_id']."'><button type='button' class='btn btn-danger' style='padding:6px 8px;'>
																		<i class='fa fa-trash' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
																	</button></a>
																</div>";
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
	