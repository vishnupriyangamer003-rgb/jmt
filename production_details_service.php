<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class production_details_service{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		//$order_date=$_POST['order_date'];		
		$od=DateTime::createFromFormat('d/m/Y', (string)($_POST['order_date'] ?? ''));
		$order_date = $od ? $od->format('Y-m-d') : date('Y-m-d');		
		//$order_date1=date('Y-m-d',strtotime($_POST['order_date']));
		$production_no=$_POST['production_no'];			
		
		$operator_id=$_POST['operator_id'];
		$product_id=$_POST['product_id'];
		$qty=$_POST['qty'];
		$remarks=$_POST['remarks'];
		
		

		$sql= "INSERT INTO tbl_production_details (operator_id,production_no,product_id,production_date,qty,remarks,created_by,create_date,delete_status) VALUES('".$operator_id."','".$production_no."','".$product_id."','".$order_date."','".$qty."','".$remarks."','".$log."','".$curdate."','NDL')";
		//  print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$sql_select = "select * from tbl_production_details where delete_status='NDL' order by id DESC";
		// print_r($sql_select);
		$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
		// print_r($exec_query_select);
		$fetch = mysqli_fetch_array($exec_query_select);

		$lastproduction_id = $fetch['id'];
		if($exec_query){
			$i=0;
			foreach ($_POST['labour_id'] as $key=>$labour_id){							
					
				$labour_id= $_POST['labour_id'][$i];	
					
					$sql_details= "INSERT INTO tbl_production_labour_details (labour_id,production_id,created_by,create_date,delete_status) VALUES('".$labour_id."','".$lastproduction_id."','".$log."','".$curdate."','NDL')";
					//  print_r($sql);
					$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				

				$i++;
			}


			$j=0;
			foreach ($_POST['start_time'] as $key=>$start_time){							
					
				$start_time= $_POST['start_time'][$j];
				$end_time= $_POST['end_time'][$j];	
					
				$sql_details1= "INSERT INTO tbl_production_shift_details (start_time,end_time,production_id,created_by,create_date,delete_status) VALUES('".$start_time."','".$end_time."','".$lastproduction_id."','".$log."','".$curdate."','NDL')";
					//  print_r($sql);
				$exec_query_details1=mysqli_query($this->mySQLconn, $sql_details1);				

				$j++;
			}

			/*$final_dest='userdata/images/product_details';
			if(is_dir( $final_dest)==FALSE){
				mkdir($final_dest,0777,TRUE);
			}
			copy('temp/'.$_POST['photo_name'],$final_dest.'/'.$_POST['photo_name']);*/
			return true;
		}
		else{
			 return false;
		}

	}

	
	
	function add_update($curdate){
		$log=$_SESSION['login_user'];

		//$order_date=$_POST['order_date'];		
		$od=DateTime::createFromFormat('d/m/Y', (string)($_POST['order_date'] ?? ''));
		$order_date = $od ? $od->format('Y-m-d') : date('Y-m-d');		
		//$order_date1=date('Y-m-d',strtotime($_POST['order_date']));
		$production_no=$_POST['production_no'];			
		
		$operator_id=$_POST['operator_id'];
		$product_id=$_POST['product_id'];
		$qty=$_POST['qty'];
		$remarks=$_POST['remarks'];

		$production_id=$_POST['production_id'];

		 $sql_pro= "update tbl_production_details set  operator_id='".$_POST['operator_id']."',production_no='".$_POST['production_no']."',product_id='".$_POST['product_id']."',qty='".$_POST['qty']."',remarks='".$_POST['remarks']."', production_date='".$order_date ."',updated_by='".$log."',update_date='".$curdate."' where id='".$_POST['production_id']."'";
		 
		 
		 //print_r($sql);
	    $exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
		
		if($exec_query_pro){
			$rql="delete from tbl_production_labour_details where production_id='".$_POST['production_id']."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);		
				
				$i=0;
				foreach ($_POST['labour_id'] as $key=>$labour_id){							
						
					$labour_id= $_POST['labour_id'][$i];	
						
						$sql_details= "INSERT INTO tbl_production_labour_details (labour_id,production_id,created_by,create_date,delete_status) VALUES('".$labour_id."','".$production_id."','".$log."','".$curdate."','NDL')";
						//  print_r($sql);
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				

					$i++;
				}	
				

			
			
				$rql1="delete from tbl_production_shift_details where production_id='".$_POST['production_id']."'";
				$exec_rql1=mysqli_query($this->mySQLconn, $rql1);
				

					$j=0;
					foreach ($_POST['start_time'] as $key=>$start_time){							
							
						$start_time= $_POST['start_time'][$j];
						$end_time= $_POST['end_time'][$j];	
							
						$sql_details1= "INSERT INTO tbl_production_shift_details (start_time,end_time,production_id,created_by,create_date,delete_status) VALUES('".$_POST['start_time'][$j]."','".$_POST['end_time'][$j]."','".$production_id."','".$log."','".$curdate."','NDL')";
						
						$exec_query_details1=mysqli_query($this->mySQLconn, $sql_details1);				

						$j++;
					}

			return true;

		}
		else{
			 return false;
		}
	}

	


	function production_delete($curdate){		
			$log=$_SESSION['login_user'];
			$sql= "update tbl_production_details set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where id='".$_POST['delid']."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			
			if($exec_query){

				$sql_second= "update tbl_production_labour_details set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where production_id='".$_POST['delid']."'";
				$exec_query_second=mysqli_query($this->mySQLconn, $sql_second);

				$sql_second1= "update tbl_production_shift_details set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where production_id='".$_POST['delid']."'";
				$exec_query_second1=mysqli_query($this->mySQLconn, $sql_second1);

				return true;
			}
			else{
				 return false;
			}
	}	
	
	
	function production_autobind($curdate){
		$bannerData=array();
		$sql= "select *,date_format(production_date,'%d/%m/%Y') as order_date from tbl_production_details where id='".$_POST['production_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	
	/****************************************** */
	
		
}		
$objVDS=new production_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->add_update($curdate);
}

else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->production_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->production_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>