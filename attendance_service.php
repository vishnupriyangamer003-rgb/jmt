<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
	include_once("sessionservices.php");	
	date_default_timezone_set('Asia/Kolkata');	
if (!class_exists('attendance_services')) {
class attendance_services{
	public $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$attendance_date = DateTime::createFromFormat('d/m/Y', $_POST['attendance_date'])->format('Y-m-d');
		//$attendance_date=date('Y-m-d',strtotime($_POST['attendance_date']));
		  $sql_exist= "select * from tbl_attendance where attendance_date=date('".$attendance_date."') and delete_status='NDL'";
		 $exec_query_exist=mysqli_query($this->mySQLconn, $sql_exist);
		  $exist_row=mysqli_num_rows($exec_query_exist);

		if($exist_row>0){
			$attendance_date = DateTime::createFromFormat('d/m/Y', $_POST['attendance_date'])->format('Y-m-d');
			//$attendance_date=date('Y-m-d',strtotime($_POST['attendance_date']));
			$i=0;
			foreach ($_POST['emp_id'] as $key => $emp_id) {
		
				$attendance_status=$_POST["attendance_status".$i.""];
				foreach ($attendance_status as $key => $a_status) {
					
				  $sql= "update tbl_attendance set attendance_status='".$a_status."',updated_by='".$log."',update_date='".$curdate."' where attendance_date='".$attendance_date."' and emp_id='".$emp_id."'";
				 $exec_query=mysqli_query($this->mySQLconn, $sql);
				
				
				}
				 $i++;
				
				}
				if($exec_query){		
					return true;
				}
				else{
					return false;
				}

		}
		else{
		


			$attendance_date = DateTime::createFromFormat('d/m/Y', $_POST['attendance_date'])->format('Y-m-d');
			//$attendance_date=date('Y-m-d',strtotime($_POST['attendance_date']));
			$i=0;
			foreach ($_POST['emp_id'] as $key => $emp_id) {
		
				$attendance_status=$_POST["attendance_status".$i.""];
				foreach ($attendance_status as $key => $a_status) {
				  $sql= "INSERT INTO tbl_attendance (attendance_date,attendance_status,emp_id,created_by,create_date) VALUES('".$attendance_date."','".$a_status."','".$emp_id."','".$log."','".$curdate."')";
				 $exec_query=mysqli_query($this->mySQLconn, $sql);
				
				
				}
				 $i++;
				
				}
					//   print_r($sql);
	
				if($exec_query){		
					return true;
				}
				else{
					return false;
				}

		}
		
	
	}
	function attendance_delete($curdate){
		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_attendance set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where attendance_id='".$_POST['delid']."'";
	//    print_r($sql);
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			//unlink('userdata/images/banner/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
	// function attendance_autobind($curdate){
	// 	$bannerData=array();
	// 	$sql= "select * from tbl_attendance where attendance_id='".$_POST['attendance_id']."' and delete_status='NDL'";
	//     $exec_query=mysqli_query($this->mySQLconn, $sql);
	// 	$rows=mysqli_num_rows($exec_query);
	// 	if($rows>0){
	// 		while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
	// 			$bannerData[]=str_replace("^","'",$row);		
	// 		}
	// 	}
	// 	return $bannerData;
	// }


	function attendance_autobind($curdate){

	
		//print_r($_POST['attendance_date']);
// if($_POST['attendance_date']){
	$attendance_date = DateTime::createFromFormat('d/m/Y', $_POST['attendance_date'])->format('Y-m-d');
	//$attendance_date=date('Y-m-d',strtotime($_POST['attendance_date']));
// }
// else{
// 
// }
// $curdate1=date('Y-m-d',strtotime($curdate));

		
		$bannerData=array();
		$sql_exist= "select * from tbl_attendance where attendance_date=date('".$attendance_date."') and delete_status='NDL'";

		//print_r($sql_exist);

		$exec_query_exist=mysqli_query($this->mySQLconn, $sql_exist);
		 $exist_row=mysqli_num_rows($exec_query_exist);
		 if($exist_row>0){
	
			$sql= "select t1.*,t2.emp_name from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where t1.attendance_date='".$attendance_date."' and t2.emp_salary_type='1' and t1.delete_status='NDL'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
		
		}
		else{
	
			 $sql= "select * from tbl_employee_details where delete_status='NDL' and emp_salary_type='1'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
		}
	
			
		$rows=mysqli_num_rows($exec_query);


		$sql_present= "select count(attendance_id) as present from tbl_attendance where attendance_date='".$attendance_date."' and delete_status='NDL'and attendance_status='Present' GROUP BY attendance_status";
	    $exec_query_present=mysqli_query($this->mySQLconn, $sql_present);
		$fetch_present=mysqli_fetch_assoc($exec_query_present);
		$sql_absent="select count(attendance_id) as absent from tbl_attendance where attendance_date='".$attendance_date."' and delete_status='NDL'and attendance_status='Absent' GROUP BY attendance_status";
	    $exec_query_absent=mysqli_query($this->mySQLconn, $sql_absent);
		$fetch_absent=mysqli_fetch_assoc($exec_query_absent);
		
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$rows=mysqli_num_rows($exec_query);
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return ['result'=>$bannerData,'total_absent'=>$fetch_absent['absent'],'total_present'=>$fetch_present['present']];
	}



	function attendance_update($curdate){
		$log=$_SESSION['login_user'];
		$sql= "update tbl_attendance set attendance='".$_POST['attendance']."',description='".$_POST['description']."',updated_by='".$log."',update_date='".$curdate."' where attendance_id='".$_POST['attendance_id']."'";
	// print_r($sql);
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			// if($_POST['photo_new_name']!=''){
			// 	$final_dest='userdata/images/addingfiles';
			// 	 if(is_dir( $final_dest)==FALSE){
			// 		mkdir($final_dest,0777,TRUE);
			// 	}
			// 	copy('temp/'.$_POST['photo_new_name'],$final_dest.'/'.$_POST['photo_new_name']);
			// 	//unlink('userdata/images/banner/'.$_POST['photo_old_name']);
			// }
			return true;
		}
		else{
			 return false;
		}
	}
		
	function save_single_cell($curdate) {
		$log = $_SESSION['login_user'] ?? 'admin';
		$emp_id = intval($_POST['emp_id'] ?? 0);
		$att_date = trim($_POST['date'] ?? '');
		$status = trim($_POST['status'] ?? '');

		if ($emp_id <= 0 || empty($att_date)) {
			return ['status' => 'error', 'message' => 'Invalid parameters'];
		}

		// Ensure Y-m-d format
		$ts = strtotime($att_date);
		if (!$ts) {
			return ['status' => 'error', 'message' => 'Invalid date'];
		}
		$db_date = date('Y-m-d', $ts);

		// Sunday guard: Sunday must never be saved as Absent
		if (date('N', $ts) == 7) {
			if ($status === 'Absent') {
				return ['status' => 'error', 'message' => 'Sunday cannot be marked as Absent'];
			}
		}

		$valid_statuses = ['Present', 'Absent', 'Halfday', 'Festival', 'Holiday'];

		if ($status === '' || $status === '-' || !in_array($status, $valid_statuses, true)) {
			// Delete existing record
			$stmt = mysqli_prepare($this->mySQLconn, "UPDATE tbl_attendance SET delete_status='0', deleted_by=?, deleted_date=? WHERE emp_id=? AND attendance_date=? AND delete_status='NDL'");
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "ssis", $log, $curdate, $emp_id, $db_date);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			return ['status' => 'success', 'action' => 'cleared', 'emp_id' => $emp_id, 'date' => $db_date];
		}

		// Check if record already exists
		$stmt_check = mysqli_prepare($this->mySQLconn, "SELECT attendance_id FROM tbl_attendance WHERE emp_id=? AND attendance_date=? AND delete_status='NDL' LIMIT 1");
		mysqli_stmt_bind_param($stmt_check, "is", $emp_id, $db_date);
		mysqli_stmt_execute($stmt_check);
		$res_check = mysqli_stmt_get_result($stmt_check);
		$existing = $res_check ? mysqli_fetch_assoc($res_check) : null;
		mysqli_stmt_close($stmt_check);

		if ($existing) {
			$stmt_up = mysqli_prepare($this->mySQLconn, "UPDATE tbl_attendance SET attendance_status=?, updated_by=?, update_date=? WHERE attendance_id=?");
			mysqli_stmt_bind_param($stmt_up, "sssi", $status, $log, $curdate, $existing['attendance_id']);
			$ok = mysqli_stmt_execute($stmt_up);
			mysqli_stmt_close($stmt_up);
			return ['status' => $ok ? 'success' : 'error', 'action' => 'updated', 'emp_id' => $emp_id, 'date' => $db_date, 'new_status' => $status];
		} else {
			$stmt_in = mysqli_prepare($this->mySQLconn, "INSERT INTO tbl_attendance (attendance_date, attendance_status, emp_id, created_by, create_date, delete_status) VALUES (?, ?, ?, ?, ?, 'NDL')");
			mysqli_stmt_bind_param($stmt_in, "ssiss", $db_date, $status, $emp_id, $log, $curdate);
			$ok = mysqli_stmt_execute($stmt_in);
			mysqli_stmt_close($stmt_in);
			return ['status' => $ok ? 'success' : 'error', 'action' => 'inserted', 'emp_id' => $emp_id, 'date' => $db_date, 'new_status' => $status];
		}
	}

	function save_batch_cells($curdate) {
		$log = $_SESSION['login_user'] ?? 'admin';
		$entries = $_POST['entries'] ?? [];
		if (is_string($entries)) {
			$entries = json_decode($entries, true) ?? [];
		}

		$saved_count = 0;
		$valid_statuses = ['Present', 'Absent', 'Halfday', 'Festival', 'Holiday'];

		foreach ($entries as $item) {
			$emp_id = intval($item['emp_id'] ?? 0);
			$att_date = trim($item['date'] ?? '');
			$status = trim($item['status'] ?? '');
			if ($emp_id <= 0 || empty($att_date)) continue;

			$ts = strtotime($att_date);
			if (!$ts) continue;
			$db_date = date('Y-m-d', $ts);

			// Sunday guard
			if (date('N', $ts) == 7 && $status === 'Absent') {
				continue;
			}

			if ($status === '' || $status === '-' || !in_array($status, $valid_statuses, true)) {
				$stmt = mysqli_prepare($this->mySQLconn, "UPDATE tbl_attendance SET delete_status='0', deleted_by=?, deleted_date=? WHERE emp_id=? AND attendance_date=? AND delete_status='NDL'");
				if ($stmt) {
					mysqli_stmt_bind_param($stmt, "ssis", $log, $curdate, $emp_id, $db_date);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					$saved_count++;
				}
			} else {
				$stmt_check = mysqli_prepare($this->mySQLconn, "SELECT attendance_id FROM tbl_attendance WHERE emp_id=? AND attendance_date=? AND delete_status='NDL' LIMIT 1");
				mysqli_stmt_bind_param($stmt_check, "is", $emp_id, $db_date);
				mysqli_stmt_execute($stmt_check);
				$res_check = mysqli_stmt_get_result($stmt_check);
				$existing = $res_check ? mysqli_fetch_assoc($res_check) : null;
				mysqli_stmt_close($stmt_check);

				if ($existing) {
					$stmt_up = mysqli_prepare($this->mySQLconn, "UPDATE tbl_attendance SET attendance_status=?, updated_by=?, update_date=? WHERE attendance_id=?");
					mysqli_stmt_bind_param($stmt_up, "sssi", $status, $log, $curdate, $existing['attendance_id']);
					mysqli_stmt_execute($stmt_up);
					mysqli_stmt_close($stmt_up);
					$saved_count++;
				} else {
					$stmt_in = mysqli_prepare($this->mySQLconn, "INSERT INTO tbl_attendance (attendance_date, attendance_status, emp_id, created_by, create_date, delete_status) VALUES (?, ?, ?, ?, ?, 'NDL')");
					mysqli_stmt_bind_param($stmt_in, "ssiss", $db_date, $status, $emp_id, $log, $curdate);
					mysqli_stmt_execute($stmt_in);
					mysqli_stmt_close($stmt_in);
					$saved_count++;
				}
			}
		}

		return ['status' => 'success', 'saved_count' => $saved_count];
	}

}
}		
$objVDS=new attendance_services($conn);
$curdate=date('Y-m-d H:i:s');
$rtnMsg = null;
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->attendance_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->attendance_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->attendance_update($curdate);
}
else if(($_POST['req'] ?? '')=='SAVE_CELL'){
	$rtnMsg=$objVDS->save_single_cell($curdate);
}
else if(($_POST['req'] ?? '')=='SAVE_BATCH'){
	$rtnMsg=$objVDS->save_batch_cells($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>