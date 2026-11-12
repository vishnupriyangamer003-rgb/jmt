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
	$inputFileName = '../temp/' . $_POST['colors_import_name'];

$final_dest='../userdata/colors_imported_excel';
 if(is_dir( $final_dest)==FALSE){
	mkdir($final_dest,0777,TRUE);
}
copy('../temp/'.$_POST['colors_import_name'],$final_dest.'/'.$_POST['colors_import_name']);	
	
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
				$color=str_replace("'","^",$value['A']);
				/******************check the color************************** */
				$sql_color="select * from tbl_color where color='$color' and delete_status='NDL'";
				$query_color=mysqli_query($conn, $sql_color);
				// $fetch_design=mysqli_fetch_array($query_design);
				$count=mysqli_num_rows($query_color);
			
				if($count==0){
				$sql = "INSERT INTO tbl_color(color,created_by,create_date) VALUES('".$color."','".$log."','".date('Y-m-d H:i:s')."')";
				
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