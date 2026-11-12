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
    <!-- end::global styles -->

   <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="vendors/clockpicker/bootstrap-clockpicker.min.css" type="text/css">
    <!-- begin::datepicker -->
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <!-- begin::vmap -->
    <link rel="stylesheet" href="vendors/vmap/jqvmap.min.css">
    <!-- begin::vmap -->
	<link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
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
            <h4>Update Purchase Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Purchase</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Purchase Details</li>
                </ol>
            </nav>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">

							<div class="col-md-6">

								<div class="form-group row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label text-left">Service Provider:</label>
                                    <div class="col-md-5">
										<?php
										$admin_sql = "select * from tbl_admin where admin_id='1'";
										$admin_exec_sql = mysqli_query($conn, $admin_sql);
										$admin_fetch_sql = mysqli_fetch_array($admin_exec_sql);
										?>
										<p style="margin-bottom: 0rem;"><b><?php echo $admin_fetch_sql['cname']; ?></b></p>
										<p style="margin-bottom: 0rem;"><?php echo $admin_fetch_sql['addr']; ?></p>
										<p style="margin-bottom: 0rem;"><b>GST :</b> <?php echo $admin_fetch_sql['gstno']; ?></p>
									</div>
								</div> 
								<?php
									$sql="SELECT *,a.purchase_id,a.dc_no,a.total_amount,a.gst_total_amount,a.grand_total_amount,d.supplier_id,d.supplier_name,e.uom_id,e.uom_name,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.hsn_code SEPARATOR ',<br/>') as hsn_code,group_concat(b.rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_purchase  a 
									inner join tbl_purchase_details b on a.purchase_id=b.purchase_id 
									left join  tbl_uom e on e.uom_id=b.uom_id 
									left join  tbl_supplier d on d.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' and a.purchase_id='".$_GET['id']."'";
									$exec_sql=mysqli_query($conn,$sql);
									$fetch_sql=mysqli_fetch_array($exec_sql); ?>
									
								<div class="form-group row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label text-left">Select Supplier :<a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#supplierModalCenter"><i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></label>
                                    <div class="col-md-5">
										<select  class="form-control" id="supplier_id" name="supplier_id" >
											<option value="">Select Supplier</option>
											<?php
											$sql_product="select * from tbl_supplier where delete_status='NDL'";
											$exec_sql_product=mysqli_query($conn,$sql_product); 
											while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
												<option value="<?php  echo $fetch_sql_product['supplier_id'] ?>"<?php if(($fetch_sql_product['supplier_id']) ==(($fetch_sql['supplier_id']))) echo "selected" ?>><?php echo $fetch_sql_product['supplier_name'] ?></option>
												<?php }  ?>
										</select>
									</div>
								</div> 
								     
                            </div>

								
								<div class="col-md-6">
									
									
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Invoice No : </label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="dc_no" name="dc_no" value="<?php echo $fetch_sql['dc_no'];?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Invoice  Date :</label>
											<div class="col-sm-5">
												<input type="text" id="invoice_date" class="form-control" placeholder="Pick Invoice Date" name="invoice_date" value='<?php echo $fetch_sql['billing_date'];?>'>

												<!--input type="text" name="single-date-picker" class="form-control" id="date1" value="<?php //echo $fetch_sql['billing_date'];?>"-->
												<!--input type="hidden" name="order_date" id="order_date" value="<?php //echo $fetch_sql['billing_date'];?>"-->
											</div>
										</div>
									
                                    
                                </div>

								
							
							<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
							<thead>
								<tr>
									<th style="width: 15%">Model</th>	
									<th style="width: 15%">Design</th>										
									<th style="width: 15%">HSN Code</th>
									<th style="width: 10%">UOM</th>
									<th style="width: 10%">Quantity</th>
									<th style="width: 20%">Rate</th>
									<th style="width: 15%">Amount</th>
									<th style="width: 5%">Action</th>
								</tr>
							</thead>
							<tbody id="tablemainbind">
							<?php
								$sql="SELECT b.*,a.total_amount,a.gst_total_amount,a.grand_total_amount FROM tbl_purchase  a 
								inner join tbl_purchase_details b on a.purchase_id=b.purchase_id 
								left join  tbl_uom e on e.uom_id=b.uom_id 
								left join  tbl_supplier d on d.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' and b.purchase_id='".$_GET['id']."'";
								$exec_sql=mysqli_query($conn,$sql);
								$i=0;
								while($fetch_zql=mysqli_fetch_array($exec_sql)){
							?>
								<tr class="trtag" id="trtag<?php echo $i+1;?>">
								
									<!--td style="padding:5px">
										<select class="form-control" id="product_id<?php echo $i;?>" name="product_id[]" style="margin:0;">
											<option value="">Select Products</option>
												<?php
													//$sql_product="select * from tbl_products where delete_status='NDL'";
													//$exec_sql_product=mysqli_query($conn,$sql_product); 
													//while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){
														
														$gql3 = "SELECT b.category_name,c.sub_category_name,m.design FROM tbl_products a left join  tbl_category b on b.category_id=a.category_id left join  tbl_sub_category c on c.sub_category_id=a.sub_category_id left join  tbl_design m on m.design_id=a.design left join  tbl_purchase_details d on d.product_id=a.product_id where a.delete_status='NDL' and a.product_id='".$fetch_zql['product_id']."' ";
														$exec_gql3 = mysqli_query($conn, $gql3);			
														$fetch_gql3 = mysqli_fetch_array($exec_gql3);
			?>
													<option value="<?php  //echo $fetch_sql_product['product_id'] ?>"<?php //if(($fetch_sql_product['product_id']) ==(($fetch_zql['product_id']))) echo "selected" ?>><?php //echo $fetch_gql3["category_name"]."-".$fetch_gql3["sub_category_name"]."-".$fetch_gql3["design"]; ?></option>
													<?php //}  ?>
										</select>
									</td-->

									<td style="padding:5px">
										
										<input type="text" id="model_id_<?php echo $i;?>" name="model_id[]"  class="form-control model_id" value="<?php echo $fetch_gql3["sub_category_name"]; ?>" />
										<div id="suggesstion-box"></div>
										
									</td>
									<td style="padding:5px">
										
										<input type="text" id="design_<?php echo $i;?>"  name="design[]" class="form-control design" value="<?php echo $fetch_gql3["design"]; ?>" />
										<div id="suggesstion-box1"></div>
										
									</td>	


									<td style="padding:5px">
										<input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_<?php echo $i;?>"  placeholder="Enter HSN code" value="<?php echo $fetch_zql['hsn_code'];?>">
									</td>
									
									
									<td style="padding:5px">
										 <select class="form-control" id="uom_id<?php echo $i;?>" name="uom_id[]" style="margin:0;">
											<option value="">Select UOM</option>
												<?php
													$sql_product="select * from tbl_uom where delete_status='NDL'";
													$exec_sql_product=mysqli_query($conn,$sql_product); 
													while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
													<option value="<?php  echo $fetch_sql_product['uom_id'] ?>"<?php if(($fetch_sql_product['uom_id']) ==(($fetch_zql['uom_id']))) echo "selected" ?>><?php echo $fetch_sql_product['uom_name'] ?></option>
													<?php }  ?>
										</select>
									</td>
									
									
									
									
									<td style="padding:5px">
										<input type="number" class="form-control man_day" name="man_day[]" id="man_day_<?php echo $i;?>"  placeholder="Enter Qty" value="<?php echo $fetch_zql['qty'];?>">
									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_<?php echo $i;?>"  placeholder="Enter Rate" value="<?php echo $fetch_zql['product_rate'];?>">

									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control rate" name="rate[]" id="rate_<?php echo $i;?>"  placeholder="Enter Amount" value="<?php echo $fetch_zql['rate'];?>" readonly>

									</td>
									
									<td style="padding:5px;text-align:center">
										<a href="#" class="trtag1" data-value=<?php echo $i+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>
									
								</tr>
							<?php $i++; } ?>
							</tbody>
							<tfoot id="taxbind1">
																<tr class="taxdiv" id="taxdiv0">
									<th colspan="7" style="border:none"></th>									
									<th style="border:none; text-align:center;">
										<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
									</th>
								
								</tr>
							
                                <tr class="taxdiv" id="taxdiv0">
                                    <th colspan="6" class="text-right">Total</th>
                                    <th colspan="2"><input type="text" class="form-control" id="total_amount" name="total_amount" value="<?php echo $fetch_sql['total_amount'];?>" style="margin:0;" value=""></th>
                                </tr>
                                            <!--tr class="taxdiv" id="taxdiv0">
											<th colspan="4" class="text-right">SGST</th>
											<th colspan="2">250</th>
										</tr-->
                                <tr class="taxdiv" id="taxdiv0">
                                    <th colspan="3" class="text-right"></th>
                                    <th colspan="2" class="text-left" style="color:green">
                                                    CGST In (%) : <input type="number" class="form-control cgst" id="cgst" name="cgst" placeholder="CGST" style="margin:0;" value="<?php echo $fetch_sql['cgst'];?>" >
                                    </th>
									<th class="text-left" style="color:green">
                                                    SGST In (%) : <input type="number" class="form-control sgst" id="sgst" name="sgst" placeholder="SGST" style="margin:0;" value="<?php echo $fetch_sql['sgst'];?>" >
                                    </th>
                                    <th colspan="2">GST Total: <input type="text" class="form-control" id="gst_total_amount" name="gst_total_amount" placeholder="GST Total" style="margin:0;" value="<?php echo $fetch_sql['gst_total_amount'];?>" readonly></th>
                                </tr>
                                            
                                <tr class="taxdiv" id="taxdiv0" style="display: none">
                                    <th colspan="6" class="text-right" style="font-size:16px;color:#5700f0">
                                                    Discount</th>
                                    <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control discount" id="discount" name="discount" value="<?php echo $fetch_sql['discount'];?>" placeholder="Discount in Rs." style="margin:0;"></th>
                                </tr>
                                            
                                <tr class="taxdiv" id="taxdiv0">
                                    <th colspan="6" class="text-right" style="font-size:16px;color:red">
                                                    Grand Total Amount</th>
                                    <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control grand_total_amount" id="grand_total_amount" name="grand_total_amount" placeholder="Grand Total" style="margin:0;" value="<?php echo $fetch_sql['grand_total_amount'];?>" readonly></th>
                                </tr>

                            </tfoot>


						</table>
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" class="form-control" id="purchase_type" name="purchase_type" value="purchase">
									<input type="hidden" name="purchase_id" id="purchase_id" value=<?php echo $_GET['id'];?>>
									<button type="submit" name="submit" id="submit" class="btn btn-success">Save</button>									
									<button type="reset" name="resetbut" id="resetbut" class="btn btn-danger" style="margin-top:32px;">Reset</button>
								</div>
							</div>
							<div class="col-md-2">
							<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
						
                    </form>
                </table>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->
<div class="modal fade" id="supplierModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Supplier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="supplier_mainform" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Supplier Name :</label><span style="color:red">*</span>
										<input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter supplier Name">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Company Name :</label>
										<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name">
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Mobile Number :</label><span style="color:red">*</span>
										<input type="number" class="form-control" id="mblno" name="mblno" placeholder="Enter Mobile Number">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Email Id :</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Id">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Address :</label><span style="color:red">*</span>
										<textarea class="form-control" id="address" name="address" placeholder="Enter Address"></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>GST Number :</label>
										<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number">
									</div>
								</div>

								
								<div class="col-md-3">
									<span id="cus_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
								</div>
							</div>
							<div class='row'>
							
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="req" id="supplier_req">
										<button type="submit" name="supplier_submit" id="supplier_submit" class="btn btn-success">Save</button>									
										<button type="reset" name="supplier_submit" id="supplier_submit" class="btn btn-danger">Reset</button>
									</div>
								</div>
							</div>
						</form>
						<!--<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="colorgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Color</th>
								<th>Action</th>
							</tr>
						</thead>
					
					</table>-->
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: #000321;color: #fff;">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>
<!--<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Design</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="mainformwork" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
									<input type="hidden" name="design_id" id="work_design_id" >
										<label>Design:</label>
										<input type="text" placeholder="Design" id="design" name="design"  class="form-control">
									
									</div>
								</div>
							
								<input type="hidden" name="req" id="designreq">
								<span id="designmsg" style="font-weight:bold;float:left;margin-top:7px;"></span>
								<div class="col-md-2">
									<div class="form-group" style="padding-top: 25px;">
										<button type="button" name="submit" id="submitwork" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
										<button type="button" name="submit" id="updatework" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;display:none;">Update</button>
									</div>
								</div>
							</div>
						</form>
						<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="defgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Design</th>
								<th>Action</th>
							</tr>
						</thead>
					
					</table>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: #000321;color: #fff;">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Size</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="sizeformwork" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
									<input type="hidden" name="size_id" id="work_size_id" >
										<label>Size:</label>
										<input type="text" placeholder="Size" id="size" name="size"  class="form-control">
									
									</div>
								</div>
							
								<input type="hidden" name="req" id="sizereq">
								<span id="sizemsg" style="font-weight:bold;float:left;margin-top:7px;"></span>
								<div class="col-md-2">
									<div class="form-group" style="padding-top: 25px;">
										<button type="button" name="submit" id="submitsize" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
										<button type="button" name="submit" id="updatesize" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;display:none;">Update</button>
									</div>
								</div>
							</div>
						</form>
						<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="sizegrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Size</th>
								<th>Action</th>
							</tr>
						</thead>
					
					</table>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: #000321;color: #fff;">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>-->
<input type="hidden" name="modulenamebox" id="modulenamebox" value="1">
<input type="hidden" name="rightsbox" id="rightsbox">


<?php include("footer.php") ?>



<!-- begin::global scripts -->

<!-- end::global scripts -->
<!--script src="vendors/bundle.js"></script-->
<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<!-- end::global scripts -->

<!-- begin::charts -->
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>
<!-- end::charts -->

<!-- begin::daterangepicker -->
<script src="vendors/datepicker/daterangepicker.js"></script>
<script src="js/examples/datepicker.js"></script>
<!-- end::daterangepicker -->

<!-- begin::dashboard -->
<script src="js/examples/dashboard.js"></script>
<!-- end::dashboard -->

<!-- begin::vamp -->
<script src="vendors/vmap/jquery.vmap.min.js"></script>
<script src="vendors/vmap/maps/jquery.vmap.usa.js"></script>
<script src="js/examples/vmap.js"></script>
<!-- end::vamp -->
  <!-- START::select2 -->
  <script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<!-- end::select2 -->
<!-- begin::custom scripts -->
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
<script src="js/examples/sweet-alert.js"></script>
<!-- end::custom scripts -->

</body>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script>
	/*$(function() {
		$(".model_id").autocomplete({
			source: "model_search.php",
			select: function( event, ui ) {
				event.preventDefault();
				$("#model_id_0").val(ui.item.value);
			}
		});
	});*/
</script>

<script>

/*function selectmodel(val) {
	$(".model_id").val(val);
	$("#suggesstion-box").hide();
}

function selectdesign(val) {
	

	$(".design").val(val);
	$("#suggesstion-box1").hide();
}*/


	$("#model_id_0").autocomplete({
		source: "model_search.php",
		select: function( event, ui ) {
			event.preventDefault();
			$("#model_id_0").val(ui.item.value);
		}
	});

	$("#design_0").autocomplete({
		source: "design_search.php",
		select: function( event, ui ) {
			event.preventDefault();
			$("#design_0").val(ui.item.value);
		}
	});

$(document).ready(function(){


	$('input[name="invoice_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});

	$(document).on('click', '.trtag1', function () {
		$("#trtag"+$(this).data('value')+"").remove();
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


	$("#supplier_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#supplier_name").val()==''){
				$("#cus_msg").css("color","red").html('* Enter supplier Name');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else if($("#mblno").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Mobileno');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else if($("#address").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Address');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else{
				$("#supplier_req").val('ADDINS');
				$("#cus_msg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "supplier_service.php",
						dataType:'json',
						data: $("#supplier_mainform").serialize(),						
						success: function(result) {
							var supplier_name = $("#supplier_name").val();
							//console.log(supplier_name);
							//console.log(result.op);
							if(result.op=='' || result.op==null){
								$("#cus_msg").css("color","red").html('Duplicate supplier already exists !');
								setTimeout(function(){$("#cus_msg").html('')},3000);
								return false;
							}else{

								if(result.op==1){
									
									swal("Success!", "Successfully Saved !", "success");
									setTimeout(function(){
										window.location.href='purchase_edit_details.php?id=<?php echo $_GET['id'];?>';
									},2000);
								}
								else{
									alert($("#cus_msg").html(result.op));
								}
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

	$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"purchase_details_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data: {purchase_type:"purchase"},
            error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
          }
		 }
        });	

	/*$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
		 	aLengthMenu: [
			[10, 100, 500, 1000],
			[10, 100, 500, 1000]
		],
// 		"pageLength": 10,
         "ajax":{
            url :"purchase_details_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
             $("#detailsgrid").css("display","none");
						console.log(JSON.stringify(xhr,status,error));
            }
          }
    });*/
	
/*setTimeout(function(){
	var datefullvalue= $("#date1").val();
	var datevalue = datefullvalue.split('/')[0];
	var monthvalue = datefullvalue.split('/')[1];
	var yearvalue = datefullvalue.split('/')[2];
	$("#order_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
},500);

$("#date1").change(function(){
	var datefullvalue= $("#date1").val();
	var datevalue = datefullvalue.split('/')[0];
	var monthvalue = datefullvalue.split('/')[1];
	var yearvalue = datefullvalue.split('/')[2];
	$("#order_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
});*/
	

	$("#resetbut").click(function(){
		$("#gal_cat_id").val('');
		$("#title").val('');
		$("#photo").val('');
		$("#photo_name").val('');
		$("#imgpreview").html('<label>Image Preview :</label><img src="media/image/no_image.png"  style="width:100px;margin-left:4px">');
		$("#resetbut").css('outline','none');
		$("#resetbut").css('box-shadow','none');
	});

	


	$.ajax({
			
		type: "POST",
		url: "uom_dropdown.php",
		success: function(result) {
			var uom_id=result.uom_id;
			var uom_name=result.uom_name;
			var d_length=result.uom_id.length;
			var d_data='<option value="">Select UOM</option>';
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

					$(".product_id").append(d_data);
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


	$(document).on('keyup', '.model_id', function() {	
		var id = this.id;
		var model_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];
		//$("#hsn_code"+index).empty();	
		//alert(index);	

		$("#model_id_"+index).autocomplete({
			source: "model_search.php",
			select: function( event, ui ) {
				event.preventDefault();
				$("#model_id_"+index).val(ui.item.value);
			}
		});
	});


	$(document).on('keyup', '.design', function() {	
		var id = this.id;
		var design=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[1];
		//$("#hsn_code"+index).empty();	
		
		
		$("#design_"+index).autocomplete({
			source: "design_search.php",
			select: function( event, ui ) {
				event.preventDefault();
				$("#design_"+index).val(ui.item.value);
			}
		});
	});


	

	$(document).on('keyup', '.man_day', function() {
		var id = this.id;
		var product_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];
		console.log(index);
        var man_day = $("#man_day_"+index).val();
        var product_rate = $("#product_rate_"+index).val();
        
        
            price = product_rate * man_day;
            discount = price;
        		
		//$("#total_amount").val(price.toFixed(2));
        $("#rate_"+index).val(discount);
    });

	$(document).on('keyup', '.product_rate', function() {
		var id = this.id;
		var product_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];
        var product_rate = $("#product_rate_"+index).val();
        var man_day = $("#man_day_"+index).val();
        
            price = product_rate * man_day;
            discount = price;
        		
		//$("#total_amount").val(price.toFixed(2));
        $("#rate_"+index).val(discount);
    });

	
	$(document).on('keyup', '.man_day', function() {
		get_total_amount();
    });
	
	$(document).on('keyup', '.product_rate', function() {
		get_total_amount();
    });

	$(document).on('keyup', '.sgst', function() {
		get_total_amount();
    });

	$(document).on('keyup', '.cgst', function() {
		get_total_amount();
    });

	$(document).on('keyup', '.discount', function() {
		get_total_amount();
    });

	$(document).on('keyup', '.total_amount', function() {
		get_total_amount();
    });

	
	function get_total_amount() {
		var row_count = (document.getElementsByClassName("rate").length);		
        countofamount = 0;		
        for (i = 0; i < row_count; i++) {	
            if (($("#rate_"+i).val() != '')) {   				
				countofamount += +$("#rate_"+i).val();		
            }
        }
        if (isNaN(countofamount)) {
			countofamount =0;
		}	
        total_amount = countofamount;	
		
		cgst=total_amount * ($("#cgst").val() / 100);
		sgst=total_amount * ($("#sgst").val() / 100);

		gst_amount = cgst+sgst;
		$("#gst_total_amount").val(gst_amount.toFixed(2));
        $("#total_amount").val(total_amount.toFixed(2));
		grand_total = total_amount+gst_amount;
		$("#grand_total").val(grand_total.toFixed(2));
		
		
		if ($("#discount").val() == '') {
			var discount = 0;
		} else {
			var discount = $("#discount").val();
		}
		var grand_total_amount = grand_total - discount
		$("#grand_total_amount").val(grand_total_amount.toFixed());
	}

	
	

	

	$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		if($("#supplier_id").val()==''){
			swal("Error!", "Select supplier !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#billing_type").val()=='0'){
			swal("Error!", "Select billing type !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#billing_type").val()=='1' && ($("#proforma_date").val()=='' || $("#proforma_no").val()=='') ){
			swal("Error!", "Enter proforma no and proforma date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;

		}
		else if($("#billing_type").val()=='2' && ($("#invoice_date").val()=='' || $("#invoice_no").val()=='') ){
			swal("Error!", "Enter invoice no and invoice date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;

		}
		else if($("#billing_type").val()=='3' && ($("#debit_date").val()=='' || $("#debit_no").val()=='')){
			swal("Error!", "Enter debit no and debit date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;

		}
		else if($("#billing_type").val()=='4' && ($("#credit_date").val()=='' || $("#credit_no").val()=='')){
			swal("Error!", "Enter credit no and credit date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		
		}
		else if($("#inspection_0").val()==''){
			swal("Error!", "Enter Inspection !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#product_id_0").val()==''){
			swal("Error!", "Select product !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#man_day_0").val()==''){
			swal("Error!", "Enter Man day !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#rate_0").val()==''){
			swal("Error!", "Enter Rate !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			//$("#req").val('PACKING_PRINTING_UPD');
			$("#req").val('ADDUPD');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "purchase_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='purchase_details.php';
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

	

	
	$("#photo").change(function(){
		var numb = $(this)[0].files[0].size/1024/1024;
		numb = numb.toFixed(2);
		var fileName = $("#photo").val();
		var idxDot = fileName.lastIndexOf(".") + 1;
		var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
		if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="JPG" || extFile=="JPEG" || extFile=="PNG"){
			if(numb <= 0.3){
				$(".page-loader").show();
				var fd=new FormData();
				fd.append('photo',$('#photo').prop('files')[0]);
				setTimeout(function(){	
					$.ajax({
							type:'POST',
							url:'phpservices/img_upload.php',
							data:fd ,
							cache:false,
							contentType:false,
							processData:false,
							dataType: 'JSON',
							success: function(result) {
								$(".page-loader").hide();
								$("#photo_name").val(result.op);
								$("#imgpreview").html('<label>Image Preview :</label><img src="temp/'+result.op+'" style="width:100px;margin-left:10px">');
							},
							async:false
					});
				},2000);
			}
			else{
				$("#photo").val('');
				$("#photo_name").val('');
				swal("Error!", "* Upload maximum 300 kb Image only !", "warning");
				return false;
			}
		}
		else{
			$("#photo").val('');
			$("#photo_name").val('');
			swal("Error!", "* Upload .png, .jpg, .jpeg, .PNG, .JPG, .JPEG type image only!", "warning");
			return false;
		}
	});	
		
 	$(document).on('click','.deleteTriger', function(){
		var delid=$(this).data('value');
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"PRODEDEL"},
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Deleted !", "success");
							setTimeout(function(){
								$("#msg").html('');
							},2000);
							$('#detailsgrid').DataTable().ajax.reload();
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
	});
		
		
});
function qualaddfunc(){
	var count = document.getElementsByClassName("trtag").length;
	$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><input type="text" id="model_id_'+count+'" name="model_id[]" placeholder="Model Name" class="form-control model_id" /><div id="suggesstion-box_'+count+'"></div></td><td style="padding:5px"><input type="text" id="design_'+count+'" name="design[]" placeholder="Design " class="form-control design" /><div id="suggesstion-box1_'+count+'"></div></td> 	<td style="padding:5px"> <input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_'+count+'" placeholder="Enter HSN Code" style="margin:0;">	</td><td style="padding:5px"> 	<select class="form-control uom_id" name="uom_id[]" id="uom_id_'+count+'"></select>	</td>	<td style="padding:5px"><input type="number" class="form-control man_day" name="man_day[]" id="man_day_'+count+'" placeholder="Enter Qty" style="margin:0;"></td>	<td style="padding:5px"><input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_'+count+'" placeholder="Enter Rate" style="margin:0;">	</td><td style="padding:5px"> 				<input type="number" class="form-control rate" name="rate[]" id="rate_'+count+'" placeholder="Enter Amount" style="margin:0;" readonly>			</td>				<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');
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


		$("#model_id_"+count).autocomplete({
			source: "model_search.php",
			select: function( event, ui ) {
				event.preventDefault();
				$("#model_id_"+count).val(ui.item.value);
			}
		});

		$("#design_"+count).autocomplete({
			source: "design_search.php",
			select: function( event, ui ) {
				event.preventDefault();
				$("#design_"+count).val(ui.item.value);
			}
		});

}
</script>
</html>