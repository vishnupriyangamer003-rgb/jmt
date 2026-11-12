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
	$inputFileName = '../temp/' . $_POST['purchase_order_importname'];

$final_dest='../userdata/purchseorder_imported_excel';
 if(is_dir( $final_dest)==FALSE){
	mkdir($final_dest,0777,TRUE);
}
copy('../temp/'.$_POST['purchase_order_importname'],$final_dest.'/'.$_POST['purchase_order_importname']);	
	
	$reader = IOFactory::createReader($inputFileType);
	$reader->setReadDataOnly(true);
	$spreadsheet = $reader->load('../userdata/purchseorder_imported_excel/' . $_POST['purchase_order_importname']);

	$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
	$html="";
	$i =0;
	
	// var_dump($sheetData);
	foreach ($sheetData as $key => $value) {
		$curdate=date('Y-m-d H:i:s');
			//$prod = mysqli_real_escape_string($conn,$value['A']);	 //coulmn A, b,c	
            //$box = $value['B'];
			if($key == 2){
				$warehouse=$value['A'];
				$sql_warehouse="select * from tbl_warehouse where warehouse='".trim($warehouse)."' and delete_status='NDL'";
				$query_warehouse=mysqli_query($conn, $sql_warehouse);
				$fetch_warehouse=mysqli_fetch_array($query_warehouse);				


				if(!empty($fetch_warehouse['warehouse_id'])){
					$warehouse_id=$fetch_warehouse['warehouse_id'];
				}
				else{
					$insert_warehouse="insert into tbl_warehouse (`warehouse`,`created_by`,`create_date`) VALUES('".$warehouse."','".$log."','".$curdate."')";
					$exec_query_warehouse=mysqli_query($conn, $insert_warehouse);

					$warehouse_id = $conn->insert_id;
				}



				$po_no=$value['B'];
				$buyercode=$value['C'];
				$podate = ($value['D'] - 25569) * 86400;
				$po_date=gmdate("Y-m-d H:i:s", $podate);
				$workorderdate = ($value['E'] - 25569) * 86400;
				$work_order_date=gmdate("Y-m-d H:i:s", $workorderdate);
				$salesorderdate = ($value['F'] - 25569) * 86400;
				$sales_order_date=gmdate("Y-m-d H:i:s", $salesorderdate);
				$fabricenddate = ($value['G'] - 25569) * 86400;
				$fabric_end_date=gmdate("Y-m-d H:i:s", $fabricenddate);
				$aql="insert into tbl_fabric_purchase(warehouse_id,po_no,buyer_code,po_date,work_order_date,sales_order_date,fabric_end_date,work_order_no,created_by,create_date) values ('".$warehouse_id."','".$value['B']."','".$value['C']."','".$po_date."','".$work_order_date."','".$sales_order_date."','".$fabric_end_date."','".$value['H']."','".$log."','".date('Y-m-d H:i:s')."')";
				$exec_aql=mysqli_query($conn, $aql);
				if($exec_aql){
					$bql="select * from tbl_fabric_purchase where delete_status='NDL' order by purchase_id desc";
					$exec_bql=mysqli_query($conn,$bql);
					$fetch_bql=mysqli_fetch_array($exec_bql);
					$last_purchase_id=$fetch_bql['purchase_id'];
				}
			}
				
				if($key > 5){
					 $product_name=str_replace("'","^",$value['B']);
					 $design=str_replace("'","^",$value['C']);				
					 $color=str_replace("'","^",$value['D']);
					 $size=str_replace("'","^",$value['E']);
				
					$quantity=str_replace("'","^",$value['F']);
				
					
					 $unit=str_replace("'","^",$value['G']);
			
					 $description=str_replace("'","^",$value['H']);
			
					

					$sql_design="select * from tbl_design where design='$design' and delete_status='NDL'";
					$query_design=mysqli_query($conn, $sql_design);
					$fetch_design=mysqli_fetch_array($query_design);

					if(!empty($fetch_design['design_id'])){
						$design_id=$fetch_design['design_id'];
					}
					else{
						$insert_design="insert into tbl_design (`design`,`created_by`,`create_date`) VALUES('".$design."','".$log."','".$curdate."')";
						$exec_query_design=mysqli_query($conn, $insert_design);

						$design_id = $conn->insert_id;

					}
					$sql_size="select * from tbl_size where size='$size' and delete_status='NDL'";
					$query_size=mysqli_query($conn, $sql_size);
					$fetch_size=mysqli_fetch_array($query_size);
				
					if(!empty($fetch_size['size_id'])){
						$size_id=$fetch_size['size_id'];
					}
					else{
						$insert_size="insert into tbl_size (`size`,`created_by`,`create_date`) VALUES('".$size."','".$log."','".$curdate."')";
						$exec_query_size=mysqli_query($conn, $insert_size);

						$size_id = $conn->insert_id;

					

					}

					$sql_product="select * from tbl_products where product_name='$product_name' and delete_status='NDL'";
					$query_product=mysqli_query($conn, $sql_product);
					$fetch_product=mysqli_fetch_array($query_product);
					if(!empty($fetch_product['product_id'])){
						$product_id=$fetch_product['product_id'];
					}
					else{
						$insert_product="insert into tbl_products (`product_name`,`design_id`,`size_id`,`created_by`,`create_date`) VALUES('".$product_name."','".$design_id."','".$size_id."','".$log."','".date('Y-m-d H:i:s')."')";
						$exec_query_product=mysqli_query($conn, $insert_product);

						$last_product_id = $conn->insert_id;
						// print_r($insert_product);

						$product_id = $conn->insert_id;
						if($exec_query_product){
							$sql_department="select * from tbl_department where  delete_status='NDL'";
							$query_department=mysqli_query($conn, $sql_department);
							while($fetch_department=mysqli_fetch_array($query_department)){
								$department_id=$fetch_department['department_id'];
	
								$sql_subdepartment="select * from tbl_subdepartment where department_id='$department_id' and delete_status='NDL'";
								$query_subdepartment=mysqli_query($conn, $sql_subdepartment);
								$rate='1';
								$rows=mysqli_num_rows($query_subdepartment);
								
								if($rows>0){
									while($fetch_subdepartment=mysqli_fetch_array($query_subdepartment)){
								
										$sub_department_id=$fetch_subdepartment['sub_department_id'];

																	
										$sql_insert_prd = "INSERT INTO tbl_products_details(product_id,department_id,sub_department_id,rate,created_by,create_date) VALUES('".$last_product_id."','".$department_id."','".$sub_department_id."','".$rate."','".$log."','".date('Y-m-d H:i:s')."')";
										$query_insert_prd=mysqli_query($conn, $sql_insert_prd);
									}
								}
								else{
									$sub_department_id=0;
											
									$sql_insert_prd = "INSERT INTO tbl_products_details(product_id,department_id,sub_department_id,rate,created_by,create_date) VALUES('".$last_product_id."','".$department_id."','".$sub_department_id."','".$rate."','".$log."','".date('Y-m-d H:i:s')."')";
									$query_insert_prd=mysqli_query($conn, $sql_insert_prd);

								}
														
								
								
							}
						}	

					}


				

					$sql_color="select * from tbl_color where color='$color' and delete_status='NDL'";
					$query_color=mysqli_query($conn, $sql_color);
					$fetch_color=mysqli_fetch_array($query_color);				


					if(!empty($fetch_color['color_id'])){
						$color_id=$fetch_color['color_id'];
					}
					else{
						$insert_color="insert into tbl_color (`color`,`created_by`,`create_date`) VALUES('".$color."','".$log."','".$curdate."')";
						$exec_query_color=mysqli_query($conn, $insert_color);

						$color_id = $conn->insert_id;


					}

				$sql_unit="select * from tbl_unit where unitname='$unit' and delete_status='NDL'";
				$query_unit=mysqli_query($conn, $sql_unit);
				$fetch_unit=mysqli_fetch_array($query_unit);
				
				if(!empty($fetch_unit['id'])){
					$unit_id=$fetch_unit['id'];

				}
				else{
					$insert_unit="insert into tbl_unit (unit,`created_by`,`create_date`) VALUES(".$unit.",'".$log."','".$curdate."')";
					$exec_query_unit=mysqli_query($conn, $insert_unit);

					$unit_id = $conn->insert_id;
					
				}
			
				




					$sql = "INSERT INTO tbl_fabric_purchase_details(purchase_id,product_id,design_id,color_id,sizeid,quantity,unitid,description,created_by,create_date) VALUES('".$last_purchase_id."','".$product_id."','".$design_id."','".$color_id."','".$size_id."','".$quantity."','".$unit_id."','".$description."','".$log."','".date('Y-m-d H:i:s')."')";
					
					$query=mysqli_query($conn, $sql);
				
				}
	    $i++;
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