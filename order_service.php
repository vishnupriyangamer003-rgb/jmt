<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class order_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$sql = "select * from tbl_order ";
		$exec_sql = mysqli_query($this->mySQLconn, $sql);
		$fetch_sql = mysqli_fetch_array($exec_sql);
		$rows_sql = mysqli_num_rows($exec_sql);
		if ($rows_sql) {
			$firstPart ='00'.($rows_sql + 1);
		} else {
			$firstPart ='001';
		}


		$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');
		$delivery_date = DateTime::createFromFormat('d/m/Y', $_POST['delivery_date'])->format('Y-m-d');

		


		$sql= "INSERT INTO tbl_order (order_no,company_name,mblno,email,address,gst_no,state,state_code,order_date,delivery_date,customer_id,created_by,create_date,delete_status) VALUES('".$firstPart."','".$_POST['company_name']."','".$_POST['mblno']."','".$_POST['email']."','".$_POST['address']."','".$_POST['gst_no']."','".$_POST['state']."','".$_POST['state_code']."','".$order_date."','".$delivery_date."','".$_POST['customer_id']."','".$log."','".$curdate."','NDL')";
		//  print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);


		$sql_select = "select * from tbl_order where delete_status='NDL' order by order_id DESC";
		$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
		$fetch = mysqli_fetch_array($exec_query_select);

		$lastorder_id = $fetch['order_id'];

		if($exec_query){
			$i=0;
			foreach ($_POST['product_id'] as $key=>$order_id){					
				
				$qty=$_POST['qty'][$i];		
				$product_id= $_POST['product_id'][$i];
				$uom_id= $_POST['uom_id'][$i];			
					
					$sql_details= "INSERT INTO tbl_order_details (order_id,product_id,uom_id,qty,created_by,create_date,delete_status) VALUES('".$lastorder_id."','".$product_id."','".$uom_id."','".$qty."','".$log."','".$curdate."','NDL')";
					$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				

				$i++;
			}

			return true;
		}
		else{
			 return false;
		}
	}
	
	function order_details_delete($curdate){		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_order set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where order_id='".$_POST['delid']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){

			$sql1= "update tbl_order_details set delete_status='0',deleted_by='".$log."',delete_date='".$curdate."' where order_id='".$_POST['delid']."'";
			$exec_query1=mysqli_query($this->mySQLconn, $sql1);

			return true;
		}
		else{
			 return false;
		}
	}
	
	
	function order_autobind($curdate){
		$bannerData=array();
		$sql= "select *,date_format(delivery_date,'%d/%m/%Y') as delivery_date,date_format(order_date,'%d/%m/%Y') as order_date from tbl_order where order_id='".$_POST['order_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	
	function order_update($curdate){
		$log=$_SESSION['login_user'];
	
		$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');
		$delivery_date = DateTime::createFromFormat('d/m/Y', $_POST['delivery_date'])->format('Y-m-d');

		$sql= "update tbl_order set order_no='".$_POST['order_no']."',customer_id='".$_POST['customer_id']."',order_date='".$order_date."',delivery_date='".$delivery_date."',updated_by='".$log."',update_date='".$curdate."' where order_id='".$_POST['order_id']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){

			$rql="delete from tbl_order_details where order_id='".$_POST['order_id']."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);
			if($exec_rql){

				$i=0;
				foreach ($_POST['product_id'] as $key=>$order_id){					
				
					$qty=$_POST['qty'][$i];		
					$product_id= $_POST['product_id'][$i];	
					$uom_id= $_POST['uom_id'][$i];		
						
						$sql_details= "INSERT INTO tbl_order_details (order_id,product_id,uom_id,qty,created_by,create_date,delete_status) VALUES('".$_POST['order_id']."','".$product_id."','".$uom_id."','".$qty."','".$log."','".$curdate."','NDL')";
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				
	
					$i++;
				}
			}


			return true;

		}
		else{
			return false;
		}
	}
	/****************************************** */
	
		
}		
$objVDS=new order_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->order_details_delete($curdate);
}

else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->order_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->order_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>