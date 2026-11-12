<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php 
include_once("sessionservices.php");
date_default_timezone_set('Asia/Kolkata');	
$month=$_POST['select_month'];
$year=$_POST['select_year'];
$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);

    $sql_employee= "select * from tbl_employee_details where delete_status='NDL' and active_status='Y' and emp_salary_type='1'";
	$exec_query_employee=mysqli_query($conn, $sql_employee);
	$tot_employee=mysqli_num_rows($exec_query_employee);

	$tot_holiday=0;
	$tot_working=0;
	for($z=1;$z<=$days;$z++){  
	
	    $sql_holiday= "select DISTINCT t1.attendance_date from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='1' and t1.attendance_date='$year-$month-$z' and attendance_status='Festival'";
        $exec_query_holiday=mysqli_query($conn, $sql_holiday);
         $tot_holiday+=mysqli_num_rows($exec_query_holiday);


	    $sql_working= "select DISTINCT t1.attendance_date from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='1' and t1.attendance_date='$year-$month-$z' and (attendance_status='Festival' or attendance_status='Sunday')";
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
            <th class="name" style="width:130px">Name</th>';
            								
           
            for($i=1;$i<=$days;$i++){
                $html.='<th>'.$i.'</th>';
            } 						
$html.=  '</tr>
        </thead>';
$html.='<tbody>';
							
$sql= "select * from tbl_employee_details where delete_status='NDL' and active_status='Y' and emp_salary_type='1'";
$exec_query=mysqli_query($conn, $sql);

$j=0;
while($fetch=mysqli_fetch_array($exec_query)){
    $emp_name=$fetch['emp_name'];
    $emp_id=$fetch['emp_id'];
    $html.='<tr>';
    $html.='<td  style="font-weight:bold;">'.($j+1).'</td>';
    $html.='<td  style="font-weight:bold;">'.$emp_name.'</td>';    
        for($z=1;$z<=$days;$z++){ 
            $sql_sql= "select t1.*,t2.emp_name from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='1' and t1.attendance_date='$year-$month-$z' and t1.emp_id=".intval($emp_id)."";
            $exec_query_sql=false;
            try{ $exec_query_sql=mysqli_query($conn, $sql_sql); }catch(Throwable $attEx){ $exec_query_sql=false; }
            $num_rows=($exec_query_sql) ? mysqli_num_rows($exec_query_sql) : 0;
            if($num_rows > 0){
                while($fetch_sql=mysqli_fetch_array($exec_query_sql)){  
                
                    if($fetch_sql['attendance_status']=='Present'){

                        $html.='<td><i class="fa fa-check text-success"></i></td>';
                    }
                    else if($fetch_sql['attendance_status']=='Absent'){

                        $html.='<td><i class="fa fa-times text-danger"></i</td>';			
                }
                    else if($fetch_sql['attendance_status']=='Festival'){

                        $html.='<td class="Festival">F</td>';
                    }
                    else if($fetch_sql['attendance_status']=='Sunday'){

                        $html.='<td class="sunday">S</td>';
                    } 


                    else if($fetch_sql['attendance_status']=='Halfday'){

                    $html.='<td class="halfday">H</td>';
                     }

                    else{
                        $html.='<td>-</td>';
                    }   
                } 
            } else{
                $html.='<td  style="font-weight:bold;">-</td>';
            } 
        } 

        $html.='</tr>';
$j++;
} 
 $html.='</tbody>';

 $html.='<tfoot style="font-weight:bold;background-color:#9fe79f;color:black">
 <tr>
     <td colspan="2">Total Present</td>';
  
     for($z=1;$z<=$days;$z++){  							
         $sql_sql= "select t1.*,t2.emp_name from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='1' and t1.attendance_date='$year-$month-$z' ";
         $exec_query_sql=false;
         try{ $exec_query_sql=mysqli_query($conn, $sql_sql); }catch(Throwable $attEx){ $exec_query_sql=false; }
         $num_rows=($exec_query_sql) ? mysqli_num_rows($exec_query_sql) : 0;
         if($num_rows > 0){
             $tot_present=0;
             $tot_sunday=0;
             $tot_holiday=0;
             $k=1;
             while($fetch_sql=mysqli_fetch_array($exec_query_sql)){ 							
                 if($fetch_sql['attendance_status']=="Present"){
                 $tot_present+=$k;
                 }
                 else if($fetch_sql['attendance_status']=="Sunday"){
                     $tot_sunday+=$k;
                 }
                 else if($fetch_sql['attendance_status']=="Festival"){
                     $tot_holiday+=$k;
                 }							
             }$k++;								
             
             if($tot_present!=0){ 
                $html.='<td>'.$tot_present.'</td>';
              }
             else if($tot_sunday!=0){ 
                $html.='<td class="sunday">S</td>';
            } 
             else if($tot_holiday!=0){ 
                 $html.='<td class="Festival">F</td>';
              } else{ 

                $html.='<td >0</td>';

             }	
         } else{					
            $html.='<td>-</td>';
         }
     }
     $html.='</tr>';
     $html.='<tr>';
     $html.='<td colspan="2">Total Absent</td>';

     for($z=1;$z<=$days;$z++){  							
         $sql_sql= "select t1.*,t2.emp_name from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='1' and t1.attendance_date='$year-$month-$z' ";
         $exec_query_sql=false;
         try{ $exec_query_sql=mysqli_query($conn, $sql_sql); }catch(Throwable $attEx){ $exec_query_sql=false; }
         $num_rows=($exec_query_sql) ? mysqli_num_rows($exec_query_sql) : 0;
         if($num_rows > 0){
             $tot_absent=0;
             $tot_sunday=0;
             $tot_holiday=0;
             $k=1;
             while($fetch_sql=mysqli_fetch_array($exec_query_sql))	{ 
 
                 if($fetch_sql['attendance_status']=="Absent"){
                 $tot_absent+=$k;
                 }
                 else if($fetch_sql['attendance_status']=="Sunday"){
                     $tot_sunday+=$k;
                 }
                 else if($fetch_sql['attendance_status']=="Festival"){
                     $tot_holiday+=$k;
                 }							
 
             }$k++;
             
             if($tot_absent!=0){ 
                $html.='<td>'.$tot_absent.'</td>';
              }
             else if($tot_sunday!=0){ 
                $html.='<td class="sunday">S</td>';
             } 
             else if($tot_holiday!=0){ 
                $html.='<td class="Festival">F</td>';
              } else{ 
                $html.='<td >0</td>';
         }
 
        } else{					
            $html.='<td>-</td>';	
          }								
     } 
     $html.='</tr>
</tfoot>';
$html.='<table>';

$json = array("attendance_bind" =>$html,"tot_holiday"=>$holidays,"tot_working"=>($days-$workingdays),'tot_employee'=>$tot_employee,'tot_days'=>$days);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);



?>