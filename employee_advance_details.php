<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>
    <link rel="icon" type="image/png" href="userdata/images/favicon.png">
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include('sessionservices.php');?>
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>

<?php echo $header;?>

<main class="main-content">
    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Employee Advance</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Attendance & Salary</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Employee Advance</li>
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
                                    <label>Employee :</label><span style="color:red">*</span>
                                    <select class="form-control js-example-basic-single" id="emp_id" name="emp_id">
                                        <option value="">Select Employee</option>
                                        <?php
                                        $eq = mysqli_query($conn, "SELECT emp_id, emp_name FROM tbl_employee_details WHERE delete_status='NDL' ORDER BY emp_name ASC");
                                        while ($er = mysqli_fetch_array($eq)) {
                                            echo '<option value="'.$er['emp_id'].'">'.htmlspecialchars($er['emp_name']).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date :</label><span style="color:red">*</span>
                                    <input type="text" class="form-control" id="adv_date" name="adv_date" placeholder="DD/MM/YYYY" autocomplete="off" value="<?php echo date('d/m/Y'); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Amount :</label><span style="color:red">*</span>
                                    <input type="number" min="1" step="0.01" class="form-control" id="amount" name="amount" placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Payment Mode :</label>
                                    <select class="form-control" id="payment_mode" name="payment_mode">
                                        <option value="Cash">Cash</option>
                                        <option value="Bank">Bank</option>
                                        <option value="UPI">UPI</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Ref No :</label>
                                    <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Ref no.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remarks :</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="hidden" name="req" id="req">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:32px;">Save</button>
                                    <button type="reset" class="btn btn-danger" style="margin-top:32px;">Reset</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
                            </div>
                        </div>
                    </form>
                    <hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                    <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Advance</th>
                                <th>Adjusted</th>
                                <th>Outstanding</th>
                                <th>Mode / Ref</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("footer.php") ?>
<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<script src="vendors/datepicker/daterangepicker.js"></script>
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
</body>
<script>
$(document).ready(function(){
    $('input[name="adv_date"]').daterangepicker({ singleDatePicker: true, showDropdowns: true, locale: { format: 'DD/MM/YYYY' } });
    $('#detailsgrid').DataTable({
        "bProcessing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": { url: "employee_advance_grid.php", type: "post" }
    });
    $("#submit").click(function(e){
        e.preventDefault();
        if($("#emp_id").val()==''){ swal("Error!", "Select Employee !", "warning"); return false; }
        if($("#adv_date").val()==''){ swal("Error!", "Select Date !", "warning"); return false; }
        if($("#amount").val()=='' || parseFloat($("#amount").val())<=0){ swal("Error!", "Enter valid Amount !", "warning"); return false; }
        $("#req").val('ADDINS');
        $.ajax({
            type: "POST", url: "employee_advance_service.php", dataType: 'json',
            data: $("#mainform").serialize(),
            success: function(result){
                if(result.op==1){
                    swal("Success!", "Advance Saved !", "success");
                    $('#detailsgrid').DataTable().ajax.reload();
                    $("#mainform")[0].reset();
                } else { swal("Error!", result.op || "Save failed", "error"); }
            }
        });
    });
    $(document).on('click','.deleteTriger', function(){
        if(!confirm("Do you want to Delete ?")) return false;
        var delid=$(this).data('value');
        $.ajax({ type: "POST", url: "employee_advance_service.php", dataType: 'json',
            data: {delid: delid, req: "ADDDEL"},
            success: function(result){
                if(result.op==1){ swal("Success!", "Deleted !", "success"); $('#detailsgrid').DataTable().ajax.reload(); }
            }
        });
    });
    $(document).on('click','.eadjTriger', function(){
        var id=$(this).data('value');
        var cur=$(this).data('adj');
        var val=prompt("Adjusted amount (against salary):", cur);
        if(val===null) return false;
        $.ajax({ type: "POST", url: "employee_advance_service.php", dataType: 'json',
            data: {id: id, adjusted_amount: val, req: "ADJUPD"},
            success: function(result){
                if(result.op==1){ swal("Success!", "Adjusted !", "success"); $('#detailsgrid').DataTable().ajax.reload(); }
                else { swal("Error!", result.op || "Update failed", "error"); }
            }
        });
    });
});
</script>
</html>
