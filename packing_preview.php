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

    <style>
        body {
            color: black;
        }

        #tablemainbind {
            vertical-align: bottom;
            padding: 0.2rem !important;
        }

        .table td {
            vertical-align: bottom !important;

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
    </style>
    <!-- begin::main content -->
    <main class="main-content" style="padding-top:0px">
        <?php
            $booking_id = $_GET['id'];
            $sql_customer = "SELECT *,a.booking_type,a.billing_no,a.billing_type,date_format(a.billing_date,'%d/%m/%Y') as billing_date,d.customer_id,d.customer_name,d.company_name,d.gst_no,d.address FROM tbl_booking  a  
            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  d.delete_status!='0' and a.booking_id='$booking_id'";
            $query_customer = mysqli_query($conn, $sql_customer);
            $row_customer = mysqli_fetch_array($query_customer);

            $booking_type=$row_customer['booking_type'];
            $billing_no=$row_customer['billing_no'];
            $billing_date=$row_customer['billing_date'];
            $customer_company=$row_customer['company_name'];
            $customer_address=$row_customer['address'];
            $customer_gst_no=$row_customer['gst_no'];
            $cgst=$row_customer['cgst'];
            $sgst=$row_customer['sgst'];



            

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
                        

                        <!--div class="row" style="margin-top: 50px;">
                            <div class="col-sm-12">
							<?php //if($row_customer['billing_type']=='1'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">PRO FORMA</h3>
							<?php //} else if($row_customer['billing_type']=='2'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">INVOICE</h3>
							<?php //} else if($row_customer['billing_type']=='3'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">DEBIT NOTE</h3>
							<?php //} else if($row_customer['billing_type']=='4'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">CREDIT NOTE</h3>
							<?php //} else if($row_customer['billing_type']=='5'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">PURCHASE INVOICE</h3>
							<?php //} ?>
							
                            <div class="col-md-12" style="border: solid;border-color: #f0f0f0;margin-top: -11px;">
					 
                    <div class="row">
                        <div class="col-md-6" style="border-right: solid;border-color: #f0f0f0">
							<p><b>Service Provider :</b><br>
							<?php                           
							  //$sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
							  //$resul = $conn->query($sql);  
							  //$row = $resul->fetch_assoc();
							 ?>
								<b><?php //echo $row['cname']; ?></b>,<br>
								<?php //echo nl2br ($row['addr']);?><br>
								<b>GST No :</b> <?php //echo $row['gstno']; ?>
							</p><hr>
                            <p><b>Consin :</b><br>
								<?php //if(!empty($customer_company)){ ?>
								<?php //echo $customer_company; ?><br>
								<?php //} ?>                                                
								<?php //if(!empty($customer_address)){ ?>
								<?php //echo $customer_address; ?>
								<?php //} ?><br>
								<?php //if(!empty($customer_gst_no)){ ?> 
								GST No : <?php //echo $customer_gst_no ?>
								<?php //} ?>
							</p>
						</div>
                        <div class="col-md-6">
							<p><b>Invoice No. & Date </b>: <?php //echo $billing_no ?> & <?php //echo $billing_date ?><br>
								Buyer's Order No. : <?php //echo nl2br ($row_customer['order_detail']); ?> <br>
							</p>
						</div>
					</div>
					</div-->


                    <div class="row" style="margin-top: 50px;">
                            

                            <div class="col-sm-12">

                                <div>

                                <p style="text-align: left; padding: 5px; border-top: solid;border-right: solid;border-left: solid;border-color: #f0f0f0;margin-top: 10px;"><br>
                                    <img src="images/sm_logo.jpeg" width="100" alt="">
                                        <?php                           
                                        $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
                                        $resul = $conn->query($sql);  
                                        $row = $resul->fetch_assoc();
                                        ?>
                                            <span style="text-align: left; font-size: 30px; text-width:bold;"><?php echo $row['cname']; ?></span><br><br>
                                            
                                            <span style="float:right; text-align: right; padding: 10px;font-size: 14px; margin-top: -130px;">
                                
                                            <?php if($row_customer['billing_type']=='1'){ ?>
                                                <span style="font-size: 30px;">PRO FORMA</span>
                                            
                                            <?php } else if($row_customer['billing_type']=='2'){ ?>                  

                                            <span style="font-size: 30px;">INVOICE</span>
                                
                                            <?php } else if($row_customer['billing_type']=='3'){ ?>
                                                <span style="font-size: 30px;">DEBIT NOTE</span>
                                            
                                            <?php } else if($row_customer['billing_type']=='4'){ ?>
                                                <span style="font-size: 30px;">CREDIT NOTE</span>
                                            
                                            <?php } else if($row_customer['billing_type']=='5'){ ?>
                                                <span style="font-size: 30px;">PURCHASE INVOICE</span>
                                            <?php } ?>

                                            <br><?php echo nl2br ($row['addr']);?><br>
                                            <b>GST No :</b> <?php echo $row['gstno']; ?></span>

                                </p>

                            </div>
                            
							
                                <div class="col-md-12" style="border: solid;border-color: #f0f0f0;margin-top: -11px;">
                        
                                    <div class="row">
                                        <div class="col-md-6" style="border-right: solid;border-color: #f0f0f0">                                            
                                            
                                            <p><b>Service Provider :</b><br>
                                            <?php                           
                                            $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
                                            $resul = $conn->query($sql);  
                                            $row = $resul->fetch_assoc();
                                            ?>
                                                <b><?php echo $row['cname']; ?></b>,<br>
                                                <?php echo nl2br ($row['addr']);?><br>
                                                <b>GST No :</b> <?php echo $row['gstno']; ?>
                                            </p><hr>
                                            <p><b>Consin :</b><br>
                                                <?php if(!empty($customer_company)){ ?>
                                                <?php echo $customer_company; ?><br>
                                                <?php } ?>                                                
                                                <?php if(!empty($customer_address)){ ?>
                                                <?php echo $customer_address; ?>
                                                <?php } ?><br>
                                                <?php if(!empty($customer_gst_no)){ ?> 
                                                GST No : <?php echo $customer_gst_no ?>
                                                <?php } ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">                                            

                                            <p><b>Invoice No. & Date </b>: <?php echo $billing_no ?> & <?php echo $billing_date ?><br>
                                                Buyer's Order No. : <?php echo nl2br ($row_customer['order_detail']); ?> <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <table  class="table table-striped table-bordered" width="100%"  style="border: none;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;text-align: center">S.No</th>
                                            <th style="width: 25%;text-align: center">Products</th>
                                            <th style="width: 15%;text-align: center">Size(Inch)</th>
                                            <th style="width: 10%;text-align: center">Colour</th>
                                            <th style="width: 10%;text-align: center">HSN&nbsp;Code</th>
                                            <th style="width: 10%;text-align: center">Units</th>
                                            <th style="width: 10%;text-align: center">Quantity</th>
                                            <th style="width: 15%; text-align: center;">Rate</th>
                                            <th style="width: 15%; text-align: center;">Total&nbsp;Price&nbsp;Rs</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                            $sql = "SELECT a.booking_id,b.size as size,c.product_name  as product_name,d.unit_name as unit_name,e.color_name as color_name,b.hsn_code  as hsn_code,b.rate  as rate,b.product_rate  as product_rate,b.man_day as man_day,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_booking  a 
                                            inner join tbl_booking_details b on a.booking_id=b.booking_id 
                                            left join  tbl_products c on c.product_id=b.product_id 
                                            left join  tbl_unit d on d.unit_id=b.unit_id  
                                            left join  tbl_color e on e.color_id=b.color_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  c.delete_status!='0' and  d.delete_status!='0' and  e.delete_status!='0' and   a.booking_id='$booking_id' ";
                                            $query = mysqli_query($conn, $sql);
                                            
                                            $j=0;
                                            $total_amount=0;
                                        while ($fetch_booking_details = mysqli_fetch_array($query)) {
                                            
                                            $total_amount=$total_amount+$fetch_booking_details['rate'];

                                            //$get_amount= numberTowords($total_amount);

                                            
                                            
                                        ?>


                                            <tr style="page-break-inside: avoid">
                                                <td class="text-center"><?php echo $j + 1; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['product_name']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['size']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['color_name']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['hsn_code']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['unit_name']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['man_day']; ?></td>
                                                <td class="text-center" style="width: 15%; text-align: right;"><?php echo number_format((float) $fetch_booking_details['product_rate'], 2, '.', ''); ?></td>
                                                <td class="text-center" style="width: 15%; text-align: right;"><?php echo number_format((float)$fetch_booking_details['rate'], 2, '.', ''); ?></td>
                                                
                                            </tr>

                                        <?php

                                            $j++;

                                            
                                        } ?>

                                        <?php

                                        //$i = $ten - $count;
                                       // for ($z = $count; $z < $ten; $z++) { ?>

                                            <tr style="page-break-inside: avoid">
                                                <td><?php //echo $j+1; ?></td>
                                                <!-- <td></td> -->
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
												<td></td>
                                                <td></td>
                                                
                                            </tr>


                                        <?php //} ?>

											<tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              

												<th colspan="6" class="text-right" style="padding:2px">Total </th>
												<th colspan="5" class="text-right" style="padding:2px"><?php echo number_format((float)$total_amount, 2, '.', ''); ?></th>
											</tr>

                                            <?php
                                            
                                            function convertToIndianCurrency($number) {
                                                $no = round($number);
                                                $decimal = round($number - ($no = floor($number)), 2) * 100;    
                                                $digits_length = strlen($no);    
                                                $i = 0;
                                                $str = array();
                                                $words = array(
                                                    0 => '',
                                                    1 => 'One',
                                                    2 => 'Two',
                                                    3 => 'Three',
                                                    4 => 'Four',
                                                    5 => 'Five',
                                                    6 => 'Six',
                                                    7 => 'Seven',
                                                    8 => 'Eight',
                                                    9 => 'Nine',
                                                    10 => 'Ten',
                                                    11 => 'Eleven',
                                                    12 => 'Twelve',
                                                    13 => 'Thirteen',
                                                    14 => 'Fourteen',
                                                    15 => 'Fifteen',
                                                    16 => 'Sixteen',
                                                    17 => 'Seventeen',
                                                    18 => 'Eighteen',
                                                    19 => 'Nineteen',
                                                    20 => 'Twenty',
                                                    30 => 'Thirty',
                                                    40 => 'Forty',
                                                    50 => 'Fifty',
                                                    60 => 'Sixty',
                                                    70 => 'Seventy',
                                                    80 => 'Eighty',
                                                    90 => 'Ninety');
                                                $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                                                while ($i < $digits_length) {
                                                    $divider = ($i == 2) ? 10 : 100;
                                                    $number = floor($no % $divider);
                                                    $no = floor($no / $divider);
                                                    $i += $divider == 10 ? 1 : 2;
                                                    if ($number) {
                                                        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
                                                        $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
                                                    } else {
                                                        $str [] = null;
                                                    }  
                                                }
                                                
                                                $Rupees = implode(' ', array_reverse($str));
                                                $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
                                                return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
                                            }
                                                ?>

                                        <?php  
                                            $cgst_amount=number_format((float)$total_amount * ($row_customer['cgst'] / 100), 2, '.', '');
                                            $sgst_amount=number_format((float)$total_amount * ($row_customer['sgst'] / 100), 2, '.', '');
                                            $total_amount1=number_format((float)$total_amount, 2, '.', '');
                                            $total_amount_word=$total_amount1+$cgst_amount+$sgst_amount
                                            
                                        ?>

                                            
											<tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                                <th colspan="6">Amount in words: </th>
												<th  class="text-center" style="padding:2px">CGST</th>
												<th  class="text-right" style="padding:2px"><?php echo $row_customer['cgst']; ?>%</th>
                                                <th  class="text-right" style="padding:2px; text-align: right;"><?php echo $cgst_amount=number_format((float)$total_amount * ($row_customer['cgst'] / 100), 2, '.', '');?></th>

											</tr>
                                            
											<tr class="taxdiv" id="taxdiv0" >
                                                <td colspan="6"><b>Rupees :</b> <?php  echo convertToIndianCurrency($total_amount_word);?></td>

												<td  class="text-center" style="padding:2px">SGST</td>
												<td  class="text-right" style="padding:2px"><?php echo $row_customer['sgst']; ?>%</td>
                                                <td  class="text-right" style="padding:2px; text-align: right;"><?php echo $sgst_amount=number_format((float)$total_amount * ($row_customer['sgst'] / 100), 2, '.', '');?></td>

											</tr>
                                            <tr style="page-break-inside: avoid">
											<?php                           
											  $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
											  $resul = $conn->query($sql);  
											  $row = $resul->fetch_assoc();
											 ?>
                                                <td colspan="4" style="width: 50%"><b>Bank :</b> <?php echo $row['bank']; ?><br>
                                                <b>Branch :</b> <?php echo $row['branch']; ?><br>
                                                <b>A/C No :</b> <?php echo $row['acc_no']; ?><br>
                                                <b>Account Type :</b> <?php echo $row['acc_type']; ?><br>
                                                <b>IFSC  :</b> <?php echo $row['ifsc']; ?><br>
                                                <b>A/C Name  :</b> <?php echo $row['holder_name']; ?>
                                                    
                                                
                                                </td>
                                                <th ></th>
                                                <th ></th>
                                                <th ></th>
                                                <th  style="text-align:right"><br><br><br><br><br>Total</th>
                                                <th  style="text-align:right"><br><br><br><br><br><?php echo number_format((float)$total_amount+$cgst_amount+$sgst_amount, 2, '.', ''); ?></th>
                                                    
                                                </th>

                                        </tr>
																	
											
											
                                    </tbody>
                                    <tfoot >
										
										<tr style="page-break-inside: avoid">
										
											<td colspan="6" class="text-right">
											</td>
											
											<td colspan="6" style="text-align: center">
											<p style="margin-bottom: 0rem;font-size:15px"><b>FOR SMCUBE ENTERPRISES</b></p>
												<img src="images/no_image.png" style="width:130px;height:109px;text-align:center;object-fit:contain">
											<p style="text-align:center;font-size:15px">Authorizes Signatory</p>
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