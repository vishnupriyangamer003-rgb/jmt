<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	

if (file_exists(__DIR__ . '/phpservices/jayam_helpers.php')) {
    require_once __DIR__ . '/phpservices/jayam_helpers.php';
}
if (!function_exists('jayam_parse_date')) {
    function jayam_parse_date($date_str, $fmt = 'd/m/Y') {
        if ($date_str === null || trim((string)$date_str) === '') return null;
        $date_str = trim((string)$date_str);
        $d = DateTime::createFromFormat($fmt, $date_str);
        if ($d && $d->format($fmt) === $date_str) {
            return $d->format('Y-m-d');
        }
        $d2 = DateTime::createFromFormat('Y-m-d', $date_str);
        if ($d2 && $d2->format('Y-m-d') === $date_str) {
            return $d2->format('Y-m-d');
        }
        $ts = strtotime(str_replace('/', '-', $date_str));
        return $ts !== false ? date('Y-m-d', $ts) : null;
    }
}

class dc_details_service{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	function esc($v){ return mysqli_real_escape_string($this->mySQLconn, (string)($v ?? '')); }
	function dbdate($dmy){ $r = function_exists('jayam_parse_date') ? jayam_parse_date($dmy ?? '') : null; return $r ?? date('Y-m-d'); }
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$delivery_address=$_POST['delivery_address'];
		$customer_id=$_POST['customer_id'];
		//$order_date=$_POST['order_date'];
		$order_date = $this->dbdate($_POST['order_date'] ?? '');
		$dc_no=$_POST['dc_no'];	
		$order_id=$_POST['order_id'] ?? '';
		$advance_amount = (float)($_POST['advance_amount'] ?? 0);
		$payment_terms_days = ($_POST['payment_terms_days'] ?? '') === '' ? null : (int)$_POST['payment_terms_days'];
		$service_place = in_array(($_POST['service_place'] ?? ''), ['Outdoor','Workshop'], true) ? $_POST['service_place'] : null;
		$is_service_bill = !empty($_POST['is_service_bill']) ? 1 : 0;
		
		
		
		$total_amount=$_POST['total_amount'];		
		$grand_total_amount=$_POST['grand_total_amount'];
		// Server-side guards: discount 0..total, advance 0..grand (recompute grand).
		$_POST['discount'] = max(0, min((float)($_POST['discount'] ?? 0), (float)$total_amount));
		$grand_total_amount = (float)$total_amount - (float)$_POST['discount'];
		$advance_amount = max(0, min($advance_amount, (float)$grand_total_amount));
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
		

		$sql= "INSERT INTO tbl_non_dc (customer_id,company_name,mblno,email,address,gst_no,state,state_code,delivery_address,order_id,dc_no,billing_date,total_amount,discount,driver_type,driver_name,driver_id,vechicle_number,vechicle_id,grand_total_amount,advance_amount,payment_terms_days,service_place,is_service_bill,refrence_name,created_by,create_date,delete_status) VALUES('".$customer_id."','".$_POST['company_name']."','".$_POST['mblno']."','".$_POST['email']."','".$_POST['address']."','".$_POST['gst_no']."','".$_POST['state']."','".$_POST['state_code']."','".$delivery_address."','".$order_id."','".$dc_no."','".$order_date."','".$total_amount."','".$this->esc($_POST['discount'] ?? '')."','".$driver_type."','".$driver_name."','".$driver_id."','".$vechicle_no."','".$vechicle_id."','".$grand_total_amount."','".$advance_amount."',".($payment_terms_days === null ? "NULL" : "'".$payment_terms_days."'").",".($service_place === null ? "NULL" : "'".$service_place."'").",'".$is_service_bill."','".$refrence_name."','".$log."','".$curdate."','NDL')";
		 //print_r($sql);
	 $exec_query=mysqli_query($this->mySQLconn, $sql);
		$sql_select = "select * from tbl_non_dc where delete_status='NDL' order by dc_id DESC";
		// print_r($sql_select);
		$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
		// print_r($exec_query_select);
		$fetch = mysqli_fetch_array($exec_query_select);

		$lastdc_id = $fetch['dc_id'];
		if($exec_query){
			$i=0;
			foreach (($_POST['product_id'] ?? []) as $key=>$product_id){		
						
				
				//$product_id = $_POST['product_id'][$i];	
				$product_rate= $_POST['product_rate'][$i];		
				
				$rate = $_POST['rate'][$i];
				$qty = $_POST['qty'][$i];
				$uom_id = $_POST['uom_id'][$i];
				$dc_id=$lastdc_id;

				//if(	$inspection !=0){	
					
					$sql_details= "INSERT INTO tbl_non_dc_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$dc_id."','".$product_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
					// print_r($sql);
					$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
				//}

				$i++;
			}

			// Auto-record bill-level advance as first receipt row (keeps outstanding consistent).
			if ($advance_amount > 0) {
				$advStmt = mysqli_prepare($this->mySQLconn, "INSERT INTO tbl_non_receipt (customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,remarks,created_by,create_date,delete_status) VALUES (?,?,?,?,?,?,?,?,?,?, 'NDL')");
				if ($advStmt) {
					$advMode = 'Advance';
					$advBank = '';
					$advRemark = 'Bill-level advance';
					$advDcNo = (string)$dc_no;
					$advCust = (string)$customer_id;
					mysqli_stmt_bind_param($advStmt, 'ssssssdsss', $advCust, $advDcNo, $order_date, $lastdc_id, $advMode, $advBank, $advance_amount, $advRemark, $log, $curdate);
					mysqli_stmt_execute($advStmt);
					mysqli_stmt_close($advStmt);
				}
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
		$delivery_address=$_POST['delivery_address'];
		$customer_id=$_POST['customer_id'];
		//$order_date=$_POST['order_date'];
		$dc_no=$_POST['dc_no'];		
		
		$order_date = $this->dbdate($_POST['invoice_date'] ?? '');
		//$order_date=date('Y-m-d',strtotime($_POST['invoice_date']));
		$dc_id=$_POST['dc_id'];
		$advance_amount = (float)($_POST['advance_amount'] ?? 0);
		$payment_terms_days = ($_POST['payment_terms_days'] ?? '') === '' ? null : (int)$_POST['payment_terms_days'];
		$service_place = in_array(($_POST['service_place'] ?? ''), ['Outdoor','Workshop'], true) ? $_POST['service_place'] : null;
		$is_service_bill = !empty($_POST['is_service_bill']) ? 1 : 0;

		$total_amount=$_POST['total_amount'];		
		$grand_total_amount=$_POST['grand_total_amount'];
		// Server-side guards: discount 0..total, advance 0..grand (recompute grand).
		$_POST['discount'] = max(0, min((float)($_POST['discount'] ?? 0), (float)$total_amount));
		$grand_total_amount = (float)$total_amount - (float)$_POST['discount'];
		$advance_amount = max(0, min($advance_amount, (float)$grand_total_amount));
		$driver_type = $_POST['driver_type'] ?? '1';
		$driver_name = ($_POST['driver_name'] ?? '') ?? '';
		$driver_id = ($_POST['driver_id'] ?? '') ?? '';
		$vechicle_no = ($_POST['vechicle_no'] ?? '') ?? '';
		$vechicle_id = ($_POST['vechicle_id'] ?? '') ?? '';
		$driver_name=($_POST['driver_name'] ?? '');
		$driver_id=($_POST['driver_id'] ?? '');
		//$vechicle_no=($_POST['vechicle_no'] ?? '');

		$refrence_name=$_POST['refrence_name'];

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


		 $sql_pro= "update tbl_non_dc set delivery_address='".$delivery_address."',driver_type='".$driver_type."',driver_name='".$driver_name."',driver_id='".$driver_id."',vechicle_number='".$vechicle_no."',vechicle_id='".$vechicle_id."',refrence_name='".$refrence_name."',dc_no='".$dc_no."',customer_id='".$_POST['customer_id']."',total_amount='".$total_amount."',discount='".$this->esc($_POST['discount'] ?? '')."',grand_total_amount='".$grand_total_amount."',advance_amount='".$advance_amount."',payment_terms_days=".($payment_terms_days === null ? "NULL" : "'".$payment_terms_days."'").",service_place=".($service_place === null ? "NULL" : "'".$service_place."'").",is_service_bill='".$is_service_bill."', billing_date='".$order_date ."',updated_by='".$log."',update_date='".$curdate."' where dc_id='".$dc_id."'";
		// print_r($sql);
	 $exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
		
		if($exec_query_pro){
			$rql="delete from tbl_non_dc_details where dc_id='".$dc_id."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);
			if($exec_rql){
				$i=0;
				foreach (($_POST['product_id'] ?? []) as $key=>$product_id){							
				
					//$product_id = $_POST['product_id'][$i];	
					$product_rate= $_POST['product_rate'][$i];		
					$uom_id = $_POST['uom_id'][$i];
					$rate = $_POST['rate'][$i];
					$qty = $_POST['qty'][$i];	
						
						$sql_details= "INSERT INTO tbl_non_dc_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$dc_id."','".$product_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";						
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
					
	
					$i++;
				}
				if($exec_query_details){
					// Sync bill-level advance receipt: replace existing Advance rows only (preserve real payments). Covers spares + service bills.
					mysqli_query($this->mySQLconn, "UPDATE tbl_non_receipt SET delete_status='0',delete_by='".$log."',delete_date='".$curdate."' WHERE dc_id='".$dc_id."' AND payment_mode='Advance' AND delete_status='NDL'");
					if ($advance_amount > 0) {
						$advRow = mysqli_fetch_assoc(mysqli_query($this->mySQLconn, "SELECT dc_no,customer_id,billing_date FROM tbl_non_dc WHERE dc_id='".$dc_id."' LIMIT 1"));
						$advStmt = mysqli_prepare($this->mySQLconn, "INSERT INTO tbl_non_receipt (customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,remarks,created_by,create_date,delete_status) VALUES (?,?,?,?,?,?,?,?,?,?, 'NDL')");
						if ($advStmt && $advRow) {
							$advMode = 'Advance'; $advBank = ''; $advRemark = 'Bill-level advance';
							$advCust = (string)$advRow['customer_id']; $advDcNo = (string)$advRow['dc_no']; $advDate = (string)$advRow['billing_date'];
							mysqli_stmt_bind_param($advStmt, 'ssssssdsss', $advCust, $advDcNo, $advDate, $dc_id, $advMode, $advBank, $advance_amount, $advRemark, $log, $curdate);
							mysqli_stmt_execute($advStmt);
							mysqli_stmt_close($advStmt);
						}
					}
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

	


	function dc_delete($curdate){		
			$log=$_SESSION['login_user'];
			$sql= "update tbl_non_dc set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$_POST['delid']."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			

			
			if($exec_query){
				$sql_second= "update tbl_non_dc_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$_POST['delid']."'";
				$exec_query_second=mysqli_query($this->mySQLconn, $sql_second);

				$sql_3= "update tbl_non_receipt set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$_POST['delid']."'";
				$exec_query_3=mysqli_query($this->mySQLconn, $sql_3);


				return true;
			}
			else{
				 return false;
			}
	}

	function dc_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_non_dc where dc_id='".$_POST['dc_id']."' and delete_status='NDL'";
	 $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}

	
	/*function booking_grid_delete($curdate){		
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
			$sql= "delete from tbl_products_details where product_details_id='".$_POST['proj_det_id']."'";
		 
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
	}*/
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


			$sql_delete= "delete from tbl_products_details where product_id='".$_POST['product_id']."'";

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
$objVDS=new dc_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->add_update($curdate);
}

else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->dc_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->dc_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>
