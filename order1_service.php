<?php
include_once("sessionservices1.php");	
date_default_timezone_set('Asia/Kolkata');	
class order_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log='admin';

		$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');
		$delivery_date = DateTime::createFromFormat('d/m/Y', $_POST['delivery_date'])->format('Y-m-d');

		$sql= "INSERT INTO tbl_order (order_no,order_date,delivery_date,customer_id,created_by,create_date,delete_status) VALUES('".$_POST['order_no']."','".$order_date."','".$delivery_date."','".$_POST['customer_id']."','".$log."','".$curdate."','NDL')";
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
	
	
	/****************************************** */
	
		
}		
$objVDS=new order_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>