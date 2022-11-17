
function selectCustomer(cid, contrr, pgui1, cname, cadd1, cadd2, ph, email, discount = 0, cli_tax) {
    $('#customer_id').val(cid);
	if(cli_tax == null || cli_tax == '')
	{
		cli_tax = '999999990';
	}
	
	$('#customer_tax').val(cli_tax);
    $('#custom_discount').val(discount);
    $('#customer_name').html('<strong>' + cname + '</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html(cadd1+'<br>'+pgui1+' '+cadd2+'<br>'+contrr);
    //$('#customer_phone').html('Phone: <strong>' + ph + '</strong><br>Email: <strong>' + email + '</strong>');
    $("#customer-box").val();
    $("#customer-box-result").hide();
    $(".sbox-result").hide();
    $("#customer").show();
}


function def_timeout(ms) {
	var wait_obj = $.Deferred();
	setTimeout(wait_obj.resolve, ms);
	return wait_obj.promise();
}
///////////////////////////////////////////////////////////////////
function sleep(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}

//hjghj

const add2SecondsDelay = () => {
  return new Promise(resolve => {
    setTimeout(() => {
      resolve('added 2 seconds delay');
    }, 20000);
  });
}
async function asyncFunctionCall() {

  console.log('abc'); // ------> first step
  const result = await add2SecondsDelay();
  console.log("xyz"); // ------> second step will execute after 2 seconds

}

function PselectCustomer(cid, cname, discount, cli_tax) {
    $('#customer_id').val(cid);
	$('#customer_tax').val(cli_tax);
    $('#custom_discount').val(discount);
    $('#customer_name').html('<strong>' + cname + '</strong>');
	$("#customer-box").val();
    $("#customer-box-result").hide();
    $("#customer").show();
}

function selectSupplier(cid, contrr, cname, cadd1, cadd2, ph, email, cli_tax) {
    $('#customer_id').val(cid);
	$('#customer_tax').val(cli_tax);
	$('#customer_tax_name').html('<strong>' + cli_tax + '</strong>');
    $('#customer_tax_name').val(cname);
    $('#customer_name').html('<strong>' + cname + '</strong>');
    $('#customer_name').val(cname);
	$('#customer_address1').html(cadd1+'<br>'+cadd2+'<br>'+contrr);
    //$('#customer_phone').html('Phone: <strong>' + ph + '</strong><br>Email: <strong>' + email + '</strong>');
    $("#supplier-box").val();
    $("#supplier-box-result").hide();
    $("#customer").show();
}


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 44 || charCode > 57)) {
        return false;
    }
    return true;
}

function selectCustomerGuide(cid, pgui1, pgui2, pgui3, pgui4, cname, cadd1, cadd2, ph, email, discount = 0, cli_tax) {
    $('#customer_id').val(cid);
	if(cli_tax == null || cli_tax == '')
	{
		cli_tax = '999999990';
	}
	$('#customer_tax').val(cli_tax);
    $('#custom_discount').val(discount);
    $('#customer_city_hi').val(cadd2);
    $('#customer_adr_hi').val(cadd1);
    $('#customer_post_box_hi').val(pgui1);
    $('#customer_country_hi').val(pgui2);
	
	$('#customer_name').html('<strong>' + cname + '</strong>');
    $('#customer_name').val(cname);
	
    $('#customer_address1').html('<strong>' + cadd1 + '<br>' + cadd2 + '</strong>');
    //$('#customer_phone').html('Phone: <strong>' + ph + '</strong><br>Email: <strong>' + email + '</strong>');
    $("#customer-box").val();
    $("#customer-box-result").hide();
    $(".sbox-result").hide();
    $("#customer").show();
}

$(document).ready(function () {

	$("#customer-box-guide").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearchguide',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer-box-guide").css("background", "none");

            }
        });
    });
	
    $("#customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearch',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer-box").css("background", "none");

            }
        });
    });

    $("#pos-customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/pos_c_search',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#pos-customer-box").css("background", "none");

            }
        });
    });

    $('#warehouses').change(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#pos_item").html(data);

            }
        });
    });


    $('#categories').change(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });


$('#search_bar').keyup(function () {
	var whr = $('#warehouses option:selected').val();
	var cat = $('#categories option:selected').val();
	$.ajax({
		type: "POST",
		url: baseurl + 'search_products/pos_search',
		data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
		beforeSend: function () {
			$("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
		},
		success: function (data) {

			$("#pos_item").html(data);

		}
	});
});
wait = true;

$("#supplier-box").keyup(function () {
	$.ajax({
		type: "GET",
		url: baseurl + 'search_products/supplier',
		data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
		beforeSend: function () {
			$("#supplier-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
		},
		success: function (data) {
			$("#supplier-box-result").show();
			$("#supplier-box-result").html(data);
			$("#supplier-box").css("background", "none");

		}
	});
});

$("#invoice-box").keyup(function () {
	$.ajax({
		type: "GET",
		url: baseurl + 'search/invoice',
		data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
		beforeSend: function () {
			$("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
		},
		success: function (data) {
			$("#invoice-box-result").show();
			$("#invoice-box-result").html(data);
			$("#invoice-box").css("background", "none");

		}
	});
});

$("#head-customerbox").keyup(function () {
	$.ajax({
		type: "GET",
		url: baseurl + 'search/customer',
		data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
		beforeSend: function () {
			$("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
		},
		success: function (data) {
			$("#head-customerbox-result").show();
			$("#head-customerbox-result").html(data);
			//$("#invoice-box").css("background", "none");

		}
	});
});


});
//make payment 

$(document).on('click', "#thermal_p", function (e) {
    var ptid = $(this).attr('data-ptid');
    e.preventDefault();
    $.ajax({
        url: baseurl + 'pos_invoices/thermal_print?id=' + ptid,
        dataType: 'json',
        data: crsf_token + '=' + crsf_hash,
        success: function (data) {
            if (data.status == 'Success') {
                $("#thermal_a").removeClass("alert-warning").addClass("alert alert-info").fadeIn();
                $("#thermal_a .message").html(data.message);
                $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
            } else {
                $("#thermal_a").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("#thermal_a .message").html(data.message);
                $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
            }
        }
    });
});

$(document).on('click', "#thermal_server", function (e) {
    var ptid = $(this).attr('data-ptid');
    var url = $(this).attr('data-url');
    e.preventDefault();
    $.ajax({
        url: url + '?id=' + ptid,
        data: crsf_token + '=' + crsf_hash,
        dataType: 'html',
        success: function (data) {
            $("#thermal_a").removeClass("alert-warning").addClass("alert alert-info").fadeIn();
            $("#thermal_a .message").html('Success');
            $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
        }
    });
});

//part
$(document).on('click', "#submitpayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/payinvoice';
    payInvoice(pyurl);

});
$(document).on('click', "#purchasepayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/paypurchase';

    payInvoice(pyurl);


});
$(document).on('click', "#recpayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/pay_recinvoice';

    payInvoice(pyurl);


});

function payInvoice(pyurl) {

    var errorNum = farmCheck();
    $("#part_payment").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: pyurl,
            type: 'POST',
            data: $('form.payment').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $('#activity').append(data.activity);
                    $('#rmpay').val(data.amt);
                    $('#paymade').text(data.ttlpaid);
                    $('#paydue').text(data.amt);

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}

//////////////send

function loadEmailTem(action) {

    jQuery.ajax({

        url: baseurl + 'emailinvoice/template',
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        beforeSend: function () {
            setTimeout(
                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request').hide();
            $('#emailbody').show();
            $('#subject').val(data.subject);
            $('.note-editable').html(data.message);


        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

$('.sendbill').click(function (e) {
    e.preventDefault();
    $('#emailtype').val($(this).attr('data-type'));
    $('#itype').val($(this).attr('data-itype'));

});
$('.sendsms').click(function (e) {
    e.preventDefault();
    $('#smstype').val($(this).attr('data-type'));

});
$("#sendEmail").on("show.bs.modal", function (e) {
    var action = 'ttype=' + $('#emailtype').val() + '&invoiceid=' + $('#invoiceid').val() + '&itype=' + $('#itype').val();
    loadEmailTem(action);
});

$("#sendSMS").on("show.bs.modal", function (e) {
    var action = 'ttype=' + $('#smstype').val() + '&invoiceid=' + $('#invoiceid').val();
    loadSmsTem(action);
});

function loadSmsTem(action) {

    jQuery.ajax({

        url: baseurl + 'sms/template',
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        beforeSend: function () {
            setTimeout(
                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request_sms').hide();
            $('#smsbody').show();
            $('#sms_tem').html(data.message);
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

$('#submitSMS').on('click', function (e) {
    e.preventDefault();
    $("#sendSMS").modal('hide');

    var action = 'mobile=' + $('#smstype').val() + '&message=' + $('#invoiceid').val();

    sendSms(action);

});

function sendSms(message) {
    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter mobile number!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + 'sms/send_sms',
            type: 'POST',
            data: $('#sendsms').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

//mail
function sendBill(message) {
    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter email!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + 'communication/send_invoice',
            type: 'POST',
            data: $('#sendbill').serialize() + '&message=' + encodeURIComponent(message) + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

////////////////////////////////////////////////////////////
//////////////cancel
$(document).on('click', "#cancel-bill", function (e) {
    e.preventDefault();
    $('#cancel_bill').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function () {
        var acturl = 'transactions/cancelinvoice';
        cancelBill(acturl);
    });
});

function cancelBill(acturl) {
    var $btn;
    var errorNum = farmCheck();
    $("#cancel_bill").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + acturl,
            type: 'POST',
            data: $('form.cancelbill').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
                setTimeout(function () {// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

/////// product add edit actions
//calcualtions
$("#calculate_income").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'reports/customincome';
    actionCaculate(actionurl);
});
$("#calculate_expense").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'reports/customexpense';
    actionCaculate(actionurl);
});

function actionCaculate(actionurl, f_name = '#product_action') {
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        $(".required").parent().removeClass("has-error");
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $(f_name).serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                //  $("#product_action").remove();
                $("#param1").html(data.param1);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
            }
        });
    }
}

$("#mclient_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'invoices/addcustomer';
    searchCS(actionurl);
});

function searchCS(actionurl) {
    var errorNum = farmCheck2();
    if (errorNum > 0) {
        $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#statusMsg").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
    } else {
        $(".crequired").parent().removeClass("has-error");
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == 'Success') {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                    $('#customer_id').val(data.cid);
                    $('#customer_name').html('<strong>' + $('#mcustomer_name').val() + '</strong>');
                    $('#customer_address1').html('<strong>' + $('#mcustomer_address1').val() + '<br>' + $('#mcustomer_city').val() + ',' + $('#mcustomer_country').val() + '</strong>');
                    $('#customer_phone').html('Phone: <strong>' + $('#mcustomer_phone').val() + '</strong><br>Email: <strong>' + $('#mcustomer_email').val() + '</strong>');
					$('#customer_tax').html('IVA: <strong>' + $('#mcustomer_tax').val() + '</strong>');
                    $('#customer_pass').html('Login Password ' + data.pass);
                    $('#custom_discount').val(data.discount);
                    $("#customer-box").val();
                    $("#customer-box-result").hide();
                    $("#customer").show();
                    $('#addCustomer').find('input:text,input:hidden').val('');
                    $("#addCustomer").modal('toggle');
                    $("#Pos_addCustomer").modal('toggle');
                } else {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
                }
            },
            error: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
            }
        });
    }
}

$("#msupplier_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'supplier/addsupplier';
    searchCSSuplier(actionurl);
});

function searchCSSuplier(actionurl) {
    var errorNum = farmCheck2();
    if (errorNum > 0) {
        $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#statusMsg").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
    } else {
        $(".crequired").parent().removeClass("has-error");
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == 'Success') {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                    $('#customer_id').val(data.cid);
                    $('#customer_name').html('<strong>' + $('#name').val() + '</strong>');
                    $('#customer_address1').html('<strong>' + $('#address').val() + '<br>' + $('#city').val() + ',' + $('#region').val() + '</strong>');
                    $('#customer_phone').html('Phone: <strong>' + $('#phone').val() + '</strong><br>Email: <strong>' + $('#email').val() + '</strong>');
					$('#customer_tax').val($('#taxid').val());
                    $('#addSupplier').find('input:text,input:hidden').val('');
                    $("#addSupplier").modal('toggle');
                } else {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
                }
            },
            error: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
            }
        });
    }
}


//task manager
$('.icheck-activity').click(function (e) {
    var actionurl = 'tools/set_task';
    var id = $(this)[0].value;
    var stat = '';
    var hid = $(this).attr('id');
    if ($(this)[0].checked) {
        stat = 'Done';
        $('#s' + hid).removeClass("task_Due").addClass('task_Done');
    } else {
        stat = 'Due';
        $('#s' + hid).removeClass("task_Done").addClass('task_Due');
    }
    $('#s' + hid).text(stat);
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        data: 'tid=' + id + '&stat=' + stat + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {

        }
    });

});

$(document).on('click', ".check", function (e) {
    e.preventDefault();
    var actionurl = 'tools/set_task';
    var rval = 'Due';
    var id = $(this).attr('data-id');
    var stat = $(this).attr('data-stat');
    if (stat == 'Done') {
        $(this).attr('data-stat', 'Due');
        $(this).toggleClass('text-success text-default');
    } else {
        $(this).toggleClass('text-default text-success');
        $(this).attr('data-stat', 'Done');
        rval = 'Done';
    }
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        data: 'tid=' + id + '&stat=' + rval + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
        }
    });
});

//universal list item delete from table
$(document).on('click', ".delete-object", function (e) {
    e.preventDefault();
    $('#object-id').val($(this).attr('data-object-id'));
	$('#object-tid').val($(this).attr('data-object-tid'));
    $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
	$(this).closest('tr').attr('tid', $(this).attr('data-object-tid'));
    $('#delete_model').modal({backdrop: 'static', keyboard: false});

});
$(document).on('click', ".delete-object2", function (e) {
    e.preventDefault();
	$('#object-id2').val($(this).attr('data-object-id'));
	$('#object-tid2').val($(this).attr('data-object-tid'));	
    $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
	$(this).closest('tr').attr('tid', $(this).attr('data-object-tid'));
    $('#delete_model2').modal({backdrop: 'static', keyboard: false});

});
$("#delete-confirm").on("click", function () {
	if($('#justification_cancel').val() == '')
	{
		alert('Por favor Inserir uma Justificação.');
		return;
	}
	var o_data = 'deleteid=' + $('#object-id').val()+'&'+'deletetid=' + $('#object-tid').val()+'&'+'draft=' + $('#object-tdraft').val()+'&'+'justification=' + $('#justification_cancel').val();
    var action_url = $('#delete_model #action-url').val();
    $('#' + $('#object-id').val()).remove();
	$('#' + $('#object-id').val()).remove();
	$('#' + $('#object-id').val()).remove();
    removeObject(o_data, action_url);
});

$("#delete-confirm2").on("click", function () {
	var o_data = 'deleteid=' + $('#object-id2').val()+'&'+'deletetid=' + $('#object-tid2').val()+'&'+'draft=' + $('#object-tdraft2').val();
    var action_url = $('#delete_model2 #action-url2').val();
    $('#' + $('#object-id2').val()).remove();
	$('#' + $('#object-tid2').val()).remove();
	$('#' + $('#object-tdraft2').val()).remove();
    removeObject(o_data, action_url);
});

function removeObject(action, action_url) {
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    jQuery.ajax({
        url: baseurl + action_url,
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });
}

//universal create
$("#submit-data-save").on("click", function (e) {
    e.preventDefault();
    $(this).hide();
    var o_data = $("#data_form").serialize();
    var action_url = $('#action-url').val();
    addObject(o_data, action_url);
    setTimeout(function(){  $("#submit-data-save").show(); }, 1000);
});

$("#submit-data-draft").on("click", function (e) {
    e.preventDefault();
    $(this).hide();
    var o_data = $("#data_form").serialize();
    var action_url = $('#action-url2').val();
    addObject(o_data, action_url);
    setTimeout(function(){  $("#submit-data-draft").show(); }, 1000);
});

//universal create
$("#submit-data").on("click", function (e) {
    e.preventDefault();
    $(this).hide();
    var o_data = $("#data_form").serialize();
    var action_url = $('#action-url').val();
    addObject(o_data, action_url);
    setTimeout(function(){  $("#submit-data").show(); }, 1000);
});


$("#submit-data1").on("click", function (e) {
    e.preventDefault();
	$(this).hide();
    var o_data = $("#data_form1").serialize();
    var action_url = $('#action-url1').val();7
    addObject(o_data, action_url);
	setTimeout(function(){  $("#submit-data1").show(); }, 1000);
});
$("#submit-data2").on("click", function (e) {
    e.preventDefault();
	$(this).hide();
    var o_data = $("#data_form2").serialize();
    var action_url = $('#action-url2').val();
    addObject(o_data, action_url);
	setTimeout(function(){  $("#submit-data2").show(); }, 1000);
});

$("#submit-data3").on("click", function (e) {
    e.preventDefault();
	$(this).hide();
    var o_data = $("#data_form3").serialize();
    var action_url = $('#action-url3').val();
    addObject(o_data, action_url);
	setTimeout(function(){  $("#submit-data3").show(); }, 1000);
});

$("#submit-data4").on("click", function (e) {
    e.preventDefault();
	$(this).hide();
    var o_data = $("#data_form4").serialize();
    var action_url = $('#action-url4').val();
    addObject(o_data, action_url);
	setTimeout(function(){  $("#submit-data4").show(); }, 1000);
});

$("#submit-data5").on("click", function (e) {
    e.preventDefault();
	$(this).hide();
    var o_data = $("#data_form5").serialize();
    var action_url = $('#action-url5').val();
    addObject(o_data, action_url);
	setTimeout(function(){  $("#submit-data5").show(); }, 1000);
});

$("#submit-data6").on("click", function (e) {
    e.preventDefault();
	$(this).hide();
    var o_data = $("#data_form6").serialize();
    var action_url = $('#action-url6').val();
    addObject(o_data, action_url);
	setTimeout(function(){  $("#submit-data6").show(); }, 1000);
});

function addObject(action, action_url) {
    var errorNum = farmCheck();
    var $btn;
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: Parece que se esqueceu de completar alguma coisa!");
        $("html, body").scrollTop($("body").offset().top);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: action + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {

                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#data_form").remove();
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

//
function actionProduct(actionurl) {
    var errorNum = farmCheck();

    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: Parece que se esqueceu de completar algo!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        $(".required").parent().removeClass("has-error");
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                //   $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
            }
        });
    }
}

//uni sender
$('#sendMail').on('click', '#sendNow', function (e) {
    e.preventDefault();
    var o_data = $("#sendmail_form").serialize();
    var action_url = $('#sendMail #action-url').val();
    sendMail_g(o_data, action_url);
});

$(document).on('click', "#upda", function (e) {
    e.preventDefault();
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: Parece que você se esqueceu dos detalhes!");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        var action_url = $("#core").val();
        $.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: $("#activ").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {

                if (data.status == 'Success') {
                    $("#notify .message").html("<strong>Success</strong>: Obrigada! Licença atualizada, atualize a página.");
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    setTimeout(function () {
                        window.location.href = baseurl;
                    }, 1000);
                } else if (data.status == 'WError') {
                    $("#notify .message").html("<strong>Error</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else if (data.status == 'Error') {
                    $("#notify .message").html("<strong>Error</strong>: " + data.message + " <a class='blue' href='https://pcteckserv.com/product/licenca-all1touch-1-mes/' target='_blank'>Faça a aquisição de uma nova licença</a> OR <a href='https://pcteckserv.com/product/licenca-all1touch-1-mes/terms' target='_blank'> leia os nossos Termos!</a>");
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else {
                    setTimeout(function () {
                        window.location.href = baseurl;
                    }, 100);
                }
            }
        });

    }
});


function sendMail_g(o_data, action_url) {
    var errorNum = farmCheck();
    $("#sendMail").modal('hide');
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }

    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
            }
        });
    }
}

//generic model

//part
$(document).on('click', "#submit_model", function (e) {
    e.preventDefault();
    var o_data = $("#form_model").serialize();
    var action_url = $('#form_model #action-url').val();
    $("#pop_model").modal('hide');
    saveMData(o_data, action_url);
});

$(document).on('click', "#submit_model2", function (e) {
    e.preventDefault();
    var o_data = $("#form_model2").serialize();
    var action_url = $('#form_model2 #action-url').val();
    $("#pop_model2").modal('hide');
    saveMData(o_data, action_url);
});

$(document).on('click', "#submit_model3", function (e) {
    e.preventDefault();
    var o_data = $("#form_model3").serialize();
    var action_url = $('#form_model3 #action-url').val();
    $("#pop_model3").modal('hide');
    saveMData(o_data, action_url);
});

function saveMData(o_data, action_url) {
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }
}

function miniDash() {
    var actionurl = $('#dashurl').val();
    var d_csrf = crsf_token + '=' + crsf_hash;
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        dataType: 'json',
        data: d_csrf,
        success: function (data) {
            var i = 0;
            //  var obj = jQuery.parseJSON(data);
            $.each(data, function (key, value) {
                for (ind in value) {
                    $('#dash_' + i).text(value[ind]);
                    i++;
                }
            });
        }
    });
}

//universal list item delete from table

$(document).on('click', ".delete-custom", function (e) {
    e.preventDefault();
    var did = $(this).attr('data-did');
    $('#object-id_' + did).val($(this).attr('data-object-id'));
    // $(this).closest('section').attr('id','d_'+$(this).attr('data-object-id'));
    $(this).closest("*[data-block]").attr('id', 'd_' + $(this).attr('data-object-id'));

    $('#delete_model_' + did).modal({backdrop: 'static', keyboard: false});
    // $("#notify .message")
    $('#delete_model_' + did + ' .delete-confirm').attr('data-mid', did);
});

$(".delete-confirm").on("click", function () {
    var did = $(this).attr('data-mid');
    var o_data = $('#mform_' + did).serialize();
    var action_url = $('#action-url_' + did).val();
    $('#d_' + $('#object-id_' + did).val()).remove();
    removeObject_c(o_data, action_url);
});

function removeObject_c(action, action_url) {

    jQuery.ajax({
        url: baseurl + action_url,
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

$("#copy_address").change(function () {
    if ($(this).prop("checked") == true) {
        // alert("Checkbox is checked." );
        $('#mcustomer_name_s').val($('#mcustomer_name').val());
        $('#mcustomer_phone_s').val($('#mcustomer_phone').val());
        $('#mcustomer_email_s').val($('#mcustomer_email').val());
        $('#mcustomer_address1_s').val($('#mcustomer_address1').val());
        $('#mcustomer_city_s').val($('#mcustomer_city').val());
        $('#region_s').val($('#region').val());
        $('#mcustomer_country_s').val($('#mcustomer_country').val());
        $('#postbox_s').val($('#postbox').val());
    } else {
        $('#mcustomer_name_s').val('');
        $('#mcustomer_phone_s').val('');
        $('#mcustomer_email_s').val('');
        $('#mcustomer_address1_s').val('');
        $('#mcustomer_city_s').val('');
        $('#region_s').val('');
        $('#mcustomer_country_s').val('');
        $('#postbox_s').val('');
    }
});

$(document).on('click', ".apply_coupon", function (e) {
    e.preventDefault();
    var actionurl = 'pos_invoices/set_coupon';
    var coupon = $('#coupon').val();

    $.ajax({

        url: baseurl + actionurl,
        type: 'POST',
        data: 'coupon=' + coupon + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            $('#r_coupon').html(data.message);
            if (data.status == 'Success') $('#i_coupon').val(data.message);
            $('#coupon_amount').val(accounting.unformat(data.amount, accounting.settings.number.decimal));
            billUpyogInv();
        }

    });
});


//////Todas as funções para Relações///////////////
////////////////////////////////////////////////////
$(document).on('click', ".related-object", function (e) {
    e.preventDefault();
	$("#relations-id").val($(this).attr('data-object-id'));
	$("#relations-type").val($(this).attr('data-object-type'));
	$("#relations-ext").val($(this).attr('data-object-ext'));
	$('#relations-type_n').val($(this).attr('data-object-type_n'));
	
    $('#titulo_relationt').text('O documento '+$(this).attr('data-object-type_n')+' '+$(this).attr('data-object-type_s')+' '+$(this).attr('data-object-serie')+'/'+$(this).attr('data-object-tid')+' teve origem nos documentos abaixo (Está conciliado com)');
	$('#titulo_relationd').text('O documento '+$(this).attr('data-object-type_n')+' '+$(this).attr('data-object-type_s')+' '+$(this).attr('data-object-serie')+'/'+$(this).attr('data-object-tid')+' deu origem aos documentos abaixo (Foi conciliado com)');
	
	var table = document.getElementById("relationsdview");
		table.innerHTML = '<thead><tr><th width="10%">Documento</th><th width="12%">Série/Nº</th><th width="13%">Data Emissão</th><th width="10%">NIF/NIC</th><th width="10%">Ilíquido</th><th width="15%">Impostos</th><th width="10%">Total Liq.</th><th width="20%">Configurações</th></tr></thead>';
		draw_data_relation('relationsdview', $(this).attr('data-object-id'), 0, '', 0,$(this).attr('data-object-ext'),-1,'Não existe nenhum documento que desse origem a este documento!');
		
	var table = document.getElementById("relationstview");
		table.innerHTML = '<thead><tr><th width="10%">Documento</th><th width="12%">Série/Nº</th><th width="13%">Data Emissão</th><th width="10%">NIF/NIC</th><th width="10%">Ilíquido</th><th width="15%">Impostos</th><th width="10%">Total Liq.</th><th width="20%">Configurações</th></tr></thead>';
		draw_data_relation('relationstview', 0, $(this).attr('data-object-id'), '', 0,$(this).attr('data-object-ext'),-1,'Não existe nenhum documento que tenha origem neste documento!');
});


$(document).on('click', ".convert-object", function (e) {
    e.preventDefault();
	$("#convert-id").val($(this).attr('data-object-id'));
	$("#convert-type").val($(this).attr('data-object-type'));
	$("#convert-ext").val($(this).attr('data-object-ext'));
	var table = document.getElementById("convertersview");
	table.innerHTML = '<thead><tr><th width="10%">Documento</th><th width="12%">Série/Nº</th><th width="13%">Data Emissão</th><th width="10%">NIF/NIC</th><th width="10%">Ilíquido</th><th width="15%">Impostos</th><th width="10%">Total Liq.</th><th width="20%">Configurações</th></tr></thead>';
	draw_data_relation('convertersview', $(this).attr('data-object-id'), 0, '', 0,$(this).attr('data-object-ext'),-1,'Este documento ainda não foi convertido');
});

$("#convert-confirm").on("click", function (e) {
	e.preventDefault();
	var action_url = $('#doc-convert-type option:selected').attr('data-url');
	var o_data = 'id=' + $('#convert-id').val()+'&'+'typ=' + $('#convert-type').val()+'&'+'typdoc=' + $('#doc-convert-type').val()+'&'+'ext=' + $('#convert-ext').val();
	
	window.open(baseurl+action_url+'?'+o_data, '_self');
});

$(document).on('click', ".duplicate-object", function (e) {
    e.preventDefault();
	$('#duplicate-id').val($(this).attr('data-object-id'));
	$('#duplicate-type_n').val($(this).attr('data-object-type'));
	$("#duplicate-ext").val($(this).attr('data-object-ext'));
});


$("#duplicate-confirm").on("click", function (e) {
	e.preventDefault();
	var action_url = $('#duplicate-type option:selected').attr('data-url');
	var o_data = 'id=' + $('#duplicate-id').val()+'&'+'typ=' + $('#duplicate-type').val()+'&'+'ext=' + $('#duplicate-ext').val();
	window.open(baseurl+action_url+'?'+o_data, '_self');
});

$("#choise_type_duplicate_but").on("click", function (e) {
	e.preventDefault();
	$("#duplicate-id").val($(this).attr('data-object-id'));
	$("#duplicate-ext").val($(this).attr('data-object-ext'));
});


$("#choise_docs_relateds_but").on("click", function (e) {
	e.preventDefault();
	$("#relations-id").val($(this).attr('data-object-id'));
	$("#relations-type").val($(this).attr('data-object-type'));
	$("#relations-ext").val($(this).attr('data-object-ext'));
});


$('#choise_docs_related_but').click(function (e) {
	e.preventDefault();
	$('#choise-doc-type').prop('selectedIndex', 0);
	$("#startdaterel").val('');
	$("#enddaterel").val('');
	$("#searchdoc").val('');
	
	var table = document.getElementById("relationssearch");
	table.innerHTML = '<thead><tr><th>Não há informação para apresentar.</th></tr></thead><tbody></tbody>';
	
	$('#relationssearch').DataTable().destroy();
	
	var table = document.getElementById("relationssearch");
	table.innerHTML = '<thead><tr><th>Não há informação para apresentar.</th></tr></thead><tbody></tbody>';
	
	$('#choise_docs_related').modal();
	$('#choise_docs_related').modal({ keyboard: false });
	$('#choise_docs_related').modal('show');
});


$('#searchdocbut').click(function (e) {
	e.preventDefault();
	var start_date = $('#startdaterel').val();
	var end_date = $('#enddaterel').val();
	var searchdoc = $('#searchdoc').val();
	var related_ext = $('#related-ext').val();
	var el = $("#choise-doc-type option:selected").val();
	
	
	if (el == -1)
	{
		alert("Selecione um Tipo pelo menos.");
	}else{
		var table = document.getElementById("relationssearch");
		table.innerHTML = '<thead><tr><th width="20%">Configurações</th><th width="10%">Documento</th><th width="12%">Série/Nº</th><th width="13%">Data Emissão</th><th width="10%">NIF/NIC</th><th width="10%">Ilíquido</th><th width="15%">Impostos</th><th width="10%">Total Liq.</th><th width="10%">Valor a Conciliar</th></tr></thead>';
		draw_data_relation('relationssearch',start_date, end_date, searchdoc, el,related_ext,0,'Não há informação para apresentar.');
	}
});

function draw_data_relation(idtable = '', start_date = '', end_date = '', search = '', el = '', ext = 0, tip = 0, mensagem='') {
	$('#'+idtable).DataTable({
		'processing': true,
		'destroy': true,
		'searching': false,
		'serverSide': true,
		'stateSave': true,
		'responsive': true,
		'ajax': {
			'url': baseurl +"receipts/get_relations_search",
			'type': 'POST',
			'data': {
				//$this->security->get_csrf_token_name(): crsf_hash,
				start_date: start_date,
				end_date: end_date,
				search: search,
				typ: el,
				ext: ext,
				tipolo:tip
			}
		},
		"initComplete": function(settings, json) {
			var table = document.getElementById(idtable);
			if(json.data != null){
				if(json.data.length <= 0){
					table.innerHTML = '<thead><tr><th>'+mensagem+'</th></tr></thead><tbody></tbody>';
				}
			}else{
				table.innerHTML = '<thead><tr><th>'+mensagem+'</th></tr></thead><tbody></tbody>';
			}
		},
		'order': [1, 'asc'],
		'columnDefs': [
			{
				'targets': [0],
				'orderable': false,
			},
		],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				footer: true,
				exportOptions: {
					columns: [2, 3, 4]
				}
			}
		]
	});
};

$(document).on('click', "#pass_selected", function (e) {
		e.preventDefault();
		var tableRelation = document.getElementById("relationsdocs");
		tableRelation.innerHTML = '<thead><tr><th width="20%">Série</th><th width="10%">Nº</th><th width="15%">Data Emissão</th><th width="15%">Cliente</th><th width="20%">Total Liq.</th><th width="20%">Valor Conciliado</th></tr></thead><tbody>';
		seriaa = $("input[name='relatsel_']:checked").serialize();
		if(seriaa == ''){
			alert("Selecione pelo menos um Documento.");
		}else{
			var valdocrela = 0;
			var valapagar = parseFloat($('#invoiceyoghtml').val());
			var strArrayfirst = seriaa.split("relatsel_=");
			for (var iqq = 1; iqq < strArrayfirst.length; iqq++ ) {
				var idvar = '';
				var idtyp = '';
				var idext = '';
				var idcla = '';
				var strArrayVars = strArrayfirst[iqq].split("%26");
				for (var trq = 0; trq < strArrayVars.length; trq++ ) {
					if(trq == 0)
					{
						idvar = strArrayVars[trq].replaceAll("id%3D", "");
					}else if(trq == 1)
					{
						idtyp = strArrayVars[trq].replaceAll("typ%3D", "");
					}else if(trq == 2)
					{
						idext = strArrayVars[trq].replaceAll("ext%3D", "");
					}else if(trq == 3)
					{
						idcla = strArrayVars[trq].replaceAll("i_class%3D", "");
					}
					
					idvar = idvar.replaceAll("&", "");
					idtyp = idtyp.replaceAll("&", "");
					idext = idext.replaceAll("&", "");
					idcla = idcla.replaceAll("&", "");
				}
				
				var variable = strArrayfirst[iqq].replaceAll("%26", "&");
				variable = strArrayfirst[iqq].replaceAll("%3D", ":");
				$.ajax({
					type: "GET",
					url: baseurl + 'receipts/get_id_relations_select',
					data: {
						//$this->security->get_csrf_token_name(): crsf_hash,
						id: idvar,
						typ: idtyp,
						ext: idext,
						i_class: idcla
					},
					beforeSend: function () {
						$("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
					},
					success: function (data) {
						var obj = JSON.parse(data);
						var valparconsiliar = 0;
						var tiiid = obj['iddoc'];
						var addrow = '<tr class="last-item-row-related sub_related"><input type="hidden" value="'+obj['iddoc']+'" name="idtyprelation[]" id="idtyprelation-'+valdocrela+'"><input type="hidden" value="'+obj['type_related']+'" name="typrelation[]" id="typrelation-'+valdocrela+'"><td><strong>'+obj['serie_name']+'</strong></td>';
						if(obj['type_related'] == "0" || obj['type_related'] == "2"){
							if(obj['draft'] == "0"){
								addrow += '<td><a href="'+baseurl+'invoices/view?id='+obj['iddoc']+'&ty=0" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'+obj['type']+'/'+obj['tid']+'</a><a href="'+baseurl+'invoices/printinvoice?id='+obj['iddoc']+'&ty=0&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
							}else{
								addrow += '<td><a href="'+baseurl+'invoices/view?id='+obj['iddoc']+'&ty=1" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'+obj['type']+'/'+obj['tid']+'</a><a href="'+baseurl+'invoices/printinvoice?id='+obj['iddoc']+'&ty=1&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
							}
							valparconsiliar = parseFloat(obj['pamnt']);
						}else if(obj['type_related'] == "1"){
							addrow += '<td><a href="'+baseurl+'invoices/view?id='+obj['iddoc']+'&ty=0" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'+obj['type']+'/'+obj['tid']+'</a><a href="'+baseurl+'invoices/printinvoice?id='+obj['iddoc']+'&ty=0&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
							valparconsiliar = parseFloat(obj['pamnt']);
						}else if(obj['type_related'] == "3"){
							addrow += '<td><a href="'+baseurl+'quote/view?id='+obj['iddoc']+'&ty=0" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'+obj['type']+'/'+obj['tid']+'</a><a href="'+baseurl+'quote/printquote?id='+obj['iddoc']+'&ty=0&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
							valparconsiliar = 0;
						}else if(obj['type_related'] == "4"){
							addrow += '<td><a href="'+baseurl+'guides/view?id='+obj['iddoc']+'&ty=1" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'+obj['type']+'/'+obj['tid']+'</a><a href="'+baseurl+'guides/printguide?id='+obj['iddoc']+'&ty=1&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
							valparconsiliar = 0;
						}else if(obj['type_related'] == "5"){
							addrow += '<td><a href="'+baseurl+'guides/view?id='+obj['iddoc']+'&ty=2" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'+obj['type']+'/'+obj['tid']+'</a><a href="'+baseurl+'guides/printguide?id='+obj['iddoc']+'&ty=2&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
							valparconsiliar = 0;
						}else if(obj['type_related'] == "6"){
							addrow += '<td><a href="'+baseurl+'purchase/view?id='+obj['iddoc']+'&ty=1" target="_blank" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i>'+obj['type']+'/'+obj['tid']+'</a><a href="'+baseurl+'purchase/printinvoice?id='+obj['iddoc']+'&ty=1&d=1" target="_blank" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a> ';
							valparconsiliar = parseFloat(obj['pamnt']);
						}
						addrow += '<td>'+obj['invoicedate']+'</td><td>'+obj['taxid']+'</td><td><input type="text" disabled readonly value="'+obj['total_discount_tax']+'" id="val_tot_rel-'+valdocrela+'"></td><td><input type="text" disabled readonly value="'+valparconsiliar+'" id="val_tot_rel_con-'+valdocrela+'"></td></tr>';
						
						valapagar = valapagar+(parseFloat(obj['total_discount_tax']) - valparconsiliar);
						valdocrela++;
						tableRelation.innerHTML += addrow;
						$('#invoiceyoghtml').val(parseFloat(valapagar).toFixed(2));
					}
				});
			}
			tableRelation.innerHTML += '<tbody>';
			$('#relationsdocs').removeClass('hidden');
			$('#choise_docs_related').modal('hide');
		}	
	});
