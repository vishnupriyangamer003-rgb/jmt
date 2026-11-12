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

            $dc_id = $_GET['id'] ?? '';
            $sql_customer = "SELECT a.*, date_format(a.billing_date,'%d/%m/%Y') as billing_date,
                d.customer_name as cust_name, d.company_name as cust_company, d.state_code as cust_state_code, 
                d.state as cust_state, d.gst_no as cust_gst, d.address as cust_address 
                FROM tbl_dc a 
                LEFT JOIN tbl_customer d ON d.customer_id=a.customer_id AND d.delete_status!='0' 
                WHERE a.delete_status!='0' AND a.dc_id='".mysqli_real_escape_string($conn, $dc_id)."'";
            $query_customer = mysqli_query($conn, $sql_customer);
            $row_customer = $query_customer ? mysqli_fetch_array($query_customer) : array();

            $driver_name = '-';
            $vechicle_name = '-';
            $driver_type_val = $row_customer["driver_type"] ?? '';

            if (!empty($row_customer["vechicle_number"])) {
                $vechicle_name = $row_customer["vechicle_number"];
            } else if (!empty($row_customer["refrence_name"])) {
                $vechicle_name = $row_customer["refrence_name"];
            }

            if ($driver_type_val == '1') {
                $driver_type = 'Own';
                $emp_id = trim((string)($row_customer["driver_id"] ?? ''));
                if ($emp_id !== '') {
                    $gql_driver = "SELECT emp_name FROM tbl_employee_details WHERE delete_status='NDL' AND emp_id='".mysqli_real_escape_string($conn, $emp_id)."' LIMIT 1";
                    $exec_gql_driver = mysqli_query($conn, $gql_driver);
                    if ($exec_gql_driver && ($fetch_gql_driver = mysqli_fetch_assoc($exec_gql_driver))) {
                        $driver_name = !empty($fetch_gql_driver["emp_name"]) ? $fetch_gql_driver["emp_name"] : '-';
                    }
                }
                if ($vechicle_name === '-') {
                    $vec_id = trim((string)($row_customer["vechicle_id"] ?? ''));
                    if ($vec_id !== '') {
                        $gql_vechicle = "SELECT vechicle_name FROM tbl_vechicle_details WHERE delete_status='NDL' AND vechicle_id='".mysqli_real_escape_string($conn, $vec_id)."' LIMIT 1";
                        $exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
                        if ($exec_gql_vechicle && ($fetch_gql_vechicle = mysqli_fetch_assoc($exec_gql_vechicle))) {
                            $vechicle_name = !empty($fetch_gql_vechicle["vechicle_name"]) ? $fetch_gql_vechicle["vechicle_name"] : '-';
                        }
                    }
                }
            } else if ($driver_type_val == '2') {
                $driver_type = 'Other';
                $driver_name = !empty($row_customer["driver_name"]) ? $row_customer["driver_name"] : '-';
                if ($vechicle_name === '-') {
                    $vechicle_name = !empty($row_customer["vechicle_number"]) ? $row_customer["vechicle_number"] : '-';
                }
            } else {
                $driver_type = 'Own';
            }

            $billing_no=$row_customer['dc_no'];
            $billing_date=$row_customer['billing_date'];
            $customer_name=$row_customer['customer_name'];
            $customer_company=$row_customer['company_name'];
            $state_code=$row_customer['state_code'];
            $state=$row_customer['state'];
            $customer_address=$row_customer['address'];
            $customer_gst_no=$row_customer['gst_no'];
            $customer_state=$row_customer['state'];
            $cgst=$row_customer['cgst'];
            $sgst=$row_customer['sgst'];

            $discount=$row_customer['discount'];

            $delivery_address=$row_customer['delivery_address'];

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
                                $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
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
                                        <h3 style="font-size: 22px;font-weight: 700;margin: 0;color: #000;">DC INVOICE</h3>
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
							
                                <div class="col-sm-12" style="">
                                    <div class="row">
                                        <div class="col-sm-6" style="border: 1px #00000030 solid"> 
                                           <p class="onepage_p" style="margin-top: 1rem;">
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Invoice No&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_no ?></span>

                                                </br>

                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Invoice&nbsp;Date&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_date ?></span>
                                                </br>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $row['adm_state']; ?></span></br>
                                                
                                            </p>
                                            
                                        </div>
                                        <div class="col-sm-6" style="border: 1px #00000030 solid"> 
                                            <p class="onepage_p" style="margin-top: 1rem;">
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Transportation Mode&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $driver_type; ?></span><br>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Vehicle&nbsp;Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $vechicle_name; ?></span>
                                            </p>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6" style="border: 1px #00000030 solid">          
                                            
                                            <p class="onepage_p" style="margin-top: 1rem;margin-bottom: 2rem;"><b>Details of Receiver / Billed To:</b><br>
                                                <?php if(!empty($customer_name)){ ?>
                                                <?php echo $customer_name; ?><br>
                                                <?php } ?>
                                                <?php if(!empty($customer_company)){ ?>
                                                <?php echo $customer_company; ?><br>
                                                <?php } ?>                                                
                                                <?php if(!empty($customer_address)){ ?>
                                                <?php echo $customer_address; ?>
                                                <?php } ?> <br>                                             
                                                <?php if(!empty($customer_state)){ ?>
                                                <?php echo $customer_state; ?>
                                                <?php } ?>
												<br>
                                                <?php if(!empty($customer_gst_no)){ ?> 
                                                GST No : <?php echo $customer_gst_no ?>
                                                <?php } ?>

                                                <span class="onepage_p" style="font-size: 15px;  color:black; font-weight: bold; float:right;">State&nbsp;&nbsp;Code&nbsp; : <?php echo $state_code ?></span>
                                            </p>
                                        </div>
                                        <div class="col-sm-6" style="border: 1px #00000030 solid"> 
                                           
                                            <p class="onepage_p" style="margin-top: 1rem;margin-bottom: 2rem;"><b>Details of Consignee / Shipped To:</b><br>
                                                <?php if(!empty($delivery_address)){ ?>
                                                <?php echo $delivery_address; ?><br>
                                                <?php } ?>

                                                

                                            </p> 
                                            
                                        </div>
                                        
                                    </div>
                                </div>

                                <table  class="table table-striped table-bordered" width="100%"  style="border: none;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align:center;">S.no</th>
                                            <th style="width: 30%; text-align:center;">Product</th>
                                            <th style="width: 20%; text-align:center;">HSN&nbsp;Code</th>
                                            <th style="width: 20%; text-align:center;">UOM</th>
                                            <th style="width: 10%; text-align:center;">Quantity</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                            $sql="SELECT b.*,a.total_amount,a.grand_total_amount FROM tbl_dc  a 
                                            inner join tbl_dc_details b on a.dc_id=b.dc_id
                                            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  d.delete_status!='0' and b.dc_id='".$_GET['id']."'";
                                            $query=mysqli_query($conn,$sql);
                                            
                                            $j=1;
                                            $total_amount=0;
                                            $total_qty=0;
                                            $total_product_rate=0;
                                        while ($fetch_booking_details = mysqli_fetch_array($query)) {
                                            
                                            $total_amount=$total_amount+$fetch_booking_details['rate'];  
                                            $total_qty=$total_qty+$fetch_booking_details['qty']; 
                                            $total_product_rate=$total_product_rate+$fetch_booking_details['product_rate'];  
                                            
                                            $gql3 = "SELECT *, t2.uom_name FROM tbl_products t1 left join tbl_uom t2 on t1.uom_id=t2.uom_id where  product_id='".$fetch_booking_details['product_id']."' ";
											$exec_gql3 = mysqli_query($conn, $gql3);			
											$fetch_gql3 = mysqli_fetch_array($exec_gql3);

                                            
                                        ?>


                                            <tr style="page-break-inside: avoid">
                                                <td class="text-center"><?php echo $j; ?></td>
                                                <td class="text-center"><?php echo $fetch_gql3["product_name"]; ?></td>
                                                <td class="text-center"><?php echo $fetch_gql3["hsn_code"]; ?></td>
                                                <td class="text-center"><?php echo $fetch_gql3["uom_name"]; ?></td>
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:#000; font-weight: bold"><?php echo $fetch_booking_details['qty']; ?></td>
                                                
                                                
                                                
                                                
                                            </tr>

                                        <?php

                                            $j++;

                                            
                                        } ?>

                                        <?php

                                         $i = 6 - $j;
                                        for ($z = $j; $z < 6; $z++) { ?>

                                            <tr style="page-break-inside: avoid">
                                                
                                                <td>&nbsp;</td>
                                                <td></td>
                                                <td></td>
												<td></td>
                                                
                                                <td></td>
                                                
                                                
                                            </tr>


                                        <?php } ?>

											

                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              
											<td colspan="3" style="text-align: center"></td>
                                            
                                            <td style="padding:2px; font-size: 15px;  width: 15%;  color:#000; font-weight: bold; text-align: center;vertical-align: middle!important;">Total Qty</td>
                                                <td    style="padding:2px; font-size: 16px;  width: 15%;  color:#ff6e38; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo $total_qty; ?></td>

												
											</tr>

                                           
                                            					
											
											
                                    </tbody>
                                    <tfoot >
										
										<tr style="page-break-inside: avoid">
										
											

											
											<td colspan="3" style="text-align: center">
												<p style="margin-bottom: 0rem;font-size:15px"></p>
												<br>
												<br>
												<br>
												<br>
												<br>
												<p style="text-align:center;font-size:15px"><b>Customer Signature with seal</b></p>
											</td>

											
											<td colspan="3" style="text-align: center">
											<p style="margin-bottom: 0rem;font-size:15px"><b>For Karur Chamberss</b></p><br><br><br><br><br>
												<br>
												<br>
												<!--img src="images/no_image.png" style="width:130px;height:109px;text-align:center;object-fit:contain"-->
											<p style="text-align:center;font-size:15px">Authorized Signatory</p>
											</td>
											
										</tr>
										
                                        
                                    </tfoot>						
									
									
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