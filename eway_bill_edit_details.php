<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>
    <link rel="icon" type="image/png" href="userdata/images/favicon.png">

    <!-- begin::global styles -->
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">
	<link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
    <!-- end::global styles -->

    <!-- begin::datepicker -->
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <!-- begin::datepicker -->

    <!-- begin::vmap -->
    <link rel="stylesheet" href="vendors/vmap/jqvmap.min.css">
    <!-- begin::vmap -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- end::custom styles -->

</head>
<body>
	<style>
		.no-wrap{
			word-break: break-all;
		}
		</style>
<?php include('sessionservices.php');?>
<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<!-- end::page loader -->

<?php echo $header;?>

<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>E-Way Bill DETAILS</h4>
           
        </div>
    </div>

	<?php
			$sql="SELECT *,a.id,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.doc_date,'%d/%m/%Y') as doc_date,date_format(a.trans_date,'%d/%m/%Y') as trans_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_eway_bill  a 
			inner join tbl_eway_bill_details b on a.id=b.eb_id  WHERE  a.delete_status!='0' and  b.delete_status!='0'  and a.id='".$_GET['id']."'";
			$exec_sql=mysqli_query($conn,$sql);
			$fetch_sql=mysqli_fetch_array($exec_sql);
	?>

	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12">						
								
								<div class="form-group row">
									<div class="col-md-4">
                                    	<label for="staticEmail" class="col-form-label text-left">Are you a : </label>
                                    
										<select  class="form-control" id="order_type" name="order_type" >
											<option value='0'>-- Select --</option>
											<option value='1' <?php if($fetch_sql['order_type']=='1'){ echo 'selected'; } ?>>Tax Payer</option>
											<option value='2'  <?php if($fetch_sql['order_type']=='2'){ echo 'selected'; } ?>>Transporter</option>
									
										</select>
									</div>	

									

								</div>
								<br>

								<div class="form-group row">

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">GSTIN / Transporter ID : </label>
                                    
										<input type="text" id="gstin" class="form-control" placeholder="Enter GSTIN" name="gstin" value="<?php echo $fetch_sql['gstin']; ?>" >
									</div>

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Legal Name : </label>
                                    
										<input type="text" id="legal_name" class="form-control" placeholder="Enter legal Name" name="legal_name"  value="<?php echo $fetch_sql['legal_name']; ?>" >
									</div>

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Address : </label>
                                    
										<input type="text" id="address" class="form-control" placeholder="Enter Address" name="address"  value="<?php echo $fetch_sql['address']; ?>">
									</div>

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Place : </label>
										
										<input type="text" id="place" class="form-control" placeholder="Enter Place" name="place" value="<?php echo $fetch_sql['place']; ?>" >
										
									</div>									

								</div>	
								
								<div class="form-group row">									

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">State  : </label>
                                    
										<input type="text" id="state" class="form-control" placeholder="Enter State" name="state" value="<?php echo $fetch_sql['state']; ?>" >
									</div>

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Pincode : </label>
                                    
										<input type="text" id="pincode" class="form-control" placeholder="Enter Pincode" name="pincode"  value="<?php echo $fetch_sql['pincode']; ?>">
									</div>								

								</div>                                   
								<hr> 
								
								<div class="form-group row">
									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Supply Type : </label>
                                    
										<select  class="form-control" id="supply_type" name="supply_type" >
											<option value='0'>-- Select --</option>
											<option value='1'>Inward</option>
											<option value='2'>Outward</option>
										</select>
									</div>

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Sub Type : </label>
                                    
										<select  class="form-control" id="sub_type" name="sub_type" >
											<option value='0'>-- Select --</option>
											<option value='1'>Supply</option>
											<option value='2'>Import</option>
											<option value='3'>SKD/CKD</option>
											<option value='4'>Job work returns</option>
											<option value='5'>Sales returns</option>
											<option value='6'>Exhibition or Fairs</option>
											<option value='7'>For Own Use</option>
											<option value='8'>Others</option>

											<option value='1'>Supply</option>
											<option value='9'>Export</option>
											<option value='10'>Job Work</option>
											<option value='3'>SKD/CKD</option>
											<option value='11'>Recipient Not Known</option>
											<option value='7'>For Own Use</option>
											<option value='6'>Exhibition or Fairs</option>
											<option value='12'>Lines Sales</option>
											<option value='8'>Others</option>
											
										</select>
									</div>

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Doc Type : </label>
                                    
										<select  class="form-control" id="doc_type" name="doc_type" >
											<option value='0'>-- Select --</option>	
											<option value='1'>Tax Invoice</option>
											<option value='2'>Bill to Supply</option>
											<option value='3'>Bill to Entry</option>
											<option value='4'>Delivery Challan</option>
											<option value='5'>Others</option>
										</select>
									</div>
									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Doc No : </label>
										
										<input type="text" id="doc_no" class="form-control" placeholder="Enter Doc No " name="doc_no" value="<?php echo $fetch_sql['doc_no']; ?>" >
										
									</div>

									

								</div>
								<div class="form-group row">									

									<div class="col-md-3">
										<label for="staticEmail" class="col-form-label text-left">Doc Date  : </label>
                                    
										<input type="text" id="doc_date" class="form-control" placeholder="Pick Doc Date" name="doc_date" value="<?php echo $fetch_sql['doc_date']; ?>" >
									</div>

																

								</div> 

                            </div>



							<div class="col-md-6">					 
								
									
								<div class="form-group row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label text-left">From Other Party Name :</label>
                                    <div class="col-md-5">
										<input type="text" class="form-control" id="from_party_name" name="from_party_name" placeholder="Enter Party Name" value="<?php echo $fetch_sql['from_party_name']; ?>">
									</div>
								</div>
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">From GSTIN :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="from_gstin" name="from_gstin" placeholder="Enter GSTIN" value="<?php echo $fetch_sql['from_gstin']; ?>" >
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">From  Address1 :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="from_address1" name="from_address1" placeholder="Enter Address1" value="<?php echo $fetch_sql['from_address1']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">From  Address2 :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="from_address2" name="from_address2" placeholder="Enter Address2" value="<?php echo $fetch_sql['from_address2']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">From Place :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="from_place" name="from_place" placeholder="Enter Place" value="<?php echo $fetch_sql['from_place']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">From Pincode :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="from_pincode" name="from_pincode" placeholder="Enter Pincode" value="<?php echo $fetch_sql['from_pincode']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">From State :</label>
									<div class="col-sm-5">
										<select  class="form-control" id="from_state" name="from_state" >
											<option value='0'>-- Select --</option>
											<option value='1'>JAMMU AND KASHMIR</option>
											<option value='2'>HIMACHAL PRADESH</option>
											<option value='3'>PUNJAB</option>
											<option value='4'>CHANDIGARH</option>
											<option value='5'>UTTARAKHAND</option>
											<option value='6'>HARYANA</option>
											<option value='7'>DELHI</option>
											<option value='8'>RAJASTHAN</option>
											<option value='9'>UTTAR PRADESH</option>
											<option value='10'>BIHAR</option>
											<option value='11'>SIKKIM</option>
											<option value='12'>ARUNACHAL PRADESH</option>
											<option value='13'>NAGALAND</option>
											<option value='14'>MANIPUR</option>
											<option value='15'>MIZORAM</option>
											<option value='16'>TRIPURA</option>
											<option value='17'>MEGHALAYA</option>
											<option value='18'>ASSAM</option>
											<option value='19'>WEST BENGAL</option>
											<option value='20'>JHARKHAND</option>
											<option value='21'>ORISSA</option>
											<option value='22'>CHHATTISGARH</option>
											<option value='23'>MADHYA PRADESH</option>
											<option value='24'>GUJARAT</option>
											<option value='25'>DADAR AND NAGAR HAVELI & DAMAN AND DIU</option>
											<option value='26'>MAHARASHTRA</option>
											<option value='27'>KARNATAKA</option>
											<option value='28'>GOA</option>
											<option value='29'>LAKSHADWEEP</option>
											<option value='30'>KERALA</option>
											<option value='31'>TAMIL NADU</option>
											<option value='32'>PUDUCHERRY</option>
											<option value='33'>ANDAMAN AND NICOBAR</option>
											<option value='34'>TELANGANA</option>
											<option value='35'>ANDHRA PRADESH</option>
											<option value='36'>LADAKH</option>
											<option value='37'>OTHER TERRITORY</option>
											<option value='38'>OTHER COUNTRY</option>
										</select>
									</div>
								</div> 
								
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">Dispatch State :</label>
									<div class="col-sm-5">
										<select  class="form-control" id="from_dispatch" name="from_dispatch" >
											<option value='0'>-- Select --</option>
											<option value='1'>JAMMU AND KASHMIR</option>
											<option value='2'>HIMACHAL PRADESH</option>
											<option value='3'>PUNJAB</option>
											<option value='4'>CHANDIGARH</option>
											<option value='5'>UTTARAKHAND</option>
											<option value='6'>HARYANA</option>
											<option value='7'>DELHI</option>
											<option value='8'>RAJASTHAN</option>
											<option value='9'>UTTAR PRADESH</option>
											<option value='10'>BIHAR</option>
											<option value='11'>SIKKIM</option>
											<option value='12'>ARUNACHAL PRADESH</option>
											<option value='13'>NAGALAND</option>
											<option value='14'>MANIPUR</option>
											<option value='15'>MIZORAM</option>
											<option value='16'>TRIPURA</option>
											<option value='17'>MEGHALAYA</option>
											<option value='18'>ASSAM</option>
											<option value='19'>WEST BENGAL</option>
											<option value='20'>JHARKHAND</option>
											<option value='21'>ORISSA</option>
											<option value='22'>CHHATTISGARH</option>
											<option value='23'>MADHYA PRADESH</option>
											<option value='24'>GUJARAT</option>
											<option value='25'>DADAR AND NAGAR HAVELI & DAMAN AND DIU</option>
											<option value='26'>MAHARASHTRA</option>
											<option value='27'>KARNATAKA</option>
											<option value='28'>GOA</option>
											<option value='29'>LAKSHADWEEP</option>
											<option value='30'>KERALA</option>
											<option value='31'>TAMIL NADU</option>
											<option value='32'>PUDUCHERRY</option>
											<option value='33'>ANDAMAN AND NICOBAR</option>
											<option value='34'>TELANGANA</option>
											<option value='35'>ANDHRA PRADESH</option>
											<option value='36'>LADAKH</option>
											<option value='37'>OTHER TERRITORY</option>
											<option value='38'>OTHER COUNTRY</option>
											
										</select>
									</div>
								</div> 
								     
                            </div>

								
							<div class="col-md-6">					 
								
									
								<div class="form-group row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label text-left">To Other Party Name :</label>
                                    <div class="col-md-5">
										<input type="text" class="form-control" id="to_party_name" name="to_party_name" placeholder="Enter Party Name" value="<?php echo $fetch_sql['to_party_name']; ?>">
									</div>
								</div>
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">To GSTIN :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="to_gstin" name="to_gstin" placeholder="Enter GSTIN" value="<?php echo $fetch_sql['to_gstin']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">To  Address1 :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="to_address1" name="to_address1" placeholder="Enter Address1" value="<?php echo $fetch_sql['to_address1']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">To  Address2 :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="to_address2" name="to_address2" placeholder="Enter Address2" value="<?php echo $fetch_sql['to_address2']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">To Place :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="to_place" name="to_place" placeholder="Enter Place" value="<?php echo $fetch_sql['to_place']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">To Pincode :</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="to_pincode" name="to_pincode" placeholder="Enter Pincode" value="<?php echo $fetch_sql['to_pincode']; ?>">
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">To State :</label>
									<div class="col-sm-5">
										<select  class="form-control" id="to_state" name="to_state" >
											<option value='0'>-- Select --</option>
											<option value='1'>JAMMU AND KASHMIR</option>
											<option value='2'>HIMACHAL PRADESH</option>
											<option value='3'>PUNJAB</option>
											<option value='4'>CHANDIGARH</option>
											<option value='5'>UTTARAKHAND</option>
											<option value='6'>HARYANA</option>
											<option value='7'>DELHI</option>
											<option value='8'>RAJASTHAN</option>
											<option value='9'>UTTAR PRADESH</option>
											<option value='10'>BIHAR</option>
											<option value='11'>SIKKIM</option>
											<option value='12'>ARUNACHAL PRADESH</option>
											<option value='13'>NAGALAND</option>
											<option value='14'>MANIPUR</option>
											<option value='15'>MIZORAM</option>
											<option value='16'>TRIPURA</option>
											<option value='17'>MEGHALAYA</option>
											<option value='18'>ASSAM</option>
											<option value='19'>WEST BENGAL</option>
											<option value='20'>JHARKHAND</option>
											<option value='21'>ORISSA</option>
											<option value='22'>CHHATTISGARH</option>
											<option value='23'>MADHYA PRADESH</option>
											<option value='24'>GUJARAT</option>
											<option value='25'>DADAR AND NAGAR HAVELI & DAMAN AND DIU</option>
											<option value='26'>MAHARASHTRA</option>
											<option value='27'>KARNATAKA</option>
											<option value='28'>GOA</option>
											<option value='29'>LAKSHADWEEP</option>
											<option value='30'>KERALA</option>
											<option value='31'>TAMIL NADU</option>
											<option value='32'>PUDUCHERRY</option>
											<option value='33'>ANDAMAN AND NICOBAR</option>
											<option value='34'>TELANGANA</option>
											<option value='35'>ANDHRA PRADESH</option>
											<option value='36'>LADAKH</option>
											<option value='37'>OTHER TERRITORY</option>
											<option value='38'>OTHER COUNTRY</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">Ship To State :</label>
									<div class="col-sm-5">
										<select  class="form-control" id="ship_state" name="ship_state" >
											<option value='0'>-- Select --</option>
											<option value='1'>JAMMU AND KASHMIR</option>
											<option value='2'>HIMACHAL PRADESH</option>
											<option value='3'>PUNJAB</option>
											<option value='4'>CHANDIGARH</option>
											<option value='5'>UTTARAKHAND</option>
											<option value='6'>HARYANA</option>
											<option value='7'>DELHI</option>
											<option value='8'>RAJASTHAN</option>
											<option value='9'>UTTAR PRADESH</option>
											<option value='10'>BIHAR</option>
											<option value='11'>SIKKIM</option>
											<option value='12'>ARUNACHAL PRADESH</option>
											<option value='13'>NAGALAND</option>
											<option value='14'>MANIPUR</option>
											<option value='15'>MIZORAM</option>
											<option value='16'>TRIPURA</option>
											<option value='17'>MEGHALAYA</option>
											<option value='18'>ASSAM</option>
											<option value='19'>WEST BENGAL</option>
											<option value='20'>JHARKHAND</option>
											<option value='21'>ORISSA</option>
											<option value='22'>CHHATTISGARH</option>
											<option value='23'>MADHYA PRADESH</option>
											<option value='24'>GUJARAT</option>
											<option value='25'>DADAR AND NAGAR HAVELI & DAMAN AND DIU</option>
											<option value='26'>MAHARASHTRA</option>
											<option value='27'>KARNATAKA</option>
											<option value='28'>GOA</option>
											<option value='29'>LAKSHADWEEP</option>
											<option value='30'>KERALA</option>
											<option value='31'>TAMIL NADU</option>
											<option value='32'>PUDUCHERRY</option>
											<option value='33'>ANDAMAN AND NICOBAR</option>
											<option value='34'>TELANGANA</option>
											<option value='35'>ANDHRA PRADESH</option>
											<option value='36'>LADAKH</option>
											<option value='37'>OTHER TERRITORY</option>
											<option value='38'>OTHER COUNTRY</option>
											
										</select>
									</div>
								</div>   


							 
								     
                            </div>							
							
							<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
							<thead>
								<tr>
									<th style="width: 15%" >Product</th>
									<th style="width: 15%">Description</th>								
									<th style="width: 10%">HSN Code</th>
									<th style="width: 10%">Unit</th>
									<th style="width: 15%">Qty</th>
									<th style="width: 20%">Assessable Value</th>
									<th style="width: 20%">Tax Rate</th>
									<!--th style="width: 2%">CGST</th>
									<th style="width: 2%">SGST</th>
									<th style="width: 2%">IGST</th>
									<th style="width: 2%">CESS</th>
									<th style="width: 2%">CESS Non Advol</th>
									<th style="width: 2%">Others</th>
									<th style="width: 25%">Total Invoice Value</th-->
									<th style="width: 10%">Action</th>
								</tr>
								
							</thead>
							<tbody id="tablemainbind">

							<?php
								$sql="SELECT b.* FROM tbl_eway_bill  a 
								inner join tbl_eway_bill_details b on a.id=b.eb_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and b.eb_id='".$_GET['id']."'";
								$exec_sql=mysqli_query($conn,$sql);
								$i=0;
								while($fetch_zql=mysqli_fetch_array($exec_sql)){
							?>

								
								<tr class="trtag" id="trtag<?php echo $i+1;?>">
								
									<td style="padding:5px">										
										<select  class="form-control" id="product_id_<?php echo $i;?>" name="product_id[]" class="form-control product_id">
										<?php
													$sql_product="select * from tbl_products where delete_status='NDL'";
													$exec_sql_product=mysqli_query($conn,$sql_product); 
													while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
													<option value="<?php  echo $fetch_sql_product['product_id'] ?>"<?php if(($fetch_sql_product['product_id']) ==(($fetch_zql['product_id']))) echo "selected" ?>><?php echo $fetch_sql_product['product_name'] ?></option>
													<?php }  ?>
									
										</select>							
										
									</td>					
									
									<td style="padding:5px" >									
											
										<input type="text" id="description_<?php echo $i;?>" class="form-control description"  name="description[]" placeholder="Enter description" style="margin:0;" value="<?php echo $fetch_sql['description']; ?>">
										
									</td>									
									<td style="padding:5px">
										<input type="number" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_<?php echo $i;?>"  placeholder="Enter hsncode" style="margin:0;" value="<?php echo $fetch_sql['hsn_code']; ?>">

									</td>									
									<td style="padding:5px">
										<select  class="form-control" id="unit_<?php echo $i;?>" name="unit[]" class="form-control unit">
											<option value='0'>-- Select --</option>
											<option value='1' <?php if($fetch_sql['unit']=='1'){ echo 'selected'; } ?>>BAGS</option>
											<option value='2' <?php if($fetch_sql['unit']=='2'){ echo 'selected'; } ?>>BALE</option>
											<option value='3' <?php if($fetch_sql['unit']=='3'){ echo 'selected'; } ?>>BUNDLES</option>
											<option value='4' <?php if($fetch_sql['unit']=='4'){ echo 'selected'; } ?>>BUCKLES</option>
											<option value='5'><?php if($fetch_sql['unit']=='5'){ echo 'selected'; } ?>BILLIONS OF UNITS</option>
											<option value='6'><?php if($fetch_sql['unit']=='6'){ echo 'selected'; } ?>BOX</option>
											<option value='7'><?php if($fetch_sql['unit']=='7'){ echo 'selected'; } ?>BOTTLES</option>
											<option value='8'><?php if($fetch_sql['unit']=='8'){ echo 'selected'; } ?>BUNCHES</option>
											<option value='9'><?php if($fetch_sql['unit']=='9'){ echo 'selected'; } ?>CANS</option>
											<option value='10'><?php if($fetch_sql['unit']=='10'){ echo 'selected'; } ?>CUBIC METER</option>
											<option value='11'><?php if($fetch_sql['unit']=='11'){ echo 'selected'; } ?>CUBIC CENTIMETER</option>
											<option value='12'><?php if($fetch_sql['unit']=='12'){ echo 'selected'; } ?>CENTIMETER</option>
											<option value='13'><?php if($fetch_sql['unit']=='13'){ echo 'selected'; } ?>CARTONS</option>
											<option value='14'><?php if($fetch_sql['unit']=='14'){ echo 'selected'; } ?>DOZEN</option>
											<option value='15'><?php if($fetch_sql['unit']=='15'){ echo 'selected'; } ?>DRUM</option>
											<option value='16'><?php if($fetch_sql['unit']=='16'){ echo 'selected'; } ?>GREAT GROSS</option>
											<option value='17'><?php if($fetch_sql['unit']=='17'){ echo 'selected'; } ?>GRAMS</option>
											<option value='18'><?php if($fetch_sql['unit']=='18'){ echo 'selected'; } ?>GROSS</option>
											<option value='19'><?php if($fetch_sql['unit']=='19'){ echo 'selected'; } ?>GROSS YARDS</option>
											<option value='20'><?php if($fetch_sql['unit']=='20'){ echo 'selected'; } ?>KILOGRAMS</option>
											<option value='21'><?php if($fetch_sql['unit']=='21'){ echo 'selected'; } ?>KILOLITER</option>
											<option value='22'><?php if($fetch_sql['unit']=='22'){ echo 'selected'; } ?>KILOMETRE</option>
											<option value='23'><?php if($fetch_sql['unit']=='23'){ echo 'selected'; } ?>MILLILITRE</option>
											<option value='24'><?php if($fetch_sql['unit']=='24'){ echo 'selected'; } ?>METERS</option>
											<option value='25'><?php if($fetch_sql['unit']=='25'){ echo 'selected'; } ?>METRIC TONS</option>
											<option value='26'><?php if($fetch_sql['unit']=='26'){ echo 'selected'; } ?>NUMBERS</option>
											<option value='27'><?php if($fetch_sql['unit']=='27'){ echo 'selected'; } ?>PACKS</option>
											<option value='28'><?php if($fetch_sql['unit']=='28'){ echo 'selected'; } ?>PIECES</option>
											<option value='29'><?php if($fetch_sql['unit']=='29'){ echo 'selected'; } ?>PAIRS</option>
											<option value='30'><?php if($fetch_sql['unit']=='30'){ echo 'selected'; } ?>QUINTAL</option>
											<option value='31'><?php if($fetch_sql['unit']=='31'){ echo 'selected'; } ?>ROLLS</option>
											<option value='32'><?php if($fetch_sql['unit']=='32'){ echo 'selected'; } ?>SETS</option>
											<option value='33'><?php if($fetch_sql['unit']=='33'){ echo 'selected'; } ?>SQUARE FEET</option>
											<option value='34'><?php if($fetch_sql['unit']=='34'){ echo 'selected'; } ?>SQUARE METERS</option>
											<option value='35'><?php if($fetch_sql['unit']=='35'){ echo 'selected'; } ?>SQUARE YARDS</option>
											<option value='36'><?php if($fetch_sql['unit']=='36'){ echo 'selected'; } ?>TABLETS</option>
											<option value='37'><?php if($fetch_sql['unit']=='37'){ echo 'selected'; } ?>TEN GROSS</option>
											<option value='38'><?php if($fetch_sql['unit']=='38'){ echo 'selected'; } ?>THOUSANDS</option>
											<option value='39'><?php if($fetch_sql['unit']=='39'){ echo 'selected'; } ?>TONNES</option>
											<option value='40'><?php if($fetch_sql['unit']=='40'){ echo 'selected'; } ?>TUBES</option>
											<option value='41'><?php if($fetch_sql['unit']=='41'){ echo 'selected'; } ?>US GALLONS</option>
											<option value='42'><?php if($fetch_sql['unit']=='42'){ echo 'selected'; } ?>UNITS</option>
											<option value='43'><?php if($fetch_sql['unit']=='43'){ echo 'selected'; } ?>YARDS</option>
											<option value='44'><?php if($fetch_sql['unit']=='44'){ echo 'selected'; } ?>OTHERS</option>	
										</select>

										

									</td>									
									<td style="padding:5px">
										<input type="number" class="form-control qty" name="qty[]" id="qty_<?php echo $i;?>"  placeholder="Enter Qty" style="margin:0;" value="<?php echo $fetch_sql['qty']; ?>">
									</td>									
									<td style="padding:5px">
										<input type="number" class="form-control assessable_value" name="assessable_value[]" id="assessable_value_<?php echo $i;?>"  placeholder="Enter Assessable Value" style="margin:0;" value="<?php echo $fetch_sql['assessable_value']; ?>">

									</td>
									<td style="padding:5px;text-align:center">
										<input type="number" class="form-control tax_rate" name="tax_rate[]" id="tax_rate_<?php echo $i;?>"  placeholder="Enter Tax Rate" style="margin:0;" value="<?php echo $fetch_sql['tax_rate']; ?>">
									</td>
									<td style="padding:5px;text-align:center">
										<a href="#" class="trtag1" data-value=<?php echo $i+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>							
									
								</tr>

								<tr class="trtag" id="trtagw<?php echo $i+1;?>">								
									
									<td style="padding:5px">
										<input type="number" class="form-control cgst" name="cgst[]" id="cgst_<?php echo $i;?>"  placeholder="Enter CGST Amount" style="margin:0;" value="<?php echo $fetch_sql['cgst']; ?>">

									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control sgst" name="sgst[]" id="sgst_<?php echo $i;?>"  placeholder="Enter SGST Amount" style="margin:0;" value="<?php echo $fetch_sql['sgst']; ?>">

									</td>
									<td style="padding:5px;text-align:center">
										<input type="number" class="form-control igst" name="igst[]" id="igst_<?php echo $i;?>"  placeholder="Enter IGST Amount" style="margin:0;" value="<?php echo $fetch_sql['igst']; ?>">
									</td>
									<td style="padding:5px">
										<input type="number" class="form-control cess" name="cess[]" id="cess_<?php echo $i;?>"  placeholder="Enter CESS Amount" style="margin:0;" value="<?php echo $fetch_sql['cess']; ?>">
									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control cess_non" name="cess_non[]" id="cess_non_<?php echo $i;?>"  placeholder="Enter CESS Non Advol" style="margin:0;" value="<?php echo $fetch_sql['cess_non']; ?>">

									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control others" name="others[]" id="others_<?php echo $i;?>"  placeholder="Enter Others" style="margin:0;" value="<?php echo $fetch_sql['others']; ?>">

									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control tot_invoice" name="tot_invoice[]" id="tot_invoice_<?php echo $i;?>"  placeholder="Enter Total Invoice Value" style="margin:0;" value="<?php echo $fetch_sql['tot_invoice']; ?>"> 
									</td>							
									
									
								</tr>

								<?php $i++; }?>
								

							</tbody>
							<tfoot id="taxbind1">
								<tr class="taxdiv" id="taxdiv0">
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>										
									<th colspan="3" style="border:none">
										<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
									</th>
								
								</tr>
							
                                

                            </tfoot>


						</table>



						<div class="form-group row">
							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Trans Mode : </label>
							
								<select  class="form-control" id="trans_mode" name="trans_mode" >
											<option value='0'>-- Select --</option>
											<option value='1'>Road</option>
											<option value='2'>Air</option>
											<option value='3'>Rail</option>
											<option value='4'>Ship</option>
									
										</select>
							</div>

							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Distance : </label>
							
								<input type="text" id="distance" class="form-control" placeholder="Enter Distance" name="distance" value="<?php echo $fetch_sql['distance']; ?>" >
							</div>

							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Trans Name : </label>
							
								<input type="text" id="trans_name" class="form-control" placeholder="Enter Trans Name" name="trans_name" value="<?php echo $fetch_sql['trans_name']; ?>" >
							</div>
							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Trans ID : </label>
								
								<input type="text" id="trans_id" class="form-control" placeholder="Enter Trans ID" name="trans_id" value="<?php echo $fetch_sql['trans_id']; ?>" >
								
							</div>

							

						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Trans Doc No : </label>
							
								<input type="text" id="trans_doc_no" class="form-control" placeholder="Enter Doc No" name="trans_doc_no" value="<?php echo $fetch_sql['trans_doc_no']; ?>" >
							</div>

							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Trans Date : </label>
							
								<input type="text" id="trans_date" class="form-control" placeholder="Pick Trans Date" name="trans_date" value="<?php echo $fetch_sql['trans_date']; ?>" >
							</div>

							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Vehicle Number : </label>
							
								<input type="text" id="vehicle_no" class="form-control" placeholder="Enter vehicle no" name="vehicle_no" value="<?php echo $fetch_sql['vehicle_no']; ?>" >
							</div>
							<div class="col-md-3">
								<label for="staticEmail" class="col-form-label text-left">Vehicle Type : </label>
								<select  class="form-control" id="vehicle_type" name="vehicle_type" >
											<option value='0'>-- Select --</option>
											<option value='1'>Regular</option>
											<option value='2'>ODC</option>
									
								</select>
								
								
								
							</div>

							

						</div>

						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" name="eb_id" id="eb_id" value=<?php echo $_GET['id'];?>>
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:32px;">Save</button>									
									<button type="reset" name="resetbut" id="resetbut" class="btn btn-danger" style="margin-top:32px;">Reset</button>
								</div>
							</div>
							<div class="col-md-2">
							<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
						
                    </form>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->

<input type="hidden" name="modulenamebox" id="modulenamebox" value="9">
<input type="hidden" name="rightsbox" id="rightsbox">


<?php include("footer.php") ?>



<!-- begin::global scripts -->

<!-- end::global scripts -->
<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<!-- begin::charts -->
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>
<!-- end::charts -->
<!-- START::select2 -->
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<!-- end::select2 -->
<!-- begin::daterangepicker -->
<script src="vendors/datepicker/daterangepicker.js"></script>
<!-- end::daterangepicker -->

<!-- begin::dashboard -->
<script src="js/examples/dashboard.js"></script>
<!-- end::dashboard -->

<!-- begin::vamp -->
<script src="vendors/vmap/jquery.vmap.min.js"></script>
<script src="vendors/vmap/maps/jquery.vmap.usa.js"></script>
<script src="js/examples/vmap.js"></script>
<!-- end::vamp -->

<!-- begin::custom scripts -->
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
<!-- end::custom scripts -->

</body>


<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script>

$(document).ready(function(){
		

	$('input[name="doc_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});

	  $('input[name="trans_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});

	


	$(document).on('click', '.trtag1', function () {
		$("#trtag"+$(this).data('value')+"").remove();
		$("#trtagw"+$(this).data('value')+"").remove();
		return false;
	});



	if('<?php echo $log;?>'!="admin"){
	$.ajax({
		type: "POST",
		url: "phpservices/employee_rights.php",
		dataType:'JSON',
		data: {empid:<?php echo $login_id;?>,moduleid:$("#modulenamebox").val()},
		success: function(result) {
			$("#rightsbox").val(result.rights);
			var emprights=result.rights;
				}
			});
	}


	

	$("#resetbut").click(function(){
		$("#gal_cat_id").val('');
		$("#title").val('');
		$("#photo").val('');
		$("#photo_name").val('');
		$("#imgpreview").html('<label>Image Preview :</label><img src="media/image/no_image.png" style="width:100px;margin-left:4px">');
		$("#resetbut").css('outline','none');
		$("#resetbut").css('box-shadow','none');
	});



	var ids_string=<?php echo $_GET['id']; ?>;
	$(".page-loader").show();
	$.ajax({
			type: "POST",
			url: "eway_bill_service.php",
			dataType:'json',
			data: {id:ids_string,req:"AUB"},
			success: function(result) {		
						console.log(result);
				
				setTimeout(function(){
					$("#order_type").val(result.op[0]['order_type']);
				},1000);				
				setTimeout(function(){
					$("#supply_type").val(result.op[0]['supply_type']);
				},1000);
				
				setTimeout(function(){
					$("#sub_type").val(result.op[0]['sub_type']);
				},1000);
				setTimeout(function(){
					$("#doc_type").val(result.op[0]['doc_type']);
				},1000);

				setTimeout(function(){
					$("#from_state").val(result.op[0]['from_state']);
				},1000);
				setTimeout(function(){
					$("#from_dispatch").val(result.op[0]['from_dispatch']);
				},1000);


				setTimeout(function(){
					$("#to_state").val(result.op[0]['to_state']);
				},1000);
				setTimeout(function(){
					$("#ship_state").val(result.op[0]['ship_state']);
				},1000);


				setTimeout(function(){
					$("#trans_mode").val(result.op[0]['trans_mode']);
				},1000);
				setTimeout(function(){
					$("#vehicle_type").val(result.op[0]['vehicle_type']);
				},1000);



				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
	});

	

	$.ajax({
			
			type: "POST",
			url: "uom_dropdown.php",
			success: function(result) {
				var uom_id=result.uom_id;
				var uom_name=result.uom_name;
				var d_length=result.uom_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+uom_id[i]+'">'+uom_name[i]+'</option>';
					
				}
				$(".uom_id").removeAttr("disabled");
				$(".uom_id").append(d_data);
				$(".page-loader").hide();	
			}							
	});



	$(".product_id").empty();	
	$.ajax({
			type: "POST",
			url: "product_dropdown.php",
			success: function(result) {
				if(result.product_id){
					var product_id=result.product_id;
					var product_name=result.product_name;
					
					var d_length=result.product_id.length;
					var d_data='<option value="">Select Product</option>';
					if(result.product_id!="select Product"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option  value="'+product_id[i]+'">'+product_name[i]+'</option>';
						}
					}

					$("#product_id_0").append(d_data);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
	});	

	

	$(document).on('change', '.product_id', function() {	
		var id = this.id;
		var product_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];
		$("#hsn_code"+index).empty();	
		
		$.ajax({
			type: "POST",
			url: "get_hsncode.php",
			dataType:'json',
			data: {product_id:product_id},
			success: function(result) {
				if(result.hsn_code){
					var hsn_code=result.hsn_code[0];
					var uom_id=result.uom_id[0];			

					console.log(uom_id);
   					$("#hsn_code_"+index).val(hsn_code);
					
					   setTimeout(function(){
							$("#uom_id_"+index).val(uom_id);
						},500);

					//$("#uom_id_"+index).val(uom_name);
					
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});


	
	
	

	

	$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		if($("#order_date").val()==''){
			swal("Error!", "Select Date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#product_id_0").val()==''){
			swal("Error!", "Select product !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#product_id_0").val()==''){
			swal("Error!", "Select product !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$("#req").val('UPD');
			//$("#req").val('PACKING_PRINTING_INS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "eway_bill_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='eway_bill_details.php';
							},2000);
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
		}
			else{
				swal("Error!", "Access Denied! Contact Admin...", "error");
				return false;
			}
	});

	

	
		
		
 	

});
	
	function qualaddfunc(){
		var count = document.getElementsByClassName("trtag").length;
		$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control product_id" name="product_id[]" id="product_id_'+count+'"></select><div id="suggesstion-box_'+count+'"></div></td><td style="padding:5px"><input type="number" class="form-control description" name="description[]" id="description_'+count+'" placeholder="Enter Description" style="margin:0;"></td><td style="padding:5px"><input type="number" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_'+count+'" placeholder="Enter hsn code" style="margin:0;"></td><td style="padding:5px"><select  class="form-control" id="unit_0" name="unit[]" class="form-control unit"><option value="0">-- Select --</option><option value="1">BAGS</option><option value="2">BALE</option><option value="3">BUNDLES</option><option value="4">BUCKLES</option><option value="5">BILLIONS OF UNITS</option><option value="6">BOX</option><option value="7">BOTTLES</option><option value="8">BUNCHES</option><option value="9">CANS</option><option value="10">CUBIC METER</option><option value="11">CUBIC CENTIMETER</option><option value="12">CENTIMETER</option><option value="13">CARTONS</option><option value="14">DOZEN</option><option value="15">DRUM</option><option value="16">GREAT GROSS</option><option value="17">GRAMS</option><option value="18">GROSS</option><option value="19">GROSS YARDS</option><option value="20">KILOGRAMS</option><option value="21">KILOLITER</option><option value="22">KILOMETRE</option><option value="23">MILLILITRE</option><option value="24">METERS</option><option value="25">METRIC TONS</option><option value="26">NUMBERS</option><option value="27">PACKS</option><option value="28">PIECES</option><option value="29">PAIRS</option><option value="30">QUINTAL</option><option value="31">ROLLS</option><option value="32">SETS</option><option value="33">SQUARE FEET</option><option value="34">SQUARE METERS</option><option value="35">SQUARE YARDS</option><option value="36">TABLETS</option><option value="37">TEN GROSS</option><option value="38">THOUSANDS</option><option value="39">TONNES</option><option value="40">TUBES</option><option value="41">US GALLONS</option><option value="42">UNITS</option><option value="43">YARDS</option><option value="44">OTHERS</option></select></td>	<td style="padding:5px"><input type="number" class="form-control qty" name="qty[]" id="qty_'+count+'" placeholder="Enter Qty" style="margin:0;"></td>	<td style="padding:5px"> 				<input type="number" class="form-control assessable_value" name="assessable_value[]" id="assessable_value_'+count+'" placeholder="Enter Assessable Value" style="margin:0;" >			</td> <td style="padding:5px"><input type="number" class="form-control tax_rate" name="tax_rate[]" id="tax_rate_'+count+'" placeholder="Enter Tax Rate" style="margin:0;">	</td>				<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr><tr  class="trtag" id="trtagw'+count+'"> <td style="padding:5px"><input type="number" class="form-control cgst" name="cgst[]" id="cgst_'+count+'" placeholder="Enter CGST Amount" style="margin:0;"></td><td style="padding:5px"><input type="number" class="form-control sgst" name="sgst[]" id="sgst_'+count+'" placeholder="Enter SGST Amount" style="margin:0;"></td><td style="padding:5px"><input type="number" class="form-control igst" name="igst[]" id="igst_'+count+'" placeholder="Enter IGST Amount" style="margin:0;"></td><td style="padding:5px"><input type="number" class="form-control cess" name="cess[]" id="cess_'+count+'" placeholder="Enter CESS Amount" style="margin:0;"></td>	<td style="padding:5px"><input type="number" class="form-control cess_non" name="cess_non[]" id="cess_non_'+count+'" placeholder="Enter CESS Non Advol" style="margin:0;"></td>	<td style="padding:5px"> 				<input type="number" class="form-control others" name="others[]" id="others_'+count+'" placeholder="Enter Others" style="margin:0;" >			</td> <td style="padding:5px"><input type="number" class="form-control tot_invoice" name="tot_invoice[]" id="tot_invoice_'+count+'" placeholder="Enter Total Invoice Value" style="margin:0;">	</td>				<td style="padding:5px;text-align:center"> </td> 	</tr>');

		$("#product_id_"+count).empty();	
			$.ajax({
				type: "POST",
				url: "product_dropdown.php",
				success: function(result) {
					if(result.product_id){
						var product_id=result.product_id;
						var product_name=result.product_name;
						
						var d_length=result.product_id.length;
						var d_data='<option value="">Select Product</option>';
						if(result.product_id!="select Product"){
							for(var i=0;i<=d_length-1;i++){
								d_data +='<option  value="'+product_id[i]+'">'+product_name[i]+'</option>';
							}
						}

						$("#product_id_"+count).append(d_data);
						$("#grid-loader").hide();
					}
					else{
						$("#grid-loader").hide();
					}
				},error:function(xhr,status,error){
					console.log(JSON.stringify(xhr,status,error));
				}
			});

			$("#uom_id_"+count).empty();
			$.ajax({			
				type: "POST",
				url: "uom_dropdown.php",
				success: function(result) {

					console.log(result);
					if(result.uom_id){
						var uom_id=result.uom_id;
						var uom_name=result.uom_name;
						var d_length=result.uom_id.length;
						var d_data='';
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option value="'+uom_id[i]+'">'+uom_name[i]+'</option>';
							
						}
						//$(".uom_id").removeAttr("disabled");
						$("#uom_id_"+count).append(d_data);
						$(".page-loader").hide();	
					}
					else{
						$("#grid-loader").hide();
					}
				}							
			});

			
	}
</script>
</html>