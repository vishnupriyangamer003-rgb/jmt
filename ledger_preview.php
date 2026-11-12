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
        font-size: 14px!important;
    }
</style>
<?php include('sessionservices.php');?>
<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<!-- end::page loader -->

<?php echo isset($header) ? $header : ''; ?>

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
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right d-print-none" style="text-align: center!important;margin-top:0px">
                            <a href="javascript:window.print()" class="btn btn-success m-l-5 text-right" style="margin-top:0px;margin-right:15px;color: #fff"> <i class="fa fa-print m-r-5"></i> Print
                            </a>
                        </div>
                        <div class="watermark"><img src="images/sm_logo.jpeg" alt=""></div>

                    <style>
                        .report-footer{
                            position: fixed;
                            bottom: 0;
                            background:red;
                            display: block;
                        }
                    </style>

                    <div class="row" style="margin-top: 50px;">
                            
                            <?php
                                $customer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
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
                                        <h3 style="font-size: 22px;font-weight: 700;margin: 0;color: #000;">Ledger Report</h3>
                                    </div>
                                </div>  
                                <div class="row" style="border-top: 1px #00000030 solid">                            
                                    <div class="col-sm-4">
                                        <p style="margin-top: 3px;margin-bottom: 3px!important;float: left"><b>Phone :</b> 70314 12345, 70316 12345</p>
                                    </div>                      
                                    <div class="col-sm-4">
                                        <p style="margin-top: 3px;margin-bottom: 3px!important;text-align: center">
                                        </p>
                                    </div>                      
                                    <div class="col-sm-4">
                                        <p style="margin-top: 3px;margin-bottom: 3px!important;float: right"><b>Prop :</b> S. Sudarsan</p>
                                    </div>
                                </div>   
                            </div>
                            
                            <?php if($customer_id > 0): ?>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6" style="border: 1px #00000030 solid">                                              
                                        <p><b>Customer Detail :</b><br>
                                            <?php
                                            $sql_cus = "SELECT * FROM tbl_customer WHERE  customer_id='" . $customer_id . "'";
                                            $resul_cus = $conn->query($sql_cus);  
                                            $row_cus = $resul_cus->fetch_assoc();
                                            ?>
                                            <?php echo isset($row_cus['customer_name']) ? $row_cus['customer_name'] : ''; ?>,<br>
                                            <?php echo isset($row_cus['address']) ? nl2br($row_cus['address']) : ''; ?><br>
                                            <?php echo isset($row_cus['mblno']) ? $row_cus['mblno'] : ''; ?><br>
                                            <?php echo isset($row_cus['gst_no']) ? $row_cus['gst_no'] : ''; ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-6" style="border: 1px #00000030 solid">                                            
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table id='detailsgrid' class="table table-striped table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;text-align: center">Date</th>
                                            <th style="width: 35%;text-align: center">Description</th>
                                            <th style="width: 10%;text-align: center">DOC TYPE</th>
                                            <th style="width: 10%;text-align: center">Debit</th>
                                            <th style="width: 10%; text-align: center;">Credit</th>
                                            <th style="width: 10%; text-align: center;">Balance&nbsp;(INR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" style="text-align:right;font-size: 18px  !important;">Total:</th>
                                            <th style="text-align:center;color: red;font-size: 18px  !important;"></th>
                                            <th style="text-align:center;color: red;font-size: 18px  !important;"></th>
                                            <th style="text-align:center;color: red;font-size: 18px  !important;"></th>
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
   
    <?php include("footer.php") ?>

    <!-- begin::global scripts -->
    <script src="vendors/dataTable/jquery.dataTables.min.js"></script>
    <script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/dataTable/dataTables.responsive.min.js"></script>
    <script src="js/examples/datatable.js"></script>
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
$(document).ready(function(){
    var customerId = <?php echo isset($_GET['id']) ? intval($_GET['id']) : 0; ?>;
    
    $('#detailsgrid').DataTable({
        searching: false, 
        paging: false, 
        ordering: false,
        info: false,
        "ajax":{
            url: "ledger_grid.php",
            type: "post",
            data: {customer_id: customerId},
            error: function(xhr, status, error){
                console.log(JSON.stringify(xhr));
                console.log("Status: " + status);
                console.log("Error: " + error);
            }
        },
        footerCallback: function(row, data, start, end, display) {
            var api = this.api();

            var intVal = function(i) {
                if (typeof i === 'string') {
                    var cleanStr = i.replace(/<[^>]*>/g, '').replace(/,/g, '');
                    return parseFloat(cleanStr) || 0;
                } else if (typeof i === 'number') {
                    return i;
                } else {
                    return 0;
                }
            };

            var debitTotal = api.column(3).data().reduce(function(a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            var creditTotal = api.column(4).data().reduce(function(a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            var balanceData = api.column(5).data();
            var balanceTotal = (balanceData.length > 0) ? intVal(balanceData[balanceData.length - 1]) : 0;

            $(api.column(3).footer()).html(debitTotal.toLocaleString());
            $(api.column(4).footer()).html(creditTotal.toLocaleString());
            $(api.column(5).footer()).html(balanceTotal.toLocaleString());
        }
    });
});    
</script>

</html>