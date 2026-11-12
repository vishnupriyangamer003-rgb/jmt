<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class income_header_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

			$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');
			$i=0;
			foreach ($_POST['income_header_id'] as $key=>$income_header_id){					
				
				$income_header_id = $_POST['income_header_id'][$i];
				$income_amount = $_POST['income_amount'][$i];				
					
				$sql_details= "INSERT INTO tbl_bank_income_expense_details (billing_date,bank_id,income_expense_type,header_id,amount,created_by,create_date,delete_status) VALUES('".$order_date."','".$_POST['bank_id']."','Income','".$income_header_id."','".$income_amount."','".$log."','".$curdate."','NDL')";
				//print_r($sql);
				$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				

				$i++;
			}


			$j=0;
			foreach ($_POST['expense_header_id'] as $key=>$expense_header_id){						
				
				$expense_header_id = $_POST['expense_header_id'][$j];
				$expense_amount = $_POST['expense_amount'][$j];				
					
				$sql_details= "INSERT INTO tbl_bank_income_expense_details (billing_date,bank_id,income_expense_type,header_id,amount,created_by,create_date,delete_status) VALUES('".$order_date."','".$_POST['bank_id']."','Expense','".$expense_header_id."','".$expense_amount."','".$log."','".$curdate."','NDL')";
				//print_r($sql);
				$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				

				$j++;
			}

		if($exec_query_details){			
			return true;
		}
		else{
			 return false;
		}
	}
	function income_header_delete($curdate){
		
		$log=$_SESSION['login_user'];
		

		$sql= "update tbl_bank_income_expense_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where billing_date='".$_POST['delid']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);	

		if($exec_query){
			
			return true;
		}
		else{
			 return false;
		}
	}

	function income_header_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_bank_income_expense_details where billing_date='".$_POST['billing_date']."' and delete_status='NDL'";
		//print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}

	
	function income_header_update($curdate){
		$log=$_SESSION['login_user'];
		
			$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');

			$rql="delete from tbl_bank_income_expense_details where billing_date='".$_POST['billing_date']."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);

			
				$i=0;
				foreach ($_POST['income_header_id'] as $key=>$income_header_id){					
					
					$income_header_id = $_POST['income_header_id'][$i];
					$income_amount = $_POST['income_amount'][$i];				
						
					$sql_details= "INSERT INTO tbl_bank_income_expense_details (billing_date,bank_id,income_expense_type,header_id,amount,created_by,create_date,delete_status) VALUES('".$order_date."','".$_POST['bank_id']."','Income','".$income_header_id."','".$income_amount."','".$log."','".$curdate."','NDL')";
					//print_r($sql);
					$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				

					$i++;
				}


				$j=0;
				foreach ($_POST['expense_header_id'] as $key=>$expense_header_id){						
					
					$expense_header_id = $_POST['expense_header_id'][$j];
					$expense_amount = $_POST['expense_amount'][$j];				
						
					$sql_details= "INSERT INTO tbl_bank_income_expense_details (billing_date,bank_id,income_expense_type,header_id,amount,created_by,create_date,delete_status) VALUES('".$order_date."','".$_POST['bank_id']."','Expense','".$expense_header_id."','".$expense_amount."','".$log."','".$curdate."','NDL')";
					//print_r($sql);
					$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				

					$j++;
				}

			if($exec_query_details){			
				return true;
			}
			else{
				return false;
			}
		

	}
	function income_header_add($curdate){
		$log=$_SESSION['login_user'];
		$sql= "INSERT INTO tbl_income_header (income_header_name,created_by,create_date) VALUES('".$_POST['income_header_name']."','".$log."','".$curdate."')";
		//  print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			// $final_dest='userdata/images/addingfiles';
			// if(is_dir( $final_dest)==FALSE){
			// 	mkdir($final_dest,0777,TRUE);
			// }
			// copy('temp/'.$_POST['photo_name'],$final_dest.'/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
		
}		
$objVDS=new income_header_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->income_header_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->income_header_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->income_header_update($curdate);
}
else if(($_POST['req'] ?? '')=='ADDINCOMEINS'){
	$rtnMsg=$objVDS->income_header_add($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>