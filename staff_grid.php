<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
	include_once("sessionservices.php");
	 
	
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'name', 
	
		
	
);

// getting total number records without any search
$sql = "SELECT emp_id FROM tbl_employee_details WHERE delete_status!='0'";
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT a.emp_mblno,a.emp_email,a.*,date_format(a.emp_dob,'%d/%m/%Y') as dob,date_format(a.create_date,'%d/%m/%Y %h:%i:%s %p') as create_date,date_format(a.update_date,'%d/%m/%Y %h:%i:%s %p') as update_date FROM tbl_employee_details a   where  a.delete_status!='0'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND (a.emp_name LIKE '".$requestData['search']['value']."%' ";	
	$sql.=" OR a.emp_mblno LIKE '".$requestData['search']['value']."%')"; 
	
}
// print_r($sql);
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" order by a.emp_id  desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	if($row['update_date']!=''){
		if($row['updated_by']=='admin'){
			$nestedData[] = "<span data-toggle='tooltip' data-placement='top' title='' data-original-title='Updated by Admin on ".$row['update_date']."' style='cursor:pointer'>#".$i."</span>";
		}
		else{
			$gql="select emp_name from tbl_employee_details where delete_status!='0' and emp_code='".$row['updated_by']."'";
			$exec_gql=mysqli_query($conn,$gql);
			$fetch_gql=mysqli_fetch_array($exec_gql);
			$nestedData[] = "<span data-toggle='tooltip' data-placement='top' title='' data-original-title='Updated by ".$fetch_gql['emp_name']." on ".$row['update_date']."' style='cursor:pointer'>#".$i."</span>";
		}
	}
	else{
		if($row['created_by']=='admin'){
			$nestedData[] = "<span data-toggle='tooltip' data-placement='top' title='' data-original-title='Created by Admin on ".$row['create_date']."' style='cursor:pointer'>#".$i."</span>";
		}
		else{
			$gql="select emp_name from tbl_employee_details where delete_status!='0' and emp_code='".$row['created_by']."'";
			$exec_gql=mysqli_query($conn,$gql);
			$fetch_gql=mysqli_fetch_array($exec_gql);
			$nestedData[] = "<span data-toggle='tooltip' data-placement='top' title='' data-original-title='Created by ".$fetch_gql['emp_name']." on ".$row['create_date']."' style='cursor:pointer'>#".$i."</span>";
		}
	}
	//$nestedData[] = "#".$i ;
	
	$nestedData[] = "<span class='empnamedetailstrigger' data-emp_id='".$row['emp_id']."' data-emp_name='".$row['emp_name']."' style='cursor:pointer;'>".str_replace("^","'",$row["emp_name"])."</span>";
	

	$nestedData[] = str_replace("^","'",$row["emp_mblno"]);
	$nestedData[] = str_replace("^","'",$row["emp_email"]);

	$type_gql="select name from tbl_staff_type where id='".$row["emp_type"]."'";
	$type_exec_gql=mysqli_query($conn,$type_gql);
	$type_fetch_gql=mysqli_fetch_array($type_exec_gql);

	$nestedData[] = str_replace("^","'",$type_fetch_gql["name"]);

	$salary_gql="select name from tbl_staff_salary where id='".$row["emp_salary_type"]."'";
	$salary_exec_gql=mysqli_query($conn,$salary_gql);
	$salary_fetch_gql=mysqli_fetch_array($salary_exec_gql);

	$nestedData[] = str_replace("^","'",$salary_fetch_gql["name"]);

	
	if($row["active_status"]=='Y'){
		$nestedData[]="<a href='javascript:void(0)' class='btn btn-success statuschanger' data-value='Y' data-emp_id=".$row['emp_id']." style='padding:3px 5px;color: #fff'><b><i class='fa fa-check-square-o'></i>&nbsp;&nbsp;Active</b></a>";
	}
	else if($row['active_status']=='N'){
		$nestedData[]="<a href='javascript:void(0)' class='btn btn-danger statuschanger' data-value='N' data-emp_id=".$row['emp_id']." style='padding:3px 5px;color: #fff'><b><i class='fa  fa-exclamation-circle'></i>&nbsp;&nbsp;In-Active</b></a>";
	}
	
    $nestedData[] ='<td>
																<div class="btn-group" role="group" aria-label="Basic example">
																	<a href="staff_update.php?id='.$row['emp_id'].'" ><button type="button" class="btn btn-success" style="padding:3px 5px;margin-right:5px">
																		<i class="fa fa-edit" style="color: #fff;padding: 0;margin: 0;font-size: 14px;"></i>
																	</button></a>
																	<a href="javascript:void(0)" class="deleteTriger" data-value="'.$row['emp_id'].'"><button type="button" class="btn btn-danger" style="padding:3px 5px;">
																		<i class="fa fa-trash" style="color: #fff;padding: 0;margin: 0;font-size: 14px;"></i>
																	</button></a>
																</div>';
	
	
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
	