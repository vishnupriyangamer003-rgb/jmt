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
	$inputFileName = '../temp/' . $_POST['contractor_import_name'];

$final_dest='../userdata/contractor_imported_excel';
 if(is_dir( $final_dest)==FALSE){
	mkdir($final_dest,0777,TRUE);
}
copy('../temp/'.$_POST['contractor_import_name'],$final_dest.'/'.$_POST['contractor_import_name']);	
	
	$reader = IOFactory::createReader($inputFileType);
	$reader->setReadDataOnly(true);
	$spreadsheet = $reader->load($inputFileName);

	$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
	$html="";
	$i =0;
	
	// var_dump($sheetData);
	foreach ($sheetData as $key => $value) {
		if($key > 1){

			//$prod = mysqli_real_escape_string($conn,$value['A']);	 //coulmn A, b,c	
            //$box = $value['B'];
			if($value['A']!=''){
				$contractor_name=str_replace("'","^",$value['A']);
				$department=str_replace("'","^",$value['B']);
				if($department=="Fabric Checking"){
					$department="Fabric&nbsp;Checking";
				}
				$sql_department="select * from tbl_department where department='$department' and delete_status='NDL'";
				$query_department=mysqli_query($conn, $sql_department);
				$fetch_department=mysqli_fetch_array($query_department);
				$department_id=$fetch_department['department_id'];


				$mblno=str_replace("'","^",$value['C']);
				$email=str_replace("'","^",$value['D']);
				$address=str_replace("'","^",$value['E']);
				
				
				$sql = "INSERT INTO tbl_contractors(contractor_name,department,mblno,email,address,created_by,create_date) VALUES('".$contractor_name."','".$department_id."','".$mblno."','".$email."','".$address."','".$log."','".date('Y-m-d H:i:s')."')";
				
				$query=mysqli_query($conn, $sql);
			}

	    $i++;
	    }
	}
	if($query){
		$result=1;
	}
	else{
		$result=0;
	}

$json = array("op" =>$result);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json); 
				
?>