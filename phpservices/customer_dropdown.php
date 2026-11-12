<?php 
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json", true);
include_once("connection.php");

// Contract (kept for existing callers — do not change shape):
// - List mode (no customer_id): arrays per field.
// - Single mode (customer_id + 1 row): scalars per field.
// Clients must normalize via pick(): Array.isArray(v) ? v[0] : v.

// $sql="SELECT customer_id,customer_name,company_name,gst_no,state,mblno,address FROM tbl_customer where delete_status='NDL'";

$reqId = $_POST['customer_id'] ?? '';
if($reqId === '' && !empty($_REQUEST['customer_id'])){
	// Tolerate legacy GET callers but prefer POST
	$reqId = $_REQUEST['customer_id'];
}
if($reqId !== ''){
	$customer=mysqli_real_escape_string($conn, $reqId);
	// Allow only numeric ids to prevent injection
	if(!ctype_digit((string)$customer)){ $customer='0'; }

	$sql="SELECT * FROM tbl_customer where delete_status='NDL' and customer_id='$customer'";
}
else{
	
$sql="SELECT * FROM tbl_customer where delete_status='NDL' order by customer_name ASC";
}


$query=mysqli_query($conn,$sql) ;
if($query === false){
	echo json_encode(array("error"=>"Customer lookup failed"));
	return;
}
while($row=mysqli_fetch_array($query)){
	$customer_id[]=$row['customer_id'];
	$customer_name[]=str_replace("^", "'", $row['customer_name']);
	$reference_name[]=str_replace("^", "'", ($row['reference_name'] ?? ''));
	$company_name[]=str_replace("^", "'", $row['company_name']);
	$owner_name[]=str_replace("^", "'", ($row['owner_name'] ?? ''));
	$address[]=str_replace("^", "'", $row['address']);
	$state[]=str_replace("^", "'", $row['state']);
	$mblno[]=str_replace("^", "'", $row['mblno']);
	$owner_contact[]=str_replace("^", "'", ($row['owner_contact'] ?? ''));
	$gst_no[]=str_replace("^", "'", $row['gst_no']);
	$email[]=str_replace("^", "'", $row['email']);
	$state_code[]=str_replace("^", "'", $row['state_code']);
	$reference_details[]=str_replace("^", "'", ($row['reference_details'] ?? ''));
	$status[]=($row['status'] ?? 'Active');
}

// Single-customer lookup: return scalars (not arrays) so detail panel shows one record
if($reqId !== '' && !empty($customer_id) && count($customer_id) === 1){
	$json = array("customer_id"=>$customer_id[0],"customer_name"=>$customer_name[0],"reference_name"=>$reference_name[0],"company_name"=>$company_name[0],"owner_name"=>$owner_name[0],"address"=>$address[0],"state"=>$state[0],"mblno"=>$mblno[0],"owner_contact"=>$owner_contact[0],"gst_no"=>$gst_no[0],"email"=>$email[0],"state_code"=>$state_code[0],"reference_details"=>$reference_details[0],"status"=>$status[0]);
	echo json_encode($json);
	return;
}

// UNDEF-GUARD: empty tables must still return valid JSON
$customer_id = $customer_id ?? []; 
$customer_name = $customer_name ?? []; 
$reference_name = $reference_name ?? [];
$company_name = $company_name ?? []; 
$owner_name = $owner_name ?? [];
$address = $address ?? []; 
$state = $state ?? []; 
$mblno = $mblno ?? []; 
$owner_contact = $owner_contact ?? [];
$gst_no = $gst_no ?? []; 
$email = $email ?? []; 
$state_code = $state_code ?? []; 
$reference_details = $reference_details ?? [];
$status = $status ?? [];
$json =array("customer_id"=>$customer_id,"customer_name"=>$customer_name,"reference_name"=>$reference_name,"company_name"=>$company_name,"owner_name"=>$owner_name,"address"=>$address,"state"=>$state,"mblno"=>$mblno,"owner_contact"=>$owner_contact,"gst_no"=>$gst_no,"email"=>$email,"state_code"=>$state_code,"reference_details"=>$reference_details,"status"=>$status);
	echo json_encode($json);
	
?> 