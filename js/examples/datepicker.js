'use strict';
$(document).ready(function () {

    $('input[name="single-date-picker"]').daterangepicker({
      
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

    $('input[name="simple-date-range-picker"]').daterangepicker();

    $('input[name="simple-date-range-picker-callback"]').daterangepicker({
        opens: 'left'
    }, function (start, end, label) {
        swal("A new date selection was made", start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'), "success")
    });

    // $('input[name="datetimes"]').daterangepicker({
    //     timePicker: true,
    //     startDate: moment().startOf('hour'),
    //     endDate: moment().startOf('hour').add(32, 'hour'),
    //     locale: {
    //         format: 'M/DD hh:mm A'
    //     }
    // });

    $('input[name="datetimes"]').daterangepicker({
		singleDatePicker: true,
		startDate: new Date(),
        timePicker: true,
        showDropdowns: true,
      //  startDate: moment().startOf('hour'),
       // endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'DD/MM/YYYY hh:mm A'
        }
    });

    /**
     * datefilter
     */
    var datefilter = $('input[name="datefilter"]');
    datefilter.daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    datefilter.on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input.create-event-datepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false
    }).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY'));
    });

});