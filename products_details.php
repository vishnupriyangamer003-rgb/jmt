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

    <div class="container-fluid" >
        <div class="page-header d-md-flex justify-content-between align-items-center alert alert-warning  alert-with-border alert-dismissible" >
            <h4>Products Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item" ><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page" >Products Details</li>
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
									<input type="text" class="form-control" id="category" name="category" placeholder="Enter category (e.g. Spares, Service)">
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
									<input type="text" class="form-control" id="opening_stock" name="opening_stock" placeholder="Enter Opening Stock (default 0)">
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
									<label>GST(%) :</label>
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
										<option value="Active" selected>Active</option>
										<option value="Inactive">Inactive</option>
									</select>
								</div>
							</div>

							<div class="col-md-12" style="display:none;">
								<div class="alert alert-info" style="margin-bottom:10px;">Raw-material (BOM) rows below are <b>optional</b> for spares — leave empty for traded spares/service items.</div>
							</div>
							<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:none;margin-bottom:0;border: none;">
							<thead>
								<tr>
									<th style="width: 15%">Raw Material</th>	
									<th style="width: 15%">Qty (in kg)</th>									
									
									<th style="width: 5%">Action</th>
								</tr>
							</thead>
							<tbody id="tablemainbind">
								<tr class="trtag" id="trtag0">
								
									<td style="padding:5px">
										
										<select class="form-control raw_material_id js-example-basic-single select2-hidden-accessible" id="raw_material_id_0" name="raw_material_id[]">
										</select>
										
									</td>
									<td style="padding:5px">
										
										<input type="text" id="qty_0"  name="qty[]" class="form-control qty" placeholder="Qty " />
																				
									</td>									
									
									
									<td style="padding:5px;text-align:center">
										<a href="#" class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>
								</tr>
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

							
							
							<div class="col-md-3 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:32px;">Save</button>
									<button type="reset" name="resetbut" id="resetbut" class="btn btn-danger" style="margin-top:32px;">Reset</button>
								</div>
							</div>
							<div class="col-md-2">
							<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
						
                    </form>
				<hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                     <tr>
                        <th>S.no</th>						
                        <th>Product&nbsp;Name</th>
						<th>Sale&nbsp;Price</th>
						<th>GST</th>
												
						<th>HSN&nbsp;Code</th>											
						<th>Last&nbsp;Update</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					<tbody>
							<!--tr>
								<td>1</td>
								<td>Brick</td>
								<td>20</td>
								<td>25</td>
								<td>5%</td>
								<td>KG</td>
								<td>HSN001</td>
								<td>Admin</td>
								<td><div class="btn-group" role="group" aria-label="Basic example">
										<button type="button" class="btn btn-success">
											<i class="fa fa-edit" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
										</button>
										<button type="button" class="btn btn-danger">
											<i class="fa fa-trash" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
										</button>
									</div>
								</td>
							</tr-->
							
						</tbody>
                </table>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->





<?php include("footer.php") ?>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="1">
<input type="hidden" name="rightsbox" id="rightsbox">
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
	

	$("#resetbut").click(function(){

		setTimeout(function(){
			window.location.href='products_details.php';
			
		},500);


	});

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
				$(".raw_material_id").removeAttr("disabled");
				$(".raw_material_id").append(d_data);
				$(".page-loader").hide();	
			}							
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
			$("#req").val('ADDINS');
			$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
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



	$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
		 	aLengthMenu: [
			[10, 100, 500, 1000],
			[10, 100, 500, 1000]
		],
// 		"pageLength": 10,
         "ajax":{
            url :"product_details_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
             $("#detailsgrid").css("display","none");
						console.log(JSON.stringify(xhr,status,error));
            }
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
						console.log(result.op);
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
		$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control js-example-basic-single select2-hidden-accessible raw_material_id" name="raw_material_id[]" id="raw_material_id_'+count+'"></select><div id="suggesstion-box_'+count+'"></div></td><td style="padding:5px"><input type="text" id="qty_'+count+'" name="qty[]" placeholder="Qty " class="form-control qty" /></td> 				<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');


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

		$("#raw_material_id_" + count).select2({});

		
	}
	
</script>
</html>