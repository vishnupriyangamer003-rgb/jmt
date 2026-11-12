<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class booking_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$supplier_id=$_POST['supplier_id'];
		//$order_date=$_POST['order_date'];		
		$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');		
		//$order_date1=date('Y-m-d',strtotime($_POST['order_date']));

		//print_r($order_date);

		$dc_no=$_POST['dc_no'];				
		
		$total_amount=$_POST['total_amount'];
		$tax_amount=$_POST['tax_amount'];
		//$cgst=$_POST['cgst'];
		//$sgst=$_POST['sgst'];
		//$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];

		

		$sql= "INSERT INTO tbl_raw_purchase (supplier_id,dc_no,purchase_date,billing_date,tax_amount,total_amount,grand_total_amount,created_by,create_date,delete_status) VALUES('".$supplier_id."','".$dc_no."','".$order_date."','".$order_date."','".$tax_amount."','".$total_amount."','".$grand_total_amount."','".$log."','".$curdate."','NDL')";
		//  print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$sql_select = "select * from tbl_raw_purchase where delete_status='NDL' order by purchase_id DESC";
		// print_r($sql_select);
		$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
		// print_r($exec_query_select);
		$fetch = mysqli_fetch_array($exec_query_select);

		$lastraw_purchase_id = $fetch['purchase_id'];
		if($exec_query){
			$i=0;
			foreach ($_POST['uom_id'] as $key=>$raw_material_id){						
				

				$sql_select_subuom = "select * from tbl_sub_uom where delete_status='NDL' and uom_id='".$_POST['uom_id'][$i]."' and sub_uom_id='".$_POST['sub_uom_id'][$i]."'";
				$exec_query_select_subuom = mysqli_query($this->mySQLconn, $sql_select_subuom);
				$fetch_subuom = mysqli_fetch_array($exec_query_select_subuom);


					$total_qty=$fetch_subuom['sub_uom_value']*$_POST['qty'][$i];

					if($total_qty==0){ $total_qty = ($_POST['qty'] ?? '')[$i]; }

					$qty=$_POST['qty'][$i];
				
				$name = $_POST['raw_material_id'][$i];
				//$raw_material_id = $_POST['raw_material_id'][$i];	
				$purchase_rate= $_POST['total_rate'][$i];				
				$hsn_code = $_POST['hsn_code'][$i];
				$rate = $_POST['rate'][$i];
				$rate_tax = $_POST['rate_tax'][$i];
				
				$gst = $_POST['gst'][$i];
				$raw_purchase_id=$lastraw_purchase_id;			
				$uom_id = $_POST['uom_id'][$i];
				$sub_uom_id = $_POST['sub_uom_id'][$i];

				//if(	$inspection !=0){	
					
					$sql_details= "INSERT INTO tbl_raw_purchase_details (purchase_id,raw_material_id,uom_id,sub_uom_id,hsn_code,gst,qty,total_qty,purchase_rate,rate,rate_tax,created_by,create_date,delete_status) VALUES('".$raw_purchase_id."','".$name."','".$uom_id."','".$sub_uom_id."','".$hsn_code."','".$gst."','".$qty."','".$total_qty."','".$purchase_rate."','".$rate."','".$rate_tax."','".$log."','".$curdate."','NDL')";
					//  print_r($sql);
					$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
				//}


				$i++;
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

		$supplier_id=$_POST['supplier_id'];
		//$order_date=$_POST['order_date'];		
		//$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');		
		//$order_date1=date('Y-m-d',strtotime($_POST['order_date']));

		//print_r($order_date);

		$dc_no=$_POST['dc_no'];				
		
		$total_amount=$_POST['total_amount'];
		$tax_amount=$_POST['tax_amount'];
		//$cgst=$_POST['cgst'];
		//$sgst=$_POST['sgst'];
		//$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];	
		
		$order_date = DateTime::createFromFormat('d/m/Y', $_POST['invoice_date'])->format('Y-m-d');	
		//$order_date=date('Y-m-d',strtotime($_POST['invoice_date']));

		$purchase_id=$_POST['purchase_id'];


		 $sql_pro= "update tbl_raw_purchase set  dc_no='".$_POST['dc_no']."',supplier_id='".$_POST['supplier_id']."',tax_amount='".$_POST['tax_amount']."',total_amount='".$_POST['total_amount']."',grand_total_amount='".$_POST['grand_total_amount']."', billing_date='".$order_date ."',updated_by='".$log."',update_date='".$curdate."' where purchase_id='".$_POST['purchase_id']."'";
		//  print_r($sql);
	    $exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
		
		if($exec_query_pro){
			$rql="delete from tbl_raw_purchase_details where purchase_id='".$_POST['purchase_id']."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);
			if($exec_rql){
				$i=0;
				foreach ($_POST['uom_id'] as $key=>$raw_material_id){				
				

					$sql_select_subuom = "select * from tbl_sub_uom where delete_status='NDL' and uom_id='".$_POST['uom_id'][$i]."' and sub_uom_id='".$_POST['sub_uom_id'][$i]."'";
					$exec_query_select_subuom = mysqli_query($this->mySQLconn, $sql_select_subuom);
					$fetch_subuom = mysqli_fetch_array($exec_query_select_subuom);


					$total_qty=$fetch_subuom['sub_uom_value']*$_POST['qty'][$i];

					if($total_qty==0){ $total_qty = ($_POST['qty'] ?? '')[$i]; }

					$qty=$_POST['qty'][$i];

					$name = $_POST['raw_material_id'][$i];
					//$raw_material_id = $_POST['raw_material_id'][$i];	
					$purchase_rate= $_POST['total_rate'][$i];				
					$hsn_code = $_POST['hsn_code'][$i];
					$rate = $_POST['rate'][$i];
					$rate_tax = $_POST['rate_tax'][$i];
					//$qty = $_POST['qty'][$i];
					$gst = $_POST['gst'][$i];
					$raw_purchase_id=$purchase_id;			
					$uom_id = $_POST['uom_id'][$i];
					$sub_uom_id = $_POST['sub_uom_id'][$i];
	
					//if(	$inspection !=0){	
						
						$sql_details= "INSERT INTO tbl_raw_purchase_details (purchase_id,raw_material_id,uom_id,sub_uom_id,hsn_code,gst,qty,total_qty,purchase_rate,rate,rate_tax,created_by,create_date,delete_status) VALUES('".$raw_purchase_id."','".$name."','".$uom_id."','".$sub_uom_id."','".$hsn_code."','".$gst."','".$qty."','".$total_qty."','".$purchase_rate."','".$rate."','".$rate_tax."','".$log."','".$curdate."','NDL')";
						//  print_r($sql);
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
					//}
	
	
					$i++;
				}
				if($exec_query_details){
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
			$sql= "update tbl_raw_purchase set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where purchase_id='".$_POST['delid']."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			
			if($exec_query){
				$sql_second= "update tbl_raw_purchase_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where purchase_id='".$_POST['delid']."'";
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
		$sql= "select * from tbl_raw_purchase where purchase_id='".$_POST['purchase_id']."' and delete_status='NDL'";
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
	/****************************************** */
	
		
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
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->booking_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>