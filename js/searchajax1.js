$(document).ready(function () {
    $('#roll_make,#roll_model,#roll_year,#roll_exact_ccm,#roll_engine_code').attr('readonly', true);
    // make populate
    $('#roll_product').change(function () {

        $('#roll_product_val').val($(this).find(":selected").val() + '_' + $(this).find(":selected").text());
        $.ajax({
            url: "ajax1/getMakeAjax.php",
            type: "post",
            data: {'catid': $(this).val()},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
				//console.log(data);
                var html = '';
                var data = JSON.parse(data);
							//	console.log(data);
                if (data.status == 1) {
                    html += '<option value="">Select</option>';
                    $.each(data.data, function (index, item) {
                        html += '<option value="' + item.make_id + '">' + item.make_nm + '</option>';
                    });
                    $('#roll_make').attr('readonly', false);
                    $("#loading-image").hide();
                } else if (data.status == 2) {
                    $('#roll_make').attr('readonly', true);
                    html += '<option value="">No make found</option>';
                    $('#roll_model').html('');
                    $('#roll_year').html('');
                    $('#roll_exact_ccm').html('');
                    $('#roll_engine_code').html('');

                    $("#loading-image").hide();
                } else {
                    $('#roll_make').attr('readonly', true);
                    html += '<option value="">No make found</option>';
                    $("#loading-image").hide();
                }
                $('#roll_make').html(html);
            }
        });
    });

    // model populate
    $('#roll_make').change(function () {
        $('#roll_make_val').val($(this).find(":selected").val() + '_' + $(this).find(":selected").text());
        $.ajax({
            url: "ajax1/getModelAjax.php",
            type: "post",
            data: {'makeid': $(this).val(), 'catid': $('#roll_product').val()},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var html = '';

                var data = JSON.parse(data);
                if (data.status == 1) {
                    html += '<option value="">Select</option>';
                    $.each(data.data, function (index, item) {
                        html += '<option value="' + item.model_id + '">' + item.model_nm + '</option>';
                    });
                    $('#roll_model').attr('readonly', false);
                    $("#loading-image").hide();
                } else if (data.status == 2) {
                    $('#roll_model').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                } else {
                    $('#roll_model').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                }
                $('#roll_model').html(html);
            }
        });
    });


    // year populate
    $('#roll_model').change(function () {
        $('#roll_model_val').val($(this).find(":selected").val() + '_' + $(this).find(":selected").text());
        $.ajax({
            url: "ajax1/getYearAjax.php",
            type: "post",
            data: {'modelid': $(this).val(), 'makeid': $('#roll_make').val(), 'catid': $('#roll_product').val()},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var html = '';

                var data = JSON.parse(data);
                if (data.status == 1) {
                    html += '<option value="">Select</option>';
                    $.each(data.data, function (index, item) {
						if(item.current_flag ==1){
							html += '<option value="' + item.proyr_id + '">On</option>';
						}else{
							if (item.proyr_to == 0) {
								item.proyr_to = 'On';
							}
							html += '<option value="' + item.proyr_id + '">' + item.proyr_from + '-' + item.proyr_to + '</option>';
						}
                        
                    });
                    $('#roll_year').attr('readonly', false);
                    $("#loading-image").hide();
                } else if (data.status == 2) {
                    $('#roll_year').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                } else {
                    $('#roll_year').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                }
                $('#roll_year').html(html);
            }
        });
    });


    // exact ccm populate
    $('#roll_year').change(function () {
        $('#roll_year_val').val($(this).find(":selected").val() + '_' + $(this).find(":selected").text());
        $.ajax({
            url: "ajax1/getCCMAjax.php",
            type: "post",
            data: {'yrid': $(this).val(), 'modelid': $('#roll_model').val(), 'makeid': $('#roll_make').val(), 'catid': $('#roll_product').val()},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var html = '';

                var data = JSON.parse(data);
                if (data.status == 1) {
                    html += '<option value="">Select</option>';
                    $.each(data.data, function (index, item) {
                        html += '<option value="' + item.proccm_id + '">' + item.proccm_inf + '</option>';
                    });
                    $('#roll_exact_ccm').attr('readonly', false);
                    $("#loading-image").hide();
                } else if (data.status == 2) {
                    $('#roll_exact_ccm').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                } else {
                    $('#roll_exact_ccm').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                }
                $('#roll_exact_ccm').html(html);
            }
        });
    });


    // exact engine code populate
    $('#roll_exact_ccm').change(function () {
        $('#roll_exact_ccm_val').val($(this).find(":selected").val() + '_' + $(this).find(":selected").text());
        $.ajax({
            url: "ajax1/getEngineCodeAjax.php",
            type: "post",
            data: {'ccmid': $(this).val(), 'yrid': $('#roll_year').val(), 'modelid': $('#roll_model').val(), 'makeid': $('#roll_make').val(), 'catid': $('#roll_product').val()},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var html = '';

                var data = JSON.parse(data);
                if (data.status == 1) {
                    html += '<option value="">Select</option>';
                    $.each(data.data, function (index, item) {
                        html += '<option value="' + item.engcode_id + '">' + item.engcode_inf + '</option>';
                    });
                    $('#roll_engine_code').attr('readonly', false);
                    $("#loading-image").hide();
                } else if (data.status == 2) {
                    $('#roll_engine_code').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                } else {
                    $('#roll_engine_code').attr('readonly', true);
                    html += '<option value="">No model found</option>';
                    $("#loading-image").hide();
                }
                $('#roll_engine_code').html(html);
            }
        });
    });

    $('#roll_engine_code').change(function () {
        $('#roll_engine_code_val').val($(this).find(":selected").val() + '_' + $(this).find(":selected").text());
    });


    $('.openmodel').click(function () {
        $.ajax({
            url: "spare-model.php",
            type: "post",
            data: {'sid': $(this).data('spareid')},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                $('.sparemodalajax').html(data);
                $('#mySparDeat').modal('show');
            }
        });

    });
    $('#cart_quan_val').prop("readonly",true);
//    $('#cart_quan_val').keyup(function () {
//        if ($(this).val() < 0) {
//            $(this).val('1');
//        }
//        $('#prod_amnt').text(parseFloat(Math.round(parseInt($('#prod_base_amnt').text()) * $(this).val() * 100) / 100).toFixed(2));
//    });


    $('.add , .sub').click(function () {
		var amnt = $('#prod_base_amnt').val();
		//console.log(amnt);
		if(amnt === 0){
			$('#prod_amnt').text(parseFloat(Math.round(parseFloat($('#prod_base_amnt').val()) * $('#cart_quan_val').val() * 100) / 100).toFixed(2));
		}else{
			$('#prod_amnt').text(parseFloat(Math.round(parseFloat($('#prod_base_amnt').val()) * $('#cart_quan_val').val() * 100) / 100).toFixed(2));
		}
    });


    $('#spcart_quan_val').keyup(function () {
        if ($(this).val() < 0) {
            $(this).val('1');
        }
        $('#sp_amnt').text(parseFloat(Math.round(parseFloat($('#sp_base_amnt').text()) * $(this).val() * 100) / 100).toFixed(2));
    });


    $('#spadd , #spsub').click(function () {
        $('#sp_amnt').text(parseFloat(Math.round(parseFloat($('#sp_base_amnt').text()) * $('#spcart_quan_val').val() * 100) / 100).toFixed(2));
    });



    $('#vcart_quan_val').keyup(function () {
        if ($(this).val() < 0) {
            $(this).val('1');
        }

        $('#vprod_amnt').text(parseFloat(Math.round(parseFloat($('#vprod_base_amnt').val()) * $(this).val() * 100) / 100).toFixed(2));
    });


    $('#vadd , #vsub').click(function () {
        //  alert($('#vprod_base_amnt').val());
        $('#vprod_amnt').text(parseFloat(Math.round(parseFloat($('#vprod_base_amnt').val()) * $('#vcart_quan_val').val() * 100) / 100).toFixed(2));
    });


///=======
    var sum = 0;
    $('.cartAdd , .cartSub').click(function () {
		//alert('here');

        var sum = 0;
        var bprice = $(this).data('baseprice');
		var cartid = $(this).data('cartid');
		var prodid = $(this).data('prodid');
		

		
		
        var quant = $(this).parents('td').find('.shopcart_quan_val').val();
		
		$.ajax({
            url: "ajax1/updateCartAjax.php",
            type: "post",
            data: {'prodid': prodid, 'cartid': cartid, 'cartquant': quant},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == 1) {
                    //alert(" Product added to cart successfully");
                    //window.location = "shoppingCart.php";
                } else {
                    //alert(" Product already in cart");
                    //window.location = "shoppingCart.php";
                }
            }
        });
		
        var totalprice = parseFloat(Math.round(parseFloat(bprice * quant)* 100)/100).toFixed(2);
        $(this).closest('tr').find('td:nth-child(5)').text(totalprice);

        $('.tot-price').each(function () {
            sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
        });

		$('#total_price').text( sum.toFixed(2) );
		
		

    });

    $('.tot-price').each(function () {
        sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
    });

	$('#total_price').text( sum.toFixed(2) );





    $('#butAddTo').click(function () {
        var u_id = $('#u_id').val();
        var prod_id = $('#prod_id').val();
        var prod_qty = $('#cart_quan_val').val();
        var sp_check = 0;
        $.ajax({
            url: "ajax1/addCartAjax.php",
            type: "post",
            data: {'u_id': u_id, 'prod_id': prod_id, 'prod_qty': prod_qty, 'sp_check': sp_check},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == 1) {
                    //alert(" Product added to cart successfully");
                    window.location = "shoppingCart.php";
                } else {
                    //alert(" Product already in cart");
                    window.location = "shoppingCart.php";
                }
            }
        });
    });


    $('#spbutAddTo').click(function () {
        var u_id = $('#u_id').val();
        var prod_id = $('#prod_id').val();
        var prod_qty = $('#spcart_quan_val').val();
        var sp_check = 1;
        $.ajax({
            url: "ajax1/addCartAjax.php",
            type: "post",
            data: {'u_id': u_id, 'prod_id': prod_id, 'prod_qty': prod_qty, 'sp_check': sp_check},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == 1) {
                    alert(" Spare added to cart successfully");
                    window.location = "shoppingCart.php";
                } else {
                    alert(" Spare already in cart");
                    //window.location = "shoppingCart.php";
                }
            }
        });
    });


    $('.vaddCart').click(function () {
        var u_id = $('#u_id').val();
        var prod_id = $(this).data('prod_id');
        var prod_qty = $(this).closest('tr').find('td:nth-child(10)').find('.shopcart_quan_val').val();
        var sp_check = 0;
        $.ajax({
            url: "ajax1/addCartAjax.php",
            type: "post",
            data: {'u_id': u_id, 'prod_id': prod_id, 'prod_qty': prod_qty, 'sp_check': sp_check},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == 1) {
                    //alert(" Product added to cart successfully");
                    window.location = "shoppingCart.php";
                } else {
                    //alert(" Product already in cart");
                    window.location = "shoppingCart.php";
                }
            }
        });
    });


    $('.vcartAdd , .vcartSub').click(function () {
        var sum = 0;
        var quant = $(this).parents('td').find('.shopcart_quan_val').val();
        $(this).closest('tr').find('td:nth-child(5)').text(totalprice);
        var u_id = $('#u_id').val();
        var prod_id = $('#prod_id').val();
        var prod_qty = $('#vcart_quan_val').val();
        var sp_check = 0;
        $.ajax({
            url: "ajax1/addCartAjax.php",
            type: "post",
            data: {'u_id': u_id, 'prod_id': prod_id, 'prod_qty': prod_qty, 'sp_check': sp_check},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == 1) {
                    //alert(" Product added to cart successfully");
                    window.location = "shoppingCart.php";
                } else {
                    //alert(" Product already in cart");
                    window.location = "shoppingCart.php";
                }
            }
        });
    });



    $('.spAddCart').click(function () {
        var u_id = $('#u_id').val();
        var prod_id = $(this).data('sp_id');
        var prod_qty = 1;
        var sp_check = 1;
        $.ajax({
            url: "ajax1/addCartAjax.php",
            type: "post",
            data: {'u_id': u_id, 'prod_id': prod_id, 'prod_qty': prod_qty, 'sp_check': sp_check},
            beforeSend: function () {
                $("#loading-image").show();
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == 1) {
                    window.location = "shoppingCart.php";
                } else {
                    //alert(" Spare already in cart");
                    window.location = "shoppingCart.php";
                }
            }
        });
    });


});