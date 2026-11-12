<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Services)</title>
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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jszip-2.5.0,dt-1.10.9,b-1.0.3,b-flash-1.0.3,b-html5-1.0.3/datatables.min.css" />

    <!-- Custom Week Picker CSS -->
    <style>
        .week-picker-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .week-picker-input-wrapper {
            position: relative;
        }
        .week-picker-input {
            cursor: pointer;
            background-color: #fff !important;
        }
        .week-picker-input-wrapper .calendar-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            pointer-events: none;
        }
        .week-picker-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1050;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 6px 12px rgba(0,0,0,.175);
            padding: 15px;
            min-width: 320px;
            margin-top: 2px;
        }
        .week-picker-dropdown.show {
            display: block;
        }
        .week-picker-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding: 0 5px;
        }
        .week-picker-header .month-year {
            font-weight: bold;
            font-size: 16px;
            cursor: default;
        }
        .week-picker-header .nav-btn {
            cursor: pointer;
            padding: 4px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f8f9fa;
            font-size: 14px;
            transition: all 0.2s;
        }
        .week-picker-header .nav-btn:hover {
            background: #e9ecef;
        }
        .week-picker-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .week-picker-grid th {
            font-weight: bold;
            font-size: 12px;
            color: #666;
            padding: 6px 4px;
            text-align: center;
            border-bottom: 2px solid #dee2e6;
        }
        .week-picker-grid td {
            text-align: center;
            padding: 6px 4px;
            font-size: 13px;
            border: 1px solid #f0f0f0;
            transition: all 0.15s;
        }
        .week-picker-grid td.week-number {
            font-weight: bold;
            color: #888;
            background: #f8f9fa;
            cursor: default;
            border-right: 2px solid #dee2e6;
            font-size: 11px;
        }
        .week-picker-grid td.other-month {
            color: #ccc;
            background: #fafafa;
            cursor: default;
        }
        .week-picker-grid td.today {
            font-weight: bold;
            color: #007bff;
            background: #e8f4fd;
        }
        .week-picker-grid td.week-hover {
            background-color: #e3f2fd !important;
            cursor: pointer;
        }
        .week-picker-grid td.selected-start {
            background-color: #007bff !important;
            color: #fff !important;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            font-weight: bold;
        }
        .week-picker-grid td.selected-middle {
            background-color: #cce5ff !important;
            color: #004085 !important;
        }
        .week-picker-grid td.selected-end {
            background-color: #007bff !important;
            color: #fff !important;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            font-weight: bold;
        }
        .week-picker-footer {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .week-picker-footer .week-range {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }
        .week-picker-footer .btn-sm {
            padding: 3px 8px;
            font-size: 12px;
        }
        .week-picker-input-wrapper input {
            padding-right: 35px;
        }
        .week-picker-grid td.selectable {
            cursor: pointer;
        }
        .no-wrap {
            word-break: break-all;
        }
    </style>

</head>
<body>
    <?php include('sessionservices.php'); ?>
    <!-- begin::page loader-->
    <div class="page-loader">
        <div class="spinner-border"></div>
        <span>Loading ...</span>
    </div>
    <!-- end::page loader -->

    <?php echo $header; ?>

    <!-- begin::main content -->
    <main class="main-content">

        <div class="container-fluid">
            <div class="page-header d-md-flex justify-content-between align-items-center">
                <h4>Services Non-GST - Current Week Report Details</h4>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="alllist-tab" href="services_customer_all_report.php" role="tab"
                   aria-controls="allist" aria-selected="false"><b>All</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="paidlist-tab" href="services_customer_ledger_paid_report.php" role="tab"
                   aria-controls="paidlist" aria-selected="true"><b>Current Week</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pendinglist-tab" href="services_customer_ledger_pending_report.php" role="tab"
                   aria-controls="pendinglist" aria-selected="false"><b>Pending</b></a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent" style="border-style:solid;border-color:#dee2e6;border-width:0 1px 1px 1px;padding:15px;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;">
            <div class="tab-pane fade show active" id="paidlist" role="tabpanel" aria-labelledby="paidlist-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <form id="mainform" method="POST" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Select Week :</label>
                                                <div class="week-picker-container">
                                                    <div class="week-picker-input-wrapper">
                                                        <input type="text" class="form-control week-picker-input" 
                                                               id="week_ww_yyyy" name="week_ww_yyyy" 
                                                               placeholder="Select Week (Sun-Sat)" readonly
                                                               autocomplete="off">
                                                        <i class="fa fa-calendar calendar-icon"></i>
                                                    </div>
                                                    <div class="week-picker-dropdown" id="weekPickerDropdown">
                                                        <div class="week-picker-header">
                                                            <span class="nav-btn" id="prevMonth"><i class="fa fa-chevron-left"></i></span>
                                                            <span class="month-year" id="displayMonthYear"></span>
                                                            <span class="nav-btn" id="nextMonth"><i class="fa fa-chevron-right"></i></span>
                                                        </div>
                                                        <table class="week-picker-grid" id="weekPickerGrid">
                                                            <thead>
                                                                <tr>
                                                                    <th>Week</th>
                                                                    <th>Su</th>
                                                                    <th>Mo</th>
                                                                    <th>Tu</th>
                                                                    <th>We</th>
                                                                    <th>Th</th>
                                                                    <th>Fr</th>
                                                                    <th>Sa</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="weekPickerBody">
                                                                <!-- Generated by JavaScript -->
                                                            </tbody>
                                                        </table>
                                                        <div class="week-picker-footer">
                                                            <span class="week-range" id="selectedWeekRange">Select a week</span>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-secondary btn-sm" id="clearWeek">Clear</button>
                                                                <button type="button" class="btn btn-primary btn-sm" id="thisWeek">This week</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="submit" id="search" class="btn btn-success" style="margin-top:32px;">Search</button>
                                        </div>
                                    </div>
                                    <span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
                                </form>

                                <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Paid&nbsp;Amount</th>
                                            <th>Balance&nbsp;Amount</th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <input type="hidden" name="modulenamebox" id="modulenamebox" value="14">
    <input type="hidden" name="rightsbox" id="rightsbox">

    <?php include("footer.php"); ?>

    <!-- begin::global scripts -->
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

    <!-- begin::vmap -->
    <script src="vendors/vmap/jquery.vmap.min.js"></script>
    <script src="vendors/vmap/maps/jquery.vmap.usa.js"></script>
    <script src="js/examples/vmap.js"></script>
    <!-- end::vmap -->

    <!-- begin::custom scripts -->
    <script src="js/custom.js"></script>
    <script src="js/app.min.js"></script>
    <!-- end::custom scripts -->

    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script> 

</body>

<script>
$(document).ready(function(){
    // =============================================
    // CUSTOM WEEK PICKER IMPLEMENTATION (SUN - SAT)
    // =============================================
    var WeekPicker = {
        currentDate: new Date(),
        selectedWeekStart: null,
        selectedWeekEnd: null,
        selectedWeekNumber: null,
        selectedYear: null,
        hoverWeekStart: null,
        hoverWeekEnd: null,
        
        init: function() {
            var now = new Date();
            var currentDay = now.getDay(); // 0=Sunday
            var diff = now.getDate() - currentDay;
            var sunday = new Date(now);
            sunday.setDate(diff);
            sunday.setHours(0, 0, 0, 0);
            
            this.selectedWeekStart = new Date(sunday);
            this.selectedWeekEnd = new Date(sunday);
            this.selectedWeekEnd.setDate(this.selectedWeekEnd.getDate() + 6);
            this.selectedWeekNumber = this.getWeekNumber(sunday);
            this.selectedYear = sunday.getFullYear();
            
            this.updateDisplay();
            this.renderCalendar(this.currentDate);
            
            var self = this;
            
            $('.week-picker-input').on('click', function(e) {
                e.stopPropagation();
                $('#weekPickerDropdown').toggleClass('show');
                self.renderCalendar(self.currentDate);
            });
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.week-picker-container').length) {
                    $('#weekPickerDropdown').removeClass('show');
                }
            });
            
            $('#prevMonth').on('click', function(e) {
                e.stopPropagation();
                self.currentDate.setMonth(self.currentDate.getMonth() - 1);
                self.renderCalendar(self.currentDate);
            });
            
            $('#nextMonth').on('click', function(e) {
                e.stopPropagation();
                self.currentDate.setMonth(self.currentDate.getMonth() + 1);
                self.renderCalendar(self.currentDate);
            });
            
            $('#clearWeek').on('click', function(e) {
                e.stopPropagation();
                self.selectedWeekStart = null;
                self.selectedWeekEnd = null;
                self.selectedWeekNumber = null;
                self.selectedYear = null;
                $('.week-picker-input').val('');
                $('#selectedWeekRange').text('Select a week');
                $('#weekPickerDropdown').removeClass('show');
                $('#week_ww_yyyy_hidden').remove();
            });
            
            $('#thisWeek').on('click', function(e) {
                e.stopPropagation();
                var now = new Date();
                var currentDay = now.getDay();
                var diff = now.getDate() - currentDay;
                var sunday = new Date(now);
                sunday.setDate(diff);
                sunday.setHours(0, 0, 0, 0);
                
                self.selectedWeekStart = new Date(sunday);
                self.selectedWeekEnd = new Date(sunday);
                self.selectedWeekEnd.setDate(self.selectedWeekEnd.getDate() + 6);
                self.selectedWeekNumber = self.getWeekNumber(sunday);
                self.selectedYear = sunday.getFullYear();
                
                self.updateDisplay();
                self.renderCalendar(self.currentDate);
                $('#weekPickerDropdown').removeClass('show');
            });
            
            $("#search").click(function(e) {
                e.preventDefault();
                self.onSearch();
            });
        },
        
        getWeekNumber: function(date) {
            var d = new Date(date);
            d.setHours(0, 0, 0, 0);
            d.setDate(d.getDate() + 3 - (d.getDay() + 6) % 7);
            var week1 = new Date(d.getFullYear(), 0, 4);
            return 1 + Math.round(((d - week1) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
        },
        
        formatDisplay: function(date) {
            var d = date.getDate();
            var m = date.getMonth() + 1;
            var y = date.getFullYear();
            return (d < 10 ? '0' : '') + d + '/' + (m < 10 ? '0' : '') + m + '/' + y;
        },
        
        formatDateForSql: function(date) {
            var d = date.getDate();
            var m = date.getMonth() + 1;
            var y = date.getFullYear();
            return y + '-' + (m < 10 ? '0' : '') + m + '-' + (d < 10 ? '0' : '') + d;
        },
        
        updateDisplay: function() {
            if (this.selectedWeekStart && this.selectedWeekEnd) {
                var startStr = this.formatDisplay(this.selectedWeekStart);
                var endStr = this.formatDisplay(this.selectedWeekEnd);
                var weekStr = 'W' + String(this.selectedWeekNumber).padStart(2, '0');
                $('.week-picker-input').val(weekStr + ' - ' + startStr + ' to ' + endStr);
                $('#selectedWeekRange').text('Week ' + weekStr + ': ' + startStr + ' - ' + endStr);
                
                $('#week_ww_yyyy_hidden').remove();
                var hiddenInput = $('<input>').attr('type', 'hidden')
                                              .attr('name', 'week_ww_yyyy')
                                              .attr('id', 'week_ww_yyyy_hidden')
                                              .val(this.selectedYear + '-W' + String(this.selectedWeekNumber).padStart(2, '0'));
                $('#mainform').append(hiddenInput);
            }
        },
        
        renderCalendar: function(date) {
            var year = date.getFullYear();
            var month = date.getMonth();
            
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                            'July', 'August', 'September', 'October', 'November', 'December'];
            $('#displayMonthYear').text(monthNames[month] + ' ' + year);
            
            var firstDay = new Date(year, month, 1).getDay();
            var daysInMonth = new Date(year, month + 1, 0).getDate();
            var daysInPrevMonth = new Date(year, month, 0).getDate();
            
            var today = new Date();
            var todayDate = today.getDate();
            var todayMonth = today.getMonth();
            var todayYear = today.getFullYear();
            
            var body = $('#weekPickerBody');
            body.empty();
            
            var totalDays = daysInMonth + firstDay;
            var rows = Math.ceil(totalDays / 7);
            if (rows < 6) rows = 6;
            
            for (var row = 0; row < rows; row++) {
                var tr = $('<tr></tr>');
                
                var weekNumTd = $('<td class="week-number"></td>');
                var weekDate = new Date(year, month, (row * 7) + 1 - firstDay);
                var weekNum = this.getWeekNumber(weekDate);
                weekNumTd.text(weekNum);
                tr.append(weekNumTd);
                
                for (var col = 0; col < 7; col++) {
                    var dayIndex = (row * 7) + col;
                    var dayNumber = dayIndex - firstDay + 1;
                    
                    var td = $('<td></td>');
                    
                    if (dayNumber < 1) {
                        var prevMonthDay = daysInPrevMonth + dayNumber;
                        td.text(prevMonthDay);
                        td.addClass('other-month');
                    } else if (dayNumber > daysInMonth) {
                        var nextMonthDay = dayNumber - daysInMonth;
                        td.text(nextMonthDay);
                        td.addClass('other-month');
                    } else {
                        td.text(dayNumber);
                        td.addClass('selectable');
                        
                        var cellDate = new Date(year, month, dayNumber);
                        
                        if (dayNumber === todayDate && month === todayMonth && year === todayYear) {
                            td.addClass('today');
                        }
                        
                        if (this.selectedWeekStart) {
                            var cellTime = cellDate.getTime();
                            var weekStartTime = this.selectedWeekStart.getTime();
                            var weekEndTime = this.selectedWeekEnd.getTime();
                            
                            if (cellTime >= weekStartTime && cellTime <= weekEndTime) {
                                if (cellTime === weekStartTime) {
                                    td.addClass('selected-start');
                                } else if (cellTime === weekEndTime) {
                                    td.addClass('selected-end');
                                } else {
                                    td.addClass('selected-middle');
                                }
                            }
                        }
                        
                        (function(cDate, cTd, self) {
                            cTd.on('mouseenter', function() {
                                var clickedDay = cDate.getDay();
                                var weekStart = new Date(cDate);
                                weekStart.setDate(cDate.getDate() - clickedDay);
                                weekStart.setHours(0, 0, 0, 0);
                                
                                var weekEnd = new Date(weekStart);
                                weekEnd.setDate(weekStart.getDate() + 6);
                                weekEnd.setHours(0, 0, 0, 0);
                                
                                self.hoverWeekStart = weekStart;
                                self.hoverWeekEnd = weekEnd;
                                
                                $('.week-picker-grid td.selectable').each(function() {
                                    var $this = $(this);
                                    var tdDate = new Date(year, month, parseInt($this.text()));
                                    var tdTime = tdDate.getTime();
                                    if (tdTime >= weekStart.getTime() && tdTime <= weekEnd.getTime()) {
                                        if (!$this.hasClass('selected-start') && 
                                            !$this.hasClass('selected-middle') && 
                                            !$this.hasClass('selected-end')) {
                                            $this.addClass('week-hover');
                                        }
                                    }
                                });
                            });
                            
                            cTd.on('mouseleave', function() {
                                $('.week-picker-grid td.selectable').removeClass('week-hover');
                            });
                        })(cellDate, td, this);
                        
                        (function(cDate, cTd, self) {
                            cTd.on('click', function(e) {
                                e.stopPropagation();
                                if (cTd.hasClass('other-month')) return;
                                
                                var clickedDay = cDate.getDay();
                                var weekStart = new Date(cDate);
                                weekStart.setDate(cDate.getDate() - clickedDay);
                                weekStart.setHours(0, 0, 0, 0);
                                
                                var weekEnd = new Date(weekStart);
                                weekEnd.setDate(weekStart.getDate() + 6);
                                weekEnd.setHours(0, 0, 0, 0);
                                
                                if (self.selectedWeekStart && 
                                    weekStart.getTime() === self.selectedWeekStart.getTime()) {
                                    return;
                                }
                                
                                self.selectedWeekStart = new Date(weekStart);
                                self.selectedWeekEnd = new Date(weekEnd);
                                self.selectedWeekNumber = self.getWeekNumber(weekStart);
                                self.selectedYear = weekStart.getFullYear();
                                
                                self.updateDisplay();
                                self.renderCalendar(self.currentDate);
                                $('#weekPickerDropdown').removeClass('show');
                            });
                        })(cellDate, td, this);
                    }
                    
                    tr.append(td);
                }
                
                body.append(tr);
            }
        },
        
        onSearch: function() {
            if (!this.selectedWeekStart) {
                alert('Please select a week first!');
                return;
            }
            
            var weekValue = this.selectedYear + '-W' + String(this.selectedWeekNumber).padStart(2, '0');
            var weekSunday = this.formatDateForSql(this.selectedWeekStart);
            var weekSaturday = this.formatDateForSql(this.selectedWeekEnd);
            
            $("#msg").css("color", "green").html("Processing . . .");
            
            $("#detailsgrid").dataTable().fnDestroy();
            $('#detailsgrid').DataTable({
                dom: 'Blfript',
                buttons: [
                    {
                        extend: 'excel',
                        footer: true,
                        title: 'Services Non-GST - Current Week Report',
                        filename: 'Services_Current_Week_Report',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        text: 'Print',
                        title: 'Services Non-GST - Current Week Report',
                        autoPrint: true,
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ],
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "pageLength": 25,
                "bProcessing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": {
                    url: "services_customer_ledger_paid_grid.php",
                    type: "post",
                    data: { 
                        cond: "searchbind", 
                        week_ww_yyyy: weekValue,
                        week_sunday: weekSunday,
                        week_saturday: weekSaturday
                    },
                    error: function(xhr, status, error) {
                        console.log(JSON.stringify(xhr, status, error));
                        $("#msg").css("color", "red").html("Error loading data!");
                    },
                    complete: function() {
                        $("#msg").html('');
                    }
                }
            });
            
            setTimeout(function() {
                $(".dataTables_wrapper").addClass('row');
                $(".dataTables_length").addClass('col-md-6 col-xs-12').css('margin-top', '50px');
                $(".dataTables_filter").addClass('col-md-6 col-xs-12').css('margin-top', '50px');
                $(".buttons-html5").addClass('btn btn-success');
                $(".dt-button").addClass('btn btn-success');
                $(".dt-buttons").css('position', 'absolute').css('left', '20px');
            }, 100);
        }
    };

    $(document).on('click', '.trtag', function () {
        $("#trtag" + $(this).data('value')).remove();
        return false;
    });
    
    if ('<?php echo $log;?>' != "admin") {
        $.ajax({
            type: "POST",
            url: "phpservices/employee_rights.php",
            dataType: 'JSON',
            data: {empid: <?php echo $login_id;?>, moduleid: $("#modulenamebox").val()},
            success: function(result) {
                $("#rightsbox").val(result.rights);
            }
        });
    }

    WeekPicker.init();

    // Initial table load for current week
    var initialSunday = WeekPicker.selectedWeekStart ? WeekPicker.formatDateForSql(WeekPicker.selectedWeekStart) : '';
    var initialSaturday = WeekPicker.selectedWeekEnd ? WeekPicker.formatDateForSql(WeekPicker.selectedWeekEnd) : '';
    var initialWeek = WeekPicker.selectedWeekStart ? (WeekPicker.selectedYear + '-W' + String(WeekPicker.selectedWeekNumber).padStart(2, '0')) : '';

    $('#detailsgrid').DataTable({
        dom: 'Blfript',
        buttons: [
            {
                extend: 'excel',
                footer: true, 
                className: 'green glyphicon glyphicon-list-alt',
                title: 'Services Non-GST - Current Week Report',
                filename: 'Services_Current_Week_Report',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                footer: true,
                className: 'green glyphicon glyphicon-print',
                text: 'Print',
                title: 'Services Non-GST - Current Week Report',
                autoPrint: true,
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 25,
        "bProcessing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            url: "services_customer_ledger_paid_grid.php",
            type: "post",
            data: {
                receipt_type: "receipt",
                week_ww_yyyy: initialWeek,
                week_sunday: initialSunday,
                week_saturday: initialSaturday
            },
            error: function(xhr, status, error) {
                console.log(JSON.stringify(xhr, status, error));
            }
        }
    });

    $(".dataTables_wrapper").addClass('row');
    $(".dataTables_length").addClass('col-md-6 col-xs-12').css('margin-top', '50px');
    $(".dataTables_filter").addClass('col-md-6 col-xs-12').css('margin-top', '50px');
    $(".buttons-html5").addClass('btn btn-success');
    $(".dt-button").addClass('btn btn-success');
    $(".dt-buttons").css('position', 'absolute').css('left', '20px');
});
</script>
</html>
