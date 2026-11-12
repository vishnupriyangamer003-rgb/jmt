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
$sql = "SELECT a.gate_pass_id FROM tbl_gate_pass a WHERE a.delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT a.gate_pass_id,c.customer_name,e.emp_name,v.vechicle_name,b.product_name,a.qty,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date ,a.created_by,a.updated_by FROM tbl_gate_pass a inner join tbl_products b on a.product_name=b.product_id inner join tbl_customer c on a.customer_name=c.customer_id inner join tbl_employee_details e on a.driver_name=e.emp_id left join tbl_vechicle_details v on a.vechicle_number=v.vechicle_id where a.delete_status!='0'";


 //print_r($sql);
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( c.customer_name LIKE '".$requestData['search']['value']."%' )";   
	
}
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" order by a.gate_pass_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 


	$nestedData[] = "#".$i ;
	if($row['customer_name']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["customer_name"]);
	}

	if($row['emp_name']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["emp_name"]);
	}
	
	if($row['vechicle_name']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["vechicle_name"]);
	}

	if($row['product_name']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["product_name"]);
	}

	if($row['qty']==''){
		$nestedData[] = "-";
	}
	else{
		$nestedData[] = str_replace("^","'",$row["qty"]);
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

    	$nestedData[] ="<div class='btn-group' role='group' aria-label='Basic example'>
		<a href='gate_pass_preview.php?id=".$row['gate_pass_id']."'><button type='button' class='btn btn-warning' style='padding:4px 5px; 5px; 2px;'><i class='fa fa-print' style='color: #fff;padding: 0;margin: 0;font-size: 18px;' aria-hidden='true'></i></button></a>&nbsp;
																	<a href='gate_pass_update.php?id=".$row['gate_pass_id']."'><button type='button' class='btn btn-success' style='padding:6px 8px;margin-right:5px'>
																		<i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
																	</button></a>
																	<a href='javascript:void(0)' class='deleteTriger' data-value='".$row['gate_pass_id']."'><button type='button' class='btn btn-danger' style='padding:6px 8px;'>
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
	