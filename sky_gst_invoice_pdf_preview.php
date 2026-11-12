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
		.onepage_p, .table td, .table th{
			font-size: 19px!important;
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

 <style>
 body {
 color: black;
 }

 #tablemainbind {
 vertical-align: center;
 padding: 0.2rem !important;
 }

 .table td {
 vertical-align: center !important;

 }

 .select2-container--default .select2-selection--single .select2-selection__rendered {
 color: #444;
 line-height: 36px;
 }
 .watermark {
 position: absolute;
 opacity: 0.10;
 font-size: 3em;
 width: 30%;
 text-align: center;
 z-index: 1000;
 top: 60%;
 left: 35%;
 transform: translate(-50%, -50%);
 }

 @media print {
 footer {
 position: fixed;
 bottom: 0;
 /* text-align: center; */
 width: 100%;

 }
 }
.table-striped tbody tr:nth-of-type(odd){
	background-color: #fff;
}
.table-bordered thead td, .table-bordered thead th{
	background: #fef9c3!important;
 color: #000000!important;
}
.table thead th {
 vertical-align: bottom;
 border: 1px solid #00000030;
}
 </style>
 

 <!-- begin::main content -->
 <main class="main-content" style="padding-top:0px">
 <?php

 $where='';
 $date_check='';
 if (!empty($_GET['customer_id'])){

 $where.=" and a.customer_id='".$_GET['customer_id']."'";

 }

 
 

 if(!empty($_GET['fdate'])){
		
	
 $fdate = date('Y-m-d', strtotime($_GET['fdate']));
 $tdate = date('Y-m-d', strtotime($_GET['tdate']));
 
 $date_check=" and a.billing_date between '" . $fdate . " 00:00:00' and '" . $tdate . " 23:59:59'";
 
 
 }else{
 
 $fdate='';
 $tdate='';
 $date_check="";
 	
 }

 

 ?>

 <div class="row">
 <div class="col-md-12">
 <div class="card">
 <div class="card-body">
 <div class="text-right d-print-none" style="text-align: center!important;margin-top:0px">
 <a href="javascript:window.print()" class="btn btn-success m-l-5 text-right" style="margin-top:0px;margin-right:15px;color: #fff"> <i class="fa fa-print m-r-5"></i> Print
 </a>
 </div>
 <div class="watermark"><img src="images/sm_logo.jpeg" alt=""></div>
 

 <div class="row" style="margin-top: 25px;">
 
 <?php 
 $sql = "SELECT * FROM tbl_admin WHERE admin_id='1'";
 $resul = $conn->query($sql); 
 $row = $resul->fetch_assoc();
 ?>
 <div class="col-sm-12" style="border: 1px #00000030 solid">
								<div class="row" style="padding-bottom: 5px;padding-top: 15px;">
                                    <div class="col-sm-12" style="text-align: center;">
                                        <img src="userdata/images/jayam_logo.png" alt="Jayam Hydraulics Engineering" style="max-height: 68px; margin-bottom: 6px; display: inline-block;"><br>
                                        <h2 style="font-size: 26px;font-weight: 800;color: #08444d;margin: 0 0 5px 0;">Jayam Hydraulic Engineering</h2>
                                        <p style="font-size: 15px;color: #333;line-height: 22px;margin: 0 0 8px 0;">
                                            <?php echo isset($row['addr']) ? nl2br($row['addr']) : ''; ?>
                                        </p>
                                        <h3 style="font-size: 22px;font-weight: 700;margin: 0;color: #000;">TAX REPORT</h3>
                                    </div>
                                </div> 
								<div class="row" style="border-top: 1px #00000030 solid">							
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;float: left"><b>GST No :</b> <?php echo $row['gstno']; ?></p>
									</div>						
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;text-align: center">
										<b>Phone :</b> 70314 12345, 70316 12345</p>
									</div>						
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;float: right"><b>Prop :</b> S. Sudarsan</p>
									</div>
								</div> 
 </div>
							
 

 <table class="table table-striped table-bordered" width="100%" style="border: none;">
 <thead>
 <tr>
 <th style="width: 5%; text-align:center;">S.no</th>
 <th style="width: 10%; text-align:center;">Date</th>
 <th style="width: 10%; text-align:center;">DC&nbsp;NO</th>
 <th style="width: 15%; text-align:center;">Cus&nbsp;Name</th>
 <th style="width: 10%; text-align:center;">Vechicle&nbsp;No</th>
 <th style="width: 10%; text-align:center;">Tot Amt</th>
 <th style="width: 15%; text-align:center;">GST Amt</th>
 <th style="width: 15%; text-align:center;">Grand Tot Amt</th>
 </tr>
 </thead>

 <tbody>

 <?php

 $sql = "SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,a.driver_type,a.total_amount,a.gst_total_amount,a.discount,a.grand_total_amount,d.customer_id,d.customer_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_sky_gst_invoice a inner join tbl_sky_gst_invoice_details b on a.dc_id=b.dc_id left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0' $where $date_check";
 $query=mysqli_query($conn,$sql);
 
 $j=1;
 $total_amount=0;
 
 while ($fetch_booking_details = mysqli_fetch_array($query)) {
 
 


 if($fetch_booking_details["driver_type"]=='1'){
 
 $gql_vechicle = "SELECT * FROM tbl_vechicle_details where delete_status='NDL' and vechicle_id='".$fetch_booking_details["vechicle_id"]."' ";
 $exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
 $fetch_gql_vechicle = mysqli_fetch_array($exec_gql_vechicle);
 
 $vechicle_name = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$fetch_gql_vechicle["vechicle_name"]).'</span>';
 
 
 }else if($fetch_booking_details["driver_type"]=='2'){
 
 //$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$row["driver_name"]).'</span>';	
 
 $vechicle_name = '<span style="font-size: 15px;color: red;font-weight: bold;">'.str_replace("^","'",$fetch_booking_details["vechicle_number"]).'</span>';	
 
 
 }else{
 $vechicle_name = '-';
 
 
 }


 
 ?>


 <tr style="page-break-inside: avoid">
 <td class="text-center"><?php echo $j; ?></td>
 <td class="text-center"><?php echo $fetch_booking_details["billing_date"]; ?></td>
 <td class="text-center"><?php echo $fetch_booking_details["dc_no"]; ?></td>
 <td class="text-center"><?php echo $fetch_booking_details["customer_name"]; ?><br><?php echo $fetch_booking_details["mblno"]; ?></td>
 <td class="text-center" style="font-size: 15px; text-align: right; width: 15%; color:#000; font-weight: bold"><?php echo $vechicle_name; ?></td>
 <td class="text-right" style="font-size: 15px; text-align: right; width: 15%; color:#000; font-weight: bold"><?php echo number_format((float)$fetch_booking_details['total_amount'], 2, '.', ''); ?></td>
 <td class="text-right" style="font-size: 15px; text-align: right; width: 15%; color:#000; font-weight: bold"><?php echo number_format((float)$fetch_booking_details['gst_total_amount'], 2, '.', ''); ?></td>
 <td class="text-right" style="font-size: 15px; text-align: right; width: 15%; color:#000; font-weight: bold"><?php echo number_format((float)$fetch_booking_details['grand_total_amount'], 2, '.', ''); ?></td>
 
 
 </tr>

 <?php

 $j++;

 
 } ?>

 
											
 					
											
											
 </tbody>
 						
									
									
 </table>
 </div>

 </div>



 </div>
 </div>
 </div>
 </div>
 </main>




 <!-- end::main content -->
 <style>
 .dataTables_length {
 text-align: left;
 }

 .dataTables_filter {
 text-align: left;
 }
 </style>
 <!-- begin::global scripts -->
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
<style>
 .card .card-body,
 .page-header .card-body {
 padding: 17px;
 padding-bottom: 0px;
 }

 @media print {
 .bottomdiv {
 display: none !important;
 }

 body {
 padding: 0;
 }
 }

 @media(min-width:992px) {
 .navbar-nav {
 display: block !important;
 width: 100%;
 }

 .userdiv {
 float: right;
 }

 .mybut {
 margin-top: 33px;
 }
 }

 @media(max-width:480px) {
 nav.navbar .header-logo a img {
 width: 180px;
 }
 }

 .table td {
 vertical-align: bottom !important;
 padding: 5px;
 }
</style>


<script>

</script>

</html>
