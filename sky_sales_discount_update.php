<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');

		

class booking_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	

	function add_update($curdate){		
		$log=$_SESSION['login_user'];
		//$discount=0;
		$amount_discount=$_POST['amount_discount'];

		$sql= "select discount,gst_total_amount,total_amount from tbl_sky_gst_invoice where dc_id='".$_POST['dc_id']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);

		//print_r($sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			$row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC);

			//$discount=$row['discount'];
			$total_amount=$row['total_amount'];
			$gst_total_amount=$row['gst_total_amount'];
		}

		$total_discount=$amount_discount;

		$grand_total_amount=($total_amount+$gst_total_amount)-$total_discount;


		$sql= "update tbl_sky_gst_invoice set discount='".$total_discount."',grand_total_amount='".$grand_total_amount."' where dc_id='".$_POST['dc_id']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);

		
		if($exec_query){
			
			return true;
		}
		else{
			 return false;
		}
	}	
	
	/****************************************** */
	
		
}		
$objVDS=new booking_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='DISUPD'){
	$rtnMsg=$objVDS->add_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
// send data as json format
header("Content-Type: application/json",true);
echo json_encode($json);
?>