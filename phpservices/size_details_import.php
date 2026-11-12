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
	$inputFileName = '../temp/' . $_POST['size_import_name'];

$final_dest='../userdata/size_imported_excel';
 if(is_dir( $final_dest)==FALSE){
	mkdir($final_dest,0777,TRUE);
}
copy('../temp/'.$_POST['size_import_name'],$final_dest.'/'.$_POST['size_import_name']);	
	
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
				
				$size=str_replace("'","^",$value['A']);
				/******************check the size************************** */
				$sql_size="select * from tbl_size where size='$size' and delete_status='NDL'";
				$query_size=mysqli_query($conn, $sql_design);
				// $fetch_design=mysqli_fetch_array($query_design);
				$count=mysqli_num_rows($query_design);
			
				if($count==0){
				
				$sql = "INSERT INTO tbl_size(size,created_by,create_date) VALUES('".$size."','".$log."','".date('Y-m-d H:i:s')."')";
				
				$query=mysqli_query($conn, $sql);
				}
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