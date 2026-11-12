<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class booking_details_service{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$supplier_id=$_POST['supplier_id'];
		//$order_date=$_POST['order_date'];
		$od=DateTime::createFromFormat('d/m/Y', (string)($_POST['invoice_date'] ?? ''));
		$order_date = $od ? $od->format('Y-m-d') : date('Y-m-d');	
		$dc_no=$_POST['dc_no'];		
		
		$purchase_date=$_POST['purchase_date'];
		$purchase_no=$_POST['purchase_no'];		
		
		$total_amount=$_POST['total_amount'];
		$cgst=$_POST['cgst'];
		$sgst=$_POST['sgst'];
		$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];
		

		$sql= "INSERT INTO tbl_purchase (supplier_id,purchase_no,dc_no,billing_date,purchase_date,total_amount,sgst,cgst,gst_total_amount,grand_total_amount,created_by,create_date,delete_status) VALUES('".$supplier_id."','".$purchase_no."','".$dc_no."','".$order_date."','".$purchase_date."','".$total_amount."','".$sgst."','".$cgst."','".$gst_total_amount."','".$grand_total_amount."','".$log."','".$curdate."','NDL')";
		//  print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$sql_select = "select * from tbl_purchase where delete_status='NDL' order by purchase_id DESC";
		// print_r($sql_select);
		$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
		// print_r($exec_query_select);
		$fetch = mysqli_fetch_array($exec_query_select);

		$lastpurchase_id = $fetch['purchase_id'];
		if($exec_query){
			$i=0;
			foreach ($_POST['model_id'] as $key=>$product_id){		
				
				
				$category_id=$supplier_id;

				$model_sql= "select * from tbl_sub_category where sub_category_name='".$_POST['model_id'][$i]."' and delete_status='NDL'";
				$model_exec_query=mysqli_query($this->mySQLconn, $model_sql);
				$model_rows=mysqli_num_rows($model_exec_query);
				if($model_rows<1){
					
					$sql1= "INSERT INTO tbl_sub_category (sub_category_name,created_by,create_date,delete_status) VALUES('".$_POST['model_id'][$i]."','".$log."','".$curdate."','NDL')";					
					$exec_query1=mysqli_query($this->mySQLconn, $sql1);

					
				}

				$design_sql= "select * from tbl_design where design='".$_POST['design'][$i]."' and delete_status='NDL'";
				$design_exec_query=mysqli_query($this->mySQLconn, $design_sql);
				$design_rows=mysqli_num_rows($design_exec_query);
				if($design_rows<1){
					
					$sql2= "INSERT INTO tbl_design (design,created_by,create_date,delete_status) VALUES('".$_POST['design'][$i]."','".$log."','".$curdate."','NDL')";
					$exec_query2=mysqli_query($this->mySQLconn, $sql2);
				}


				$sub_category_sql= "select * from tbl_sub_category where  sub_category_name='".$_POST['model_id'][$i]."' and delete_status='NDL'";
				$sub_category_exec_query=mysqli_query($this->mySQLconn, $sub_category_sql);
				//$sub_category_rows=mysqli_num_rows($sub_category_exec_query);
				$sub_category_rows=mysqli_fetch_array($sub_category_exec_query,MYSQLI_ASSOC);
				$sub_category_id=$sub_category_rows['sub_category_id'];


				$design_sql1= "select * from tbl_design where  design='".$_POST['design'][$i]."' and delete_status='NDL'";
				$design_exec_query1=mysqli_query($this->mySQLconn, $design_sql1);
				//$sub_category_rows=mysqli_num_rows($sub_category_exec_query);
				$design_rows1=mysqli_fetch_array($design_exec_query1,MYSQLI_ASSOC);
				$design_id=$design_rows1['design_id'];


				$products_sql= "select * from tbl_products where  sub_category_id='".$sub_category_id."' and design='".$_POST['design'][$i]."' and delete_status='NDL'";
				$products_exec_query=mysqli_query($this->mySQLconn, $products_sql);
				$products_rows=mysqli_num_rows($products_exec_query);
				if($products_rows<1){
					
					$sql2= "INSERT INTO tbl_products (category_id,sub_category_id,hsn_code,uom_id,design,created_by,create_date,delete_status) VALUES('".$category_id."','".$sub_category_id."','".$_POST['hsn_code'][$i]."','".$_POST['uom_id'][$i]."','".$design_id."','".$log."','".$curdate."','NDL')";
					$exec_query2=mysqli_query($this->mySQLconn, $sql2);
				}

				$product_sql= "select * from tbl_products where category_id='".$category_id."' and  sub_category_id='".$sub_category_id."' and design='".$design_id."' and delete_status='NDL'";
				$product_exec_query=mysqli_query($this->mySQLconn, $product_sql);
				$product_rows=mysqli_fetch_array($product_exec_query,MYSQLI_ASSOC);
				//$product_rows=mysqli_num_rows($product_exec_query);

				$product_id = $product_rows['product_id'];
				//$product_id = $_POST['product_id'][$i];	
				$product_rate= $_POST['product_rate'][$i];				
				$hsn_code = $_POST['hsn_code'][$i];
				$rate = $_POST['rate'][$i];
				$man_day = $_POST['man_day'][$i];
				$purchase_id=$lastpurchase_id;			
				$uom_id = $_POST['uom_id'][$i];

				//if(	$inspection !=0){	
					
					$sql_details= "INSERT INTO tbl_purchase_details (purchase_id,product_id,model_id,design_id,hsn_code,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$purchase_id."','".$product_id."','".$sub_category_id."','".$design_id."','".$hsn_code."','".$uom_id."','".$man_day."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
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

		/*$supplier_id=$_POST['supplier_id'];
		//$order_date=$_POST['order_date'];
		$dc_no=$_POST['dc_no'];				
		
		$total_amount=$_POST['total_amount'];
		$cgst=$_POST['cgst'];
		$sgst=$_POST['sgst'];
		$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];*/
		
		//$order_date=date('Y-m-d',strtotime($_POST['invoice_date']));
		$od=DateTime::createFromFormat('d/m/Y', (string)($_POST['invoice_date'] ?? ''));
		$order_date = $od ? $od->format('Y-m-d') : date('Y-m-d');	
		$purchase_id=$_POST['purchase_id'];

		$supplier_id=$_POST['supplier_id'];
		//$order_date=$_POST['order_date'];
		$dc_no=$_POST['dc_no'];		
		
		$purchase_date=$_POST['purchase_date'];
		$purchase_no=$_POST['purchase_no'];		
		
		$total_amount=$_POST['total_amount'];
		$cgst=$_POST['cgst'];
		$sgst=$_POST['sgst'];
		$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];



		 $sql_pro= "update tbl_purchase set  dc_no='".$_POST['dc_no']."',supplier_id='".$_POST['supplier_id']."',total_amount='".$_POST['total_amount']."',cgst='".$_POST['cgst']."',sgst='".$_POST['sgst']."',gst_total_amount='".$_POST['gst_total_amount']."',grand_total_amount='".$_POST['grand_total_amount']."', billing_date='".$order_date ."',updated_by='".$log."',update_date='".$curdate."' where purchase_id='".$_POST['purchase_id']."'";
		//  print_r($sql);
	    $exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
		
		if($exec_query_pro){
			$rql="delete from tbl_purchase_details where purchase_id='".$_POST['purchase_id']."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);
			if($exec_rql){
				$i=0;
				foreach ($_POST['model_id'] as $key=>$product_id){			
						
				
					$category_id=$supplier_id;

					$model_sql= "select * from tbl_sub_category where sub_category_name='".$_POST['model_id'][$i]."' and delete_status='NDL'";
					$model_exec_query=mysqli_query($this->mySQLconn, $model_sql);
					$model_rows=mysqli_num_rows($model_exec_query);
					if($model_rows<1){
						
						$sql1= "INSERT INTO tbl_sub_category (sub_category_name,created_by,create_date,delete_status) VALUES('".$_POST['model_id'][$i]."','".$log."','".$curdate."','NDL')";					
						$exec_query1=mysqli_query($this->mySQLconn, $sql1);

						
					}

					$design_sql= "select * from tbl_design where design='".$_POST['design'][$i]."' and delete_status='NDL'";
					$design_exec_query=mysqli_query($this->mySQLconn, $design_sql);
					$design_rows=mysqli_num_rows($design_exec_query);
					if($design_rows<1){
						
						$sql2= "INSERT INTO tbl_design (design,created_by,create_date,delete_status) VALUES('".$_POST['design'][$i]."','".$log."','".$curdate."','NDL')";
						$exec_query2=mysqli_query($this->mySQLconn, $sql2);
					}


					$sub_category_sql= "select * from tbl_sub_category where  sub_category_name='".$_POST['model_id'][$i]."' and delete_status='NDL'";
					$sub_category_exec_query=mysqli_query($this->mySQLconn, $sub_category_sql);
					//$sub_category_rows=mysqli_num_rows($sub_category_exec_query);
					$sub_category_rows=mysqli_fetch_array($sub_category_exec_query,MYSQLI_ASSOC);
					$sub_category_id=$sub_category_rows['sub_category_id'];


					$design_sql1= "select * from tbl_design where  design='".$_POST['design'][$i]."' and delete_status='NDL'";
					$design_exec_query1=mysqli_query($this->mySQLconn, $design_sql1);
					//$sub_category_rows=mysqli_num_rows($sub_category_exec_query);
					$design_rows1=mysqli_fetch_array($design_exec_query1,MYSQLI_ASSOC);
					$design_id=$design_rows1['design_id'];


					$products_sql= "select * from tbl_products where  sub_category_id='".$sub_category_id."' and design='".$_POST['design'][$i]."' and delete_status='NDL'";
					$products_exec_query=mysqli_query($this->mySQLconn, $products_sql);
					$products_rows=mysqli_num_rows($products_exec_query);
					if($products_rows<1){
						
						$sql2= "INSERT INTO tbl_products (category_id,sub_category_id,hsn_code,uom_id,design,created_by,create_date,delete_status) VALUES('".$category_id."','".$sub_category_id."','".$_POST['hsn_code'][$i]."','".$_POST['uom_id'][$i]."','".$design_id."','".$log."','".$curdate."','NDL')";
						$exec_query2=mysqli_query($this->mySQLconn, $sql2);
					}

					$product_sql= "select * from tbl_products where category_id='".$category_id."' and  sub_category_id='".$sub_category_id."' and design='".$design_id."' and delete_status='NDL'";
					$product_exec_query=mysqli_query($this->mySQLconn, $product_sql);
					$product_rows=mysqli_fetch_array($product_exec_query,MYSQLI_ASSOC);
					//$product_rows=mysqli_num_rows($product_exec_query);

					$product_id = $product_rows['product_id'];
					//$product_id = $_POST['product_id'][$i];	
					$product_rate= $_POST['product_rate'][$i];				
					$hsn_code = $_POST['hsn_code'][$i];
					$rate = $_POST['rate'][$i];
					$man_day = $_POST['man_day'][$i];
					//$purchase_id=$lastpurchase_id;			
					$uom_id = $_POST['uom_id'][$i];

					//if(	$inspection !=0){	
						
						$sql_details= "INSERT INTO tbl_purchase_details (purchase_id,product_id,model_id,design_id,hsn_code,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$purchase_id."','".$product_id."','".$sub_category_id."','".$design_id."','".$hsn_code."','".$uom_id."','".$man_day."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
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
			$sql= "update tbl_purchase set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where purchase_id='".$_POST['delid']."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			
			if($exec_query){
				$sql_second= "update tbl_purchase_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where purchase_id='".$_POST['delid']."'";
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
else if(($_POST['req'] ?? '')=='PRODAUB'){
	$rtnMsg=$objVDS->booking_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>