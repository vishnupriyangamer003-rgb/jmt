<?php
class employee_services{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}

	function q($k){ return str_replace("'","^", (string)($_POST[$k] ?? '')); }
	function qdate($k){
		$ts = strtotime((string)($_POST[$k] ?? ''));
		return $ts ? date('Y-m-d', $ts) : null;
	}
	
	function employee_insert($curdate){
		$emp_name=$this->q('emp_name');
		$emp_desig=$this->q('emp_desig');
		$emp_dob=$this->qdate('emp_dob');
		$emp_mblno=$this->q('emp_mblno');
		$salary=$this->q('salary');
		$emp_email=$this->q('emp_email');
		$emp_addr=$this->q('emp_addr');		
		$comments=$this->q('comments');

		$emp_type=$this->q('emp_type');
		$emp_salary_type=$this->q('emp_salary');
		
		$emp_status=$this->q('emp_status');
		$log=$_SESSION['login_user'];
		$dob_sql = ($emp_dob !== null) ? "'".$emp_dob."'" : "NULL";

		$sql= "INSERT INTO tbl_employee_details (emp_status,comments,emp_name,salary,emp_type,emp_salary_type,emp_dob,emp_mblno,emp_email,emp_addr,active_status,delete_status,created_by,create_date) VALUES('".$emp_status."','".$comments."','".$emp_name."','".$salary."','".$emp_type."','".$emp_salary_type."',".$dob_sql.",'".$emp_mblno."','".$emp_email."','".$emp_addr."','Y','NDL','".$log."','".$curdate."')";
	
		//print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			$last_id=mysqli_insert_id($this->mySQLconn);
			$code_sql= "update tbl_employee_details set emp_code=concat('emp00','".$last_id."') where emp_id='".$last_id."'";
			$code_exec_query=mysqli_query($this->mySQLconn, $code_sql);
			if($code_exec_query){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			 return false;
		}
	}
	function employee_delete($curdate){
		$sql= "update tbl_employee_details set delete_status='0',deleted_by='".$_SESSION['login_user']."',deleted_date='".$curdate."' where emp_id='".$_POST['delid']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			return true;
		}
		else{
			 return false;
		}
	}
	function employee_autobind($curdate){
		$employeeData=array();
		$sql= "select *,date_format(emp_dob,'%m/%d/%Y') as emp_dob from tbl_employee_details where emp_id='".$_POST['emp_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$employeeData[]=str_replace("^","'",$row);		
			}
		}
		return $employeeData;
	}
	function employee_update($curdate){
		$emp_name=$this->q('emp_name');
		$emp_desig=$this->q('emp_desig');
		$emp_dob=$this->qdate('emp_dob');
		$emp_mblno=$this->q('emp_mblno');
		$salary=$this->q('salary');
		$emp_email=$this->q('emp_email');
		$emp_addr=$this->q('emp_addr');

		$emp_type=$this->q('emp_type');
		$emp_salary_type=$this->q('emp_salary');

		
		$comments=$this->q('comments');
		
		$emp_status=$this->q('emp_status');
		$dob_set = isset($_POST['emp_dob']) && trim((string)$_POST['emp_dob']) !== '' ? ",emp_dob='".$emp_dob."'" : "";
		$sql= "update tbl_employee_details set emp_status='".$emp_status."',comments='".$comments."',emp_name='".$emp_name."',salary='".$salary."',emp_type='".$emp_type."',emp_salary_type='".$emp_salary_type."',emp_mblno='".$emp_mblno."',emp_email='".$emp_email."',emp_addr='".$emp_addr."'".$dob_set.",updated_by='".$_SESSION['login_user']."',update_date='".$curdate."' where emp_id='".$_POST['emp_id']."'";
		// print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			return true;
		}
		else{
			 return false;
		}
	}
	function employeerightsautobind($curdate){
		$customerData=array();
		$customer="SELECT emprt_id, t1.emp_id as emp_id, module_id, modules, module_status, ins, upd, del,t2.uname as uname,t2.pass as pass FROM tbl_employee_rights t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id where t1.emp_id='".$_POST['empid']."' order by module_id asc";
		$customerquery=mysqli_query($this->mySQLconn,$customer);
		$rows=mysqli_num_rows($customerquery);
		if($rows>0){
			while($row=mysqli_fetch_array($customerquery,MYSQLI_ASSOC)){
				$customerData[]=str_replace("^","'",$row);		
			}
		}
		return $customerData; 
	}
	function employeerightsadd($curdate){
		$sql="delete FROM tbl_employee_rights where emp_id='".$_POST['data2']."'";
		$sqlquery=mysqli_query($this->mySQLconn,$sql);
		if($sqlquery){
		if (substr($_POST['uname'], -4) == '@jmt'){
			$length=strlen($_POST['uname']);
			$uname=substr($_POST['uname'],0, -4);
		}
		else{
			$uname=$_POST['uname'];
		}
		$qql="update tbl_employee_details set uname='".$uname."@jmt',pass='".$_POST['pass']."' where emp_id='".$_POST['data2']."'";
			$exec_qql=mysqli_query($this->mySQLconn,$qql);
			if($exec_qql){
				foreach($_POST['data1'] as $value){
					$sql1="insert into tbl_employee_rights (emp_id, module_id,modules, module_status, ins, upd, del, created_by, create_date) values ('".$_POST['data2']."','".$value[0]."','".$value[1]."','".$value[2]."','".$value[3]."','".$value[4]."','".$value[5]."','".$_SESSION['login_user']."','".$curdate."')";
					$sqlquery1=mysqli_query($this->mySQLconn,$sql1);
				}
				if($sqlquery1){
					return true; 
				}
				else{
					return false; 
				}
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	function employeerightsdelete($curdate){
		$qql="update tbl_employee_details set uname=null,pass=null where emp_id='".$_POST['data1']."'";
		$exec_qql=mysqli_query($this->mySQLconn,$qql);
		if($exec_qql){
			$sql="delete FROM tbl_employee_rights where emp_id='".$_POST['data1']."'";
			$sqlquery=mysqli_query($this->mySQLconn,$sql);
			if($sqlquery){
				return true; 
			}
			else{
				return false; 
			}
		}
	}
	function employeestatuschange($curdate){
		if($_POST['status']=='Y'){
			$qql="update tbl_employee_details set active_status='N' where emp_id='".$_POST['emp_id']."'";
		}
		else if($_POST['status']=='N'){
			$qql="update tbl_employee_details set active_status='Y' where emp_id='".$_POST['emp_id']."'";
		}
		$exec_qql=mysqli_query($this->mySQLconn,$qql);
		if($exec_qql){
			return true; 
		}
		else{
			return false; 
		}
	}
	
}		
?>