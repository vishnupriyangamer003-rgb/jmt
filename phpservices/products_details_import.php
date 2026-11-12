<?php
header('Access-Control-Allow-Origin: *');
include_once("connection.php");	
include_once("../sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
require_once '../phpspreadsheet/vendor/phpoffice/phpspreadsheet/src/Bootstrap.php';
   //require_once 'dompdf/autoload.inc.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
   //use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
$helper = new Sample();
	$inputFileType = 'Xlsx';
	$inputFileName = '../temp/' . $_POST['products_import_name'];

$final_dest='../userdata/products_imported_excel';
 if(is_dir( $final_dest)==FALSE){
	mkdir($final_dest,0777,TRUE);
}
copy('../temp/'.$_POST['products_import_name'],$final_dest.'/'.$_POST['products_import_name']);	
	
	$reader = IOFactory::createReader($inputFileType);
	$reader->setReadDataOnly(true);
	$spreadsheet = $reader->load('../userdata/products_imported_excel/' . $_POST['products_import_name']);

	$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
	$html="";
	$i =0;	
	$z =0;
 	$access='';
	$access_flag=0;
	 foreach ($sheetData as $key => $value) {
		if($key > 1){
			if(($value['A']=='PRODUCTSNAME')&&($value['B']=='DEPARTMENT')&&($value['C']=='SUBWORK')&&($value['D']=='RATE')){
				
				$access_flag=1;
				continue;
			}
			if($access_flag==0){
				$design=str_replace("'","^",$value['A']);
				$product_name=str_replace("'","^",$value['B']);
				$description=str_replace("'","^",$value['C']);

				$sql_design="select * from tbl_design where design='$design' and delete_status='NDL'";
				$query_design=mysqli_query($conn, $sql_design);
				$fetch_design=mysqli_fetch_array($query_design);

				if(!empty($fetch_design['design_id'])){
					$design_id=$fetch_design['design_id'];
				}
				else{
					$insert_design="insert into tbl_design (`design`,`created_by`,`create_date`) VALUES('".$design."','".$log."','".date('Y-m-d H:i:s')."')";
					$exec_query_design=mysqli_query($conn, $insert_design);
					$design_id = $conn->insert_id;
				}


				$aql="insert into tbl_products(design_id,product_name,description,created_by,create_date) values ('".$design_id."','".$product_name."','".$value['C']."','".$log."','".date('Y-m-d H:i:s')."')";
				$exec_aql=mysqli_query($conn, $aql);

				
			}
			else{
				$product_name=str_replace("'","^",$value['A']);
				$sql_product="select * from tbl_products where product_name='".$product_name."' and delete_status='NDL'";
				$query_product=mysqli_query($conn, $sql_product);
				$fetch_product=mysqli_fetch_array($query_product);
				if(!empty($fetch_product['product_id'])){
					$product_id=$fetch_product['product_id'];
				}		
				$department=str_replace("'","^",$value['B']);
				if($department=="Fabric Checking"){
					$department="Fabric&nbsp;Checking";
				}
				$sub_department=str_replace("'","^",$value['C']);
				$rate=str_replace("'","^",$value['D']);
			
				$sql_department="select * from tbl_department where department='$department' and delete_status='NDL'";
				$query_department=mysqli_query($conn, $sql_department);
				$fetch_department=mysqli_fetch_array($query_department);
				$department_id=$fetch_department['department_id'];
				// print_r($sql_department);
				$sql_subdepartment="select * from tbl_subdepartment where sub_department='$sub_department' and delete_status='NDL'";
				$query_subdepartment=mysqli_query($conn, $sql_subdepartment);
				$fetch_subdepartment=mysqli_fetch_array($query_subdepartment);
				if(!empty($fetch_subdepartment['sub_department_id'])){
					$sub_department_id=$fetch_subdepartment['sub_department_id'];
				}
				else{
					$sub_department_id=0;
				}
				$sql_details = "INSERT INTO tbl_products_details(product_id,department_id,sub_department_id,rate,created_by,create_date) VALUES('".$product_id."','".$department_id."','".$sub_department_id."','".$rate."','".$log."','".date('Y-m-d H:i:s')."')";
			
				$query_details=mysqli_query($conn, $sql_details);
			}
		}
	 }
	


	if(($exec_aql)&&($query_details)){
		$result=1;
	}
	else{
		$result=0;
	}

$json = array("op" =>$result,"access_flag"=>$access_flag,'SQL1'=>$sql_details,'SQl2'=>$aql);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
				
?>