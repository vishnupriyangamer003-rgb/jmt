<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');

		$curdate=date('Y-m-d H:i:s');
		$log=$_SESSION['login_user'];

		$week_date=$_POST['week_date'];
		$emp_id=$_POST['emp_id'];	
		$pay_amount=$_POST['pay_amount'];


		$ts = strtotime($week_date);
		// find the year (ISO-8601 year number) and the current week
		$year = date('o', $ts);
		$week = date('W', $ts);

		$start_date=strtotime($year.'W'.$week.'1');
		$end_date=strtotime($year.'W'.$week.'7');

		$start_date1=date("Y-m-d", $start_date);
		$end_date1=date("Y-m-d", $end_date);

						

		$sql= "INSERT INTO tbl_emp_bundle_salary(emp_id,start_date,end_date,pay_amount,created_by,create_date,delete_status) VALUES('".$emp_id."','".$start_date1."','".$end_date1."','".$pay_amount."','".$log."','".$curdate."','NDL')";
		
		//print_r($sql);

	    $exec_query=mysqli_query($conn, $sql);
		
		if($exec_query){			
			
			$result=1;
		}
		else{
			$result=0;
		}


		
$json = array("op" =>$result);
			
// send data as json format
header("Content-Type: application/json",true);
	echo json_encode($json);

/*class booking_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$supplier_id=$_POST['supplier_id'];
		$dc_no=$_POST['dc_no'];
		$purchase_id=$_POST['purchase_id'];
		$billing_date=$_POST['billing_date'];		
		$pay_amount=$_POST['pay_amount'];				

		$sql= "INSERT INTO tbl_payment(supplier_id,dc_no,billing_date,purchase_id,pay_amount,created_by,create_date,delete_status) VALUES('".$supplier_id."','".$dc_no."','".$billing_date."','".$purchase_id."','".$pay_amount."','".$log."','".$curdate."','NDL')";
		
		print_r($sql);

	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		
		if($exec_query){
			
			return true;
		}
		else{
			 return $sql;
		}

	}

	
	
	function add_update($curdate){
		$log=$_SESSION['login_user'];

		$customer_id=$_POST['customer_id'];
		$order_detail=$_POST['order_detail'];
		$billing_type=$_POST['billing_type'];
		$booking_type=$_POST['booking_type'];
		$supplier_id=$_POST['supplier_id'];

		if($billing_type=='1'){
			$billing_no=$_POST['proforma_no'];
			$billing_date=$_POST['proforma_date'];
		}
		if($billing_type=='2'){
			$billing_no=$_POST['invoice_no'];
			$billing_date=$_POST['invoice_date'];
		}
		if($billing_type=='3'){
			$billing_no=$_POST['debit_no'];
			$billing_date=$_POST['debit_date'];
		}
		if($billing_type=='4'){
			$billing_no=$_POST['credit_no'];
			$billing_date=$_POST['credit_date'];
		}

		
		$total_amount=$_POST['total_amount'];
		$cgst=$_POST['cgst'];
		$sgst=$_POST['sgst'];
		$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];
		
		$billing_date=date('Y-m-d',strtotime($_POST['billing_date']));

		 $sql_pro= "update tbl_booking set  order_detail='".$_POST['order_detail']."',supplier_id='".$_POST['supplier_id']."',customer_id='".$_POST['customer_id']."',total_amount='".$_POST['total_amount']."',cgst='".$_POST['cgst']."',sgst='".$_POST['sgst']."',gst_total_amount='".$_POST['gst_total_amount']."',grand_total_amount='".$_POST['grand_total_amount']."', billing_date='".$billing_date ."',updated_by='".$log."',update_date='".$curdate."' where booking_id='".$_POST['booking_id']."'";
		//  print_r($sql);
	    $exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
		
		if($exec_query_pro){
			$rql="delete from tbl_booking_details where booking_id='".$_POST['booking_id']."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);
			if($exec_rql){
				for($i=0;$i<count($_POST['product_id']);$i++){					
					
				$inspection = $_POST['inspection'][$i];
				$product_id = $_POST['product_id'][$i];	
				$size = $_POST['size'][$i];
				$product_rate= $_POST['product_rate'][$i];	
				$hsn_code = $_POST['hsn_code'][$i];
				$rate = $_POST['rate'][$i];
				$man_day = $_POST['man_day'][$i];
				$color_id = $_POST['color_id'][$i];	
				$unit_id = $_POST['unit_id'][$i];	
				$composition = $_POST['composition'][$i];
				$currency = $_POST['currency'][$i];
				
				$sql= "INSERT INTO tbl_booking_details (booking_id,inspection,product_id,style,size,hsn_code,color_id,unit_id,composition,currency,product_rate,rate,man_day,created_by,create_date,delete_status) VALUES('".$_POST['booking_id']."','".$_POST['inspection'][$i]."','".$_POST['product_id'][$i]."','".$_POST['size'][$i]."','".$_POST['size'][$i]."','".$_POST['hsn_code'][$i]."','".$_POST['color_id'][$i]."','".$_POST['unit_id'][$i]."','".$_POST['composition'][$i]."','".$_POST['currency'][$i]."','".$_POST['product_rate'][$i]."','".$_POST['rate'][$i]."','".$_POST['man_day'][$i]."','".$log."','".$curdate."','NDL')";
				//print_r($sql);
					$exec_query=mysqli_query($this->mySQLconn, $sql);
				}
				if($exec_query){
					return true;
				}	
				else{
					 return false;
				}
			}
			else{
				 return $rql;
			}
		}
		else{
			 return false;
		}
	}

	


	function booking_delete($curdate){		
			$log=$_SESSION['login_user'];
			$sql= "update tbl_booking set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where booking_id='".$_POST['delid']."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			
			if($exec_query){
				$sql_second= "update tbl_booking_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where booking_id='".$_POST['delid']."'";
			$exec_query_second=mysqli_query($this->mySQLconn, $sql_second);
				return true;
			}
			else{
				 return false;
			}
	}

	
	function booking_grid_delete($curdate){		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_booking set delete_status='0',delete_date='".$curdate."' where booking_id='".$_POST['delid']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		
		if($exec_query){
			$sql_second= "update tbl_booking_details set delete_status='0',delete_date='".$curdate."' where booking_id='".$_POST['delid']."'";
		$exec_query_second=mysqli_query($this->mySQLconn, $sql_second);
			return true;
		}
		else{
			 return false;
		}
	}
	
	function booking_details_delete($curdate){		
		$log=$_SESSION['login_user'];
			$sql= "delete from tbl_products_details  where product_details_id='".$_POST['proj_det_id']."'";
		    
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query){
				
				return true;
			}
			else{
				 return false;
			}
		}
	
	function booking_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_products where product_id='".$_POST['product_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function booking_update($curdate){
		$log=$_SESSION['login_user'];
		if(($_POST['photo_new_name'] ?? '')==''){
			$photo=$_POST['photo_old_name'];
		}
		else{
			$photo=$_POST['photo_new_name'];
		}
	
		$sql= "update tbl_products set design_id='".$_POST['design_id']."',size_id='".$_POST['size_id']."',product_name='".$_POST['product_name']."',imgname='".$photo."',description='".$_POST['description']."',updated_by='".$log."',update_date='".$curdate."' where product_id='".$_POST['product_id']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){


			$sql_delete= "delete from tbl_products_details  where product_id='".$_POST['product_id']."'";

				$exec_query_delete=mysqli_query($this->mySQLconn, $sql_delete);
			if($exec_query_delete){
				$i=0;
				foreach ($_POST['department_id'] as $key=>$department_id){				
					$department_id = $_POST['department_id'][$i];
				
					$rate = $_POST['rate'][$i];
					$product_details_id=$_POST['product_details_id'][$i];
					$product_id=$_POST['product_id'];			 
					$sub_department_id = $_POST['sub_department_id'][$i];
					$sql_details= "INSERT INTO tbl_products_details (product_id,department_id,sub_department_id,rate,created_by,create_date) VALUES('".$product_id."','".$department_id."','".$sub_department_id."','".$rate."','".$log."','".$curdate."')";$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
					

					$i++;
				}
				}

				if($exec_query_details){
						if(($_POST['photo_new_name'] ?? '')!=''){
							$final_dest='userdata/images/product_details';
							if(is_dir( $final_dest)==FALSE){
								mkdir($final_dest,0777,TRUE);
							}
							copy('temp/'.$_POST['photo_new_name'],$final_dest.'/'.$_POST['photo_new_name']);
							//unlink('userdata/images/banner/'.$_POST['photo_old_name']);
						}
						return true;
				}
		}
		else{
			return false;
		}
	}
	/****************************************** *
	
		
}		
$objVDS=new booking_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='ADDUPD'){
	$rtnMsg=$objVDS->add_update($curdate);
}

else if(($_POST['req'] ?? '')=='ADDDEL'){
	$rtnMsg=$objVDS->booking_delete($curdate);
}
else if(($_POST['req'] ?? '')=='PRODAUB'){
	$rtnMsg=$objVDS->booking_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);*/
?>