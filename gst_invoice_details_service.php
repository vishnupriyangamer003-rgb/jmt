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

class gst_invoice_details_service{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	function esc($v){ return mysqli_real_escape_string($this->mySQLconn, (string)($v ?? '')); }
	function dbdate($dmy){ $r = function_exists('jayam_parse_date') ? jayam_parse_date($dmy ?? '') : null; return $r ?? date('Y-m-d'); }
	function sqlerr(){ $e = mysqli_error($this->mySQLconn); return $e !== '' ? 'SQL error: '.$e : 'SQL error: unknown database error'; }
	// Debug echo: builds the header/details SQL + data check WITHOUT writing, for POST debug=1
	function debug_insert(){
		$order_date = $this->dbdate($_POST['order_date'] ?? '');
		$vals = array(
			'customer_id'=>($this->esc($_POST['customer_id'] ?? '')),'company_name'=>($this->esc($_POST['company_name'] ?? '')),
			'mblno'=>($this->esc($_POST['mblno'] ?? '')),'email'=>($this->esc($_POST['email'] ?? '')),
			'address'=>($this->esc($_POST['address'] ?? '')),'gst_no'=>($this->esc($_POST['gst_no'] ?? '')),
			'state'=>($this->esc($_POST['state'] ?? '')),'state_code'=>($this->esc($_POST['state_code'] ?? '')),
			'delivery_address'=>($this->esc($_POST['delivery_address'] ?? '')),'convert_id'=>($this->esc($_POST['convert_id'] ?? '')),
			'convert_status'=>($this->esc($_POST['convert_status'] ?? '')),'suffix'=>($this->esc($_POST['suffix'] ?? '')),
			'dc_no'=>($this->esc($_POST['dc_no'] ?? '')),'billing_date'=>$order_date,
		);
		$dupSql = "select * from tbl_gst_invoice where suffix = '".$vals['suffix']."' and dc_no='".$vals['dc_no']."' ";
		$dup = mysqli_query($this->mySQLconn, $dupSql);
		$dupCount = ($dup !== false) ? (int)mysqli_num_rows($dup) : -1;
		$rows = [];
		foreach (($_POST['product_id'] ?? []) as $i=>$pid){
			$rows[] = array('product_id'=>($this->esc($pid)),'product_rate'=>($this->esc($_POST['product_rate'][$i] ?? '')),
				'uom_id'=>($this->esc($_POST['uom_id'][$i] ?? '')),'rate'=>($this->esc($_POST['rate'][$i] ?? '')),'qty'=>($this->esc($_POST['qty'][$i] ?? '')));
		}
		return array('debug'=>true,'post_keys'=>array_keys($_POST),'vals'=>$vals,'dup_sql'=>$dupSql,'dup_count'=>$dupCount,
			'row_count'=>count($rows),'rows'=>$rows,'db_error'=>mysqli_error($this->mySQLconn));
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$delivery_address=$this->esc($_POST['delivery_address'] ?? '');
		$customer_id=$this->esc($_POST['customer_id'] ?? '');
		//$order_date=$_POST['order_date'];
		$order_date = $this->dbdate($_POST['order_date'] ?? '');
		$dc_no=$this->esc($_POST['dc_no'] ?? '');	
		$suffix=$this->esc($_POST['suffix'] ?? '');	
		$advance_amount = (float)($_POST['advance_amount'] ?? 0);
		$payment_terms_days = ($_POST['payment_terms_days'] ?? '') === '' ? null : (int)$_POST['payment_terms_days'];
		
		$convert_id=$this->esc($_POST['convert_id'] ?? '');	
		$convert_status=$this->esc($_POST['convert_status'] ?? '');
		
		$total_amount=(float)($_POST['total_amount'] ?? 0);
		$cgst=(float)($_POST['cgst'] ?? 0);
		$sgst=(float)($_POST['sgst'] ?? 0);
		$gst_total_amount=(float)($_POST['gst_total_amount'] ?? 0);
		$grand_total_amount=(float)($_POST['grand_total_amount'] ?? 0);
		$discount=(float)($_POST['discount'] ?? 0);
		// Server-side guards: discount 0..(total+gst), advance 0..grand (recompute grand).
		$discount = max(0, min((float)$discount, (float)$total_amount + (float)$gst_total_amount));
		$grand_total_amount = (float)$total_amount + (float)$gst_total_amount - (float)$discount;
		$advance_amount = max(0, min($advance_amount, (float)$grand_total_amount));
		

		$driver_type = $this->esc($_POST['driver_type'] ?? '1');
		$driver_name = $this->esc($_POST['driver_name'] ?? '');
		$driver_id = $this->esc($_POST['driver_id'] ?? '');
		$vechicle_no = $this->esc($_POST['vechicle_no'] ?? '');
		$vechicle_id = $this->esc($_POST['vechicle_id'] ?? '');
		if($driver_type=='1'){
			$driver_name='';
			$driver_id=$this->esc($_POST['driver_id'] ?? '');
			$vechicle_no='';
			$vechicle_id=$this->esc($_POST['vechicle_id'] ?? '');
		}
		if($driver_type=='2'){
			$driver_name=$this->esc($_POST['driver_name'] ?? '');
			$driver_id='';
			$vechicle_no=$this->esc($_POST['vechicle_no'] ?? '');
			$vechicle_id='';
		}
		
		//$vechicle_no=($_POST['vechicle_no'] ?? '');	

		$refrence_name=$this->esc($_POST['refrence_name'] ?? '');
		$company_name=$this->esc($_POST['company_name'] ?? '');
		$mblno=$this->esc($_POST['mblno'] ?? '');
		$email=$this->esc($_POST['email'] ?? '');
		$address=$this->esc($_POST['address'] ?? '');
		$gst_no=$this->esc($_POST['gst_no'] ?? '');
		$state=$this->esc($_POST['state'] ?? '');
		$state_code=$this->esc($_POST['state_code'] ?? '');
		
		
		$duplicate=mysqli_query($this->mySQLconn,"select * from tbl_gst_invoice where suffix = '".$suffix."' and dc_no='".$dc_no."' ");
		if($duplicate === false){
			return $this->sqlerr();
		}
		if (mysqli_num_rows($duplicate)>0)
		{			
			return 2;

		}else{

		// Reject item-less saves BEFORE writing: header-only bills never appear in the list.
		$validRows=0;
		foreach (($_POST['product_id'] ?? []) as $pid){ if($pid !== '' && $pid !== null){ $validRows++; } }
		if($validRows === 0){
			return 'Add at least one product before saving.';
		}

		

			$sql= "INSERT INTO tbl_gst_invoice (customer_id,company_name,mblno,email,address,gst_no,state,state_code,delivery_address,convert_id,convert_status,suffix,dc_no,billing_date,total_amount,discount,sgst,cgst,gst_total_amount,grand_total_amount,advance_amount,payment_terms_days,driver_type,driver_name,driver_id,vechicle_number,vechicle_id,refrence_name,created_by,create_date,delete_status) VALUES('".$customer_id."','".$company_name."','".$mblno."','".$email."','".$address."','".$gst_no."','".$state."','".$state_code."','".$delivery_address."','".$convert_id."','".$convert_status."','".$suffix."','".$dc_no."','".$order_date."','".$total_amount."','".$discount."','".$sgst."','".$cgst."','".$gst_total_amount."','".$grand_total_amount."','".$advance_amount."',".($payment_terms_days === null ? "NULL" : "'".$payment_terms_days."'").",'".$driver_type."','".$driver_name."','".$driver_id."','".$vechicle_no."','".$vechicle_id."','".$refrence_name."','".$log."','".$curdate."','NDL')";
			
			
			//print_r($sql);
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query === false){
				return $this->sqlerr();
			}
			$lastdc_id = (int)mysqli_insert_id($this->mySQLconn);
			if($lastdc_id <= 0){
				$sql_select = "select * from tbl_gst_invoice where delete_status='NDL' order by dc_id DESC";
				$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
				$fetch = ($exec_query_select !== false) ? mysqli_fetch_array($exec_query_select) : false;
				$lastdc_id = $fetch ? (int)$fetch['dc_id'] : 0;
			}
			if($exec_query){
				$i=0;
				$detailErr='';
				$detailRows=0;
				foreach (($_POST['product_id'] ?? []) as $key=>$product_id){		
							
					
					//$product_id = $_POST['product_id'][$i];	
					$product_id=$this->esc($product_id);
					$product_rate=$this->esc($_POST['product_rate'][$i] ?? '');
					$uom_id=$this->esc($_POST['uom_id'][$i] ?? '');
					$rate=$this->esc($_POST['rate'][$i] ?? '');
					$qty=$this->esc($_POST['qty'][$i] ?? '');
					$dc_id=$lastdc_id;
					if($product_id === '' || $product_id === null){ $i++; continue; }

					//if(	$inspection !=0){	
						
						$sql_details= "INSERT INTO tbl_gst_invoice_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$dc_id."','".$product_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
						//  print_r($sql);
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
						if($exec_query_details === false && $detailErr === ''){ $detailErr=$this->sqlerr(); }
						else if($exec_query_details !== false){ $detailRows++; }
					//}

					$i++;
				}
				if($detailErr !== ''){ return $detailErr; }

				// Auto-record bill-level advance as first receipt row (keeps outstanding consistent).
				if ($advance_amount > 0) {
					$advStmt = mysqli_prepare($this->mySQLconn, "INSERT INTO tbl_receipt (customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,remarks,created_by,create_date,delete_status) VALUES (?,?,?,?,?,?,?,?,?,?, 'NDL')");
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


				if(!empty($convert_status) && !empty($convert_id)){
					$sql_pro1= "update tbl_non_dc set  convert_id='".$lastdc_id."',convert_status='".$convert_status."' where dc_id='".$convert_id."'";
					$exec_query_pro1=mysqli_query($this->mySQLconn, $sql_pro1);
		
				}
				

				/*$final_dest='userdata/images/product_details';
				if(is_dir( $final_dest)==FALSE){
					mkdir($final_dest,0777,TRUE);
				}
				copy('temp/'.$_POST['photo_name'],$final_dest.'/'.$_POST['photo_name']);*/
				return array('ok'=>1,'dc_id'=>$lastdc_id,'rows'=>$detailRows);
			}
			else{
				return false;
			}
		}

	}

	
	
	function add_update($curdate){
		$log=$_SESSION['login_user'];
		$delivery_address=$this->esc($_POST['delivery_address'] ?? '');
		$customer_id=$this->esc($_POST['customer_id'] ?? '');
		//$order_date=$_POST['order_date'];
		$dc_no=$this->esc($_POST['dc_no'] ?? '');	
		$suffix=$this->esc($_POST['suffix'] ?? '');	
		
	
		$total_amount=(float)($_POST['total_amount'] ?? 0);
		$cgst=(float)($_POST['cgst'] ?? 0);
		$sgst=(float)($_POST['sgst'] ?? 0);
		$gst_total_amount=(float)($_POST['gst_total_amount'] ?? 0);
		$grand_total_amount=(float)($_POST['grand_total_amount'] ?? 0);
		$discount=(float)($_POST['discount'] ?? 0);
		$advance_amount = (float)($_POST['advance_amount'] ?? 0);
		$payment_terms_days = ($_POST['payment_terms_days'] ?? '') === '' ? null : (int)$_POST['payment_terms_days'];
		// Server-side guards: discount 0..(total+gst), advance 0..grand (recompute grand).
		$discount = max(0, min((float)$discount, (float)$total_amount + (float)$gst_total_amount));
		$grand_total_amount = (float)$total_amount + (float)$gst_total_amount - (float)$discount;
		$advance_amount = max(0, min($advance_amount, (float)$grand_total_amount));
		
		$order_date = $this->dbdate($_POST['invoice_date'] ?? '');
		//$order_date=date('Y-m-d',strtotime($_POST['invoice_date']));
		$dc_id=$this->esc($_POST['dc_id'] ?? '');

		$driver_type = $_POST['driver_type'] ?? '1';
		$driver_name = $this->esc($_POST['driver_name'] ?? '');
		$driver_id = $this->esc($_POST['driver_id'] ?? '');
		$vechicle_no = $this->esc($_POST['vechicle_no'] ?? '');
		$vechicle_id = $this->esc($_POST['vechicle_id'] ?? '');
		if($driver_type=='1'){
			$driver_name='';
			$driver_id=$this->esc($_POST['driver_id'] ?? '');
			$vechicle_no='';
			$vechicle_id=$this->esc($_POST['vechicle_id'] ?? '');
		}
		if($driver_type=='2'){
			$driver_name=$this->esc($_POST['driver_name'] ?? '');
			$driver_id='';
			$vechicle_no=$this->esc($_POST['vechicle_no'] ?? '');
			$vechicle_id='';
		}
		
		//$vechicle_no=($_POST['vechicle_no'] ?? '');	

		$refrence_name=$this->esc($_POST['refrence_name'] ?? '');

		$dup_count=0;
		$duplicate=mysqli_query($this->mySQLconn,"select count(dc_no) as total_count from tbl_gst_invoice where dc_no='".$dc_no."' and  suffix = '".$suffix."' ");
		if($duplicate === false){
			return $this->sqlerr();
		}
		if($dup_row=mysqli_fetch_assoc($duplicate)){
			$dup_count=(int)($dup_row['total_count'] ?? 0);
		}

		if($dup_count==2)
		{			
			return;

		}else{

			$sql_pro= "update tbl_gst_invoice set  delivery_address='".$delivery_address."',driver_type='".$driver_type."',driver_name='".$driver_name."',driver_id='".$driver_id."',vechicle_number='".$vechicle_no."',vechicle_id='".$vechicle_id."',refrence_name='".$refrence_name."',dc_no='".$dc_no."',customer_id='".$customer_id."',total_amount='".$total_amount."',discount='".$discount."',cgst='".$cgst."',sgst='".$sgst."',gst_total_amount='".$gst_total_amount."',grand_total_amount='".$grand_total_amount."',advance_amount='".$advance_amount."',payment_terms_days=".($payment_terms_days === null ? "NULL" : "'".$payment_terms_days."'").", billing_date='".$order_date ."',updated_by='".$log."',update_date='".$curdate."' where dc_id='".$dc_id."'";
			//print_r($sql);
			$exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
			if($exec_query_pro === false){
				return $this->sqlerr();
			}
			
			if($exec_query_pro){
				$rql="delete from tbl_gst_invoice_details where dc_id='".$dc_id."'";
				$exec_rql=mysqli_query($this->mySQLconn, $rql);
				if($exec_rql === false){
					return $this->sqlerr();
				}
				if($exec_rql){
					$i=0;
					$detailErr='';
					foreach (($_POST['product_id'] ?? []) as $key=>$product_id){						
					

						//$product_id = $_POST['product_id'][$i];	
						$product_id=$this->esc($product_id);
						$product_rate=$this->esc($_POST['product_rate'][$i] ?? '');
						$uom_id=$this->esc($_POST['uom_id'][$i] ?? '');
						$rate=$this->esc($_POST['rate'][$i] ?? '');
						$qty=$this->esc($_POST['qty'][$i] ?? '');
						if($product_id === '' || $product_id === null){ $i++; continue; }				
		
						//if(	$inspection !=0){	
							
							$sql_details= "INSERT INTO tbl_gst_invoice_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) VALUES('".$dc_id."','".$product_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
							//  print_r($sql);
							$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
							if($exec_query_details === false && $detailErr === ''){ $detailErr=$this->sqlerr(); }
						//}
		
						$i++;
					}
					if($detailErr !== ''){ return $detailErr; }
					if($exec_query_details){
						// Sync bill-level advance receipt: replace existing Advance rows only (preserve real payments).
						$syncDel = mysqli_query($this->mySQLconn, "UPDATE tbl_receipt SET delete_status='0',delete_by='".$log."',delete_date='".$curdate."' WHERE dc_id='".$dc_id."' AND payment_mode='Advance' AND delete_status='NDL'");
						if ($advance_amount > 0) {
							$advRow = mysqli_fetch_assoc(mysqli_query($this->mySQLconn, "SELECT dc_no,customer_id,billing_date FROM tbl_gst_invoice WHERE dc_id='".$dc_id."' LIMIT 1"));
							$advStmt = mysqli_prepare($this->mySQLconn, "INSERT INTO tbl_receipt (customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,remarks,created_by,create_date,delete_status) VALUES (?,?,?,?,?,?,?,?,?,?, 'NDL')");
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
	}

	


	function gst_invoice_delete($curdate){		
			$log=$_SESSION['login_user'];
			$delid=$this->esc($_POST['delid'] ?? '');
			$sql= "update tbl_gst_invoice set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$delid."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			
			if($exec_query){
				$sql_second= "update tbl_gst_invoice_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$delid."'";
			$exec_query_second=mysqli_query($this->mySQLconn, $sql_second);

				$sql_3= "update tbl_receipt set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where dc_id='".$delid."'";
				$exec_query_3=mysqli_query($this->mySQLconn, $sql_3);

				return true;
			}
			else{
				 return false;
			}
	}

	
	
	
	function gst_invoice_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_gst_invoice where dc_id='".$this->esc($_POST['dc_id'] ?? '')."' and delete_status='NDL'";
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
$objVDS=new gst_invoice_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if((($_POST['debug'] ?? '')=='1') && (($_POST['req'] ?? '')=='ADDINS')){
	$rtnMsg=$objVDS->debug_insert($curdate);
}
else if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->add_update($curdate);
}

else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->gst_invoice_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->gst_invoice_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>