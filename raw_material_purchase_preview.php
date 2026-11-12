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

            /*$sql="SELECT *,a.purchase_id,a.dc_no,a.total_amount,a.grand_total_amount,d.supplier_id,d.supplier_name,e.uom_id,e.uom_name,group_concat(b.raw_material_id SEPARATOR ',<br/>') as raw_material_id,group_concat(b.hsn_code SEPARATOR ',<br/>') as hsn_code,group_concat(b.purchase_rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_raw_purchase  a 
            inner join tbl_raw_purchase_details b on a.purchase_id=b.purchase_id 
            left join  tbl_uom e on e.uom_id=b.uom_id 
            left join  tbl_supplier d on d.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' and a.purchase_id='".$_GET['id']."'";
            $exec_sql=mysqli_query($conn,$sql);
            $fetch_sql=mysqli_fetch_array($exec_sql);*/

            $purchase_id = $_GET['id'];
            $sql_supplier = "SELECT *,a.dc_no,date_format(a.billing_date,'%d/%m/%Y') as billing_date,d.supplier_id,d.supplier_name,d.company_name,d.gst_no,d.address FROM tbl_raw_purchase  a  
            left join  tbl_supplier d on d.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and  d.delete_status!='0' and a.purchase_id='$purchase_id'";
            $query_supplier = mysqli_query($conn, $sql_supplier);
            $row_supplier = mysqli_fetch_array($query_supplier);

            
            $billing_no=$row_supplier['dc_no'];
            $billing_date=$row_supplier['billing_date'];
            $supplier_name=$row_supplier['supplier_name'];
            $supplier_company=$row_supplier['company_name'];
            $supplier_address=$row_supplier['address'];
            $supplier_gst_no=$row_supplier['gst_no'];
            $cgst=$row_supplier['cgst'];
            $sgst=$row_supplier['sgst'];

            $total_gst_rate=$row_supplier['tax_amount'];
            $grand_total_amount=$row_supplier['grand_total_amount'];



            

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
                                        <h3 style="font-size: 22px;font-weight: 700;margin: 0;color: #000;">RAW MATERIAL PURCHASE INVOICE</h3>
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
                                    <br>
                                            
                                            <p class="onepage_p"><b>Supplier :</b> <br>
                                                <?php if(!empty($supplier_name)){ ?>
                                                <?php echo $supplier_name; ?><br>
                                                <?php } ?>
                                                <?php if(!empty($supplier_company)){ ?>
                                                <?php echo $supplier_company; ?><br>
                                                <?php } ?>                                                
                                                <?php if(!empty($supplier_address)){ ?>
                                                <?php echo $supplier_address; ?>
                                                <?php } ?><br>
                                                <?php if(!empty($supplier_gst_no)){ ?> 
                                                GST No : <?php echo $supplier_gst_no ?>
                                                <?php } ?>
                                            </p>
                                        </div>
                                        <div class="col-sm-6" style="border: 1px #00000030 solid"> 
                                            
                                           <br>
                                           <p>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Invoice No&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 20px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_no ?></span>

                                                </br>

                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 20px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_date ?></span>
                                            </p>  
                                            
                                        </div>
                                        
                                    </div>
                                </div>

                                
                                <table  class="table table-striped table-bordered" width="100%"  style="border: none;">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%">Name</th>
                                            <th style="width: 15%">HSN Code</th>
                                            <th style="width: 10%">UOM</th>
                                            <th style="width: 10%">SUB UOM</th>	
                                            <th style="width: 10%">GST(%)</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 15%">Rate Incl. of Tax</th>
                                            <th style="width: 15%">Purchase Price</th>
                                            <th style="width: 15%">Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                            $sql="SELECT b.*,s.sub_uom_name,e.uom_name,a.total_amount,a.grand_total_amount FROM tbl_raw_purchase  a 
                                            inner join tbl_raw_purchase_details b on a.purchase_id=b.purchase_id 
                                            left join  tbl_uom e on e.uom_id=b.uom_id 
                                            left join  tbl_sub_uom s on s.sub_uom_id=b.sub_uom_id 
                                            left join  tbl_supplier d on d.supplier_id=a.supplier_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' and b.purchase_id='".$_GET['id']."'";
                                            $query=mysqli_query($conn,$sql);
                                            
                                            $j=0;
                                            $total_amount=0;
                                            $total_qty=0;
                                            $total_purchase_rate=0;
                                            
                                        while ($fetch_booking_details = mysqli_fetch_array($query)) {
                                            
                                            $total_amount=$total_amount+$fetch_booking_details['rate_tax'];  
                                            $total_qty=$total_qty+$fetch_booking_details['qty']; 
                                            $total_purchase_rate=$total_purchase_rate+$fetch_booking_details['purchase_rate'];  
                                           
                                            
                                            $gql3 = "SELECT * FROM tbl_raw_material  where delete_status='NDL' and id='".$fetch_booking_details['raw_material_id']."' ";
											$exec_gql3 = mysqli_query($conn, $gql3);			
											$fetch_gql3 = mysqli_fetch_array($exec_gql3);

                                            
                                        ?>


                                            <tr style="page-break-inside: avoid">
                                                
                                                <td class="text-center"><?php echo $fetch_gql3["name"]; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['hsn_code']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['uom_name']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['sub_uom_name']; ?></td>
                                                <td class="text-center"><?php echo $fetch_booking_details['gst']; ?></td>                                           
                                                
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:red; font-weight: bold"><?php echo $fetch_booking_details['qty']; ?></td>
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:green; font-weight: bold"><?php echo number_format((float)$fetch_booking_details['rate_tax'], 2, '.', ''); ?></td>
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:green; font-weight: bold"><?php echo number_format((float)$fetch_booking_details['rate'], 2, '.', ''); ?></td>
                                                <td class="text-center"  style="font-size: 15px; text-align: right; width: 15%;  color:green; font-weight: bold"><?php echo number_format((float) $fetch_booking_details['purchase_rate'], 2, '.', ''); ?></td>
                                                
                                                
                                                
                                            </tr>

                                        <?php

                                            $j++;

                                            
                                        } ?>

                                        <?php

                                        $i = 7 - $j;
                                        for ($z = $j; $z < 7; $z++) { ?>

                                        <tr style="page-break-inside: avoid">
                                            
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            
                                        </tr>


                                        <?php } ?>

											<tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              

                                                <th colspan="4" ></th>
												<th class="text-right" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold">Total Amt : </th>
                                                <th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"><?php echo $total_qty; ?> </th>
												<th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"></th>
                                                <th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"></th>
                                                <th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"><?php echo number_format((float)$total_purchase_rate, 2, '.', ''); ?></th>
											</tr>

                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              

                                                <th colspan="4" ></th>
												<th class="text-right" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold">GST Tot Amt : </th>
                                                <th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"></th>
												<th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"></th>
                                                <th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"></th>
                                                <th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"><?php echo number_format((float)$total_gst_rate, 2, '.', ''); ?></th>
											</tr>

                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              

                                                <th colspan="4" ></th>
												<th colspan="3" class="text-right" style="padding:2px; font-size: 20px;  width: 15%;  color:red; font-weight: bold">Grand Tot Amt: </th>
                                                
												<th  class="text-center" style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold"></th>
                                                <th  class="text-center" style="padding:2px; font-size: 20px;  width: 15%;  color:red; font-weight: bold"><?php echo number_format((float)$grand_total_amount, 2, '.', ''); ?></th>
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
                                           
                                            $total_amount1=number_format((float)$grand_total_amount, 2, '.', '');
                                            $total_amount_word=$total_amount1;
                                            
                                        ?>

                                            
											<tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                                <th colspan="9" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Amount in words: </th>
												

											</tr>
                                            
											<tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                                <td colspan="9" style="font-size: 15px; width: 15%;  color:black; font-weight: bold"><?php  echo convertToIndianCurrency($total_amount_word);?></td>

												

											</tr>
                                            <!--tr style="page-break-inside: avoid">
											<?php                           
											  $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
											  $resul = $conn->query($sql);  
											  $row = $resul->fetch_assoc();
											 ?>
                                                <td colspan="5" style="width: 50%"><b>Bank :</b> <?php echo $row['bank']; ?><br>
                                                <b>Branch :</b> <?php echo $row['branch']; ?><br>
                                                <b>A/C No :</b> <?php echo $row['acc_no']; ?><br>
                                                <b>Account Type :</b> <?php echo $row['acc_type']; ?><br>
                                                <b>IFSC  :</b> <?php echo $row['ifsc']; ?><br>
                                                <b>A/C Name  :</b> <?php echo $row['holder_name']; ?>
                                                    
                                                
                                                </td>
                                                <th></th>
                                                
                                                <th class="text-center" style="padding:2px; font-size: 20px;  width: 15%;  color:red; font-weight: bold"><br><br><br><br><br>Grand Total</th>
                                                <th  class="text-center" colspan="2" style="padding:2px; font-size: 20px;  width: 15%;  color:red; font-weight: bold"><br><br><br><br><br><?php echo number_format((float)$total_purchase_rate, 2, '.', ''); ?></th>
                                                    
                                                </th>

                                        </tr-->
																	
											
											
                                    </tbody>
                                    <tfoot >
										
										<tr style="page-break-inside: avoid">
										
											<td colspan="5" class="text-right">
											</td>
											
											<td colspan="4" style="text-align: center">
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