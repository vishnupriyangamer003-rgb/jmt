<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php 
include_once("sessionservices.php");
date_default_timezone_set('Asia/Kolkata');	
$month=$_POST['select_month'];
$year=$_POST['select_year'];
$select_week=$_POST['select_week'];

//print_r($select_week);

$order_date = DateTime::createFromFormat('d/m/Y', $select_week)->format('Y-m-d');

$ts = strtotime($order_date);
// find the year (ISO-8601 year number) and the current week
$year = date('o', $ts);
$week = date('W', $ts);


$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);

    $sql_employee= "select * from tbl_employee_details where delete_status='NDL' and emp_salary_type='4'";
	$exec_query_employee=mysqli_query($conn, $sql_employee);
	$tot_employee=mysqli_num_rows($exec_query_employee);

	$tot_holiday=0;
	$tot_working=0;
	for($z=1;$z<=$days;$z++){  
	
	    $sql_holiday= "select DISTINCT t1.attendance_date from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='4' and t1.attendance_date='$year-$month-$z' and attendance_status='Festival'";
        $exec_query_holiday=mysqli_query($conn, $sql_holiday);
         $tot_holiday+=mysqli_num_rows($exec_query_holiday);


	    $sql_working= "select DISTINCT t1.attendance_date from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='4' and t1.attendance_date='$year-$month-$z' and (attendance_status='Festival' or attendance_status='Sunday')";
        $exec_query_working=mysqli_query($conn, $sql_working);
        $tot_working+=mysqli_num_rows($exec_query_working);
	
	}

 $holidays=$tot_holiday;

 $workingdays=$tot_working;



$html="";
$html.='<table style="width:100%;text-align:center">
        <thead class="jhe-thead">
        <tr>
            <th>No</th>
            <th class="name" style="width:130px">Name</th>
            <th class="name" style="width:130px">Salary</th>';
            								
           
            for($i=1;$i<=7;$i++){

                $ts = strtotime($year.'W'.$week.$i);

                $html.='<th>'.date("d/m/Y", $ts).'</th>';
            } 						
$html.=  '<th class="name" style="width:80px">Tot.Hr</th>
            <th class="name" style="width:80px">Tot.Salary</th>							
			<th class="name" style="width:80px">Tot.Paid</th>
			<th class="name" style="width:80px">Balance</th>	 </tr>
        </thead>';
$html.='<tbody>';
	

            $start_date=strtotime($year.'W'.$week.'1');
			$end_date=strtotime($year.'W'.$week.'7');

			$start_date1=date("Y-m-d", $start_date);
			$end_date1=date("Y-m-d", $end_date);

$sql= "select * from tbl_employee_details where delete_status='NDL' and emp_salary_type='4'";
$exec_query=mysqli_query($conn, $sql);

$j=0;
while($fetch=mysqli_fetch_array($exec_query)){
    $emp_name=$fetch['emp_name'];
    $salary=$fetch['salary'];
    $emp_id=$fetch['emp_id'];
    $html.='<tr>';
    $html.='<td  style="font-weight:bold;">'.($j+1).'</td>';
    $html.='<td  style="font-weight:bold;">'.$emp_name.'</td>';  
    $html.='<td  style="font-weight:bold;">'.$salary.'</td>';   
    
   // $start_date=$year.'-'.$month.'-1';

        for($z=1;$z<=7;$z++){ 

            $ts = strtotime($year.'W'.$week.$z);
            $month = date('m', $ts);
			$year = date('Y', $ts);
			$date = date('d', $ts);

            $sql_sql= "select t1.*,t2.emp_name from tbl_attendance_bundle t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='4' and t1.attendance_date='$year-$month-$date' and t1.emp_id=".$emp_id."";
            $exec_query_sql=mysqli_query($conn, $sql_sql);
            $num_rows=mysqli_num_rows($exec_query_sql);
            if($num_rows > 0){
                while($fetch_sql=mysqli_fetch_array($exec_query_sql)){  
                
                    if(!empty($fetch_sql['attendance_status'])){

                        $html.='<td>'.$fetch_sql['attendance_status'].'</td>';
                    }else{
                        $html.='<td>-</td>';
                    }   
                } 
            } else{
                $html.='<td  style="font-weight:bold;">-</td>';
            } 
        } 


        $end_date=$year.'-'.$month.'-'.($z-1);
									 							
		$sql_sql1= "select sum(attendance_status) as total_hour,t2.salary,t2.emp_id from tbl_attendance_bundle t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t2.delete_status='NDL' and t1.emp_id=".$fetch['emp_id']." and t2.emp_salary_type='4' and t1.attendance_date between '" . $start_date1 . "' and '" . $end_date1 . "'";

		$exec_query_sql1=mysqli_query($conn, $sql_sql1);
		$tot_present1=0;
		$k=1;
		while($fetch_sql1=mysqli_fetch_array($exec_query_sql1)){ 							
								
            
            $salary_sql1= "select sum(pay_amount) as total_amount from tbl_emp_bundle_salary  where  delete_status='NDL' and emp_id=".$fetch['emp_id']." and start_date ='" . $start_date1 . "' and  end_date='" . $end_date1 . "'";										
			$salary_query_sql1=mysqli_query($conn, $salary_sql1);
			$fetch_salary=mysqli_fetch_array($salary_query_sql1);

            $balance=($fetch_sql1['total_hour']*$fetch_sql1['salary'])-$fetch_salary['total_amount'];

            $html.='<td>'.$fetch_sql1['total_hour'].'</td><td><a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-week_date='.date('Y-m-d').' data-emp_id='.$fetch_sql1['emp_id'].'><button type="button"   class="btn btn-warning" style="padding:4px 5px; 5px; 2px; color:#fff">'.$fetch_sql1['total_hour']*$fetch_sql1['salary'].'</button></a></td><td><a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-week_date='.date('Y-m-d').' data-emp_id='.$fetch_sql1['emp_id'].'><button type="button"   class="btn btn-success" style="padding:4px 5px; 5px; 2px; color:#fff">'.$fetch_salary['total_amount'].'</button></a></td><td><button type="button"   class="btn btn-danger" style="padding:4px 5px; 5px; 2px; color:#fff">'.$balance.'</button></td>';
																		
		} $k++;	


        $html.='</tr>';
$j++;
} 
$html.='</tbody>';

 
$html.='<table>';

$json = array("attendance_bind" =>$html,"tot_holiday"=>$holidays,"tot_working"=>($days-$workingdays),'tot_employee'=>$tot_employee,'tot_days'=>$days);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);



?>