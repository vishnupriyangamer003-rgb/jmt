<?php
  error_reporting(0);
  header('Access-Control-Allow-Origin: *');
  include_once("connection.php");

  require_once '../PHPExcel-1.8/Classes/PHPExcel.php';
  require_once '../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
  

  $from_dt = $_REQUEST['from_dt']; 
  $to_dt   = $_REQUEST['to_dt'];
  $depart   = $_REQUEST['depart'];
  
  $fdt = explode('/',$from_dt);

  $num_signle1= sprintf("%02d",  $fdt[2]);
  $fd =$num_signle1;
//   $fd = $fdt[2];
  $tdt = explode('/',$to_dt);
  
    
  $origin = new DateTime($from_dt);
  $target = new DateTime($to_dt);
  
  $interval = $origin->diff($target);
  $day_cnt = $interval->d; 
  
  if($depart==5){
	 // checking
	 
	$j=0;
	$objPHPExcel = new PHPExcel();
	for($i=0;$i<=$day_cnt;$i++){
	
		$fd =sprintf("%02d",  $fd);
		
		if($j>0){
			$objPHPExcel->createSheet();
		}
		// echo $fd."<br>";
		$objPHPExcel->setActiveSheetIndex($j)->mergeCells('A1:L1');
		$objPHPExcel->getActiveSheet()->setTitle($fd);
		
	    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  
	    $styleArray = array(
	   'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FF0000'),
			'size'  => 15,
			'name'  => 'Verdana',
			'height'=> 50 
		));      
	    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray);
	
		$row =1;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'PACKING REPORT');

		 $row =3;
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'S.No');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'Employee Name');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'PO');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'Subwork');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'Product & Size & Color');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, 'Target');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, 'Completed Pcs');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, 'Price');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, 'Total Wages');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, 'Actual Wages');  
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, 'Wages Paid');  
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, 'Difference');
		 //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, 'Total');
				  
		
		  
		$row =4;
		$sno =1;
		// $num_signle= sprintf("%02d", $fd);
		 $from_dt_1 = $fdt[0].'-'.$fdt[1].'-'.$fd;
		
		
		$grand_tot_act = 0;
		$grand_tot_wages_paid = 0;
		$grand_tot_diff = 0;
		$diff_wages=0;
		 $sql = "select tbl_packing.emp_id,tbl_employee_details.emp_name from tbl_packing_working_details left join tbl_packing on tbl_packing.packing_id=tbl_packing_working_details.packing_id left join tbl_employee_details ON tbl_employee_details.emp_id=tbl_packing.emp_id  where tbl_packing_working_details.create_date LIKE '$from_dt_1%' group by emp_id";
		
		$emp_tot_actwages = 0;
		$query=mysqli_query($conn,$sql);
		$emp_cnt = 0;
		while($row_query=mysqli_fetch_array($query)){
				$emp_id = $row_query['emp_id'];
				$emp_nam = $row_query['emp_name'];
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $sno++);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $emp_nam);


				$sql_1 = "SELECT tbl_packing.packing_id,tbl_packing.emp_id,tbl_employee_details.emp_name, tbl_packing_details.packing_details_id,tbl_packing.po_no,tbl_products.product_name as prod_id, tbl_packing_details.product_id,tbl_size.size as size,tbl_color.color_id as color_id, tbl_color.color as color, tbl_packing_details.target,tbl_employee_details.daily_wages,tbl_subdepartment.sub_department FROM tbl_packing_working_details INNER JOIN tbl_packing ON tbl_packing_working_details.packing_id=tbl_packing.packing_id INNER JOIN  tbl_packing_details ON tbl_packing.packing_id =  tbl_packing_details.packing_id INNER JOIN tbl_products ON tbl_products.product_id = tbl_packing_details.product_id    INNER JOIN tbl_size ON tbl_size.size_id = tbl_packing_details.sizeid INNER JOIN tbl_color ON tbl_color.color_id = tbl_packing_details.color_id    LEFT JOIN tbl_subdepartment ON tbl_subdepartment.sub_department_id = tbl_packing.sub_department_id  LEFT JOIN tbl_employee_details ON  tbl_employee_details.emp_id=tbl_packing.emp_id where  tbl_packing_details.delete_status='NDL' and tbl_packing.delete_status='NDL' and tbl_packing_working_details.create_date LIKE '$from_dt_1%' and tbl_employee_details.emp_id=$emp_id and tbl_employee_details.department_id=5 group by tbl_packing_working_details.packing_id, tbl_packing_details.product_id";		
				$query_1=mysqli_query($conn,$sql_1); //tbl_products_details
				
				$row_1 = $row;
				$k=1;
				
				$emp_row = mysqli_num_rows($query_1); //echo "EMP_ROW ".
					
				$wages =0;
			
				while($row_query_1=mysqli_fetch_array($query_1)){
			
					$wages_paid = $row_query_1['daily_wages'];	
					$gql1 = "select a.product_id,a.sizeid,b.sub_department_id from tbl_packing_details a inner join tbl_packing b on a.packing_id=b.packing_id and a.packing_id='" . $row_query_1['packing_id'] . "' and  a.delete_status='NDL' and b.delete_status='NDL'";
					$exec_gql1 = mysqli_query($conn, $gql1);
				
					while ($fetch_gql1 = mysqli_fetch_array($exec_gql1)) {
						
							$gql4 = "select rate as  fab_checking_rate,per_product  from tbl_packing_details where find_in_set('".$row_query_1['product_id']."',product_id) <> 0  and   packing_id=" . $row_query_1['packing_id'] . "  and delete_status='NDL'";
							//  print_r($gql4);
							$exec_gql4 = mysqli_query($conn, $gql4);

							$actual_wages1=0;
						while ($fetch_gql4 = mysqli_fetch_array($exec_gql4)) {

							$gql5 = "select sum(completed_unit) as completed_unit,product_id from tbl_packing_working_details where find_in_set('".$row_query_1['product_id']."',product_id) <> 0   and packing_id=" . $row_query_1['packing_id'] . " and delete_status='NDL' and create_date LIKE '$from_dt_1%'";
							//   print_r($gql5);
							$exec_gql5 = mysqli_query($conn, $gql5);
							$work_completed_unit = 0;
							
							
							
								while ($fetch_gql5 = mysqli_fetch_array($exec_gql5)) {

									$work_completed_unit= $fetch_gql5['completed_unit'];
									
								
									$string=explode(",",$fetch_gql5['product_id']);
									$countofproduct=count($string);
								
									$total_product=$fetch_gql4['per_product']*$countofproduct;				

									$rate=$fetch_gql4['fab_checking_rate']/$total_product;
									// print_r($fetch_gql4['rate']);
							
									$completed_ubit=$fetch_gql4['per_product']*$work_completed_unit;
							
									$actual_wages1+=$completed_ubit * $rate;
								}
									
							// $actual_wages1+= $work_completed_unit * $fetch_gql4['fab_checking_rate'];
							// $rate =  $fetch_gql4['fab_checking_rate'];					
							
						}
						
					}
					
					$wages_paid = $row_query_1['daily_wages'];		
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $row_query_1['po_no']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $row_query_1['sub_department']); //process
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $row_query_1['prod_id'].' '.$row_query_1['size'].' '.$row_query_1['color_id']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $row_query_1['target']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $completed_ubit);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, number_format((float)$rate, 2, '.', ''));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, number_format((float)$completed_ubit*$rate, 2, '.', ''));			
				
					$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
					$wages +=$completed_ubit*$rate;
					if($k==$emp_row){	
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$row_1.':J'.$row)->getStyle('J'.$row_1.':J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$row_1.':K'.$row);
						$objPHPExcel->getActiveSheet()->mergeCells('L'.$row_1.':L'.$row);
						
						//$objPHPExcel->getActiveSheet();
						//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $emp_tot_actwages);
						
						$objPHPExcel->getActiveSheet()->getCell('J'.$row_1)->setValue($wages);
						$objPHPExcel->getActiveSheet()->getCell('K'.$row_1)->setValue($wages_paid);
						$objPHPExcel->getActiveSheet()->getCell('L'.$row_1)->setValue($wages-$wages_paid);
							
						$diff_wages = $wages-$wages_paid;
						
					}

				$row +=1;
				$k++;
				$emp_tot_actwages = $emp_tot_actwages+$actual_wages1; 
				

				}
				$grand_tot_act  += $wages;
				$grand_tot_wages_paid += $wages_paid;
				$grand_tot_diff  += $diff_wages;
				$emp_cnt++;	
		} 
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $emp_tot_actwages);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $grand_tot_act);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row,$grand_tot_wages_paid);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $grand_tot_diff);
		
		$next_row = $row+2;
		
		$objPHPExcel->getActiveSheet()->getCell('J'.$next_row)->setValue("No Of Employee");
		$objPHPExcel->getActiveSheet()->getCell('K'.$next_row)->setValue("Wages Paid");
		$objPHPExcel->getActiveSheet()->getCell('L'.$next_row)->setValue("Avg Wages");
		
		$next_row = $next_row+1;
		$objPHPExcel->getActiveSheet()->getCell('J'.$next_row)->setValue($emp_cnt);
		$objPHPExcel->getActiveSheet()->getCell('K'.$next_row)->setValue($grand_tot_wages_paid);
		$objPHPExcel->getActiveSheet()->getCell('L'.$next_row)->setValue(round($grand_tot_wages_paid/$emp_cnt));
		
		$j++;

		$num_padded = sprintf("%02d",$fd);
		$numberrrs=sprintf("%02d", 1);
		$numbergiven=$num_padded+$numberrrs;
		$fd= sprintf("%02d",$numbergiven);
		// $fd =1;
	}
	
	//FOR SUMMARY
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex($j);
	$objPHPExcel->getActiveSheet()->setTitle("TOTAL SUMMARY");
	$row =1;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'S.No');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'EMPLOYEE NAME');
	$title_row = 2;
	for($k=0;$k<=$day_cnt;$k++){
		
		$dt =sprintf("%02d",$fdt[2]).'-'.$fdt[1].'-'.$fdt[0];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($title_row, $row, $dt);
		$title_row++;
		$fdt[2] = sprintf("%02d",$fdt[2])+sprintf("%02d",1);
	}
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($title_row, $row, "TOTAL");
	
	// Total Employee details
	$fdt_2 = explode('/',$from_dt);
	$num_pad = sprintf("%02d", $fdt_2[2]);
	$num_pad_end = sprintf("%02d", $tdt[2]);
	$f_dt      = $fdt_2[0].'-'.$fdt_2[1].'-'.$num_pad;
	$to_date_1 = $tdt[0].'-'.$tdt[1].'-'.$num_pad_end;
	$row = 2;
	$sno =1; 
	
	$sql_emp = "select tbl_packing.emp_id,tbl_employee_details.emp_name from tbl_packing_working_details left join tbl_packing on tbl_packing.packing_id=tbl_packing_working_details.packing_id left join tbl_employee_details ON tbl_employee_details.emp_id=tbl_packing.emp_id  where tbl_packing_working_details.create_date between '$f_dt' and '$to_date_1' group by emp_id";
	$query_emp=mysqli_query($conn,$sql_emp);
	while($row_query_emp=mysqli_fetch_array($query_emp)){
		  $emp_id_1 = $row_query_emp['emp_id'];
		  $emp_nam_1 = $row_query_emp['emp_name'];
		
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $sno++);
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $emp_nam_1);
		  $title_column = 2;
		  $fdat_3 = explode('/',$from_dt);
		
		  $col =1; 
		  $tot_wages_1 =0;
		  $tot_wages = 0;
		for($tk=0;$tk<=$day_cnt;$tk++){

			//echo "DAY CNY .".$tk; echo '</br>';
			$num_padded = sprintf("%02d", $fdat_3[2]);
		  $dt_2 = $fdat_3[0].'-'.$fdat_3[1].'-'.$num_padded;
		//   print_r($dt_2."<br>");
		  
		
		 
	 	//  $sql_2 = "SELECT tbl_packing.packing_id,tbl_packing.emp_id,tbl_packing_details.product_id,tbl_packing.po_no,tbl_packing_working_details.completed_unit,tbl_employee_details.daily_wages FROM tbl_packing_working_details INNER JOIN tbl_packing ON tbl_packing_working_details.packing_id=tbl_packing.packing_id LEFT JOIN tbl_packing_details ON tbl_packing.packing_id = tbl_packing_details.packing_id LEFT JOIN tbl_employee_details ON  tbl_employee_details.emp_id=tbl_packing.emp_id where tbl_packing_details.delete_status='NDL' and tbl_packing.delete_status='NDL' and tbl_packing_working_details.create_date LIKE '$dt_2%' and tbl_employee_details.emp_id=$emp_id_1 and tbl_employee_details.department_id=5 group by tbl_packing_working_details.packing_id,tbl_packing_details.product_id";


		  $sql_2 = "SELECT tbl_packing.packing_id,tbl_packing.emp_id,tbl_employee_details.emp_name, tbl_packing_details.packing_details_id,tbl_packing.po_no,tbl_products.product_name as prod_id, tbl_packing_details.product_id,tbl_size.size as size,tbl_color.color_id as color_id, tbl_color.color as color, tbl_packing_details.target,tbl_employee_details.daily_wages,tbl_subdepartment.sub_department FROM tbl_packing_working_details INNER JOIN tbl_packing ON tbl_packing_working_details.packing_id=tbl_packing.packing_id INNER JOIN  tbl_packing_details ON tbl_packing.packing_id =  tbl_packing_details.packing_id INNER JOIN tbl_products ON tbl_products.product_id = tbl_packing_details.product_id    INNER JOIN tbl_size ON tbl_size.size_id = tbl_packing_details.sizeid INNER JOIN tbl_color ON tbl_color.color_id = tbl_packing_details.color_id    LEFT JOIN tbl_subdepartment ON tbl_subdepartment.sub_department_id = tbl_packing.sub_department_id  LEFT JOIN tbl_employee_details ON  tbl_employee_details.emp_id=tbl_packing.emp_id where  tbl_packing_details.delete_status='NDL' and tbl_packing.delete_status='NDL' and tbl_packing_working_details.create_date LIKE '$dt_2%' and tbl_employee_details.emp_id=$emp_id_1 and tbl_employee_details.department_id=5 group by tbl_packing_working_details.packing_id, tbl_packing_details.product_id";		
		 $query_2 = mysqli_query($conn,$sql_2);
		 $wages2=0;
		 $rate=0;
		 $actual_wages1=0;
		 $work_completed_unit1 = 0;
		 while($fetch_2 = mysqli_fetch_array($query_2)){

			$wages_paid = $fetch_2['daily_wages'];
			 $gql2_1 = "select a.product_id,a.sizeid,b.sub_department_id from tbl_packing_details a inner join tbl_packing b on a.packing_id=b.packing_id and  a.packing_id='" . $fetch_2['packing_id'] . "' and  find_in_set('".$fetch_2['product_id']."',a.product_id) <> 0 and  a.delete_status='NDL' and b.delete_status='NDL'";
			$exec_gql2_1 = mysqli_query($conn, $gql2_1);
			
			while ($fetch_gql2_1 = mysqli_fetch_array($exec_gql2_1)) {

				$gql_4 = "select rate as  fab_checking_rate,per_product  from tbl_packing_details where find_in_set('".$fetch_gql2_1['product_id']."',product_id) <> 0  and   packing_id=" . $fetch_2['packing_id'] . "  and delete_status='NDL'";
			
				
					$exec_gql2_4 = mysqli_query($conn, $gql_4);
				
				

				while ($fetch_gql2_4 = mysqli_fetch_array($exec_gql2_4)) {

					$gql5_2= "select sum(completed_unit) as completed_unit,product_id from tbl_packing_working_details where find_in_set('".$fetch_gql2_1['product_id']."',product_id) <> 0   and packing_id=" . $fetch_2['packing_id'] . " and delete_status='NDL' and create_date LIKE '$dt_2%'";
		
					$exec_gql5_2= mysqli_query($conn, $gql5_2);
				
					while ($fetch_gql5_2 = mysqli_fetch_array($exec_gql5_2)) {

						$work_completed_unit1= $fetch_gql5_2['completed_unit'];
							
						
						$string=explode(",",$fetch_gql5_2['product_id']);
						$countofproduct=count($string);
					
						$total_product=$fetch_gql2_4['per_product']*$countofproduct;				

						$rate=$fetch_gql2_4['fab_checking_rate']/$total_product;
						// print_r($rate);
				
						$completed_ubit=$fetch_gql2_4['per_product']*$work_completed_unit1;
						// echo 'COM'.$completed_ubit; echo '</br>';	
						$actual_wages1+=$completed_ubit * $rate;
						$wages2+=$completed_ubit * $rate;
						
							
					}
					
				}	
				
			}
		
		}
		
		// 'WORK COM'.$wages2; echo '</br>';	
		if($actual_wages1!=0)
		{ 
			 $diff = $actual_wages1-$wages_paid;
			$tot_wages += $diff;
		}else{
			$tot_wages =0;			
		}
		 $tot_wages_1 += $tot_wages;
	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($title_column, $row,$tot_wages);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($title_column+1, $row,$tot_wages_1);			
			$num_padded = sprintf("%02d", $fdat_3[2]);
			$numberrrs=sprintf("%02d", 1);
			$numbergiven=$num_padded+$numberrrs;
			$fdat_3[2] = sprintf("%02d",$numbergiven);
		$title_column++;
	   
	}
	 $row++;
   }
	/***************  File NAME data  ********/
	$file_name =  date('d',strtotime($from_dt)).'-'.date('m',strtotime($from_dt)).'-'.date('Y',strtotime($from_dt)).'to'.date('d',strtotime($to_dt)).'-'.date('m',strtotime($to_dt)).'-'.date('Y',strtotime($to_dt)).'packing_detail';
	
	//$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
    
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	 //$objWriter->save('php://output'); 
				  
    $objWriter->save('../uploads/'.$file_name.'.xls');

    $filename_1 = $file_name.'.xls';

    $sql_3 = "INSERT INTO `tbl_report_download` (`file_name`) VALUES ('$filename_1')";
    $query=mysqli_query($conn,$sql_3);

    echo 'uploads/'.$file_name.'.xls';

  }
  ?>