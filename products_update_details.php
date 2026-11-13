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
            <h4>Update Product Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Product</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Product Details</li>
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

							

								
						<div class="col-md-3">
								<div class="form-group">
									<label>Product Name :</label><span style="color:red;font-size:22px;font-weight:900">*</span>
									<input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Product Code :</label>
									<input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter product code">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Category :</label>
									<input type="text" class="form-control" id="category" name="category" placeholder="Enter category">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Sale Price :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="sale_amount" name="sale_amount" placeholder="Enter Sale Price">
									
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Purchase Rate :</label>
									<input type="text" class="form-control" id="purchase_rate" name="purchase_rate" placeholder="Enter Purchase Rate">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Opening Stock :</label>
									<input type="text" class="form-control" id="opening_stock" name="opening_stock" placeholder="Enter Opening Stock">
								</div>
							</div>
							<div class="col-md-3" style="display:none;">
								<div class="form-group">
									<label>UOM :</label>
									<input type="hidden" id="uom_id" name="uom_id" value="0">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>GST(%) :</label><span style="color:red;font-size:22px;font-weight:900">*</span>
									<input type="text" class="form-control" id="gst" name="gst" placeholder="Enter GST">
								</div>
							</div>						
							

							<div class="col-md-3">
								<div class="form-group">
									<label>HSN Code :</label><span style="color:red;font-size:22px;font-weight:900">*</span>
									<input type="text" class="form-control" id="hsn_code" name="hsn_code" placeholder="Enter HSN Code">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Status :</label>
									<select class="form-control" id="status" name="status">
										<option value="Active">Active</option>
										<option value="Inactive">Inactive</option>
									</select>
								</div>
							</div>

								
							
							<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:none;margin-bottom:0;border: none;">
							<thead>
								<tr>
									<th style="width: 15%">Raw Material</th>	
									<th style="width: 15%">Qty  (in kg)</th>										
									
									<th style="width: 5%">Action</th>
								</tr>
							</thead>
							<tbody id="tablemainbind">
							<?php
								$sql="SELECT b.* FROM tbl_products  a 
								inner join tbl_product_details b on a.product_id=b.product_id 
								left join  tbl_raw_material e on e.id=b.raw_material_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and b.product_id='".$_GET['id']."'";
								$exec_sql=mysqli_query($conn,$sql);
								$i=0;
								while($fetch_zql=mysqli_fetch_array($exec_sql)){
							?>
								<tr class="trtag" id="trtag<?php echo $i+1;?>">
								
									<td style="padding:5px">
										 <select class="form-control raw_material_id" id="raw_material_id_<?php echo $i;?>" name="raw_material_id[]" style="margin:0;">
											<option value="">Select raw material</option>
												<?php
													$sql_product="select * from tbl_raw_material where delete_status='NDL'";
													$exec_sql_product=mysqli_query($conn,$sql_product); 
													while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
													<option value="<?php  echo $fetch_sql_product['id'] ?>"<?php if(($fetch_sql_product['id']) ==(($fetch_zql['raw_material_id']))) echo "selected" ?>><?php echo $fetch_sql_product['name'] ?></option>
													<?php }  ?>
										</select>
									</td>

									<td style="padding:5px">
										
										<input type="text" id="qty_<?php echo $i;?>" name="qty[]"  class="form-control qty" value="<?php echo $fetch_zql["qty"]; ?>" />
										<div id="suggesstion-box"></div>
										
									</td>									
									
									
									
									<td style="padding:5px;text-align:center">
										<a href="#" class="trtag1" data-value=<?php echo $i+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>
									
								</tr>
							<?php $i++; } ?>
							</tbody>
							<tfoot id="taxbind1">
																<tr class="taxdiv" id="taxdiv0">
									<th colspan="2" style="border:none"></th>										
									<th style="border:none; text-align:center;">
										<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
									</th>
								
								</tr>
							
                               

                            </tfoot>


						</table>
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">									
									<input type="hidden" name="product_id" id="product_id" value=<?php echo $_GET['id'];?>>
									<button type="submit" name="submit" style="margin-top:32px;" id="submit" class="btn btn-success">Save</button>									
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


<script>


$(document).ready(function(){

	
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


		var ids_string=<?php echo $_GET['id']; ?>;
		$(".page-loader").show();
		$.ajax({
			type: "POST",
			url: "products_details_service.php",
			dataType:'json',
			data: {id:ids_string,req:"AUB"},
			success: function(result) {
			$("#product_name").val(result.op[0]['product_name']);
			$("#product_code").val(result.op[0]['product_code']);
			$("#category").val(result.op[0]['category']);
			$("#sale_amount").val(result.op[0]['sale_price']);
			$("#purchase_rate").val(result.op[0]['purchase_rate']);
		$("#opening_stock").val(result.op[0]['opening_stock'] ?? '');

				
							setTimeout(function(){
								$("#uom_id").val(result.op[0]['uom_id']);
							},1000);

				
			$("#gst").val(result.op[0]['gst']);
			$("#hsn_code").val(result.op[0]['hsn_code']);
			if(result.op[0]['status']){ $("#status").val(result.op[0]['status']); }
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});	
	

	$("#resetbut").click(function(){
		$("#gal_cat_id").val('');
		$("#title").val('');
		$("#photo").val('');
		$("#photo_name").val('');
		$("#imgpreview").html('<label>Image Preview :</label><img src="media/image/no_image.png"  style="width:100px;margin-left:4px">');
		$("#resetbut").css('outline','none');
		$("#resetbut").css('box-shadow','none');
	});

	


	/*$.ajax({
			
			type: "POST",
			url: "raw_material_dropdown.php",
			success: function(result) {				
				var raw_material_id=result.raw_material_id;
				var raw_material_name=result.raw_material_name;
				var d_length=result.raw_material_id.length;
				var d_data='<option value="">Select raw material</option>';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+raw_material_id[i]+'">'+raw_material_name[i]+'</option>';
					
				}
				$(".raw_material_id").removeAttr("disabled");
				$(".raw_material_id").append(d_data);
				$(".page-loader").hide();	
			}							
	});*/



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
				$("#uom_id").removeAttr("disabled");
				$("#uom_id").append(d_data);
				$(".page-loader").hide();	
			}							
	});



	

	
	

	
	

	

	$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		
		if($("#product_name").val()=='0'){
			swal("Error!", "Enter product name !", "warning");
			return false;
		}
		else if($("#sales_amount").val()=='0'){
			swal("Error!", "Enter Sales amount !", "warning");
			return false;
		}
		else if($("#gst").val()=='0'){
			swal("Error!", "Enter GST  !", "warning");
			return false;
		}
		else if($("#hsn_code").val()==''){
			swal("Error!", "Enter HSN Code !", "warning");
			return false;
		}
		else{
			//$("#req").val('PACKING_PRINTING_UPD');
			$("#req").val('PRODUPD');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='products_details.php';
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

	

	
		
		
 	$(document).on('click','.deleteTriger', function(){
		var delid=$(this).data('value');
		swalConfirm("Do you want to Delete ?", function(){
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
		});
	});
		
		
});
function qualaddfunc(){
		var count = document.getElementsByClassName("trtag").length;
		$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control raw_material_id" name="raw_material_id[]" id="raw_material_id_'+count+'"></select><div id="suggesstion-box_'+count+'"></div></td><td style="padding:5px"><input type="text" id="qty_'+count+'" name="qty[]" placeholder="Qty " class="form-control qty" /></td> 				<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');


		$("#raw_material_id_"+count).empty();
		$.ajax({
			
			type: "POST",
			url: "raw_material_dropdown.php",
			success: function(result) {				
				var raw_material_id=result.raw_material_id;
				var raw_material_name=result.raw_material_name;
				var d_length=result.raw_material_id.length;
				var d_data='<option value="">Select raw material</option>';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+raw_material_id[i]+'">'+raw_material_name[i]+'</option>';
					
				}
				$("#raw_material_id_"+count).removeAttr("disabled");
				$("#raw_material_id_"+count).append(d_data);
				$(".page-loader").hide();	
			}							
		});
	}
</script>
</html>