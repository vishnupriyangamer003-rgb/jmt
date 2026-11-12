<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class sky_gst_invoice_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$delivery_address=$_POST['delivery_address'];
		$customer_id=$_POST['customer_id'];
		//$order_date=$_POST['order_date'];
		$order_date = DateTime::createFromFormat('d/m/Y', $_POST['order_date'])->format('Y-m-d');	
		$dc_no=$_POST['dc_no'];	
		$suffix=$_POST['suffix'];	
		$convert_id=$_POST['convert_id'];	
		$convert_status=$_POST['convert_status'];
		
		$total_amount=$_POST['total_amount'];
		$cgst=$_POST['cgst'];
		$sgst=$_POST['sgst'];
		$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];
		$discount=$_POST['discount'];
		

		$driver_type = $_POST['driver_type'] ?? '1';
		$driver_name = ($_POST['driver_name'] ?? '') ?? '';
		$driver_id = ($_POST['driver_id'] ?? '') ?? '';
		$vechicle_no = ($_POST['vechicle_no'] ?? '') ?? '';
		$vechicle_id = ($_POST['vechicle_id'] ?? '') ?? '';
		if($driver_type=='1'){
			$driver_name='';
			$driver_id=($_POST['driver_id'] ?? '');
			$vechicle_no='';
			$vechicle_id=($_POST['vechicle_id'] ?? '');
		}
		if($driver_type=='2'){
			$driver_name=($_POST['driver_name'] ?? '');
			$driver_id='';
			$vechicle_no=($_POST['vechicle_no'] ?? '');
			$vechicle_id='';
		}
		
		//$vechicle_no=($_POST['vechicle_no'] ?? '');	

		$refrence_name=$_POST['refrence_name'];
		
		//echo $duplicate="select * from tbl_sky_gst_invoice where dc_no='".$_POST['dc_no']."' HAVING COUNT(dc_no) >1 ";
		
		//echo "select * from tbl_sky_gst_invoice where suffix='".$suffix."' and dc_no='".$_POST['dc_no']."'";

		$duplicate=mysqli_query($this->mySQLconn,"select * from tbl_sky_gst_invoice where suffix='".$suffix."' and dc_no='".$_POST['dc_no']."'");
		//$fetch_sql = mysqli_fetch_array($duplicate);
		if (mysqli_num_rows($duplicate)>0)
		{
			
			
			return;

		}else{
		

			 $sql= "INSERT INTO tbl_sky_gst_invoice (customer_id,company_name,mblno,email,address,gst_no,state,state_code,delivery_address,convert_id,convert_status,suffix,dc_no,billing_date,total_amount,discount,sgst,cgst,gst_total_amount,grand_total_amount,driver_type,driver_name,driver_id,vechicle_number,vechicle_id,refrence_name,created_by,create_date,delete_status) VALUES('".$customer_id."','".$_POST['company_name']."','".$_POST['mblno']."','".$_POST['email']."','".$_POST['address']."','".$_POST['gst_no']."','".$_POST['state']."','".$_POST['state_code']."','".$delivery_address."','".$convert_id."','".$convert_status."','".$suffix."','".$dc_no."','".$order_date."','".$total_amount."','".$discount."','".$sgst."','".$cgst."','".$gst_total_amount."','".$grand_total_amount."','".$driver_type."','".$driver_name."','".$driver_id."','".$vechicle_no."','".$vechicle_id."','".$refrence_name."','".$log."','".$curdate."','NDL')";
			
			
			//print_r($sql);
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			$sql_select = "select * from tbl_sky_gst_invoice where delete_status='NDL' order by dc_id DESC";
			// print_r($sql_select);
			$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
			// print_r($exec_query_select);
			$fetch = mysqli_fetch_array($exec_query_select);

			$lastdc_id = $fetch['dc_id'];
			if($exec_query){
				$i=0;
				foreach ($_POST['product_id'] as $key=>$product_id){		
							
					
					//$product_id = $_POST['product_id'][$i];	
					$product_rate= $_POST['product_rate'][$i];		
					$uom_id= $_POST['uom_id'][$i];
					$rate = $_POST['rate'][$i];
					$qty = $_POST['qty'][$i];
					$dc_id=$lastdc_id;

					//if(	$inspection !=0){	
						
						$sql_details= "INSERT INTO tbl_sky_gst_invoice_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$dc_id."','".$product_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
						// print_r($sql);
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
					//}

					$i++;
				}


				if(!empty($convert_status) && !empty($convert_id)){
					$sql_pro1= "update tbl_non_dc set convert_id='".$lastdc_id."',convert_status='".$convert_status."' where dc_id='".$convert_id."'";
					$exec_query_pro1=mysqli_query($this->mySQLconn, $sql_pro1);
		
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

	}

	
	
	function add_update($curdate){
		$log=$_SESSION['login_user'];
		$delivery_address=$_POST['delivery_address'];
		$customer_id=$_POST['customer_id'];
		//$order_date=$_POST['order_date'];
		$dc_no=$_POST['dc_no'];	 
		$suffix=$_POST['suffix'];	 
		$total_amount=$_POST['total_amount'];
		$cgst=$_POST['cgst'];
		$sgst=$_POST['sgst'];
		$gst_total_amount=$_POST['gst_total_amount'];
		$grand_total_amount=$_POST['grand_total_amount'];
		$discount=$_POST['discount'];
		
		$order_date = DateTime::createFromFormat('d/m/Y', $_POST['invoice_date'])->format('Y-m-d');
		//$order_date=date('Y-m-d',strtotime($_POST['invoice_date']));
		$dc_id=$_POST['dc_id'];

		$driver_type = $_POST['driver_type'] ?? '1';
		$driver_name = ($_POST['driver_name'] ?? '') ?? '';
		$driver_id = ($_POST['driver_id'] ?? '') ?? '';
		$vechicle_no = ($_POST['vechicle_no'] ?? '') ?? '';
		$vechicle_id = ($_POST['vechicle_id'] ?? '') ?? '';
		if($driver_type=='1'){
			$driver_name='';
			$driver_id=($_POST['driver_id'] ?? '');
			$vechicle_no='';
			$vechicle_id=($_POST['vechicle_id'] ?? '');
		}
		if($driver_type=='2'){
			$driver_name=($_POST['driver_name'] ?? '');
			$driver_id='';
			$vechicle_no=($_POST['vechicle_no'] ?? '');
			$vechicle_id='';
		}
		
		//$vechicle_no=($_POST['vechicle_no'] ?? '');	

		$refrence_name=$_POST['refrence_name'];

		$duplicate=mysqli_query($this->mySQLconn,"select count(dc_no) as total_count from tbl_sky_gst_invoice where dc_no='".$_POST['dc_no']."' and suffix='".$suffix."' ");
		$duplicate_query_pro=mysqli_query($this->mySQLconn, $duplicate);
					
		$dup_count=$duplicate_query_pro['total_count'];

		if($dup_count==2)
		{			
			return;

		}else{

			$sql_pro= "update tbl_sky_gst_invoice set delivery_address='".$delivery_address."',driver_type='".$driver_type."',driver_name='".$driver_name."',driver_id='".$driver_id."',vechicle_number='".$vechicle_no."',vechicle_id='".$vechicle_id."',refrence_name='".$refrence_name."',dc_no='".$dc_no."',customer_id='".$customer_id."',total_amount='".$total_amount."',discount='".$discount."',cgst='".$cgst."',sgst='".$sgst."',gst_total_amount='".$gst_total_amount."',grand_total_amount='".$grand_total_amount."', billing_date='".$order_date ."',updated_by='".$log."',update_date='".$curdate."' where dc_id='".$dc_id."'";
			//print_r($sql);
			$exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
			
			if($exec_query_pro){
				$rql="delete from tbl_sky_gst_invoice_details where dc_id='".$_POST['dc_id']."'";
				$exec_rql=mysqli_query($this->mySQLconn, $rql);
				if($exec_rql){
					$i=0;
					foreach ($_POST['product_id'] as $key=>$product_id){						
					

						//$product_id = $_POST['product_id'][$i];	
						$product_rate= $_POST['product_rate'][$i];		
						$uom_id= $_POST['uom_id'][$i];
						$rate = $_POST['rate'][$i];
						$qty = $_POST['qty'][$i];				
		
						//if(	$inspection !=0){	
							
							$sql_details= "INSERT INTO tbl_sky_gst_invoice_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$dc_id."','".$product_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
							// print_r($sql);
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
	}

	


	function sky_gst_invoice_delete($curdate){		
			$log=$_SESSION['login_user'];
			$sql= "update tbl_sky_gst_invoice set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$_POST['delid']."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			
			if($exec_query){
				$sql_second= "update tbl_sky_gst_invoice_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$_POST['delid']."'";
			$exec_query_second=mysqli_query($this->mySQLconn, $sql_second);

				$sql_3= "update tbl_receipt set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$_POST['delid']."'";
				$exec_query_3=mysqli_query($this->mySQLconn, $sql_3);

				return true;
			}
			else{
				 return false;
			}
	}

	
	
	
	function sky_gst_invoice_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_sky_gst_invoice where dc_id='".$_POST['dc_id']."' and delete_status='NDL'";
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
$objVDS=new sky_gst_invoice_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->add_update($curdate);
}

else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->sky_gst_invoice_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->sky_gst_invoice_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>
