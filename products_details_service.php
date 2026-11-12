<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class products_details_service{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	function esc($v){ return mysqli_real_escape_string($this->mySQLconn, (string)($v ?? '')); }
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$prRaw = trim((string)($_POST['purchase_rate'] ?? ''));
		$prSql = ($prRaw === '' ? "NULL" : "'".$this->esc($prRaw)."'");
		$opRaw = trim((string)($_POST['opening_stock'] ?? ''));
		$opSql = ($opRaw === '' ? "0" : "'".$this->esc($opRaw)."'");

		$uomVal = !empty($_POST['uom_id']) ? $this->esc($_POST['uom_id']) : '0';
		$sql= "INSERT INTO tbl_products (product_name,product_code,uom_id,hsn_code,sale_price,purchase_rate,opening_stock,gst,category,status,created_by,create_date,delete_status) VALUES('".$this->esc($_POST['product_name'] ?? '')."','".$this->esc($_POST['product_code'] ?? '')."','".$uomVal."','".$this->esc($_POST['hsn_code'] ?? '')."','".$this->esc($_POST['sale_amount'] ?? '')."',".$prSql.",".$opSql.",'".$this->esc($_POST['gst'] ?? '')."','".$this->esc($_POST['category'] ?? '')."','".$this->esc($_POST['status'] ?? 'Active')."','".$log."','".$curdate."','NDL')";
		//  print_r($sql);
	    $exec_query=mysqli_query($this->mySQLconn, $sql);


		$sql_select = "select * from tbl_products where delete_status='NDL' order by product_id DESC";
		$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
		$fetch = mysqli_fetch_array($exec_query_select);

		$lastproduct_id = $fetch['product_id'];

		if($exec_query){
			foreach (($_POST['raw_material_id'] ?? []) as $key=>$product_id){
				// BOM optional: skip rows with no material or no qty (traded spares/service items)
				$qty = trim((string)($_POST['qty'][$key] ?? ''));
				$raw_material_id = $_POST['raw_material_id'][$key] ?? '';
				if($raw_material_id === '' || $raw_material_id === null || $qty === '' || (float)$qty <= 0) continue;
					
					$sql_details= "INSERT INTO tbl_product_details (product_id,raw_material_id,qty,created_by,create_date,delete_status) VALUES('".$lastproduct_id."','".$this->esc($raw_material_id)."','".$this->esc($qty)."','".$log."','".$curdate."','NDL')";
					$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);				
			}

			return true;
		}
		else{
			 return false;
		}
	}
	
	function product_details_delete($curdate){		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_products set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where product_id='".$_POST['delid']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){

			$sql1= "update tbl_product_details set delete_status='0',deleted_by='".$log."',delete_date='".$curdate."' where product_id='".$_POST['delid']."'";
			$exec_query1=mysqli_query($this->mySQLconn, $sql1);

			return true;
		}
		else{
			 return false;
		}
	}
	
	
	function product_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_products where product_id='".$_POST['id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function product_update($curdate){
		$log=$_SESSION['login_user'];
		$prRaw = trim((string)($_POST['purchase_rate'] ?? ''));
		$prSql = ($prRaw === '' ? "purchase_rate=NULL" : "purchase_rate='".$this->esc($prRaw)."'");
		$opRaw = trim((string)($_POST['opening_stock'] ?? ''));
		$opSql = ($opRaw === '' ? "opening_stock=opening_stock" : "opening_stock='".$this->esc($opRaw)."'");
	
		$uomVal = !empty($_POST['uom_id']) ? $this->esc($_POST['uom_id']) : '0';
		$sql= "update tbl_products set product_name='".$this->esc($_POST['product_name'] ?? '')."',product_code='".$this->esc($_POST['product_code'] ?? '')."',uom_id='".$uomVal."',sale_price='".$this->esc($_POST['sale_amount'] ?? '')."',hsn_code='".$this->esc($_POST['hsn_code'] ?? '')."',gst='".$this->esc($_POST['gst'] ?? '')."',category='".$this->esc($_POST['category'] ?? '')."',status='".$this->esc($_POST['status'] ?? 'Active')."',".$prSql.",".$opSql.",updated_by='".$log."',update_date='".$curdate."' where product_id='".$this->esc($_POST['product_id'] ?? '')."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){

			$rql="delete from tbl_product_details where product_id='".$_POST['product_id']."'";
			$exec_rql=mysqli_query($this->mySQLconn, $rql);
			if($exec_rql){

				foreach (($_POST['raw_material_id'] ?? []) as $key=>$product_id){
					// BOM optional: skip rows with no material or no qty (traded spares/service items)
					$qty = trim((string)($_POST['qty'][$key] ?? ''));
					$raw_material_id = $_POST['raw_material_id'][$key] ?? '';
					if($raw_material_id === '' || $raw_material_id === null || $qty === '' || (float)$qty <= 0) continue;
						
						$sql_details= "INSERT INTO tbl_product_details (product_id,raw_material_id,qty,created_by,create_date,delete_status) VALUES('".$_POST['product_id']."','".$this->esc($raw_material_id)."','".$this->esc($qty)."','".$log."','".$curdate."','NDL')";
						$exec_query_details=mysqli_query($this->mySQLconn, $sql_details);			
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
$objVDS=new products_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='PRODEDEL'){
	$rtnMsg=$objVDS->product_details_delete($curdate);
}

else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->product_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='PRODUPD'){
	$rtnMsg=$objVDS->product_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>