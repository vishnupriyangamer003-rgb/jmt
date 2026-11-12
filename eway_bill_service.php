<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class gst_invoice_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$order_type=$_POST['order_type'];
		$gstin=$_POST['gstin'];
		$legal_name=$_POST['legal_name'];
		$address=$_POST['address'];
		$place=$_POST['place'];
		$state=$_POST['state'];
		$pincode=$_POST['pincode'];

		$supply_type=$_POST['supply_type'];
		$sub_type=$_POST['sub_type'];
		$doc_type=$_POST['doc_type'];
		$doc_no=$_POST['doc_no'];
		$doc_date = DateTime::createFromFormat('d/m/Y', $_POST['doc_date'])->format('Y-m-d');

		$from_party_name=$_POST['from_party_name'];
		$from_gstin=$_POST['from_gstin'];
		$from_address1=$_POST['from_address1'];
		$from_address2=$_POST['from_address2'];
		$from_place=$_POST['from_place'];
		$from_pincode=$_POST['from_pincode'];
		$from_state=$_POST['from_state'];
		$from_dispatch=$_POST['from_dispatch'];

		$to_party_name=$_POST['to_party_name'];
		$to_gstin=$_POST['to_gstin'];
		$to_address1=$_POST['to_address1'];
		$to_address2=$_POST['to_address2'];
		$to_place=$_POST['to_place'];
		$to_pincode=$_POST['to_pincode'];
		$to_state=$_POST['to_state'];
		$ship_state=$_POST['ship_state'];


		$trans_mode=$_POST['trans_mode'];
		$distance=$_POST['distance'];
		$trans_name=$_POST['trans_name'];
		$trans_id=$_POST['trans_id'];
		$trans_doc_no=$_POST['trans_doc_no'];
		$trans_date = DateTime::createFromFormat('d/m/Y', $_POST['trans_date'])->format('Y-m-d');
		$vehicle_no=$_POST['vehicle_no'];
		$vehicle_type=$_POST['vehicle_type'];			

			$sql= "INSERT INTO tbl_eway_bill (order_type,gstin,legal_name,address,place,state,pincode,supply_type,sub_type,doc_type,doc_no,doc_date,from_party_name,from_gstin,from_address1,from_address2,from_place,from_pincode,from_state,from_dispatch,to_party_name,to_gstin,to_address1,to_address2,to_place,to_pincode,to_state,ship_state,trans_mode,distance,trans_name,trans_id,trans_doc_no,trans_date,vehicle_no,vehicle_type,created_by,create_date,delete_status) VALUES('".$order_type."','".$gstin."','".$legal_name."','".$address."','".$place."','".$state."','".$pincode."','".$supply_type."','".$sub_type."','".$doc_type."','".$doc_no."','".$doc_date."','".$from_party_name."','".$from_gstin."','".$from_address1."','".$from_address2."','".$from_place."','".$from_pincode."','".$from_state."','".$from_dispatch."','".$to_party_name."','".$to_gstin."','".$to_address1."','".$to_address2."','".$to_place."','".$to_pincode."','".$to_state."','".$ship_state."','".$trans_mode."','".$distance."','".$trans_name."','".$trans_id."','".$trans_doc_no."','".$trans_date."','".$vehicle_no."','".$vehicle_type."','".$log."','".$curdate."','NDL')";
			
			
			//print_r($sql);
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			$sql_select = "select * from tbl_eway_bill where delete_status='NDL' order by id DESC";
			// print_r($sql_select);
			$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
			// print_r($exec_query_select);
			$fetch = mysqli_fetch_array($exec_query_select);

			$last_id = $fetch['id'];
			if($exec_query){
				$i=0;
				foreach ($_POST['product_id'] as $key=>$product_id){								
					
					//$product_id = $_POST['product_id'][$i];	
					$product_id= $_POST['product_id'][$i];		
					$description= $_POST['description'][$i];
					$hsn_code = $_POST['hsn_code'][$i];
					$unit = $_POST['unit'][$i];
					$qty = $_POST['qty'][$i];
					$assessable_value = $_POST['assessable_value'][$i];
					$tax_rate = $_POST['tax_rate'][$i];
					$cgst = $_POST['cgst'][$i];
					$sgst = $_POST['sgst'][$i];
					$igst = $_POST['igst'][$i];
					$cess = $_POST['cess'][$i];
					$cess_non= $_POST['cess'][$i];
					$others = $_POST['others'][$i];
					$tot_invoice = $_POST['tot_invoice'][$i];
					$id=$last_id;					
						
						$sql_details= "INSERT INTO tbl_eway_bill_details (eb_id,product_id,description,hsn_code,unit,qty,assessable_value,tax_rate,cgst,sgst,igst,cess,cess_non,others,tot_invoice,created_by,create_date,delete_status) VALUES('".$id."','".$product_id."','".$description."','".$hsn_code."','".$unit."','".$qty."','".$assessable_value."','".$tax_rate."','".$cgst."','".$sgst."','".$igst."','".$cess."','".$cess_non."','".$others."','".$tot_invoice."','".$log."','".$curdate."','NDL')";
						//  print_r($sql_details);
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
					

					$i++;
				}
				
				return true;			
			
			}else{
				return false;
			}

	}

	
	
	function add_update($curdate){
		$log=$_SESSION['login_user'];

		$order_type=$_POST['order_type'];
		$gstin=$_POST['gstin'];
		$legal_name=$_POST['legal_name'];
		$address=$_POST['address'];
		$place=$_POST['place'];
		$state=$_POST['state'];
		$pincode=$_POST['pincode'];

		$supply_type=$_POST['supply_type'];
		$sub_type=$_POST['sub_type'];
		$doc_type=$_POST['doc_type'];
		$doc_no=$_POST['doc_no'];
		$doc_date = DateTime::createFromFormat('d/m/Y', $_POST['doc_date'])->format('Y-m-d');

		$from_party_name=$_POST['from_party_name'];
		$from_gstin=$_POST['from_gstin'];
		$from_address1=$_POST['from_address1'];
		$from_address2=$_POST['from_address2'];
		$from_place=$_POST['from_place'];
		$from_pincode=$_POST['from_pincode'];
		$from_state=$_POST['from_state'];
		$from_dispatch=$_POST['from_dispatch'];

		$to_party_name=$_POST['to_party_name'];
		$to_gstin=$_POST['to_gstin'];
		$to_address1=$_POST['to_address1'];
		$to_address2=$_POST['to_address2'];
		$to_place=$_POST['to_place'];
		$to_pincode=$_POST['to_pincode'];
		$to_state=$_POST['to_state'];
		$ship_state=$_POST['ship_state'];


		$trans_mode=$_POST['trans_mode'];
		$distance=$_POST['distance'];
		$trans_name=$_POST['trans_name'];
		$trans_id=$_POST['trans_id'];
		$trans_doc_no=$_POST['trans_doc_no'];
		$trans_date = DateTime::createFromFormat('d/m/Y', $_POST['trans_date'])->format('Y-m-d');
		$vehicle_no=$_POST['vehicle_no'];
		$vehicle_type=$_POST['vehicle_type'];	

		$eb_id=$_POST['eb_id'];

		
			$sql_pro= "update tbl_eway_bill set  order_type='".$order_type."',gstin='".$gstin."',legal_name='".$legal_name."',address='".$address."',place='".$place."',state='".$state."',pincode='".$pincode."',supply_type='".$supply_type."',sub_type='".$sub_type."',doc_type='".$doc_type."',doc_no='".$doc_no."',doc_date='".$doc_date."',from_party_name='".$from_party_name."',from_gstin='".$from_gstin."',from_address1='".$from_address1."',from_address2='".$from_address2."', from_place='".$from_place ."', from_pincode='".$from_pincode ."', from_state='".$from_state ."', from_dispatch='".$from_dispatch ."', to_party_name='".$to_party_name ."', to_gstin='".$to_gstin ."', to_address1='".$to_address1 ."', to_address2='".$to_address2 ."', to_place='".$to_place ."', to_pincode='".$to_pincode ."', to_state='".$to_state ."', ship_state='".$ship_state ."', trans_mode='".$trans_mode ."', distance='".$distance ."', trans_name='".$trans_name ."', trans_id='".$trans_id ."', trans_doc_no='".$trans_doc_no ."',trans_date='".$trans_date."',vehicle_no='".$vehicle_no."',vehicle_type='".$vehicle_type."',updated_by='".$log."',update_date='".$curdate."' where id='".$eb_id."'";
			//print_r($sql);
			$exec_query_pro=mysqli_query($this->mySQLconn, $sql_pro);
			
			if($exec_query_pro){
				$rql="delete from tbl_eway_bill_details where eb_id='".$_POST['eb_id']."'";
				$exec_rql=mysqli_query($this->mySQLconn, $rql);
				if($exec_rql){
					$i=0;
					foreach ($_POST['product_id'] as $key=>$product_id){						
					
					//$product_id = $_POST['product_id'][$i];	
					$product_id= $_POST['product_id'][$i];		
					$description= $_POST['description'][$i];
					$hsn_code = $_POST['hsn_code'][$i];
					$unit = $_POST['unit'][$i];
					$qty = $_POST['qty'][$i];
					$assessable_value = $_POST['assessable_value'][$i];
					$tax_rate = $_POST['tax_rate'][$i];
					$cgst = $_POST['cgst'][$i];
					$sgst = $_POST['sgst'][$i];
					$igst = $_POST['igst'][$i];
					$cess = $_POST['cess'][$i];
					$cess_non= $_POST['cess'][$i];
					$others = $_POST['others'][$i];
					$tot_invoice = $_POST['tot_invoice'][$i];
					$id=$_POST['eb_id'];					
						
						$sql_details= "INSERT INTO tbl_eway_bill_details (eb_id,product_id,description,hsn_code,unit,qty,assessable_value,tax_rate,cgst,sgst,igst,cess,cess_non,others,tot_invoice,created_by,create_date,delete_status) VALUES('".$id."','".$product_id."','".$description."','".$hsn_code."','".$unit."','".$qty."','".$assessable_value."','".$tax_rate."','".$cgst."','".$sgst."','".$igst."','".$cess."','".$cess_non."','".$others."','".$tot_invoice."','".$log."','".$curdate."','NDL')";
						//  print_r($sql_details);
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);
		
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
				return false;
			}
		}
	}

	


	function gst_invoice_delete($curdate){		
			$log=$_SESSION['login_user'];
			$sql= "update tbl_eway_bill set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where id='".$_POST['delid']."'";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			
			if($exec_query){
				$sql_second= "update tbl_eway_bill_details set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where eb_id='".$_POST['delid']."'";
			$exec_query_second=mysqli_query($this->mySQLconn, $sql_second);
				return true;
			}
			else{
				 return false;
			}
	}

	
	
	
	function gst_invoice_autobind($curdate){
		$bannerData=array();
		$sql="SELECT b.*,a.* FROM tbl_eway_bill  a inner join tbl_eway_bill_details b on a.id=b.eb_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.id='".$_POST['id']."'";

		//$sql= "select * from tbl_eway_bill where dc_id='".$_POST['dc_id']."' and delete_status='NDL'";
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
if(($_POST['req'] ?? '')=='ADDINS'){
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