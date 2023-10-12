
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('fast');
    }, 4000);
    $('.loading').hide();
    $('input:checkbox').removeAttr('checked');
    try {
        CKEDITOR.replace('privacy_text');

    } catch (err) {
    }
    try {
        CKEDITOR.replace('term_text');

    } catch (err) {
    }

    try {
        CKEDITOR.replace('p_content');

    } catch (err) {
    }

    try {
        CKEDITOR.replace('news_text');

    } catch (err) {
    }
    var url = window.location.href;
    if (url.includes("data-tempuser")) {
        scrollToCustomerForm();
    }

    $("form").submit(function () {
        if ($(this).valid()) {
            $('.loading').show();//go ahead
        }
    });
//    $("form").submit(function (event) {
//        $('.loading').show();
//    });
    populateFromYear();
    $('.yearto').hide();
    $('#customers').attr('disabled', true);
    $('.selcAttr').hide();
    $('#addcust').hide();
    $('.custDetail').hide();
    $('#exb_date').datepicker({
        minDate: 0,
        dateFormat: 'dd-mm-yy'
    })
    //$('.datepicker').datepicker();
    if ("undefined" != typeof $.fn.daterangepicker) {
        console.log("init_daterangepicker2");
        var a = function (a, b, c) {
            console.log(a.toISOString(), b.toISOString(), c), $("#reportrange1 span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY"))
        },
                b = {
                    startDate: moment().subtract(29, "days"),
                    endDate: moment(),
                    dateLimit: {
                        days: 180
                    },
                    showDropdowns: !0,
                    showWeekNumbers: !0,
                    timePicker: !1,
                    timePickerIncrement: 1,
                    timePicker12Hour: !0,
                    ranges: {
                        // Today: [moment(), moment()],
                        // Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                        // "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        // "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        // "This Month": [moment().startOf("month"), moment().endOf("month")],
                        // "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                    },
                    opens: "left",
                    buttonClasses: ["btn btn-default"],
                    applyClass: "btn-small btn-primary",
                    cancelClass: "btn-small",
                    format: "MM/DD/YYYY",
                    separator: " to ",
                    locale: {
                        applyLabel: "Submit",
                        cancelLabel: "Clear",
                        fromLabel: "From",
                        toLabel: "To",
                        customRangeLabel: "Custom",
                        daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                        monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        firstDay: 1
                    }
                };
        var range = '';
        var firstday = '';
        var lastday = '';
        //console.log($('#req_date_range').val());
        if ($('#req_date_range').val() != undefined && $('#req_date_range').val() != '') {
            range = $('#req_date_range').val().split('and');
            firstday = moment(range[0]).format("MMMM D, YYYY");
            lastday = moment(range[1]).format("MMMM D, YYYY");
        } else {
            firstday = moment().subtract(29, "days").format("MMMM D, YYYY");
            lastday = moment().format("MMMM D, YYYY");
        }
        $("#reportrange1 span").html(
                firstday + " - " + lastday),
                $("#reportrange1").daterangepicker(b, a), $("#reportrange1").on("show.daterangepicker", function () {
            console.log("show event fired")
        }), $("#reportrange1").on("hide.daterangepicker", function () {
            console.log("hide event fired")
        }), $("#reportrange1").on("apply.daterangepicker", function (a, b) {

            $('#req_date_range').val(b.startDate.format("YYYY-MM-DD") + 'and' + b.endDate.format("YYYY-MM-DD"));
            console.log("apply event fired, start/end dates are " + b.startDate.format("YYYY-MM-DD") + " to " + b.endDate.format("YYYY-MM-DD"));
        }), $("#reportrange").on("cancel.daterangepicker", function (a, b) {
            console.log("cancel event fired")
        }), $("#options1").click(function () {
            $("#reportrange").data("daterangepicker").setOptions(b, a)
        }), $("#options2").click(function () {
            $("#reportrange").data("daterangepicker").setOptions(optionSet2, a)
        }), $("#destroy").click(function () {
            $("#reportrange").data("daterangepicker").remove()
        })
    }

    if ("undefined" != typeof $.fn.daterangepicker) {
        var a = function (a, b, c) {
            console.log(a.toISOString(), b.toISOString(), c), $("#reportrange2 span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY"))
        },
                b = {
                    startDate: moment(),
                    endDate: moment().add(30, "days"),
                    dateLimit: {
                        days: 180
                    },
                    showDropdowns: !0,
                    showWeekNumbers: !0,
                    timePicker: !1,
                    timePickerIncrement: 1,
                    timePicker12Hour: !0,
                    ranges: {
                        // Today: [moment(), moment()],
                        // Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                        // "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        // "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        // "This Month": [moment().startOf("month"), moment().endOf("month")],
                        // "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                    },
                    opens: "left",
                    buttonClasses: ["btn btn-default"],
                    applyClass: "btn-small btn-primary",
                    cancelClass: "btn-small",
                    format: "MM/DD/YYYY",
                    separator: " to ",
                    locale: {
                        applyLabel: "Submit",
                        cancelLabel: "Clear",
                        fromLabel: "From",
                        toLabel: "To",
                        customRangeLabel: "Custom",
                        daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                        monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        firstDay: 1
                    }
                };
        var range = '';
        var firstday = '';
        var lastday = '';
        //console.log($('#req_date_range').val());
        if ($('#dis_date_range').val() != undefined && $('#dis_date_range').val() != '') {
            range = $('#req_date_range').val().split('and');
            firstday = moment(range[0]).format("MMMM D, YYYY");
            lastday = moment(range[1]).format("MMMM D, YYYY");
        } else {
            firstday = moment().format("MMMM D, YYYY");
            lastday = moment().add(29, "days").format("MMMM D, YYYY");
        }
        $("#reportrange2 span").html(
                firstday + " - " + lastday),
                $("#reportrange2").daterangepicker(b, a), $("#reportrange2").on("show.daterangepicker", function () {
            console.log("show event fired")
        }), $("#reportrange2").on("hide.daterangepicker", function () {
            console.log("hide event fired")
        }), $("#reportrange2").on("apply.daterangepicker", function (a, b) {

            $('#dis_date_range').val(b.startDate.format("YYYY-MM-DD") + 'and' + b.endDate.format("YYYY-MM-DD"));
            console.log("apply event fired, start/end dates are " + b.startDate.format("YYYY-MM-DD") + " to " + b.endDate.format("YYYY-MM-DD"));
        }), $("#reportrange2").on("cancel.daterangepicker", function (a, b) {
            console.log("cancel event fired")
        }), $("#options1").click(function () {
            $("#reportrange2").data("daterangepicker").setOptions(b, a)
        }), $("#options2").click(function () {
            $("#reportrange2").data("daterangepicker").setOptions(optionSet2, a)
        }), $("#destroy").click(function () {
            $("#reportrange2").data("daterangepicker").remove()
        })
    }

    if ("undefined" != typeof $.fn.daterangepicker) {
        var a = function (a, b, c) {
            console.log(a.toISOString(), b.toISOString(), c), $("#reportrange2 span").html(a.format("MMMM D, YYYY") + " - " + b.format("MMMM D, YYYY"))
        },
                b = {
                    startDate: moment(),
                    endDate: moment().add(30, "days"),
                    dateLimit: {
                        days: 180
                    },
                    showDropdowns: !0,
                    showWeekNumbers: !0,
                    timePicker: !1,
                    timePickerIncrement: 1,
                    timePicker12Hour: !0,
                    ranges: {
                        // Today: [moment(), moment()],
                        // Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                        // "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        // "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        // "This Month": [moment().startOf("month"), moment().endOf("month")],
                        // "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                    },
                    opens: "left",
                    buttonClasses: ["btn btn-default"],
                    applyClass: "btn-small btn-primary",
                    cancelClass: "btn-small",
                    format: "MM/DD/YYYY",
                    separator: " to ",
                    locale: {
                        applyLabel: "Submit",
                        cancelLabel: "Clear",
                        fromLabel: "From",
                        toLabel: "To",
                        customRangeLabel: "Custom",
                        daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                        monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        firstDay: 1
                    }
                };
        var range = '';
        var firstday = '';
        var lastday = '';
        //console.log($('#req_date_range').val());
        if ($('#dis_date_range').val() != undefined && $('#dis_date_range').val() != '') {
            range = $('#req_date_range').val().split('and');
            firstday = moment(range[0]).format("MMMM D, YYYY");
            lastday = moment(range[1]).format("MMMM D, YYYY");
        } else {
            firstday = moment().format("MMMM D, YYYY");
            lastday = moment().add(29, "days").format("MMMM D, YYYY");
        }
        $("#reportrange2 span").html(
                firstday + " - " + lastday),
                $("#reportrange2").daterangepicker(b, a), $("#reportrange2").on("show.daterangepicker", function () {
            console.log("show event fired")
        }), $("#reportrange2").on("hide.daterangepicker", function () {
            console.log("hide event fired")
        }), $("#reportrange2").on("apply.daterangepicker", function (a, b) {

            $('#dis_date_range').val(b.startDate.format("YYYY-MM-DD") + 'and' + b.endDate.format("YYYY-MM-DD"));
            console.log("apply event fired, start/end dates are " + b.startDate.format("YYYY-MM-DD") + " to " + b.endDate.format("YYYY-MM-DD"));
        }), $("#reportrange2").on("cancel.daterangepicker", function (a, b) {
            console.log("cancel event fired")
        }), $("#options1").click(function () {
            $("#reportrange2").data("daterangepicker").setOptions(b, a)
        }), $("#options2").click(function () {
            $("#reportrange2").data("daterangepicker").setOptions(optionSet2, a)
        }), $("#destroy").click(function () {
            $("#reportrange2").data("daterangepicker").remove()
        })
    }



    $('#pageRegister').each(function () {
        if ($(this).data('validator'))
            $(this).data('validator').settings.ignore = ".note-editor *";
    });
    $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
    $('.confirmation1').on('click', function () {
        return confirm('Are you sure? it will remove all the images of the selected product');
    });

    if (window.location.hash == "#AddForm") {
        $('html, body').animate({
            scrollTop: $(".newRequestForm").offset().top
        }, 2000);
    }




    $(document).on('click', '.editSubCategory', function () {
        $('#titleText').html('Edit Sub Category');
        $('#submitSubCategory').html('Edit Sub Category');
        $('#subcategoryRegister').attr('action', GlblURLs + "admin/edit-subcategory");
        var subcat_id = $(this).data('id');
        scrollToCustomerForm();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/edit-subcategory-ajax',
            type: 'POST',
            data: {
                'id': subcat_id,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                $('#subcat_id').val(data['id']);
                $('#subcategoryId').val(data['subcategory_id']);
                $('#category').val(data['category_id']);
                $('#subcategoryName').val(data['name']);
                $("#cstatus").val(data['status']);
                $('#subcatimage').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/upload/subcategory/' + data['subcat_img'] + '">');
                $('#subcatbannerimage').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/upload/subcategory/' + data['subcat_banr_img'] + '">');
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    });



});



function scrollToCustomerForm() {
    $('html, body').animate({
        scrollTop: $(".newRequestForm").offset().top
    }, 2000);
}








function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val)) {
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
    }
    return val;
}


function formatDate(date, flag) {
    var todayDate = new Date(date);
    var hour = todayDate.getHours();
    var min = todayDate.getMinutes();
    var word = '';
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "June",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    if (hour > 12) {
        hour = hour - 12;
    }
    if (hour == 0) {
        hour = 12;
    }
    if (min < 10) {
        min = "0" + min;
    }
    if (todayDate.getDate() == 1) {
        word = 'st';
    } else if (todayDate.getDate() == 2) {
        word = 'nd';
    } else if (todayDate.getDate() == 3) {
        word = 'rd';
    } else {
        word = 'th';
    }
    if (flag) {
        return todayDate.getDate() + word + ' ' + monthNames[todayDate.getMonth() ] + " " + todayDate.getFullYear() + ' | ' + hour + ":" + min + " ";
    } else {
        return todayDate.getDate() + word + ' ' + monthNames[todayDate.getMonth() ] + " " + todayDate.getFullYear() + " ";
    }


}

$(function () {
    $("#datepicker").datepicker({
        minDate: 0,
        dateFormat: "yy-mm-dd",
        onSelect: function () {
            var selected = $(this).val();
            $('#selectedDate').val(selected);
        }
    });
});









$(document).on('click', '.userlist', function () {
    var cust_id = this.id;
    $('.custDetail').show();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-customer-ajax',
        type: 'POST',
        data: {
            'id': cust_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#cust_id').val(data['id']);
            $('#requestName').val(data['name']);
            $('#requestEmailID').val(data['email']);
            $('#requestMobile').val(data['mobile']);
            $('#requestLocation').val(data['location']);
            $('#requestAddress').val(data['service_add1']);
            $('#requestAddress2').val(data['service_add2']);
            $('#cust_landmark').val(data['cust_landmark']);
            $('.regcustbutton').hide();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
    $('#customerser').val($(this).text());
    $('#custList').fadeOut();

});

$(document).on('click', '#addcust', function () {
    $('#cust_id').val('');
    $('#requestName').val('');
    $('#requestEmailID').val('');
    $('#requestMobile').val('');
    $('#requestLocation').val('');
    $('#requestAddress').val('');
    $('#requestAddress2').val('');
    $('#cust_landmark').val('');
    $('.regcustbutton').show();
    $('.custDetail').toggle();
});
$(document).on('click', '#registerCust', function () {
    var cust_name = $('#requestName').val();
    var cust_email = $('#requestEmailID').val();
    var cust_mob = $('#requestMobile').val();
    var cust_seradd1 = $('#requestAddress').val();
    var cust_seradd2 = $('#requestAddress2').val();
    var cust_landmark = $('#cust_landmark').val();
    var cust_loc = $('#selectLocation').val();
    var cust_pref_date = $('#req_date').val();
    var cust_timeslot = $('#ser_timeslot').val();


    if (check_space(document.getElementById('requestName').value) == '' || check_space(document.getElementById('requestName').value) == 0)
    {
        alert('Please enter  Name');
        document.getElementById('requestName').value = '';
        document.getElementById('requestName').focus();
        return false;
    } else if (!(/^[a-zA-Z\s]+$/.test(document.getElementById('requestName').value)))
    {
        alert('Please enter valid  Name');
        document.getElementById('requestName').value = '';
        document.getElementById('requestName').focus();
        return false;
    }
    if (check_space(document.getElementById('requestEmailID').value) == '' || document.getElementById('requestEmailID').value == 'Email')
    {
        alert("Please enter Email");
        document.getElementById('requestEmailID').value = '';
        document.getElementById('requestEmailID').focus();
        return false;
    } else if (!(/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(document.getElementById('requestEmailID').value)))
    {
        alert("Please enter valid Email");
        document.getElementById('requestEmailID').value = '';
        document.getElementById('requestEmailID').focus();
    }
    if (check_space(document.getElementById('requestMobile').value) == '')
    {
        alert('Please enter Mobile no');
        document.getElementById('requestMobile').value = '';
        document.getElementById('requestMobile').focus();
        return false;
    } else if (!(/^[0-9\-]+$/.test(document.getElementById('requestMobile').value)))
    {
        alert('Please enter valid Mobile no');
        document.getElementById('requestMobile').value = '';
        document.getElementById('requestMobile').focus();
        return false;
    }
    if (check_space(document.getElementById('requestAddress').value) == '' || check_space(document.getElementById('requestAddress').value) == 0)
    {
        alert('Please enter  Service Address 1');
        document.getElementById('requestAddress').value = '';
        document.getElementById('requestAddress').focus();
        return false;
    }
    if (check_space(document.getElementById('requestAddress2').value) == '' || check_space(document.getElementById('requestAddress2').value) == 0)
    {
        alert('Please enter Service Address 2');
        document.getElementById('requestAddress2').value = '';
        document.getElementById('requestAddress2').focus();
        return false;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/add-customer-ajax',
        type: 'POST',
        data: {
            'cust_name': cust_name,
            'cust_email': cust_email,
            'cust_mob': cust_mob,
            'cust_seradd1': cust_seradd1,
            'cust_seradd2': cust_seradd2,
            'cust_landmark': cust_landmark,
            'cust_loc': cust_loc,
            'cust_pref_date': cust_pref_date,
            'cust_timeslot': cust_timeslot,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            alert(data.msg);
            $('#cust_id').val(data.data.id);
            $('#requestName').val(cust_name);
            $('#requestEmailID').val(cust_email);
            $('#requestMobile').val(cust_mob);
            $('#requestLocation').val(cust_loc);
            $('#requestAddress').val(cust_seradd1);
            $('#requestAddress2').val(cust_seradd2);
            $('#cust_landmark').val(cust_landmark);
            $('.regcustbutton').hide();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});

function check_space(str)
{
    str = str.replace(/^\s+|\s+$/g, '');
    return str;
}

$('#selectLocation').change(function () {
    $('#req_date').val('');
    $('#ser_timeslot').html('<option value="">Select Date First</option>');
});

if (window.location.hash == "#SubAdminForm") {
    $('html, body').animate({
        scrollTop: $(".newRequestForm").offset().top
    }, 2000);
}

$(document).on('click', '.editSubAdmin', function () {
    $('#titleText').html('Edit Sales');
    $('.resetbtn').hide();
    $('#submitSubAdmin').html('Edit Sales');
    $('#subAdminRegister').attr('action', GlblURLs + "admin/edit-sales");
    var subadmin_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-sales-ajax',
        type: 'POST',
        data: {
            'id': subadmin_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            $('#subadmin_id').val(data['id']);
            $('#subadminName').val(data['name']);
            $('#requestEmailID').val(data['email']);
            $('#requestMobile').val(data['mobile']);
            $('#requestEmailID').prop('readonly', true);
            $('#status').val(data['status']);
            if (data['report_access'] == 1) {
                $('#flag_report').prop('checked', true);
            }

//	    	changelocation(data['center_id']);
        },
        error: function (request, error)
        {
            alert("Error while editing the subadmin.");
        }
    });
});


$(document).on('click', '.editDiscount', function () {
    $('#titleText').html('Edit Discount');
    $('#submitDiscount').html('Edit Discount');
    $('#discountRegister').attr('action', GlblURLs + "admin/edit-discount");
    var d_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-discount-ajax',
        type: 'POST',
        data: {
            'id': d_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#d_id').val(data['d_id']);
            $('#d_code').val(data['d_code']);
            $('#dis_date_range').val(data['d_date_start'] + 'and' + data['d_date_end']);
            firstday = moment(data['d_date_start']).format("MMMM D, YYYY");
            lastday = moment(data['d_date_end']).format("MMMM D, YYYY");
            $("#reportrange2 span").html(firstday + " - " + lastday);
            $('#d_loc').val(data['d_loc'].split(','));
            $('#d_amnt').val(data['d_amnt']);
            $('#d_min_ordr_amnt').val(data['d_min_ordr_amnt']);
            $('#d_max_consumed').val(data['d_max_consumed']);
            $('#d_status').val(data['d_status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});






// rollco


$(document).on('click', '.editUserCat', function () {
    $('#titleText').html('Edit User category');
    $('#submitLocation').html('Edit User category');
    $('#userCatRegister').attr('action', GlblURLs + "admin/edit-usercategory");
    var cat_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-usercategory-ajax',
        type: 'POST',
        data: {
            'id': cat_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#cust_cat_id').val(data['cust_cat_id']);
            $('#cust_cat_nme').val(data['cust_cat_nme']);
            $('#cust_cat_status').val(data['cust_cat_status']);
            $('#cust_cat_info').val(data['cust_cat_info']);
        },
        error: function (request, error)
        {
            alert("Error while editing  user category data");
        }
    });
});


$(document).on('click', '.editCurrency', function () {
    $('#titleText').html('Edit Currency');
    $('#submitLocation').html('Edit Currency');
    $('#currRegister').attr('action', GlblURLs + "admin/edit-currency");
    var cat_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-currency-ajax',
        type: 'POST',
        data: {
            'id': cat_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#curr_id').val(data['curr_id']);
            $('#curr_name').val(data['curr_name']);
            $('#curr_info').val(data['curr_info']);
            $('#curr_status').val(data['curr_status']);
        },
        error: function (request, error)
        {
            alert("Error while editing  currency data");
        }
    });
});

$(document).on('click', '.editCategory', function () {
    $('#titleText').html('Edit Category');
    $('#submitCategory').html('Edit Category');
    $('#categoryRegister').attr('action', GlblURLs + "admin/edit-category");
    var cat_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-category-ajax',
        type: 'POST',
        data: {
            'id': cat_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            //$('#cat_id').val(data['cat_id']);
            $('#catid').val(data['catid']);
            //$('#mcatid').val(data['mcatid']);
//            $('#cat_nm').val(data['cat_nm']);
//            $('#cat_headinglines').val(data['cat_headinglines']);
//            CKEDITOR.instances.cat_detail.setData(data['cat_detail']);
            //CKEDITOR.instances.cat_catlog.setData(data['cat_catlog']);
            $('#cat_brochure').html('<a target="_blank" href="' + imgUrl + 'catalogues/' + data['cat_brochure'] + '">View Brochure</a>');

            $("#cat_status").val(data['cat_status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$(document).on('click', '.editMake', function () {
    $('#titleText').html('Edit Make');
    $('#submitSubCategory').html('Edit Make');
    $('#makeRegister').attr('action', GlblURLs + "admin/edit-make");
    var subcat_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-make-ajax',
        type: 'POST',
        data: {
            'id': subcat_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#make_id').val(data['id']);
            $('#category').val(data['category_id']);
            $('#make_nm').val(data['name']);
            $("#cstatus").val(data['status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});

function populateMakeData(cat_id, make_id) {
    var sel_cat = '';
    if (cat_id == '0') {
        sel_cat = $('#category').find(":selected").val();
    } else {
        sel_cat = cat_id;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (sel_cat != '') {
        $.ajax({
            url: GlblURLs + 'admin/get-make-data',
            type: 'POST',
            data: {
                'id': sel_cat,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {

                $('#product_make').html('');
                if (data.length > 0) {
                    var $dropdown = $("#product_make");
                    $dropdown.append($("<option />").val('').text("Select Make"));
                    $.each(data, function () {
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                    $('#product_make').val(make_id);
                } else {
                    alert("No make data ");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    }
}



function populateModelData(cat_id, make_id, model_id) {
    var sel_cat = '';
    var sel_model = '';
    if (cat_id == '0') {
        sel_cat = $('#category').find(":selected").val();
        sel_model = $('#product_make').find(":selected").val();
    } else {
        sel_cat = cat_id;
        sel_model = make_id;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (sel_cat != '') {
        $.ajax({
            url: GlblURLs + 'admin/get-model-data',
            type: 'POST',
            data: {
                'id': sel_model,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {

                $('#product_model').html('');
                if (data.length > 0) {
                    var $dropdown = $("#product_model");
                    $dropdown.append($("<option />").val('').text("Select Model"));
                    $.each(data, function () {
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                    $('#product_model').val(model_id);
                } else {
                    alert("No model data ");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    }
}


function populateYearData(cat_id, make_id, model_id, proyr_id) {
    var sel_cat = '';
    var sel_model = '';
    if (cat_id == '0') {
        sel_cat = $('#category').find(":selected").val();
        sel_model = $('#product_model').find(":selected").val();
    } else {
        sel_cat = cat_id;
        sel_model = model_id;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (sel_cat != '') {
        $.ajax({
            url: GlblURLs + 'admin/get-proyear-data',
            type: 'POST',
            data: {
                'id': sel_model,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                $('#proyr').html('');
                console.log(data.length);
                if (data.length > 0) {
                    var $dropdown = $("#proyr");
                    $dropdown.append($("<option />").val('').text("Select year"));
                    var text = '';

                    $.each(data, function () {
                        if (this.current_flag == 1) {
                            text = 'On';
                        } else {
                            if (this.yr_to != 0) {
                                text = this.yr_from + '-' + this.yr_to;
                            } else {
                                text = this.yr_from + '-on';
                            }
                        }

                        $dropdown.append($("<option />").val(this.id).text(text));
                    });
                    $('#proyr').val(proyr_id);
                } else {
                    alert("No year data ");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    }
}
function populateCCMData(cat_id, make_id, model_id, proyr_id, proccm_id) {



    var sel_yr = '';
    if (cat_id == '0') {
        sel_yr = $('#proyr').find(":selected").val();
    } else {
        sel_yr = proyr_id;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (sel_yr != '') {
        $.ajax({
            url: GlblURLs + 'admin/get-proccm-data',
            type: 'POST',
            data: {
                'id': sel_yr,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                $('#proccm').html('');

                if (data.length > 0) {
                    var $dropdown = $("#proccm");
                    $dropdown.append($("<option />").val('').text("Select CCM"));
                    var text = '';

                    $.each(data, function () {
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                    $('#proccm').val(proccm_id);
                } else {
                    alert("No CCM data ");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    }
}
function populateEngCodeData(engcode_id, proccm_id) {

    var sel_engcode_id = '';
    if (engcode_id == '0') {
        sel_engcode_id = $('#proccm').find(":selected").val();
    } else {
        sel_engcode_id = proccm_id;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (sel_engcode_id != '') {
        $.ajax({
            url: GlblURLs + 'admin/get-engcode-data',
            type: 'POST',
            data: {
                'id': sel_engcode_id,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                $('#engcode').html('');
                if (data.length > 0) {
                    var $dropdown = $("#engcode");
                    $dropdown.append($("<option />").val('').text("Select Engine code"));
                    var text = '';
                    $.each(data, function () {
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                    $('#engcode').val(engcode_id);
                } else {
                    alert("No Engine Code data ");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    }
}
function populateProductData(make_id, prod_id) {

    var make = '';
    if (make_id == '0') {
        make = $('#make').find(":selected").val();
    } else {
        make = make_id;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (make != '') {
        $.ajax({
            url: GlblURLs + 'admin/get-product-data',
            type: 'POST',
            data: {
                'id': make,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                $('#product').html('');
                if (data.length > 0) {
                    var $dropdown = $("#product");
                    $dropdown.append($("<option />").val('').text("Select product"));
                    var text = '';
                    $.each(data, function () {
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                    $('#product').val(prod_id);
                } else {
                    alert("No Product data");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    }
}


$(document).on('click', '.editSpare', function () {
    $('#titleText').html('Edit Spare');
    $('#submitSubCategory').html('Edit Spare');
    $('#spareRegister').attr('action', GlblURLs + "admin/edit-spare");
    var spare_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-spare-ajax',
        type: 'POST',
        data: {
            'id': spare_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#make').val(data['makeid']);
            $('#spare_id').val(data['spare_id']);
            $('#spare_nm').val(data['spare_nm']);
            $('#spare_part_no').val(data['spare_part_no']);
            $('#spare_desc').val(data['spare_desc']);
            $('#spare_avail').val(data['spare_avail']);
            $('#spare_add_inf').val(data['spare_add_inf']);
            $('#spare_price').val(data['spare_price']);
            $('#spare_oem').val(data['spare_oem']);
            $('#spare_make').val(data['spare_make']);
            $('#spare_cargo').val(data['spare_cargo']);
            if (data['spare_img1'] != '' && data['spare_img1'] != undefined && data['spare_img1'] != null) {
                $('#spare_img1').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img1'] + '">');
            }
            if (data['spare_img2'] != '' && data['spare_img2'] != undefined && data['spare_img2'] != null) {
                $('#spare_img2').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img2'] + '">');
            }
            if (data['spare_img3'] != '' && data['spare_img3'] != undefined && data['spare_img3'] != null) {
                $('#spare_img3').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img3'] + '">');
            }
            if (data['spare_img4'] != '' && data['spare_img4'] != undefined && data['spare_img4'] != null) {
                $('#spare_img4').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img4'] + '">');
            }
            if (data['spare_img5'] != '' && data['spare_img5'] != undefined && data['spare_img5'] != null) {
                $('#spare_img5').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img5'] + '">');
            }
            if (data['spare_img6'] != '' && data['spare_img6'] != undefined && data['spare_img6'] != null) {
                $('#spare_img6').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img6'] + '">');
            }
            if (data['spare_img7'] != '' && data['spare_img7'] != undefined && data['spare_img7'] != null) {
                $('#spare_img7').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img7'] + '">');
            }
            if (data['spare_img8'] != '' && data['spare_img8'] != undefined && data['spare_img8'] != null) {
                $('#spare_img8').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/spare/' + data['spare_img8'] + '">');
            }
            $("#cstatus").val(data['spare_status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});



$(document).on('click', '.editModel', function () {
    $('#titleText').html('Edit Model');
    $('#submitSubCategory').html('Edit Model');
    $('#modelRegister').attr('action', GlblURLs + "admin/edit-model");
    var model_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-model-ajax',
        type: 'POST',
        data: {
            'id': model_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            populateMakeData(data['category_id'], data['make_id']);
            $('#model_id').val(data['id']);
            $('#category').val(data['category_id']);

            $('#model_nm').val(data['name']);
            $("#cstatus").val(data['status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$('input:radio[name="yearRadio"]').change(function () {
    if (this.id == 'customRadio1') {
        $('.yearto').hide();
    } else if (this.id == 'customRadio2') {
        $('.yearto').show();
    }
});


function populateFromYear(yrf) {
    var html = '';
    var cyear = new Date().getFullYear();
    for (var i = 1900; i <= cyear; i++) {
        html += '<option value="' + i + '">' + i + '</option>';
    }
    $('#year_from').html(html);
    $('#year_from').val(yrf);
}

$('#year_from').change(function () {
    var from_selected = $('#year_from option:selected').val();
    populateToYear(from_selected);
});

function populateToYear(from, yrt) {
    var html = '';
    var from = parseInt(from) + 1;
    var cyear = new Date().getFullYear();
    for (var i = from; i <= cyear; i++) {
        html += '<option value="' + i + '">' + i + '</option>';
    }

    $('#year_to').html(html);
    $('#year_to').val(yrt);
}
$(document).on('click', '.editProYear', function () {
    $('#titleText').html('Edit Manufacturing year');
    $('#submitSubCategory').html('Edit');
    $('#proyrRegister').attr('action', GlblURLs + "admin/edit-proyr");
    var proyr_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-proyr-ajax',
        type: 'POST',
        data: {
            'id': proyr_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            populateMakeData(data['category_id'], data['make_id']);
            populateModelData(data['category_id'], data['make_id'], data['model_id']);
            $('#proyr_id').val(data['id']);
            $('#category').val(data['category_id']);
            populateFromYear(data['proyr_from']);
            if (data['proyr_to'] != 0) {
                $('.yearto').show();
                $('#customRadio2').prop('checked', true);
            }
            populateToYear(data['proyr_from'], data['proyr_to']);

            $("#cstatus").val(data['status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$(document).on('click', '.editProCCM', function () {
    $('#titleText').html('Edit Manufacturing CCM');
    $('#submitSubCategory').html('Edit');
    $('#proccmRegister').attr('action', GlblURLs + "admin/edit-proccm");
    var proccm_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-proccm-ajax',
        type: 'POST',
        data: {
            'id': proccm_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            populateMakeData(data['category_id'], data['make_id']);
            populateModelData(data['category_id'], data['make_id'], data['model_id']);
            populateYearData(data['category_id'], data['make_id'], data['model_id'], data['proyr_id']);
            $('#proccm_id').val(data['id']);
            $('#category').val(data['category_id']);
            $('#proccm_inf').val(data['proccm_inf']);
            populateFromYear(data['proyr_from']);
            if (data['proyr_to'] != 0) {
                $('.yearto').show();
                $('#customRadio2').prop('checked', true);
            }
            populateToYear(data['proyr_from'], data['proyr_to']);

            $("#cstatus").val(data['status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$(document).on('click', '.editEngcode', function () {
    $('#titleText').html('Edit Engine Code');
    $('#submitSubCategory').html('Edit');
    $('#engcodeRegister').attr('action', GlblURLs + "admin/edit-engcode");
    var engcode_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-engcode-ajax',
        type: 'POST',
        data: {
            'id': engcode_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            populateMakeData(data['category_id'], data['make_id']);
            populateModelData(data['category_id'], data['make_id'], data['model_id']);
            populateYearData(data['category_id'], data['make_id'], data['model_id'], data['proyr_id']);
            populateCCMData(data['category_id'], data['make_id'], data['model_id'], data['proyr_id'], data['proccm_id']);
            $('#engcode_id').val(data['id']);
            $('#category').val(data['category_id']);
            $('#engcode_inf').val(data['engcode_inf']);

            $("#cstatus").val(data['status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});

$(document).on('click', '.editProd', function () {
    $('#titleText').html('Edit Product');
    $('#submitSubCategory').html('Edit');
    $('#prodRegister').attr('action', GlblURLs + "admin/edit-product");
    var engcode_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-product-ajax',
        type: 'POST',
        data: {
            'id': engcode_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            // console.log(data);
            populateCategoryData(data['mcatid'], data['catid']);
            populateMakeData(data['catid'], data['makeid']);
            populateModelData(data['catid'], data['makeid'], data['modelid']);
            populateYearData(data['catid'], data['makeid'], data['modelid'], data['proyrid']);
            populateCCMData(data['catid'], data['makeid'], data['modelid'], data['proyrid'], data['proccmid']);
            populateEngCodeData(data['engid'], data['proccmid']);
            $('#mcategory').val(data['mcatid']);
            $('#prod_id').val(data['prod_id']);
            $('#category').val(data['catid']);
            $('#prod_add_inf').val(data['prod_add_inf']);
            $('#prod_desc').val(data['prod_desc']);
            $('#prod_nm').val(data['prod_nm']);
            $('#prod_part_no').val(data['prod_part_no']);
            $('#prod_stock').val(data['prod_stock']);
            $('#prod_price').val(data['prod_price']);
            $('#is_latest').val(data['is_latest']);
            $('#mscode').val(data['mscode']);
            CKEDITOR.instances.prod_overview.setData(data['prod_overview']);


            if (data['prod_dim'] != undefined) {
                $('.prod_dim').attr('checked', true);
                $('#prod_dim').attr('disabled', false);
                $('#prod_dim').val(data['prod_dim']);
            }
            if (data['prod_volt'] != undefined) {
                $('.prod_volt').attr('checked', true);
                $('#prod_volt').attr('disabled', false);
                $('#prod_volt').val(data['prod_volt']);
            }
            if (data['prod_out'] != undefined) {
                $('.prod_out').attr('checked', true);
                $('#prod_out').attr('disabled', false);
                $('#prod_out').val(data['prod_out']);
            }
            if (data['prod_regu'] != undefined) {
                $('.prod_regu').attr('checked', true);
                $('#prod_regu').attr('disabled', false);
                $('#prod_regu').val(data['prod_regu']);
            }
            if (data['prod_pull_type'] != undefined) {
                $('.prod_pull_type').attr('checked', true);
                $('#prod_pull_type').attr('disabled', false);
                $('#prod_pull_type').val(data['prod_pull_type']);
            }
            if (data['prod_fan'] != undefined) {
                $('.prod_fan').attr('checked', true);
                $('#prod_fan').attr('disabled', false);
                $('#prod_fan').val(data['prod_fan']);
            }
            if (data['prod_teeth'] != undefined) {
                $('.prod_teeth').attr('checked', true);
                $('#prod_teeth').attr('disabled', false);
                $('#prod_teeth').val(data['prod_teeth']);
            }
            if (data['prod_trans'] != undefined) {
                $('.prod_trans').attr('checked', true);
                $('#prod_trans').attr('disabled', false);
                $('#prod_trans').val(data['prod_trans']);
            }
            if (data['prod_rot'] != undefined) {
                $('.prod_rot').attr('checked', true);
                $('#prod_rot').attr('disabled', false);
                $('#prod_rot').val(data['prod_rot']);
            }

            if (data['ptype'] != undefined) {
                $('.ptype').prop('checked', true);
                $('#ptype').attr('disabled', false);
                $('#ptype').val(data['ptype']);
            }
            if (data['position'] != undefined) {
                $('.position').attr('checked', true);
                $('#position').attr('disabled', false);
                $('#position').val(data['position']);
            }
            if (data['gr'] != undefined) {
                $('.gr').attr('checked', true);
                $('#gr').attr('disabled', false);
                $('#gr').val(data['gr']);
            }
            if (data['car_fits'] != undefined) {
                $('.car_fits').attr('checked', true);
                $('#car_fits').attr('disabled', false);
                $('#car_fits').val(data['car_fits']);
            }
            if (data['fuel'] != undefined) {
                $('.fuel').attr('checked', true);
                $('#fuel').attr('disabled', false);
                $('#fuel').val(data['fuel']);
            }
            if (data['external_teeth'] != undefined) {
                $('.external_teeth').attr('checked', true);
                $('#external_teeth').attr('disabled', false);
                $('#external_teeth').val(data['external_teeth']);
            }
            if (data['internal_teeth'] != undefined) {
                $('.internal_teeth').attr('checked', true);
                $('#internal_teeth').attr('disabled', false);
                $('#internal_teeth').val(data['internal_teeth']);
            }
            if (data['height'] != undefined) {
                $('.height').attr('checked', true);
                $('#height').attr('disabled', false);
                $('#height').val(data['height']);
            }
            if (data['abs_ring'] != undefined) {
                $('.abs_ring').attr('checked', true);
                $('#abs_ring').attr('disabled', false);
                $('#abs_ring').val(data['abs_ring']);
            }
            if (data['cylinders'] != undefined) {
                $('.cylinders').attr('checked', true);
                $('#cylinders').attr('disabled', false);
                $('#cylinders').val(data['cylinders']);
            }

            if (data['prod_img1'] != '' && data['prod_img1'] != undefined && data['prod_img1'] != null) {
                $('#prod_img1').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img1'] + '">');
            }
            if (data['prod_img2'] != '' && data['prod_img2'] != undefined && data['prod_img2'] != null) {
                $('#prod_img2').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img2'] + '">');
            }
            if (data['prod_img3'] != '' && data['prod_img3'] != undefined && data['prod_img3'] != null) {
                $('#prod_img3').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img3'] + '">');
            }
            if (data['prod_img4'] != '' && data['prod_img4'] != undefined && data['prod_img4'] != null) {
                $('#prod_img4').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img4'] + '">');
            }
            if (data['prod_img5'] != '' && data['prod_img5'] != undefined && data['prod_img5'] != null) {
                $('#prod_img5').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img5'] + '">');
            }
            if (data['prod_img6'] != '' && data['prod_img6'] != undefined && data['prod_img6'] != null) {
                $('#prod_img6').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img6'] + '">');
            }
            if (data['prod_img7'] != '' && data['prod_img7'] != undefined && data['prod_img7'] != null) {
                $('#prod_img7').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img7'] + '">');
            }
            if (data['prod_img8'] != '' && data['prod_img8'] != undefined && data['prod_img8'] != null) {
                $('#prod_img8').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img8'] + '">');
            }

            $("#cstatus").val(data['prod_status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});



function changeInputState(id) {
    if ($('.' + id).is(":checked")) {
        $('#' + id).attr('disabled', false);
    } else {
        $('#' + id).attr('disabled', true);
    }

}

$(document).on('click', '#checkAll', function () {
    if (this.checked) {
        $('.deleteCrossButt').show();
    } else {
        $('.deleteCrossButt').hide();
    }
    $('input:checkbox.deleteCrossref').not(this).prop('checked', this.checked);
});

$(document).on('click', '.deleteCrossref', function () {
    var checkid = [];
    var crossbut = 0;
    $('input:checkbox.deleteCrossref').each(function () {
        var sThisVal = (this.checked ? this.id : "");
        if (sThisVal > 0) {
            checkid.push(sThisVal);
            crossbut = 1;
        }
    });
    if (crossbut > 0) {
        $('.deleteCrossButt').show();
    } else {
        $('.deleteCrossButt').hide();
    }
});

$(document).on('click', '#deletecrossRef', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteCrossref').each(function () {
            var sThisVal = (this.checked ? this.id : "");
            checkid.push(sThisVal);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-crossref-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Cross refrences deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting cross refrences");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});
$(document).on('click', '#deleteUnverifiedUsers', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteCrossref').each(function () {
            var sThisVal = (this.checked ? this.id : "");
            checkid.push(sThisVal);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-customer-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Unverified users deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting Unverified users");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});



$(document).on('click', '.deleteContact', function () {
    var checkid = [];
    var crossbut = 0;
    $('input:checkbox.deleteContact').each(function () {
        var sThisVal = (this.checked ? this.id : "");
        if (sThisVal > 0) {
            checkid.push(sThisVal);
            crossbut = 1;
        }
    });

    if (crossbut > 0) {
        $('.deleteCrossButt').show();
    } else {
        $('.deleteCrossButt').hide();
    }
});

$(document).on('click', '#deleteContactDetails', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteContact').each(function () {
            var sThisVal = (this.checked ? this.id : "");
            checkid.push(sThisVal);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-contact-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Contact details deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting contact details");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});
$(document).on('click', '.deleteEnquiry', function () {
    var checkid = [];
    var crossbut = 0;
    $('input:checkbox.deleteEnquiry').each(function () {
        var sThisVal = (this.checked ? this.id : "");
        if (sThisVal > 0) {
            checkid.push(sThisVal);
            crossbut = 1;
        }
    });

    if (crossbut > 0) {
        $('.deleteCrossButt').show();
    } else {
        $('.deleteCrossButt').hide();
    }
});

$(document).on('click', '#deleteEnquiryDetails', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteEnquiry').each(function () {
            var sThisVal = (this.checked ? this.id : "");
            checkid.push(sThisVal);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-enquiry-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Enquiry details deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting enquiry details");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});

$(document).on('click', '.deleteSNF', function () {
    var checkid = [];
    var crossbut = 0;
    $('input:checkbox.deleteSNF').each(function () {
        var sThisVal = (this.checked ? this.id : "");
        if (sThisVal > 0) {
            checkid.push(sThisVal);
            crossbut = 1;
        }
    });

    if (crossbut > 0) {
        $('.deleteCrossButt').show();
    } else {
        $('.deleteCrossButt').hide();
    }
});

$(document).on('click', '#deleteSNFDetails', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteSNF').each(function () {
            var sThisVal = (this.checked ? this.id : "");
            checkid.push(sThisVal);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-snf-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Search not found details deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting search not found details");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});

$(document).on('click', '.deleteRecent', function () {
    var checkid = [];
    var crossbut = 0;
    $('input:checkbox.deleteRecent').each(function () {
        var sThisVal = (this.checked ? this.id : "");
        if (sThisVal > 0) {
            checkid.push(sThisVal);
            crossbut = 1;
        }
    });

    if (crossbut > 0) {
        $('.deleteCrossButt').show();
    } else {
        $('.deleteCrossButt').hide();
    }
});

$(document).on('click', '#deleteRecentDetails', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteRecent').each(function () {
            var sThisVal = (this.checked ? this.id : "");
            checkid.push(sThisVal);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-recent-search-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Recent details deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting recent details");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});




$(document).on('click', '.editCustomer', function () {
    $('#titleText').html('Edit Customer');
    $('#submitCust').html('Edit Customer');
    // $('.sendpwdradio').show();
    $('#requestEmailID').attr('readonly', true);
    $('#custRegister').attr('action', GlblURLs + "admin/edit-customer");
    var customer_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-customer-ajax',
        type: 'POST',
        data: {
            'id': customer_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            $('#u_id').val(data.users['u_id']);
            $('#requestFName').val(data.users['firstName']);
            $('#requestLName').val(data.users['lastName']);
            $('#custcatid').val(data.users['role']);
            $('#com_emailAddress').val(data.users['com_emailAddress']);
            $('#streetAddress1').val(data.users['streetAddress1']);
            $('#streetAddress2').val(data.users['streetAddress2']);
            $('#com_city').val(data.users['com_city']);
            $('#com_state').val(data.users['com_state']);
            $('#com_zipCode').val(data.users['com_zipCode']);
            $('#com_Telephone').val(data.users['com_Telephone']);
            $('#com_Fax').val(data.users['com_Fax']);
            $('#companyName').val(data.users['companyName']);
            $('#companyWebsite').val(data.users['companyWebsite']);
            $('#companyRegistrationNumber').val(data.users['companyRegistrationNumber']);
            $('#companyVatNumber').val(data.users['companyVatNumber']);
            $('#companyRegAdd1').val(data.users['companyRegAdd1']);
            $('#companyRegAdd2').val(data.users['companyRegAdd2']);
            $('#companyRegState').val(data.users['companyRegState']);
            $('#companyRegCity').val(data.users['companyRegCity']);
            $('#companyRegZip').val(data.users['companyRegZip']);
            $('#companyInvAdd1').val(data.users['companyInvAdd1']);
            $('#companyInvAdd2').val(data.users['companyInvAdd2']);
            $('#companyInvCity').val(data.users['companyInvCity']);
            $('#companyInvState').val(data.users['companyInvState']);
            $('#companyInvZip').val(data.users['companyInvZip']);
            $('#companyAccountPerName').val(data.users['companyAccountPerName']);
            $('#companyAccountPerEmail').val(data.users['companyAccountPerEmail']);
            $('#companyAccountPerMobile').val(data.users['companyAccountPerMobile']);
            $('#companyAccountPerDepartment').val(data.users['companyAccountPerDepartment']);
            $('#companyBankName').val(data.users['companyBankName']);
            $('#companyBankAddress').val(data.users['companyBankAddress']);
            $('#companyBankAccount').val(data.users['companyBankAccount']);
            $('#companyContactNumber').val(data.users['companyContactNumber']);
            $('#companySortCode').val(data.users['companySortCode']);
            $('#grp_id').val(data.users['g_id']);
            $('#customerID').val(data.users['customerID']);
            $('.cust-form').show();
            $("#cust_status").val(data.users['user_status']);
            $("#cal_show").val(data.users['cal_show']);
            $("#c_verified").val(data.users['c_verified']);
//            if (data.userCatData.length > 0) {
//                $.each(data.userCatData, function (k, v) {
//                    $('#flag_' + v.cat_id).prop('checked', true);
//                });
//            }
            scrollToCustomerForm();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$(document).on('click', '.editNews', function () {
    $('#titleText').html('Edit News');
    $('#submitNews').html('Edit News');
    $('#newsRegister').attr('action', GlblURLs + "admin/edit-news");
    var news_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-news-ajax',
        type: 'POST',
        data: {
            'id': news_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#news_id').val(data['news_id']);
            //$('#news_text').val(data['news_text']);
            CKEDITOR.instances.news_text.setData(data['news_text']);
            $('#news_status').val(data['news_status']);
        },
        error: function (request, error)
        {
            alert("Error while editing  news data");
        }
    });
});


$(document).on('click', '.editExb', function () {
    $('#titleText').html('Edit Exhibition');
    $('#submitNews').html('Edit');
    $('#exbRegister').attr('action', GlblURLs + "admin/edit-exb");
    var exb_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-exb-ajax',
        type: 'POST',
        data: {
            'id': exb_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#exb_id').val(data['exb_id']);
            $('#exb_nm').val(data['exb_nm']);
            $('#exb_inf').val(data['exb_inf']);
            $('#exb_date').val(data['exb_date']);
            $('#exb_place').val(data['exb_place']);
            $('#exb_img').html('<img style="height:100px;width:150px;"  src="' + imgUrl + 'exhibition/' + data['exb_img'] + '">');
            $('#exb_status').val(data['exb_status']);
        },
        error: function (request, error)
        {
            alert("Error while editing  exhibition data");
        }
    });
});


$(document).on('click', '.editAnnouncement', function () {
    $('#titleText').html('Edit Announcement');
    $('#submitAnnouncement').html('Edit');
    $('#announcementRegister').attr('action', GlblURLs + "admin/edit-announcement");
    var announcement_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-announcement-ajax',
        type: 'POST',
        data: {
            'id': announcement_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#announcement_id').val(data['announcement_id']);
            $('#announcement_text').val(data['announcement_text']);
            $('#announcement_status').val(data['announcement_status']);
        },
        error: function (request, error)
        {
            alert("Error while editing  announcement data");
        }
    });
});


$(document).on('click', '.editGroup', function () {
    $('#titleText').html('Edit Group');
    $('#submitGroup').html('Edit Group');
    $('#GroupRegister').attr('action', GlblURLs + "admin/edit-group");
    var gr_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-group-ajax',
        type: 'POST',
        data: {
            'id': gr_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#gr_id').val(data['id']);
            $('#gr_currency').val(data['currency']);
            $('#groupName').val(data['name']);
            $("#curr_status").val(data['status']);
        },
        error: function (request, error)
        {
            alert("Error while edit data");
        }
    });
});

$(document).on('click', '.editProductsgroup', function () {
    $('.viewPrgrps').hide();
    $('.viewPrgrp').show();
    $('#titleText').html('Edit Price');
    $('#submitProductGroup').html('Edit Price');
    $('#GroupRegister').attr('action', GlblURLs + "admin/edit-product-group");
    var grps_id = $(this).data('id');
    var grps_arr = grps_id.split('_');
    var gr_id = grps_arr[0];
    var grp_id = grps_arr[1];

    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-product-group-ajax',
        type: 'POST',
        data: {
            'id': grp_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#gr_id').val(data['gr_id']);
            $('#grp_id').val(data['grp_id']);
            $('#part_nm').val(data['part_nm']);
            $('#pr_price').val(data['pr_price']);
        },
        error: function (request, error)
        {
            alert("Error while edit data");
        }
    });
});

$(document).on('click', '.editspare_services', function () {
    $('.viewPrgrp').show();
    $('#titleText').html('Edit Service');
    $('#submitspare_services').html('Edit Service');
    $('#servsUpdate').attr('action', GlblURLs + "admin/edit-spare-service");
    var srvs_id = $(this).data('id');
    var srvs_arr = srvs_id.split('_');
    var srv_id = srvs_arr[0];
    var sps_id = srvs_arr[1];

    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: GlblURLs + 'admin/edit-spare-service-ajax',
        type: 'POST',
        data: {
            'id': sps_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#sps_id').val(data['sps_id']);
            $('#spare_num').val(data['spare_num']);
            $('#srvs_num').val(data['srvs_num']);
        },
        error: function (request, error)
        {
            alert("Error while edit data");
        }
    });
});

$(document).on('click', '.editspare_oem', function () {
    $('.viewPrgrp').show();
    $('#titleText').html('Edit Service');
    $('#submitspare_oem').html('Edit Service');
    $('#oemUpdate').attr('action', GlblURLs + "admin/edit-spare-oem");
    var oems_id = $(this).data('id');
    var oems_arr = oems_id.split('_');
    var oem_id = oems_arr[0];
    var spm_id = oems_arr[1];

    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: GlblURLs + 'admin/edit-spare-oem-ajax',
        type: 'POST',
        data: {
            'id': spm_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#spm_id').val(data['spm_id']);
            $('#spare_num').val(data['spare_num']);
            $('#oem_num').val(data['oem_num']);
        },
        error: function (request, error)
        {
            alert("Error while edit data");
        }
    });
});

$(document).on('click', '.editproduct-application', function () {
    $('.viewPrgrp').show();
    $('#titleText').html('Edit Application');
    $('#submitApplication').html('Edit Application');
    $('#applicationUpdate').attr('action', GlblURLs + "admin/edit-product-application");
    var aps_id = $(this).data('id');
    var aps_arr = aps_id.split('_');
    var part_id = aps_arr[0];
    var ap_id = aps_arr[1];

    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: GlblURLs + 'admin/edit-product-application-ajax',
        type: 'POST',
        data: {
            'id': ap_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#submitapplication').text('Update');
            $('.otherdiv').show();
            $('.fileuploaddiv').hide();
            $('#ap_id').val(data['ap_id']);
            $('#part_no').val(data['part_no']);
            $('#make_nm').val(data['make_nm']);
            $('#model_nm').val(data['model_nm']);
            $('#year').val(data['year']);
            $('#cc').val(data['cc']);
        },
        error: function (request, error)
        {
            alert("Error while edit data");
        }
    });
});

$(document).on('click', '.editMCategory', function () {
    $('#titleText').html('Edit Master Categories');
    $('#submitMCategory').html('Edit Master Category');
    $('#mcategoryRegister').attr('action', GlblURLs + "admin/edit-mcategory");
    var mcat_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-mcategory-ajax',
        type: 'POST',
        data: {
            'id': mcat_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#mcat_id').val(data['mcat_id']);
            $('#mcat_nm').val(data['mcat_nm']);
            $('#mcat_status').val(data['mcat_status']);
            $('#mcat_image').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/mcat/' + data['mcat_image'] + '">');
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


function populateCategoryData(mcat_id, cat_id) {
    var sel_cat = '';
    if (mcat_id == '0') {
        sel_cat = $('#mcategory').find(":selected").val();
    } else {
        sel_cat = mcat_id;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (sel_cat != '') {
        $.ajax({
            url: GlblURLs + 'admin/get-category-data',
            type: 'POST',
            data: {
                'id': sel_cat,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                $('#category').html('');
                if (data.length > 0) {
                    var $dropdown = $("#category");
                    $dropdown.append($("<option />").val('').text("Select Category"));
                    $.each(data, function () {
                        $dropdown.append($("<option />").val(this.id).text(this.name));
                    });
                    $('#category').val(cat_id);
                } else {
                    alert("No category data ");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    }
}


$(document).on('click', '.editcrossref', function () {
    $('.updCr').hide();
    $('.edtCr').show();
    $('#edt_titleText').html('Edit Cross references');
    $('#submitcrossref').html('Edit Cross references');
    $('#crossrefRegister').attr('action', GlblURLs + "admin/edit-crossref");
    var crossref_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-crossref-ajax',
        type: 'POST',
        data: {
            'id': crossref_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#crossref_id').val(data['crossref_id']);
            $('#rc_num').val(data['rc_num']);
            $('#crossref_make').val(data['crossref_make']);
            $('#crossref_oem').val(data['crossref_oem']);
            $('#crossref_status').val(data['crossref_status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


try {
    CKEDITOR.replace('cat_detail');
} catch (err) {
}
try {
    //CKEDITOR.replace('cat_catlog');
} catch (err) {
}

try {
    CKEDITOR.replace('prod_overview');
} catch (err) {
//    console.log(err);
}



$(document).on('click', '.editFlyres', function () {
    $('#titleText').html('Edit Flyers');
    $('#submitFlyers').html('Edit Flyers');
    $('#catalogueRegister').attr('action', GlblURLs + "admin/edit-catalogue");
    var cat_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-catalogue-ajax',
        type: 'POST',
        data: {
            'id': cat_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#cat_title').val(data['cat_title']);
            $('#id').val(data['id']);
            $('#fly_detail').val(data['fly_detail']);
            $('#flyer_file').html('<a target="_blank" href="' + imgUrl + 'catalogues/' + data['cat_filename'] + '">View Flyer</a>');
            $('#flyer_thfile').html('<a target="_blank" href="' + imgUrl + 'catalogues/' + data['cat_thnail'] + '">View Thumbnail</a>');
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$(document).on('click', '.editSCategory', function () {
    $('#titleText').html('Edit Sales Category');
    $('#submitCategory').html('Edit Sales Category');
    $('#scategoryRegister').attr('action', GlblURLs + "admin/edit-salescat");
    var cat_id = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-salescat-ajax',
        type: 'POST',
        data: {
            'id': cat_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            $('#sc_id').val(data['sc_id']);
            $('#scat_nm').val(data['scat_nm']);
            $("#scat_status").val(data['scat_status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$('.user_id_sales').change(function () {
    var user_id = $(this).val();
    var checktemp = user_id.includes("temp");
    if (!checktemp) {

        $('.sscustcat').show();

        if ($('#checkflag').val() == 1) {
            $('#salesSheetRegister').submit();
        }
//        $('form').submit();
        populateSalesCategory(user_id);
    } else {
        if (checktemp) {
            var tempArr = user_id.split('_');
            $('.show-msg').html("<strong style='color:red'>You can not fill sales sheet of a temp user. Register this user first</strong><br/><a href='" + GlblURLs + "admin/data-tempuser/" + window.btoa(tempArr[1]) + "'>&nbsp;<button type='button' class='btn btn-secondary mt-3'> Register  </button></a>");
        }
        $('.sscustcat').hide();
    }
});



function populateSalesCategory(cid) {
    $('.all_flag').prop('checked', false);
    $('.loading').show();//go ahead
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/get-salessheet-category',
        type: 'POST',
        data: {
            'id': cid,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.userCatData.length > 0) {
                $.each(data.userCatData, function (k, v) {
                    $('#flag_' + v.cat_id).prop('checked', true);
                });
            }

            $('#grp_name').html(data.userData.g_id);
            $('#post_code').html(data.userData.com_zipCode);
            $('#user_email').html(data.userData.com_emailAddress);
            $('#user_phone_no').html(data.userData.com_Telephone);
            $('#user_buying_grp').html(data.userData.buying_group);
            $('#user_acnt_date').html(data.userData.regisdate);
            $('.loading').hide();//go ahead
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
            $('.loading').hide();//go ahead
        }
    });
}

$(document).on('click', '#populateAptLogs', function (e) {
    e.preventDefault();
    var u_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/getssapt-data-ajax',
        type: 'POST',
        data: {
            'u_id': u_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        beforeSend: function () {
            // setting a timeout
            $(".loader").show();
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.success == 1) {
                $('.populateLogs').html(data.html);
                $('#myModal').modal('show');
            }
            $(".loader").hide();
        },
        error: function (request, error)
        {
            alert("Error while fetching the config.");
        }
    });

});

$(document).on('click', '.viewAptlogs', function (e) {
    e.preventDefault();
    var u_id = $(this).data('uid');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/getssapt-data-ajax',
        type: 'POST',
        data: {
            'u_id': u_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        beforeSend: function () {
            // setting a timeout
            $(".loader").show();
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.success == 1) {
                $('.populateLogs').html(data.html);
                $('#myModal').modal('show');
            }
            $(".loader").hide();
        },
        error: function (request, error)
        {
            alert("Error while fetching the config.");
        }
    });

});

$('.unitsQty').blur(function () {
    var qty = parseFloat($(this).val());
    var fqty = parseFloat($(this).siblings('.addWhite').children('.funitsQty').val());
    if (fqty > 0) {
        var fper = parseFloat((fqty / qty) * 100);
        $(this).siblings('.addWhite').children('.funitPer').val(fper.toFixed(2));
    }
});

$('.funitsQty').blur(function () {
    var fqty = parseFloat($(this).val());
    var qty = parseFloat($(this).parent('.addWhite').siblings('.unitsQty').val());
    if (fqty > 0) {
        var fper = parseFloat((fqty / qty) * 100);
        $(this).siblings('.funitPer').val(fper.toFixed(2));
    }
});

$('.grossSale').blur(function () {
    var qty = parseFloat($(this).val());
    var fqty = parseFloat($('.grossFaulty').val());
    if (fqty > 0) {
        var fper = parseFloat((fqty / qty) * 100);
        $('.grossFaultyPer').val(fper.toFixed(2));
    }
});
$('.grossFaulty').blur(function () {
    var fqty = parseFloat($(this).val());
    var qty = parseFloat($('.funitsQty').val());
    if (fqty > 0) {
        var fper = parseFloat((fqty / qty) * 100);
        $('.grossFaultyPer').val(fper.toFixed(2));
    }
});



$(document).on('click', '.editTempCustomer', function () {
    $('#titleText').html('Approve Temp Customer');
    $('#submitCust').html('Approve');
    // $('.sendpwdradio').show();
    $('#requestEmailID').attr('readonly', true);
    $('#tempcustRegister').attr('action', GlblURLs + "admin/edit-tempuser");
    var customer_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-tempuser-ajax',
        type: 'POST',
        data: {
            'id': customer_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            $('#u_id').val(data.users['u_id']);
            $('#companyName').val(data.users['firstName']);
            //$('#requestLName').val(data.users['lastName']);
            $('#com_city').val(data.users['com_city']);
            $('#com_zipCode').val(data.users['com_zipCode']);
            $('.cust-form').show();

            scrollToCustomerForm();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});

$(document).on('click', '#checkAllStatus', function () {
    if (this.checked) {
        $('.statusCrossButt').show();
    } else {
        $('.statusCrossButt').hide();
    }
    $('input:checkbox.changeStatusCrossref').not(this).prop('checked', this.checked);
});

$(document).on('click', '.changeStatusCrossref', function () {
    var checkid = [];
    var crossbut = 0;
    $('input:checkbox.changeStatusCrossref').each(function () {
        var sThisVal = (this.checked ? this.id : "");
        if (sThisVal > 0) {
            checkid.push(sThisVal);
            crossbut = 1;
        }
    });
    if (crossbut > 0) {
        $('.statusCrossButt').show();
    } else {
        $('.statusCrossButt').hide();
    }
});

$(document).on('click', '#changeStatuscrossRef', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.changeStatusCrossref').each(function () {
            var sThisVal = '';
            if (this.checked) {
                sThisVal = this.id;
                checkid.push(sThisVal);
            }
            // var sThisVal = (this.checked ? this.id :"");

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/changestatus-crossref-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Cross refrences status changed successfully");
                    location.reload();
                } else {
                    alert("Error while changing status of  cross refrences");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});


$(document).on('click', '.resendPwd', function () {
    var userid = $(this).data('id');
    $(this).text('Please Wait');
    var r = confirm("Are you sure?");
    if (r == true) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/resend-pwd-user',
            type: 'POST',
            data: {
                'ids': userid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                //console.log(data);
                $('.resendPwd').text('Re-send');
                if (data.status == 1) {
                    alert("The new password is " + data.pwd);
                } else {
                    alert("Error while resending new password");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});

$(document).on('click', '.editProdDesc', function () {
    var prod_nm = $(this).data('id');
    scrollToCustomerForm();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-productdesc-ajax',
        type: 'POST',
        data: {
            'id': prod_nm,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {
            // console.log(data);
            $('.proddescform').show();
            $('#prod_name').val(data['prod_nm']);
            $('#prod_add_inf').val(data['prod_add_inf']);
            $('#prod_desc').val(data['prod_desc']);
            $('#prod_nm').val(data['prod_nm']);
            $('#prod_part_no').val(data['prod_part_no']);
            $('#prod_stock').val(data['prod_stock']);
            $('#prod_price').val(data['prod_price']);
            $('#is_latest').val(data['is_latest']);
            $('#mscode').val(data['mscode']);
            CKEDITOR.instances.prod_overview.setData(data['prod_overview']);


            if (data['prod_dim'] != undefined && data['prod_dim'] != '') {
                $('.prod_dim').prop('checked', true);
                $('#prod_dim').attr('disabled', false);
                $('#prod_dim').val(data['prod_dim']);
            }
            if (data['prod_volt'] != undefined && data['prod_volt'] != '') {
                $('.prod_volt').prop('checked', true);
                $('#prod_volt').attr('disabled', false);
                $('#prod_volt').val(data['prod_volt']);
            }
            if (data['prod_out'] != undefined && data['prod_out'] != '') {
                $('.prod_out').prop('checked', true);
                $('#prod_out').attr('disabled', false);
                $('#prod_out').val(data['prod_out']);
            }
            if (data['prod_regu'] != undefined && data['prod_regu'] != '') {
                $('.prod_regu').prop('checked', true);
                $('#prod_regu').attr('disabled', false);
                $('#prod_regu').val(data['prod_regu']);
            }
            if (data['prod_pull_type'] != undefined && data['prod_pull_type'] != '') {
                $('.prod_pull_type').prop('checked', true);
                $('#prod_pull_type').attr('disabled', false);
                $('#prod_pull_type').val(data['prod_pull_type']);
            }
            if (data['prod_fan'] != undefined && data['prod_fan'] != '') {
                $('.prod_fan').prop('checked', true);
                $('#prod_fan').attr('disabled', false);
                $('#prod_fan').val(data['prod_fan']);
            }
            if (data['prod_teeth'] != undefined && data['prod_teeth'] != '') {
                $('.prod_teeth').prop('checked', true);
                $('#prod_teeth').attr('disabled', false);
                $('#prod_teeth').val(data['prod_teeth']);
            }
            if (data['prod_trans'] != undefined && data['prod_trans'] != '') {
                $('.prod_trans').prop('checked', true);
                $('#prod_trans').attr('disabled', false);
                $('#prod_trans').val(data['prod_trans']);
            }
            if (data['prod_rot'] != undefined && data['prod_rot'] != '') {
                $('.prod_rot').prop('checked', true);
                $('#prod_rot').attr('disabled', false);
                $('#prod_rot').val(data['prod_rot']);
            }

            if (data['ptype'] != undefined && data['ptype'] != '') {
                $('.ptype').prop('checked', true);
                $('#ptype').attr('disabled', false);
                $('#ptype').val(data['ptype']);
            }
            if (data['position'] != undefined && data['position'] != '') {
                $('.position').prop('checked', true);
                $('#position').attr('disabled', false);
                $('#position').val(data['position']);
            }
            if (data['gr'] != undefined && data['gr'] != '') {
                $('.gr').prop('checked', true);
                $('#gr').attr('disabled', false);
                $('#gr').val(data['gr']);
            }
            if (data['car_fits'] != undefined && data['car_fits'] != '') {
                $('.car_fits').prop('checked', true);
                $('#car_fits').attr('disabled', false);
                $('#car_fits').val(data['car_fits']);
            }
            if (data['fuel'] != undefined) {
                $('.fuel').prop('checked', true);
                $('#fuel').attr('disabled', false);
                $('#fuel').val(data['fuel']);
            }
            if (data['external_teeth'] != undefined && data['external_teeth'] != '') {
                $('.external_teeth').prop('checked', true);
                $('#external_teeth').attr('disabled', false);
                $('#external_teeth').val(data['external_teeth']);
            }
            if (data['internal_teeth'] != undefined && data['internal_teeth'] != '') {
                $('.internal_teeth').prop('checked', true);
                $('#internal_teeth').attr('disabled', false);
                $('#internal_teeth').val(data['internal_teeth']);
            }
            if (data['height'] != undefined && data['height'] != '') {
                $('.height').prop('checked', true);
                $('#height').attr('disabled', false);
                $('#height').val(data['height']);
            }
            if (data['abs_ring'] != undefined && data['abs_ring'] != '') {
                $('.abs_ring').prop('checked', true);
                $('#abs_ring').attr('disabled', false);
                $('#abs_ring').val(data['abs_ring']);
            }
            if (data['cylinders'] != undefined && data['cylinders'] != '') {
                $('.cylinders').prop('checked', true);
                $('#cylinders').attr('disabled', false);
                $('#cylinders').val(data['Piston_Dia']);
            }
            // start/end
            if (data['Weight'] != undefined && data['Weight'] != '') {
                $('.Weight').prop('checked', true);
                $('#Weight').attr('disabled', false);
                $('#Weight').val(data['Weight']);
            }
            if (data['Disc_Dia'] != undefined && data['Disc_Dia'] != '') {
                $('.Disc_Dia').prop('checked', true);
                $('#Disc_Dia').attr('disabled', false);
                $('#Disc_Dia').val(data['Disc_Dia']);
            }
            if (data['Disc_Thick'] != undefined && data['Disc_Thick'] != '') {
                $('.Disc_Thick').prop('checked', true);
                $('#Disc_Thick').attr('disabled', false);
                $('#Disc_Thick').val(data['Disc_Thick']);
            }
            if (data['Piston_Dia'] != undefined && data['Piston_Dia'] != '') {
                $('.Piston_Dia').prop('checked', true);
                $('#Piston_Dia').attr('disabled', false);
                $('#Piston_Dia').val(data['Piston_Dia']);
            }
            if (data['Man'] != undefined && data['Man'] != '') {
                $('.Man').prop('checked', true);
                $('#Man').attr('disabled', false);
                $('#Man').val(data['Man']);
            }
            if (data['Pump_Type'] != undefined && data['Pump_Type'] != '') {
                $('.Pump_Type').prop('checked', true);
                $('#Pump_Type').attr('disabled', false);
                $('#Pump_Type').val(data['Pump_Type']);
            }
            if (data['Pressure'] != undefined && data['Pressure'] != '') {
                $('.Pressure').prop('checked', true);
                $('#Pressure').attr('disabled', false);
                $('#Pressure').val(data['Pressure']);
            }
            if (data['Pully_Ribs'] != undefined && data['Pully_Ribs'] != '') {
                $('.Pully_Ribs').prop('checked', true);
                $('#Pully_Ribs').attr('disabled', false);
                $('#Pully_Ribs').val(data['Pully_Ribs']);
            }
            if (data['Total_Length'] != undefined && data['Total_Length'] != '') {
                $('.Total_Length').prop('checked', true);
                $('#Total_Length').attr('disabled', false);
                $('#Total_Length').val(data['Total_Length']);
            }
            if (data['Pin'] != undefined && data['Pin'] != '') {
                $('.Pin').prop('checked', true);
                $('#Pin').attr('disabled', false);
                $('#Pin').val(data['Pin']);
            }
            if (data['Fitting_position'] != undefined && data['Fitting_position'] != '') {
                $('.Fitting_position').prop('checked', true);
                $('#Fitting_position').attr('disabled', false);
                $('#Fitting_position').val(data['Fitting_position']);
            }
            if (data['No_of_Holes'] != undefined && data['No_of_Holes'] != '') {
                $('.No_of_Holes').prop('checked', true);
                $('#No_of_Holes').attr('disabled', false);
                $('#No_of_Holes').val(data['No_of_Holes']);
            }
            if (data['Bolt_Hole_Circle_Dia'] != undefined && data['Bolt_Hole_Circle_Dia'] != '') {
                $('.Bolt_Hole_Circle_Dia').prop('checked', true);
                $('#Bolt_Hole_Circle_Dia').attr('disabled', false);
                $('#Bolt_Hole_Circle_Dia').val(data['Bolt_Hole_Circle_Dia']);
            }
            if (data['Inner_Dia'] != undefined && data['Inner_Dia'] != '') {
                $('.Inner_Dia').prop('checked', true);
                $('#Inner_Dia').attr('disabled', false);
                $('#Inner_Dia').val(data['Inner_Dia']);
            }
            if (data['Outer_Dia'] != undefined && data['Outer_Dia'] != '') {
                $('.Outer_Dia').prop('checked', true);
                $('#Outer_Dia').attr('disabled', false);
                $('#Outer_Dia').val(data['Outer_Dia']);
            }

            if (data['Teeth_wheel_side'] != undefined && data['Teeth_wheel_side'] != '') {
                $('.Teeth_wheel_side').prop('checked', true);
                $('#Teeth_wheel_side').attr('disabled', false);
                $('#Teeth_wheel_side').val(data['Teeth_wheel_side']);
            }

            if (data['Teeth_Diff_Side'] != undefined && data['Teeth_Diff_Side'] != '') {
                $('.Teeth_Diff_Side').prop('checked', true);
                $('#Teeth_Diff_Side').attr('disabled', false);
                $('#Teeth_Diff_Side').val(data['Teeth_Diff_Side']);
            }
            if (data['Min_Th'] != undefined && data['Min_Th'] != '') {
                $('.Min_Th').prop('checked', true);
                $('#pr_Min_Th').attr('disabled', false);
                $('#pr_Min_Th').val(data['Min_Th']);
            }
            if (data['Max_Th'] != undefined && data['Max_Th'] != '') {
                $('.Max_Th').prop('checked', true);
                $('#pr_Max_Th').attr('disabled', false);
                $('#pr_Max_Th').val(data['Max_Th']);
            }
            if (data['Centre_Dia'] != undefined && data['Centre_Dia'] != '') {
                $('.Centre_Dia').prop('checked', true);
                $('#pr_Centre_Dia').attr('disabled', false);
                $('#pr_Centre_Dia').val(data['Centre_Dia']);
            }
            if (data['PCD'] != undefined && data['PCD'] != '') {
                $('.PCD').prop('checked', true);
                $('#pr_PCD').attr('disabled', false);
                $('#pr_PCD').val(data['PCD']);
            }
            if (data['Disc_Type'] != undefined && data['Disc_Type'] != '') {
                $('.Disc_Type').prop('checked', true);
                $('#pr_Disc_Type').attr('disabled', false);
                $('#pr_Disc_Type').val(data['Disc_Type']);
            }
            if (data['Width'] != undefined && data['Width'] != '') {
                $('.Width').prop('checked', true);
                $('#pr_Width').attr('disabled', false);
                $('#pr_Width').val(data['Width']);
            }
            if (data['F_R'] != undefined && data['F_R'] != '') {
                $('.F_R').prop('checked', true);
                $('#pr_F_R').attr('disabled', false);
                $('#pr_F_R').val(data['F_R']);
            }


            if (data['prod_img1'] != '' && data['prod_img1'] != undefined && data['prod_img1'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img1'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="1" >Remove</button>';
                $('#prod_img1').html(img1);
            }
            if (data['prod_img2'] != '' && data['prod_img2'] != undefined && data['prod_img2'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img2'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="2" >Remove</button>';
                $('#prod_img2').html(img1);
            }
            if (data['prod_img3'] != '' && data['prod_img3'] != undefined && data['prod_img3'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img3'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="3" >Remove</button>';
                $('#prod_img3').html(img1);
            }
            if (data['prod_img4'] != '' && data['prod_img4'] != undefined && data['prod_img4'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img4'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="4" >Remove</button>';
                $('#prod_img4').html(img1);
            }
            if (data['prod_img5'] != '' && data['prod_img5'] != undefined && data['prod_img5'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img5'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="5" >Remove</button>';
                $('#prod_img5').html(img1);
            }
            if (data['prod_img6'] != '' && data['prod_img6'] != undefined && data['prod_img6'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img6'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="6" >Remove</button>';
                $('#prod_img6').html(img1);
            }
            if (data['prod_img7'] != '' && data['prod_img7'] != undefined && data['prod_img7'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img7'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="7" >Remove</button>';
                $('#prod_img7').html(img1);
            }
            if (data['prod_img8'] != '' && data['prod_img8'] != undefined && data['prod_img8'] != null) {
                var img1 = '<img style="height:100px;width:150px;"  src="' + imgUrl + '/product/' + data['prod_img8'] + '">';
                img1 += '<button type="button" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  mt-2 text-uppercase removeImageBtn" data-id="' + data['prod_id'] + '" data-name="' + data['prod_nm'] + '" data-img="8" >Remove</button>';
                $('#prod_img8').html(img1);
            }
            // end


            $("#cstatus").val(data['prod_status']);
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$(document).on('click', '.removeImageBtn', function () {

    var id = $(this).data('id');
    var img = $(this).data('img');
    var imgname = $(this).data('name');
    var r = confirm("Are you sure?");
    if (r == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-productimagesingle-ajax',
            type: 'POST',
            data: {
                'id': id,
                'img': img,
                'imgname': imgname,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Image deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting image");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }
});

$(document).on('click', '.editPrivacyPolicy', function () {
    $('#titleText').html('Edit Privacy Policy');
    $('.privacy-policy-form').show();
    $('#privacyRegister').attr('action', GlblURLs + "admin/edit-privacypolicy");
    var customer_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-privacypolicy-ajax',
        type: 'POST',
        data: {
            'id': customer_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            $('#id').val(data['id']);
            $('#privacy_title').val(data['privacy_title']);
            CKEDITOR.instances.privacy_text.setData(data['privacy_text']);
            scrollToCustomerForm();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});

$(document).on('click', '.editTerms', function () {
    $('#titleText').html('Edit Terms & Conditions');
    $('.privacy-policy-form').show();
    $('#privacyRegister').attr('action', GlblURLs + "admin/edit-terms");
    var customer_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-terms-ajax',
        type: 'POST',
        data: {
            'id': customer_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            $('#id').val(data['id']);
            $('#term_title').val(data['term_title']);
            CKEDITOR.instances.term_text.setData(data['term_text']);
            scrollToCustomerForm();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});

$(document).on('click', '.editCustomerAddress', function () {
    $('#titleText').html('Edit Customer Address');
    $('#custAddRegister').attr('action', GlblURLs + "admin/edit-useraddress");
    var add_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-useraddress-ajax',
        type: 'POST',
        data: {
            'id': add_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            $('#u_id').val(data['id']);
            $('#user_id').val(data['user_id']);
            $('#addresstypeother').val(data['addresstypeother']);
            $('#streetAddress1other').val(data['streetAddress1other']);
            $('#streetAddress2other').val(data['streetAddress2other']);
            $('#com_cityother').val(data['com_cityother']);
            $('#com_stateother').val(data['com_stateother']);
            $('#com_zipCodeother').val(data['com_zipCodeother']);
            scrollToCustomerForm();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});


$(document).on('click', '#deleteApplication', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteCrossref').each(function () {

            if (this.checked) {
                sThisVal = this.id;
                checkid.push(sThisVal);
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-application-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Applications deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting applications");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});



$(document).on('click', '.editPopup', function () {
    $('#titleText').html('Edit Popup');
    $('#newsRegister').attr('action', GlblURLs + "admin/edit-popup");
    var add_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/edit-popup-ajax',
        type: 'POST',
        data: {
            'id': add_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            $('#p_id').val(data['p_id']);
            $('#p_title').val(data['p_title']);
            CKEDITOR.instances.p_content.setData(data['p_content']);
            $('#p_status').val(data['p_status']);
            if (data['p_image'] != '' && data['p_image'] != undefined && data['p_image'] != null) {
                $('#p_image_div').html('<img style="height:100px;width:150px;"  src="' + imgUrl + '/popup/' + data['p_image'] + '">');
            }
            scrollToCustomerForm();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});

$(document).on('click', '#deleteMscode', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteCrossref').each(function () {

            if (this.checked) {
                sThisVal = this.id;
                checkid.push(sThisVal);
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-mscode-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Mscode deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting mscode");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});

$(document).on('click', '.deleteprod', function () {
    var checkid = [];
    var crossbut = 0;
    $('input:checkbox.deleteprod').each(function () {
        var sThisVal = (this.checked ? this.id : "");

        if (sThisVal != '') {
            checkid.push(sThisVal);
            crossbut = 1;
        }
    });

    if (crossbut > 0) {
        $('.deleteCrossButt').show();
    } else {
        $('.deleteCrossButt').hide();
    }
});

$(document).on('click', '#deleteProduct', function () {
    var checkid = [];

    var r = confirm("Are you sure?");
    if (r == true) {
        $('input:checkbox.deleteprod').each(function () {

            if (this.checked) {
                sThisVal = this.id;
                checkid.push(sThisVal);
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: GlblURLs + 'admin/delete-product-ajax',
            type: 'POST',
            data: {
                'ids': checkid,
                '_token': $('meta[name="csrf_token"]').attr('content')
            },
            dataType: 'JSON',
            success: function (data) {
                if (data == 1) {
                    alert("Product(s) deleted successfully");
                    location.reload();
                } else {
                    alert("Error while deleting product(s)");
                }
            },
            error: function (request, error)
            {
                alert("Error while edit  data");
            }
        });
    } else {
        return false;
    }

});

$('#comp_name').change(function () {
    var hreftochange = $('#exporttoExcelComp').attr('href');

    $("#exporttoExcelComp").attr("href", hreftochange + '&comp_name=' + $(this).val());
    //console.log(hreftochange + '&comp_name='+$(this).val());
});

$(document).on('click', '.restoreDelCustomer', function () {

    var customer_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/restore-deluser-ajax',
        type: 'POST',
        data: {
            'id': customer_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            alert("Customer data restored successfully");
            location.reload();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});
$(document).on('click', '.restoreDelTempUser', function () {

    var customer_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: GlblURLs + 'admin/restore-deltempuser-ajax',
        type: 'POST',
        data: {
            'id': customer_id,
            '_token': $('meta[name="csrf_token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) {

            alert("Temp Customer data restored successfully");
            location.reload();
        },
        error: function (request, error)
        {
            alert("Error while edit  data");
        }
    });
});