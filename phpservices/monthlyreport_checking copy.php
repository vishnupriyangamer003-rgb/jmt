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
  $fd = $fdt[2];
  
  $tdt = explode('/',$to_dt);
  
    
  $origin = new DateTime($from_dt);
  $target = new DateTime($to_dt);
  
  $interval = $origin->diff($target);
  $day_cnt = $interval->d; 
  
  if($depart==4){
	 // checking
	 
	$j=0;
	$objPHPExcel = new PHPExcel();
	for($i=0;$i<=$day_cnt;$i++){
		// For every sheet
		//echo "ROW : ".$i."DAY :".$fd;
		
		if($j>0){
			$objPHPExcel->createSheet();
		}
		
		$objPHPExcel->setActiveSheetIndex($j)->mergeCells('A1:L1');
		$objPHPExcel->getActiveSheet()->setTitle("$fd");
		
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
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'CHECKING REPORT');

		 $row =3;
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'S.No');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'Employee Name');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'PO');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'Product & Size');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'Process');
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
		
		$from_dt_1 = $fdt[0].'-'.$fdt[1].'-'.$fd;
		
		
		$grand_tot_act = 0;
		$grand_tot_wages_paid = 0;
		$grand_tot_diff = 0;
				
		$sql = "select tbl_checking.emp_id,tbl_employee_details.emp_name from tbl_checking_working_details left join tbl_checking on tbl_checking.checking_id=tbl_checking_working_details.checking_id left join tbl_employee_details ON tbl_employee_details.emp_id=tbl_checking.emp_id  where tbl_checking_working_details.create_date LIKE '$from_dt_1%' group by emp_id";
		
		$emp_tot_actwages = 0;
		$query=mysqli_query($conn,$sql);
		$emp_cnt = 0;
		while($row_query=mysqli_fetch_array($query)){
		  $emp_id = $row_query['emp_id'];
		  $emp_nam = $row_query['emp_name'];
		  
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $sno++);
		  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $emp_nam);


		$sql_1 = "SELECT tbl_checking.checking_id,tbl_checking.emp_id,tbl_employee_details.emp_name,tbl_checking_details.checking_details_id,tbl_checking.po_no,tbl_checking_details.product_name as prod_id,tbl_checking_details.product_id,tbl_checking_details.size as size,tbl_checking_details.target,tbl_employee_details.daily_wages FROM tbl_checking_working_details LEFT JOIN tbl_checking ON tbl_checking_working_details.checking_id=tbl_checking.checking_id LEFT JOIN tbl_checking_details
ON tbl_checking.checking_id = tbl_checking_details.checking_id LEFT JOIN tbl_employee_details ON  tbl_employee_details.emp_id=tbl_checking.emp_id where tbl_checking_details.delete_status='NDL' and tbl_checking.delete_status='NDL' and tbl_checking_working_details.create_date LIKE '$from_dt_1%' and tbl_employee_details.emp_id=$emp_id and tbl_employee_details.department_id=4 group by tbl_checking_working_details.checking_id,tbl_checking_details.product_id";

		
		$query_1=mysqli_query($conn,$sql_1); //tbl_products_details
		
		$row_1 = $row;
		$k=1;
		$emp_row = mysqli_num_rows($query_1); //echo "EMP_ROW ".
		
		
		while($row_query_1=mysqli_fetch_array($query_1)){
			/*******************complted unit***************** */
			
			$gql3 = "SELECT sum(completed_unit) as completed_unit,target FROM tbl_checking_working_details where delete_status='NDL' and po_no='".$row_query_1['po_no'] ."' and checking_id='" . $row_query_1['checking_id'] . "' and product_id='".$row_query_1['product_id']."' group by checking_id,product_id";

			$exec_gql3 = mysqli_query($conn, $gql3);
			$completed_ubit=0;
			$fetch_gql3 = mysqli_fetch_array($exec_gql3);
			$completed_ubit = $fetch_gql3["completed_unit"];
			//$target=$fetch_gql3['target'];
	
			$gql1 = "select a.product_id,a.size,b.sub_department_id from tbl_checking_details a inner join tbl_checking b on a.checking_id=b.checking_id and a.checking_id='" . $row_query_1['checking_id'] . "' and  a.delete_status='NDL' and b.delete_status='NDL'";
			$exec_gql1 = mysqli_query($conn, $gql1);
			$rate=0;
			$actual_wages1=0;

			while ($fetch_gql1 = mysqli_fetch_array($exec_gql1)) {
				if(($fetch_gql1['sub_department_id']!="0") || ($fetch_gql1['sub_department_id']!=NULL) || ($fetch_gql1['sub_department_id']!='')){
					// print_r($fetch_gql1['sub_department_id']);
					$gql4 = "select rate as  checking_rate from tbl_products_details where product_id='" . $fetch_gql1['product_id'] . "' and  department_id='4' and sub_department_id='" . $fetch_gql1['sub_department_id'] . "'  and  delete_status='NDL'";
					// print_r($gql4);
					$exec_gql4 = mysqli_query($conn, $gql4);
				}
				else{
					$gql4 = "select rate as  checking_rate  from tbl_products_details where department_id='4' and  product_id='" . $fetch_gql1['product_id'] . "' and  delete_status='NDL'";
					//  print_r($gql4);
					$exec_gql4 = mysqli_query($conn, $gql4);
				}


				while ($fetch_gql4 = mysqli_fetch_array($exec_gql4)) {

					$gql5 = "select completed_unit from tbl_checking_working_details where product_id='" . $fetch_gql1['product_id'] . "' and checking_id=" . $row_query_1['checking_id'] . " and delete_status='NDL'";
					// print_r($gql5);
					$exec_gql5 = mysqli_query($conn, $gql5);
					$work_completed_unit = 0;
					while ($fetch_gql5 = mysqli_fetch_array($exec_gql5)) {

						$work_completed_unit += $fetch_gql5['completed_unit'];
					}

				    $actual_wages1+= $work_completed_unit * $fetch_gql4['checking_rate'];
					$rate =  $fetch_gql4['checking_rate'];					
					
				}
				
		$wages_paid = $row_query_1['daily_wages'];		
		 
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $row_query_1['po_no']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $row_query_1['prod_id'].' '.$row_query_1['size']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, ''); //process
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $row_query_1['target']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $completed_ubit);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $rate);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, round($completed_ubit*$rate));
		
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		  
		if($k==$emp_row){
		
		  
		   $objPHPExcel->getActiveSheet()->mergeCells('J'.$row_1.':J'.$row)->getStyle('J'.$row_1.':J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
		   $objPHPExcel->getActiveSheet()->mergeCells('K'.$row_1.':K'.$row);
		   $objPHPExcel->getActiveSheet()->mergeCells('L'.$row_1.':L'.$row);
		   
		   //$objPHPExcel->getActiveSheet();
		   //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $emp_tot_actwages);
		   
		   $objPHPExcel->getActiveSheet()->getCell('J'.$row_1)->setValue($actual_wages1);
		   $objPHPExcel->getActiveSheet()->getCell('K'.$row_1)->setValue($wages_paid);
		   $objPHPExcel->getActiveSheet()->getCell('L'.$row_1)->setValue($actual_wages1-$wages_paid);
			
		   $diff_wages = $actual_wages1-$wages_paid;
		   		   
		}
	}

		  $row +=1;
		  $k++;
		  $emp_tot_actwages = $emp_tot_actwages+$actual_wages1; 
		  

		}
		$grand_tot_act  += $actual_wages1;
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
		$fd +=1;
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
		$dt = $fdt[2].'-'.$fdt[1].'-'.$fdt[0];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($title_row, $row, $dt);
		$title_row++;
		$fdt[2] = $fdt[2]+1;
	}
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($title_row, $row, "TOTAL");
	
	
	// Total Employee details
	$fdt_2 = explode('/',$from_dt);
	
	
	$f_dt      = $fdt_2[0].'-'.$fdt_2[1].'-'.$fdt_2[2];
	$to_date_1 = $tdt[0].'-'.$tdt[1].'-'.$tdt[2];
	$row = 2;
	$sno =1; 
	
	$sql_emp = "select tbl_checking.emp_id,tbl_employee_details.emp_name from tbl_checking_working_details left join tbl_checking on tbl_checking.checking_id=tbl_checking_working_details.checking_id left join tbl_employee_details ON tbl_employee_details.emp_id=tbl_checking.emp_id  where tbl_checking_working_details.create_date between '$f_dt' and '$to_date_1' group by emp_id";
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
		  
		  $dt_2 = $fdat_3[0].'-'.$fdat_3[1].'-'.$fdat_3[2];
		  
		  
		  $rate=0;
		  $actual_wages1=0;

		 $sql_2 = "SELECT tbl_checking.checking_id,tbl_checking.emp_id,tbl_checking_details.product_id,tbl_checking.po_no,tbl_checking_working_details.completed_unit,tbl_employee_details.daily_wages FROM tbl_checking_working_details LEFT JOIN tbl_checking ON tbl_checking_working_details.checking_id=tbl_checking.checking_id LEFT JOIN tbl_checking_details ON tbl_checking.checking_id = tbl_checking_details.checking_id LEFT JOIN tbl_employee_details ON  tbl_employee_details.emp_id=tbl_checking.emp_id where tbl_checking_details.delete_status='NDL' and tbl_checking.delete_status='NDL' and tbl_checking_working_details.create_date LIKE '$dt_2%' and tbl_employee_details.emp_id=$emp_id_1 and tbl_employee_details.department_id=4 group by tbl_checking_working_details.checking_id,tbl_checking_details.product_id";



		 $query_2 = mysqli_query($conn,$sql_2);
		 while($fetch_2 = mysqli_fetch_array($query_2)){

			$wages_paid = $fetch_2['daily_wages'];
			$gql2_1 = "select a.product_id,a.size,b.sub_department_id from tbl_checking_details a inner join tbl_checking b on a.checking_id=b.checking_id and  a.checking_id='" . $fetch_2['checking_id'] . "' and a.product_id='".$fetch_2['product_id']."' and  a.delete_status='NDL' and b.delete_status='NDL'";
			$exec_gql2_1 = mysqli_query($conn, $gql2_1);
			

			while ($fetch_gql2_1 = mysqli_fetch_array($exec_gql2_1)) {
				if(($fetch_gql2_1['sub_department_id']!="0") || ($fetch_gql2_1['sub_department_id']!=NULL) || ($fetch_gql2_1['sub_department_id']!='')){
					// print_r($fetch_gql2_1['sub_department_id']);
					$gql4 = "select rate as  checking_rate from tbl_products_details where product_id='" . $fetch_gql2_1['product_id'] . "' and  department_id='4' and sub_department_id='" . $fetch_gql2_1['sub_department_id'] . "'  and  delete_status='NDL'";
					// print_r($gql4);
					$exec_gql2_4 = mysqli_query($conn, $gql4);
				}
				else{
					$gql4 = "select rate as  checking_rate  from tbl_products_details where department_id='4' and  product_id='" . $fetch_gql2_1['product_id'] . "' and  delete_status='NDL'";
					//  print_r($gql4);
					$exec_gql2_4 = mysqli_query($conn, $gql4);
				}
				$work_completed_unit = 0;

				while ($fetch_gql2_4 = mysqli_fetch_array($exec_gql2_4)) {

					$gql5 = "select completed_unit from tbl_checking_working_details where product_id='" . $fetch_2['product_id'] . "' and checking_id=" . $fetch_2['checking_id'] . " and delete_status='NDL'";
					// print_r($gql5);
					$exec_gql5 = mysqli_query($conn, $gql5);
					
					while ($fetch_gql5 = mysqli_fetch_array($exec_gql5)) {

						$work_completed_unit += $fetch_gql5['completed_unit'];
					}
					
					// echo 'WORK COM'.$work_completed_unit; echo '</br>';

				    $actual_wages1+= $work_completed_unit * $fetch_gql2_4['checking_rate'];  
					$rate =  $fetch_gql2_4['checking_rate'];						
					
				}	
				
			}
		}

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
		
		$fdat_3[2] = $fdat_3[2]+1;
		$title_column++;
	   
	}
	 $row++;
   }
	/***************  File NAME data  ********/
	$file_name =  date('d',strtotime($from_dt)).'-'.date('m',strtotime($from_dt)).'-'.date('Y',strtotime($from_dt)).'to'.date('d',strtotime($to_dt)).'-'.date('m',strtotime($to_dt)).'-'.date('Y',strtotime($to_dt)).'checking_detail';
	
	//$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
    
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	 //$objWriter->save('php://output'); 
				  
	 $objWriter->save('../uploads/'.$file_name.'.xls');

	 $filename_1 = $file_name.'.xls';

	 $sql_3 = "INSERT INTO `tbl_report_download` (`file_name`) VALUES ('$filename_1')";
	 $query=mysqli_query($conn,$sql_3);
 
	 echo 'uploads/'.$file_name.'.xls';
  }