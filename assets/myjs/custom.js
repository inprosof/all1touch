var billtype = $('#billtype').val();
var billtypetax = $('#billtypetax').val();
var bill_tax = $('#bill_tax').val();
var bill_supplier = $('#bill_supplier').val();
var bill_serie = $('#bill_serie').val();
var bill_activ = $('#bill_activ').val();
var bill_copys = $('#bill_copys').val();
var bill_wareh = $('#bill_wareh').val();
var d_csrf = crsf_token + '=' + crsf_hash;

$('#addtaxinvoice').on('click', function () {
	$.ajax({
		url: baseurl + 'settings/withholdingsoptions',
		dataType: "json",
		method: 'post',
		data: d_csrf,
		success: function (data) {
			var cvalue = 0;
			$('.amnttax').each(function () {
				cvalue++;
			});
			var valIva = $("#taxas option:selected").text();
			var valIvaperc = $("#taxas option:selected").attr('data-type')+'%';
			var valIvapercs = $("#taxas option:selected").attr('data-type');
			var valIvacod = $("#taxas option:selected").attr('data-tformat');
			var valIvaid = $("#taxas option:selected").val();
			
			if(valIvaperc == '0')
			{
				valIvaperc = '0.00';
			}
			$('#taxas').prop('selectedIndex', -1);
			$("#taxas").val('0');
			$("#autos_se").attr({ disabled: false});
			
			
			var table = document.getElementById("last-item-row-intax");
			var rowCount = table.rows.length;
			var erro = "";
			for (var i = 0; i < rowCount-1; i++) {
				vat_cod = $('#pcodidtax-' + i).val();
				if(vat_cod == valIvacod)
				{
					erro = 'Já existe uma taxa com esse nome.'
					break;
				}else if(vat_cod == 'ISE')
				{
					erro = 'Remova primeiro a taxa de isenção para adicionar outras taxas.'
					break;
				}
				
				if(valIvacod == 'ISE' && vat_cod != 'ISE')
				{
					erro = 'Remova todas as taxas de Iva para adicionar a taxa de Isenção.'
					break;
				}
				
				if(valIvaid == 0)
				{
					erro = 'Selecione uma Taxa.'
					break;
				}
			}
			
			if(erro != "")
			{
				alert(erro);
				return;
			}
			
			
			var dataInsert = '<tr><td><input type="text" disabled class="form-control amnttax" name="taxi_n[]" id="taxi_n-'+cvalue+'" value="'+valIva+'"></td><td><input type="text" disabled class="form-control text-center taxin" id="taxi_val-'+cvalue+'" name="taxi_val[]" value="'+valIvaperc+'"></td><td>';
			
			if(valIvacod == 'ISE')
			{
				dataInsert += '<input type="hidden" class="form-control text-center" id="taxi_como-' + cvalue + '" name="taxi_como[]">';
				dataInsert += '<select name="taxi_ise[]" id="taxi_ise-' + cvalue + '" class="form-control round">';
			}else{
				dataInsert += '<input type="checkbox" class="form-control text-center" id="taxi_como-' + cvalue + '" name="taxi_como[]">';
				dataInsert += '<select hidden name="taxi_ise[]" id="taxi_ise-' + cvalue + '" class="form-control round">';
			}
			
			dataInsert += '<option value="0">Escolha uma Opção</option>';
			$.map(data, function (item) {
				dataInsert += '<option value="'+item[0]+'" data-type="'+item[2]+'">'+item[4]+'</option>';
			});
			
			dataInsert += '</select></td><td class="text-center"><button type="button" data-rowid="'+cvalue+'" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" class="pdIntax" name="pidttax[]" id="pidttax-'+cvalue+'" value="' +valIvaid+ '"><input type="hidden" class="pdIntax2" name="pcodidtax[]" id="pcodidtax-'+cvalue+'" value="'+valIvacod+'"><input type="hidden" class="pdIntax3" name="pperidtax[]" id="pperidtax-'+cvalue+'" value="'+valIvapercs+'"></tr>';
			
			var tablered = document.getElementById("last-item-row-intax");
			tablered.innerHTML += dataInsert;
			row = cvalue;
			
			$('#taxi_n-'+ cvalue).autocomplete({
				source: function (request, response) {
					$.ajax({
						url: baseurl + 'settings/' + bill_tax,
						dataType: "json",
						method: 'post',
						data: 'row_num=' + row +'&' + d_csrf,
						success: function (data) {
							response($.map(data, function (item) {
								var tax_d = item[0];
								return {
									label: tax_d,
									value: tax_d,
									data: item
								};
							}));
						}
					});
				},
				autoFocus: true,
				minLength: 0,
				select: function (event, ui) {
					id_arr = $(this).attr('id');
					id = id_arr.split("-");
					$('#pidttax-' + id[1]).val(ui.item.data[3]);
					$('#pcodidtax-' + id[1]).val(ui.item.data[1]);
					$('#pperidtax-' + id[1]).val(ui.item.data[2]);
					if(ui.item.data[1] == 'ISE')
					{
						$('#taxi_val-' + id[1]).val(ui.item.data[0]);
					}else{
						$('#taxi_val-' + id[1]).val(ui.item.data[2]+'%');
					}
					
					//rowTotalTax(cvalue);
					//billUpyogProduct();
				},
				create: function (e) {
					$(this).prev('.ui-helper-hidden-accessible').remove();
				}
			});
		}
	});
});


$('#taxi_n-0').autocomplete({
	source: function (request, response) {
		$.ajax({
			url: baseurl + 'settings/' + bill_tax,
			dataType: "json",
			method: 'post',
			data: 'row_num=1'+'&' + d_csrf,
			success: function (data) {
				response($.map(data, function (item) {
					var tax_d = item[0];
					return {
						label: tax_d,
						value: tax_d,
						data: item
					};
				}));
			}
		});
	},
	autoFocus: true,
	minLength: 0,
	select: function (event, ui) {
		$('#pidttax-0').val(ui.item.data[3]);
		$('#pcodidtax-0').val(ui.item.data[1]);
		$('#pperidtax-0').val(ui.item.data[2]);
		if(ui.item.data[1] == 'ISE')
		{
			$('#taxi_val-' + id[1]).val(ui.item.data[0]);
		}else{
			$('#taxi_val-' + id[1]).val(ui.item.data[2]+'%');
		}
		rowTotalTax(0);
		billUpyogProduct();
	}
});





$('#addpayment').on('click', function () {
	$.ajax({
		url: baseurl + 'settings/smetopagamento',
		dataType: "json",
		method: 'post',
		data: d_csrf,
		success: function (data) {
			var cvalue = parseInt($('#ganakpay').val()) + 1;
			var nxt = parseInt(cvalue);
			$('#ganakpay').val(nxt);
			
			row = cvalue;
			var functionNum = "'" + cvalue + "'";
			var dataInsert = '<tr><input type="hidden" class="pdPaymen"/><td><select name="pay_met[]" id="pay_met-' + cvalue + '" class="form-control round payment"><option value="">Escolha uma Opção</option>';
			$.map(data, function (item) {
				dataInsert += '<option value="'+item[0]+'" data-type="'+item[1]+'">'+item[2]+'</option>';
			});
			
			var today = new Date();
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0');
			var yyyy = today.getFullYear();

			today = dd + '-' + mm + '-' + yyyy;
			dataInsert += '</select></td><td><input type="text" class="form-control required" placeholder="00-00-0000" name="pay_date[]" id="pay_date-' + cvalue + '" data-toggle="datepicker" autocomplete="true" value="'+today+'"/></td><td><div class="input-group"><input type="text" class="form-control req prc" name="pay_tot[]" id="pay_tot-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotalPayments(' + functionNum + ')" autocomplete="off" inputmode="numeric"><a title="€" class="btn btn-blue btn-sm pay_but_tot" name="pay_but_tot[]" id="pay_but_tot-'+cvalue+'"><span class="fa fa-edit" aria-hidden="false"></span></a></div></td><td><input type="text" class="form-control" name="pay_obs[]" id="pay_obs-' + cvalue + '"></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removePayment" title="Remove" > <i class="fa fa-minus-square"></i></button></td></tr>';
			$('tr.last-item-row-payments').before(dataInsert);
			
			$('#pay_but_tot-'+ cvalue).on('click', function () {
				var totpayments = $("#invoiceyoghtml").val();
				var totpaymentsval = deciFormat(totpayments);
				var idArray = [];
				$('.payment').each(function () {
					var id_e = $(this).attr('id');
					id_e = id_e.split("-");
					idArray.push(id_e[1]);
				});
				var percPay = 0;
				for (var i = 0; i < idArray.length; i++) {
					var x = idArray[i];
					percPay += deciFormat($("#pay_tot-" + x).val());
				}
				if(totpaymentsval < percPay)
				{
					alert('O valor inserido supera o valor a Pagar. Por favor verifique.');
				}else{
					if(totpaymentsval == percPay)
					{
						alert('Já inseriu o valor correspondente á fatura nos meios de pagamento.');
					}else{
						$("#pay_tot-" + cvalue).val(numnovo);
					}
				}
				var numnovo = totpaymentsval-percPay;
				$("#pay_tot-" + cvalue).val(numnovo);
			});
		}
	});
});

var rowTotalPayments = function (numb) {
	var totpayments = $("#invoiceyoghtml").val();
	var totpaymentsval = deciFormat(totpayments);
	
	var idArray = [];
    $('.payment').each(function () {
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
    });
	
	var percPay = 0;
	for (var i = 0; i < idArray.length; i++) {
		var x = idArray[i];
		percPay += deciFormat($("#pay_tot-" + x).val());
	}
	
	if(totpaymentsval < percPay)
	{
		alert('O valor inserido supera o valor a Pagar. Por favor verifique.');
	}
	
	if(totpaymentsval == percPay)
	{
		alert('Já inseriu o valor correspondente á fatura nos meios de pagamento.');
	}
	
	var numnovo = totpaymentsval-percPay;
	$("#pay_tot-" + numb).val(numnovo);
}


$('#saman-row-payments').on('click', '.removePayment', function () {
    var pidd = $(this).closest('tr').find('.pdPaymen').val();
    $(this).closest('tr').remove();
	var cvalue = parseInt($('#ganakpay').val());
	var nxt = parseInt(cvalue);
	$('#ganakpay').val(nxt);
    $('#newline_' + cvalue).closest('tr').remove();
    return false;
});


$('#addproduct').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";		
	
    var data = '<tr><td><div id="accordionDocs' + cvalue + '" role="tablist" aria-multiselectable="true"><div id="obs_inv" class="class="input-group"><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"><a data-toggle="collapse" data-parent="#accordionDocs' + cvalue + '" href="#obs_accor_inv' + cvalue + '" aria-expanded="false" aria-controls="obs_accor_inv' + cvalue + '" class="card-title lead collapsed"> <i class="fa fa-plus-circle"></i></a></div></div></td><td><div class="input-group"><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off" value="1"  inputmode="numeric"><span id="product_uni-' + cvalue + '" name="product_uni[]" class="lightMode"></span></div></td><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> <input type="hidden" id="verif_typ-' + cvalue + '" value=""  name="verif_typ[]"><td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off" inputmode="numeric"></td><td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off"></td> <td><div class="input-group"><input type="text" disabled class="col-form-label text-center" id="texttaxa-' + cvalue + '" value="0%"><a title="Alterar" hidden class="btn btn-blue btn-sm butedittax" name="butedittax[]" id="butedittax-'+cvalue+'"><span class="fa fa-edit" aria-hidden="false"></span></a></div></td><td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i></button><input type="hidden" name="taxacomo[]" id="taxacomo-' + cvalue + '" value=""><input type="hidden" name="taxavals[]" id="taxavals-' + cvalue + '" value=""><input type="hidden" name="taxaname[]" id="taxaname-' + cvalue + '" value=""><input type="hidden" name="taxaperc[]" id="taxaperc-' + cvalue + '" value=""><input type="hidden" name="taxacod[]" id="taxacod-' + cvalue + '" value=""><input type="hidden" name="taxaid[]" id="taxaid-' + cvalue + '" value=""><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInputsub" name="subtotal[]" id="subtotal-' + cvalue + '" value="0"><input type="hidden" class="ttInputtot2" name="product_tax[]" id="product_tax-' + cvalue + '" value="0"><input type="hidden" class="ttInputtot" name="total[]" id="total-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"><input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""><input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </td></tr><tr><td colspan="8" class="pdIn2"><div id="obs_accor_inv' + cvalue + '" role="tabpanel" aria-labelledby="obs_inv" class="card-collapse collapse" aria-expanded="false"><div class="card-body"><textarea class="form-control" id="product_description-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea></div></div></td></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            var discount = ui.item.data[4];
            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
			$('#subtotal-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#discount-' + id[1]).val(discount);
            $('#product_description-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
			$('#product_uni-' + id[1]).text(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
			$('#verif_typ-' + id[1]).val(ui.item.data[9]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
			$('#butedittax-' + id[1]).removeAttr('hidden');
			
			rowTotalNew(cvalue);
			$('#closemodal').click(function() {
				$('#newtaxs').modal('hide');
			});
			
			$('#updatemodal').click(function() {
				var cvalue = $("#numrow").val();
				var table = document.getElementById("last-item-row-intax");
				var rowCount = table.rows.length;
				var qttProd = deciFormat($("#amount-" + cvalue).val());
				var priceVal = deciFormat($("#price-" + cvalue).val());
				var totalPrice = qttProd * priceVal;
				var erro = "";
				
				if(rowCount == 1){
					erro = "Por favor Selecionar pelo menos uma Taxa de Iva.";
				}
				for (var i = 0; i < rowCount-1; i++) {
					Inpercentage = precentCalc(totalPrice, $('#pperidtax-' + i).val());
					Inpercentage = accounting.unformat(Inpercentage, accounting.settings.number.decimal);
					if(i == 0)
					{
						if($('#pcodidtax-' + i).val() == 'ISE'){
							vat_text = $('#taxi_n-' + i).val();
							if($("#taxi_ise-"+i+" option:selected").val() == 0 || $("#taxi_ise-"+i+" option:selected").val() == "0")
							{
								erro = "Por favor selecionar uma Justificação!";
								break;
							}else{
								vat_como = $("#taxi_ise-"+i+" option:selected").val();
							}
						}else{
							vat_text = $('#pperidtax-' + i).val()+'%';
							if($('#taxi_como-' + i).val() == 'on')
							{
								vat_como = '1';
							}else{
								vat_como = '0';
							}
						}
						vat_name = $('#taxi_n-' + i).val();
						vat_vals = Inpercentage;
						vat_perc = $('#pperidtax-' + i).val();
						vat_cod = $('#pcodidtax-' + i).val();
						vat_id = $('#pidttax-' + i).val();
					}else{
						if($('#pcodidtax-' + i).val() == 'ISE'){
							vat_text += '/'+$('#taxi_n-' + i).val();
							if($("#taxi_ise-"+i+" option:selected").val() == '0' || $("#taxi_ise-"+i+" option:selected").val() == 0)
							{
								erro = "Por favor selecionar uma Justificação!";
								break;
							}else{
								vat_como += ';'+$("#taxi_ise-"+i+" option:selected").val();
							}
						}else{
							vat_text += '/'+$('#pperidtax-' + i).val()+'%';
							if($('#taxi_como-' + i).val() == 'on')
							{
								vat_como += ';1';
							}else{
								vat_como += ';0';
							}
						}
						vat_name += ';'+$('#taxi_n-' + i).val();
						vat_vals += ';'+Inpercentage;
						vat_perc += ';'+$('#pperidtax-' + i).val();
						vat_cod += ';'+$('#pcodidtax-' + i).val();
						vat_id += ';'+$('#pidttax-' + i).val();
					}
				}
				
				if(erro != "")
				{
					alert(erro);
					return;
				}
				
				$('#newtaxs').modal('hide');
				$('#taxaname-' + cvalue).val(vat_name);
				$('#texttaxa-' + cvalue).val(vat_text);
				$('#taxaid-' + cvalue).val(vat_id);
				$('#taxacod-' + cvalue).val(vat_cod);
				$('#taxaperc-' + cvalue).val(vat_perc);
				$('#taxavals-' + cvalue).val(vat_vals);
				$('#taxacomo-' + cvalue).val(vat_como);
				
				rowTotalNew(cvalue);
			});
			$('#butedittax-'+ cvalue).on('click', function () {
				$("#newtaxs").modal("show");
				$("#numrow").val(cvalue);
				$.ajax({
					url: baseurl + 'settings/withholdingsoptions',
					dataType: "json",
					method: 'post',
					data: d_csrf,
					success: function (data) {
						var tablered = document.getElementById("last-item-row-intax");
						var cvalue = $("#numrow").val();
						var vat_name = $("#taxaname-" + cvalue).val();
						var myArraytax = [];
						if (typeof vat_name === 'string') {
							myArraytax = vat_name.split(";");
							if(myArraytax.length == 0){
								myArraytax.push({
									vat_name
								});
							}
						}				
						var vat_perc = $("#taxaperc-" + cvalue).val();
						var myArraytaxperc = [];
						if (typeof vat_perc === 'string') {
							myArraytaxperc = vat_perc.split(";");
							if(myArraytaxperc.length == 0){
								myArraytaxperc.push({
									vat_perc
								});
							}
						}
						
						var vat_cod = $("#taxacod-" + cvalue).val();
						var myArraytaxcod = [];
						if (typeof vat_cod === 'string') {
							myArraytaxcod = vat_cod.split(";");
							if(myArraytaxcod.length == 0){
								myArraytaxcod.push({
									vat_cod
								});
							}
						}
						
						var vat_como = $("#taxacomo-" + cvalue).val();
						var myArraytaxcomo = [];
						if (typeof vat_como === 'string') {
							myArraytaxcomo = vat_como.split(";");
							if(myArraytaxcomo.length == 0){
								myArraytaxcomo.push({
									vat_como
								});
							}
						}
						
						var vat_ctid = $("#taxaid-" + cvalue).val();
						var myArraytaxid = [];
						if (typeof vat_ctid === 'string') {
							myArraytaxid = vat_ctid.split(";");
							if(myArraytaxid.length == 0){
								myArraytaxid.push({
									vat_ctid
								});
							}
						}
						
						tablered.innerHTML = '<thead><tr class="item_header bg-gradient-directional-blue white"><th width="50%" class="text-center">Imposto</th><th width="15%" class="text-center">Valor</th><th width="25%" class="text-center">Comulativo</th><th width="10%" class="text-center">Ações</th></tr></thead>';
						var dataInsert = "";
						for (var iq = 0; iq < myArraytax.length; iq++ ) {
							var sleccom = "";
							if(myArraytaxcomo[iq] == 1)
							{
								sleccom = 'checked="checked"';
							}
							
							dataInsert += '<tr><td><input type="text" disabled class="form-control amnttax" name="taxi_n[]" id="taxi_n-'+iq+'" value="'+myArraytax[iq]+'"></td><td><input type="text" disabled class="form-control text-center taxin" id="taxi_val-'+iq+'" name="taxi_val[]" value="'+myArraytaxperc[iq]+'%"></td><td>';
							
							var tipochec = "checkbox";
							var slisento = "";
							if(myArraytaxcod[iq] != 'ISE')
							{
								slisento = 'hidden';
								dataInsert += '<input type="checkbox" class="form-control text-center" id="taxi_como-' + iq + '" name="taxi_como[]" '+sleccom+'>';
							}else{
								dataInsert += '<input type="hidden" class="form-control text-center" id="taxi_como-' + iq + '" name="taxi_como[]" '+sleccom+'>';
							}
							dataInsert += '<select '+slisento+' name="taxi_ise[]" id="taxi_ise-' + iq + '" class="form-control round">';
							
							if(slisento == "")
							{
								dataInsert += '<option value="'+myArraytaxcomo[iq]+'">-Alterar Justificação-</option>';
							}else{
								dataInsert += '<option value="0">Escolha uma Opção</option>';
							}
							$.map(data, function (item) {
								dataInsert += '<option value="'+item[0]+'" data-type="'+item[2]+'">'+item[4]+'</option>';
							});
							
							dataInsert += '</select></td><td class="text-center"><button type="button" data-rowid="'+iq+'" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" class="pdIntax" name="pidttax[]" id="pidttax-'+iq+'" value="' +myArraytaxid[iq]+ '"><input type="hidden" class="pdIntax2" name="pcodidtax[]" id="pcodidtax-'+iq+'" value="'+myArraytaxcod[iq]+'"><input type="hidden" class="pdIntax3" name="pperidtax[]" id="pperidtax-'+iq+'" value="'+myArraytaxperc[iq]+'"></tr>';
						}
						
						tablered.innerHTML += dataInsert;
					}
				});
			});
        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });
});

$('#saman-row-tax').on('click', '.removeProd', function () {
    var pidd = $(this).closest('tr').find('.pdIntax').val();
    var pqty = $(this).closest('tr').find('.taxin').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    return false;
});


$('#addtax').on('click', function () {
    var cvalue = 0;
	$('.amnt').each(function () {
        cvalue++;
    });
	//Tax row
	$.ajax({
		url: baseurl + 'settings/withholdingsoptions',
		dataType: "json",
		method: 'post',
		data: d_csrf,
		success: function (data) {
			var dataInsert = '<tr><td><input type="text" class="form-control" name="tax_n[]" placeholder="Please select One Tax" id="tax_n-' + cvalue + '"> </td><td><input type="text" readonly class="form-control text-center amnt" id="tax_val-' + cvalue + '" name="tax_val[]" value="0.00"></td><td><input type="checkbox" class="form-control text-center" id="tax_como-' + cvalue + '" name="tax_como[]"><select hidden name="tax_ise[]" id="tax_ise-' + cvalue + '" class="form-control round">';
			
			$.map(data, function (item) {
				dataInsert += '<option value="'+item[0]+'" data-type="'+item[2]+'">'+item[4]+'</option>';
			});
			
			dataInsert += '</select></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" class="pdIn" name="pidt[]" id="pidt-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pcodid[]" id="pcodid-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pperid[]" id="pperid-' + cvalue + '" value="0"></tr>';
			//ajax request
			$('tr.last-item-row').before(dataInsert);

			row = cvalue;
			
			$('#tax_n-'+ cvalue).autocomplete({
				source: function (request, response) {
					$.ajax({
						url: baseurl + 'settings/' + bill_tax,
						dataType: "json",
						method: 'post',
						data: 'name_startsWith=' + request.term + '&' + d_csrf,
						success: function (data) {
							response($.map(data, function (item) {
								var tax_d = item[0];
								return {
									label: tax_d,
									value: tax_d,
									data: item
								};
							}));
						}
					});
				},
				autoFocus: true,
				minLength: 0,
				select: function (event, ui) {
					id_arr = $(this).attr('id');
					id = id_arr.split("-");
					$('#pidt-' + id[1]).val(ui.item.data[3]);
					$('#pcodid-' + id[1]).val(ui.item.data[1]);
					$('#pperid-' + id[1]).val(ui.item.data[2]);
					
					$('#tax_como-' + id[1]).attr('selected', false);
					$('#tax_ise-' + id[1]).prop('selectedIndex', -1);
					$('#tax_ise-' + id[1]).val('0');
					if(ui.item.data[1] == 'ISE')
					{
						$('#tax_como-' + id[1]).attr('type', 'hidden');
						$('#tax_ise-' + id[1]).removeAttr('hidden');
						$('#tax_ise-' + id[1]).removeClass('hidden');
					}else{
						$('#tax_como-' + id[1]).attr('type', 'checkbox');
						$('#tax_ise-' + id[1]).addClass('hidden');
						$('#tax_ise-' + id[1]).attr('hidden');
					}
				
					$('#tax_val-' + id[1]).val('0.00');
					rowTotalTax(cvalue);
					billUpyogProduct();
				},
				create: function (e) {
					$(this).prev('.ui-helper-hidden-accessible').remove();
				}
			});
		}
	});
});


$('#tax_n-0').autocomplete({
	source: function (request, response) {
		$.ajax({
			url: baseurl + 'settings/' + bill_tax,
			dataType: "json",
			method: 'post',
			data: 'name_startsWith=' + request.term + '&row_num=1'+'&' + d_csrf,
			success: function (data) {
				response($.map(data, function (item) {
					var tax_d = item[0];
					return {
						label: tax_d,
						value: tax_d,
						data: item
					};
				}));
			}
		});
	},
	autoFocus: true,
	minLength: 0,
	select: function (event, ui) {
		$('#pidt-0').val(ui.item.data[3]);
		$('#pcodid-0').val(ui.item.data[1]);
		$('#pperid-0').val(ui.item.data[2]);
		$('#tax_como-0').attr('selected', false);
		$('#tax_ise-0').prop('selectedIndex', -1);
		$("#tax_ise-0").val('0');
		if(ui.item.data[1] == 'ISE')
		{
			$('#tax_como-0').attr('type', 'hidden');
			$('#tax_ise-0').removeAttr('hidden');
			$('#tax_ise-0').removeClass('hidden');
		}else{
			$('#tax_como-0').attr('type', 'checkbox');
			$('#tax_ise-0').addClass('hidden');
			$('#tax_ise-0').attr('hidden');
		}			
		$('#tax_val-0').val('0.00');
		rowTotalTax(0);
		billUpyogProduct();
	}
});


var billUpyog = function () {
	
	
};

var billUpyogProduct = function () {
	var idArray = [];
    $('.amnt').each(function () {
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
    });
	
	var amountVal = 0;
	if ($('#product_price').val()) {
		amountVal = accounting.unformat($('#product_price').val(), accounting.settings.number.decimal);
	}
	
	var amountValDisc = 0;
	if ($('#product_disc').val()) {
		amountValDisc = accounting.unformat($('#product_disc').val(), accounting.settings.number.decimal);
	}
	
	var valutott = 0;
	for (var i = 0; i < idArray.length; i++) {
		var x = idArray[i];
		//var valline = accounting.unformat($('#tax_val-' + x).val(), accounting.settings.number.decimal);
		var percVal = accounting.formatNumber($("#pperid-" + x).val());
		var totalTax = (amountVal-(amountVal*(amountValDisc/100))) * (percVal/100);
		
		valutott = valutott+totalTax;
		$("#tax_val-" + x).html(parseFloat(totalTax).toFixed(2));
		$("#tax_val-" + x).val(parseFloat(totalTax).toFixed(2));
	}
	$("#ftotal_tax").html(parseFloat(valutott).toFixed(2));
	$("#ftotal_tax").val(parseFloat(valutott).toFixed(2));
};



var rowTotalTax = function (numb) {
	var amountVal = 0;
	if ($('#product_price').val()) {
		amountVal = accounting.unformat($('#product_price').val(), accounting.settings.number.decimal);
	}
	var amountValDisc = 0;
	if ($('#product_disc').val()) {
		amountValDisc = accounting.unformat($('#product_disc').val(), accounting.settings.number.decimal);
	}
	
	var percVal = accounting.formatNumber($("#pperid-" + numb).val());
	var totalTax = (amountVal-(amountVal*(amountValDisc/100))) * (percVal/100);
	$("#tax_val-" + numb).html(parseFloat(totalTax).toFixed(2));
	$("#tax_val-" + numb).val(parseFloat(totalTax).toFixed(2));
}

var rowTotalSupl = function (numb) {
	var amountValproduct = 0;
	if ($('#product_price').val()) {
		amountValproduct = accounting.unformat($('#product_price').val(), accounting.settings.number.decimal);
	}
	
	var percdisglobVal = accounting.formatNumber($("#supli_des_g-" + numb).val());
	var percVal = accounting.formatNumber($("#supli_pr_c-" + numb).val());
	
	var totaldisc = percVal * (percdisglobVal/100);
	var totalprod = percVal-totaldisc;
	
	var val_marg_euro = amountValproduct-totalprod;
	var val_marg_p = amountValproduct/val_marg_euro;
	
	$('#supli_des_c-' + numb).html('0.00');
	$('#supli_des_c-' + numb).val('0.00');
	$('#supli_pr_c_d-' + numb).html(parseFloat(totalprod).toFixed(2));
	$('#supli_pr_c_d-' + numb).val(parseFloat(totalprod).toFixed(2));
	$('#supli_marg_e-' + numb).html(parseFloat(val_marg_euro).toFixed(2));
	$('#supli_marg_e-' + numb).val(parseFloat(val_marg_euro).toFixed(2));
	$('#supli_marg_p-' + numb).html(parseFloat(val_marg_p).toFixed(2));
	$('#supli_marg_p-' + numb).val(parseFloat(val_marg_p).toFixed(2));
}

$('#addsupplier').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row-supplier div').length;
	//Tax row
    var data = '<tr><td><input type="text" class="form-control" name="supli_n[]" placeholder="Please select One Supplier" id="supli_n-' + cvalue + '"> </td><td><input type="text" class="form-control text-center" id="supli_ref-' + cvalue + '" name="supli_ref[]"></td><td><input type="text" onkeyup="rowTotalSupl(' + cvalue + ')" class="form-control text-center" id="supli_pr_c-' + cvalue + '" name="supli_pr_c[]"></td><td><input type="text" readonly class="form-control text-center" id="supli_des_c-' + cvalue + '" name="supli_des_c[]" value="0.00"></td><td><input type="text" readonly class="form-control text-center" id="supli_des_g-' + cvalue + '" name="supli_des_g[]" value="0.00"></td><td><input type="text" readonly class="form-control text-center" id="supli_pr_c_d-' + cvalue + '" name="supli_pr_c_d[]" value="0.00"></td><td><input type="text" readonly class="form-control text-center" id="supli_marg_e-' + cvalue + '" name="supli_marg_e[]" value="0.00"></td><td><input type="text" readonly class="form-control text-center" id="supli_marg_p-' + cvalue + '" name="supli_marg_p[]" value="0.00"></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" class="pdIn" name="supliid[]" id="supliid-' + cvalue + '" value="0">';
    //ajax request
    $('tr.last-item-row-s').before(data);

    row = cvalue;
	
	$('#supli_n-'+ cvalue).autocomplete({
		source: function (request, response) {
			$.ajax({
				url: baseurl + 'supplier/' + bill_supplier,
				dataType: "json",
				method: 'post',
				data: 'name_startsWith=' + request.term + '&row_num=' + row +'&' + d_csrf,
				success: function (data) {
					response($.map(data, function (item) {
						var supli_d = item[0];
						return {
							label: supli_d,
							value: supli_d,
							data: item
						};
					}));
				}
			});
		},
		autoFocus: true,
		minLength: 0,
		select: function (event, ui) {
			id_arr = $(this).attr('id');
			id = id_arr.split("-");
			$('#supliid-' + id[1]).val(ui.item.data[2]);
			$('#supli_des_g-' + id[1]).html(ui.item.data[1]);
			$('#supli_des_g-' + id[1]).val(ui.item.data[1]);
			rowTotalSupl(cvalue);
		},
		create: function (e) {
			$(this).prev('.ui-helper-hidden-accessible').remove();
		}
	});
});


$('#supli_n-0').autocomplete({
	source: function (request, response) {
		$.ajax({
			url: baseurl + 'supplier/' + bill_supplier,
			dataType: "json",
			method: 'post',
			data: 'name_startsWith=' + request.term + '&row_num=1'+'&' + d_csrf,
			success: function (data) {
				response($.map(data, function (item) {
					var supli_d = item[0];
					return {
						label: supli_d,
						value: supli_d,
						data: item
					};
				}));
			}
		});
	},
	autoFocus: true,
	minLength: 0,
	select: function (event, ui) {
		$('#supliid-0').val(ui.item.data[2]);
		$('#supli_des_g-0').html(ui.item.data[1]);
		$('#supli_des_g-0').val(ui.item.data[1]);
		rowTotalSupl(0);
	}
});



$('#addserie').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
	//serie row
    var data = '<tr><td><input type="text" class="form-control" name="serie_n[]" placeholder="Please select One Serie" id="serie_n-' + cvalue + '"> </td> <td><select name="serie_pred[]" id="serie_pred-' + cvalue + '" class="form-control b_input"><option value="0">Não</option><option value="1">Sim</option></select></td><td><input type="text" class="form-control text-center" id="serie_copy-' + cvalue + '" name="serie_copy[]" placeholder="Num. Cópias"></td><td><input type="text" class="form-control" name="serie_class[]" placeholder="Sel. Activ" id="serie_class-' + cvalue + '"> </td> <td><input type="text" class="form-control" name="serie_wareh[]" placeholder="Please Select warehouse" id="serie_wareh-' + cvalue + '"></td><td><select name="serie_type_com[]" id="serie_type_com-' + cvalue + '" class="form-control b_input"><option value="0">Web Service</option><option value="1">SAFT</option><option value="2">Sem Comunicação</option><option value="3">Manual</option></select></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pactid[]" id="pactid-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pcopyid[]" id="pcopyid-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pwareid[]" id="pwareid-' + cvalue + '" value="0"></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;
	
	$('#serie_n-'+ cvalue).autocomplete({
		source: function (request, response) {
			$.ajax({
				url: baseurl + 'settings/' + bill_serie,
				dataType: "json",
				method: 'post',
				data: 'name_startsWith=' + request.term + '&row_num=' + row +'&' + d_csrf,
				success: function (data) {
					response($.map(data, function (item) {
						var serie_d = item[0];
						return {
							label: serie_d,
							value: serie_d,
							data: item
						};
					}));
				}
			});
		},
		autoFocus: true,
		minLength: 0,
		select: function (event, ui) {
			id_arr = $(this).attr('id');
			id = id_arr.split("-");
			$('#pid-' + id[1]).val(ui.item.data[1]);
			//rowTotal(cvalue);
		},
		create: function (e) {
			$(this).prev('.ui-helper-hidden-accessible').remove();
		}
	});
	
	$('#serie_class-'+ cvalue).autocomplete({
		source: function (request, response) {
			$.ajax({
				url: baseurl + 'settings/' + bill_activ,
				dataType: "json",
				method: 'post',
				data: 'name_startsWith=' + request.term + '&row_num=' + row +'&' + d_csrf,
				success: function (data) {
					response($.map(data, function (item) {
						var sactiv_d = item[0];
						return {
							label: sactiv_d,
							value: sactiv_d,
							data: item
						};
					}));
				}
			});
		},
		autoFocus: true,
		minLength: 0,
		select: function (event, ui) {
			id_arr = $(this).attr('id');
			id = id_arr.split("-");
			$('#pactid-' + id[1]).val(ui.item.data[1]);
			//rowTotal(cvalue);
		},
		create: function (e) {
			$(this).prev('.ui-helper-hidden-accessible').remove();
		}
	});
	
	$('#serie_copy-'+ cvalue).autocomplete({
		source: function (request, response) {
			$.ajax({
				url: baseurl + 'settings/' + bill_copys,
				dataType: "json",
				method: 'post',
				data: 'name_startsWith=' + request.term + '&row_num=' + row +'&' + d_csrf,
				success: function (data) {
					response($.map(data, function (item) {
						var scopy = item[0];
						return {
							label: scopy,
							value: scopy,
							data: item
						};
					}));
				}
			});
		},
		autoFocus: true,
		minLength: 0,
		select: function (event, ui) {
			id_arr = $(this).attr('id');
			id = id_arr.split("-");
			$('#pcopyid-' + id[1]).val(ui.item.data[1]);
			//rowTotal(cvalue);
		},
		create: function (e) {
			$(this).prev('.ui-helper-hidden-accessible').remove();
		}
	});
	
	$('#serie_wareh-'+ cvalue).autocomplete({
		source: function (request, response) {
			$.ajax({
				url: baseurl + 'settings/' + bill_wareh,
				dataType: "json",
				method: 'post',
				data: 'name_startsWith=' + request.term + '&row_num=' + row +'&' + d_csrf,
				success: function (data) {
					response($.map(data, function (item) {
						var sware_d = item[0];
						return {
							label: sware_d,
							value: sware_d,
							data: item
						};
					}));
				}
			});
		},
		autoFocus: true,
		minLength: 0,
		select: function (event, ui) {
			id_arr = $(this).attr('id');
			id = id_arr.split("-");
			$('#pwareid-' + id[1]).val(ui.item.data[1]);
			//rowTotal(cvalue);
		},
		create: function (e) {
			$(this).prev('.ui-helper-hidden-accessible').remove();
		}
	});
});

//caculations
var precentCalc = function (total, percentageVal) {
    var pr = (total / 100) * percentageVal;
    return parseFloat(pr);
};
//format
var deciFormat = function (minput) {
    if (!minput) minput = 0;
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + '-' + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var coupon = function () {
    var cp = 0;
    if ($('#coupon_amount').val()) {
        cp = accounting.unformat($('#coupon_amount').val(), accounting.settings.number.decimal);
    }
    return cp;
};

var shipTot = function (valc,vals) {
    var ship_p = 0;
    var ship_rate = accounting.unformat($('#shipping').val(), accounting.settings.number.decimal);
	var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'off') {
        ship_p = precentCalc(vals, ship_rate);
    } else if (tax_status == 'incl') {
        ship_p = precentCalc(valc, ship_rate);
    }
    $('#ship_tax').val(parseFloat(ship_p).toFixed(two_fixed));
    $('#ship_final').text(parseFloat(ship_p).toFixed(two_fixed));
	
    return ship_p;
};

//actions
var deleteRow = function (num) {
    var totalSelector = $("#subttlform");
    var prodttl = accounting.unformat($("#total-" + num).val(), accounting.settings.number.decimal);
    var subttl = accounting.unformat(totalSelector.val(), accounting.settings.number.decimal);
    var totalSubVal = subttl - prodttl;
    totalSelector.val(totalSubVal);
    $("#subttlid").html(accounting.formatNumber(totalSubVal));
    var totalBillVal = totalSubVal + shipTot(0,0) - coupon;
    //final total
    var clean = accounting.formatNumber(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#bigtotal").html(clean);
};

var rowTotalNew = function (numb, pos = false) {
	var pid = formInputGet("#pid", numb);
	$.ajax({
        url: baseurl + 'search_products/' + billtypetax,
		dataType: "json",
		method: 'post',
		data: 'pid=' + pid +'&' + d_csrf,
        success: function (data) {
			var result;
			var page = '';
			var totalValue = 0;
			
			var qttProdval = deciFormat($("#amount-" + numb).val());
			var priceValval = deciFormat($("#price-" + numb).val());
			var qttProd = accounting.unformat(qttProdval, accounting.settings.number.decimal);
			var priceVal = accounting.unformat(priceValval, accounting.settings.number.decimal);
			var discountVal = deciFormat($("#discount-" + numb).val());
			
			var alertaa = $("#alert-" + numb).val();
			var verify_typ = $("#verif_typ-" + numb).val();
			var alertVal = accounting.unformat(alertaa, accounting.settings.number.decimal);
			
			var vatVal = 0;
			var totalPrice = qttProd * priceVal;
			var totalValue = totalPrice;
			
			console.log('Tipo: '+verify_typ);
			if ($("#inv_page").val() == 'new_i' && pid > 0) {
				if(verify_typ == 1){
					if (alertVal <= +qttProd) {
						var aqt = alertVal - qttProd;
						if(pos)
						{
							
						}else{
							alert('Rutura de Stock! ' + accounting.formatNumber(aqt));
						}
					}
				}
				
			}
            var i = 0;
			var Inpercentage = 0;
			var product_tax = 0;
			var disFormat = $("#discount_format").val();
			
			
			var disco = 0;
			//Antes tax
			if (disFormat != '%') {
				var discount = precentCalc(totalPrice, discountVal);
				totalValue = parseFloat(totalPrice) - parseFloat(discount);
				disco = deciFormat(discount);
				$("#subtotal-" + numb).val(parseFloat(totalValue));
			}
			
			var vat_name = "";
			var vat_vals = "";
			var vat_perc = "";
			var vat_cod = "";
			var vat_id = "";
			var vat_como = "";
			var vat_text = "";
			
			for (var i = 0; i < data.length; i++ ) {
				Inpercentage = precentCalc(totalValue, data[i][5]);
				valPerc = accounting.unformat(Inpercentage, accounting.settings.number.decimal);
				product_tax += valPerc;
				if(i == 0)
				{
					if(data[i][4] == 'ISE'){
						vat_text = data[i][1];
					}else{
						vat_text = data[i][5]+'%';
					}
					vat_name = data[i][1];
					vat_vals = parseFloat(valPerc);
					vat_perc = data[i][5];
					vat_cod = data[i][4];
					vat_id = data[i][0];
					vat_como = data[i][3];
				}else{
					if(data[i][4] == 'ISE'){
						vat_text += '/'+data[i][1];
					}else{
						vat_text += '/'+data[i][5]+'%';
					}
					vat_name += ';'+data[i][1];
					vat_vals += ';'+parseFloat(valPerc);
					vat_perc += ';'+data[i][5];
					vat_cod += ';'+data[i][4];
					vat_id += ';'+data[i][0];
					vat_como += ';'+data[i][3];
				}
			}
			
			totalValue += product_tax;
			//depois tax
			if (disFormat == '%') {
				var discount = precentCalc(totalValue, discountVal);
				totalValue = parseFloat(totalValue) - parseFloat(discount);
				disco = deciFormat(discount);
				$("#subtotal-" + numb).val(parseFloat(totalValue).toFixed(two_fixed));
			}
			
			$('#disca-' + numb).val(disco);
			$("#result-" + numb).text(parseFloat(totalValue).toFixed(two_fixed));
			$("#total-" + numb).val(parseFloat(totalValue));
			$("#product_tax-" + numb).val(parseFloat(product_tax));
			$('#taxaname-' + numb).val(vat_name);
			$('#texttaxa-' + numb).val(vat_text);
			$('#taxaid-' + numb).val(vat_id);
			$('#taxacod-' + numb).val(vat_cod);
			$('#taxaperc-' + numb).val(vat_perc);
			$('#taxavals-' + numb).val(vat_vals);
			$('#taxacomo-' + numb).val(vat_como);
			
			billUpyogInv();
        }
    });
}


var setvalRelation = function (){
	$totalBillVal = 0;
	var discountVal = deciFormat($("#discount").val());
	var totalpay = accounting.unformat($('#totalpay').val(), accounting.settings.number.decimal);
	var valnovoBig = parseFloat(totalpay-discountVal);
	$("#invoiceyoghtml").val(parseFloat(valnovoBig).toFixed(two_fixed));
}

var billUpyogInv = function () {
	var itempriceList = [];
    var idList = [];
	var r = 0;
    $('.ttInputsub').each(function () {
        var vv = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var vid = $(this).attr('id');
        vid = vid.split("-");
        itempriceList.push(vv);
        idList.push(vid[1]);
    });
    var sum = 0;
    var iliqpr = 0;
    var discs = 0;
	var pricess = 0;
	var subtott = 0;
	
	var data = "";
	var arr = [];
	var numpp = 0;
    for (var z = 0; z < idList.length; z++) {
        var x = idList[z];
		var numelems = accounting.unformat($('#amount-' + x).val(), accounting.settings.number.decimal);
		numpp += numelems;
		var itempriceListtt = accounting.unformat(itempriceList[z], accounting.settings.number.decimal);
        if (itempriceListtt > 0) {
            sum += itempriceListtt;
			var d2 = accounting.unformat($("#price-" + x).val(), accounting.settings.number.decimal);
			if (d2 > 0) {
				pricess += d2;
			}
			
			subtott += (pricess*numelems);
			
			var d1 = accounting.unformat($("#disca-" + x).val(), accounting.settings.number.decimal);
			if (d1 > 0) {
				discs += d1;
			}
			var vat_name = $("#taxaname-" + x).val();
			var myArraytax = [];
			if (typeof vat_name === 'string') {
				myArraytax = vat_name.split(";");
				if(myArraytax.length == 0){
					myArraytax.push({
						vat_name
					});
				}
			}
			
			var vat_vals = $("#taxavals-" + x).val();
			var myArraytaxvals = [];
			if (typeof vat_vals === 'string') {
				myArraytaxvals = vat_vals.split(";");
				if(myArraytaxvals.length == 0){
					myArraytaxvals.push({
						vat_vals
					});
				}
			}
			
			var vat_cods = $("#taxacod-" + x).val();
			var myArraytaxcods = [];
			if (typeof vat_cods === 'string') {
				myArraytaxcods = vat_cods.split(";");
				if(myArraytaxcods.length == 0){
					myArraytaxcods.push({
						vat_cods
					});
				}
			}
			
			for (var iq = 0; iq < myArraytax.length; iq++ ) {
				var verf = verifyarray(arr,myArraytax[iq],myArraytaxvals[iq]);
				if(verf)
				{
					arr.push({
						title: myArraytax[iq], 
						cod: myArraytaxcods[iq],
						val:  myArraytaxvals[iq]
					});
				}
			}
        }
    }
	
	if(sum > 0)
	{
		var table = document.getElementById("last-item-row-taxs");
		table.innerHTML = '<thead><tr class="item_header bg-gradient-directional-blue white"><th width="70%" class="text-center">Impostos</th><th width="30%" class="text-center">Valor</th></tr></thead>';
		var iio = 0;
		var valiva = 0;
		wait = true;
		$.each(arr, function (index, value) {
			var valnnt = accounting.unformat(value.val, accounting.settings.number.decimal);
			table.innerHTML +='<tr><td><strong>'+value.title+'</strong></td><td><span class="currenty lightMode"> '+currency+' </span>'+parseFloat(valnnt).toFixed(two_fixed)+'<input type="hidden" name="tax_name[]" value="'+value.title+'" id="tax_name-' + iio + '"/><input type="hidden" name="tax_val[]" value="'+value.val+'" id="tax_val-' + iio + '"/><input type="hidden" name="tax_cod[]" value="'+value.cod+'" id="tax_cod-' + iio + '"/></td></tr>';
			valiva += valnnt;
			iio++;
			if(index -1 == iio)
			{
				wait = false;
			}
		});
		
		
		var valnovoiliq = parseFloat(subtott).toFixed(two_fixed);
		$("#subttlform_in").text(valnovoiliq);
		$("#subttlform_val").val(valnovoiliq);
		
		var discfin = accounting.unformat($('#disc_val').val(), accounting.settings.number.decimal);
		
		$("#discs").text(discs);
		$("#discs_come").val(discs);
		var valnovo = valiva+subtott+discs;
		
		var totalBillVal = (valnovo + shipTot(valiva,sum) - discfin - coupon());
		valnovo = parseFloat(valnovo).toFixed(two_fixed);
		
		$("#discs_tot_val").val(valnovo);
		$("#discs_tot").text(valnovo);
		$("#taxas_tota").val(valiva);
		$("#tota_items").val(numpp);
		$("#total_items_count").text(numpp);
		
		var valnovoBig = parseFloat(totalBillVal);
		$("#invoiceyoghtml").val(parseFloat(valnovoBig).toFixed(two_fixed));
		$("#bigtotal").text(parseFloat(valnovoBig).toFixed(two_fixed));
	}
};

function verifyarray (arr,title,val) {
	var pode = true;
	$.each(arr, function (index, value) {
		if(value.title == title)
		{
			var valnn = accounting.unformat(value.val, accounting.settings.number.decimal);
			var d1 = accounting.unformat(val, accounting.settings.number.decimal);
			value.val = parseFloat(valnn+d1).toFixed(two_fixed);
			pode = false;
		}
	});
	return pode;
}


//remove productrow
$('#saman-row-supplier').on('click', '.removeProd', function () {
    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').remove();
    //$('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('.amnt').each(function (index) {
		rowTotalTax(index);
		billUpyogProduct();
    });

    return false;
});


$('#saman-row').on('click', '.removeProd', function () {
    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
	$(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
	$('.amnt').each(function (index) {
        rowTotalTax(index);
		billUpyogProduct();
    });
    return false;
});

$('#saman-row-invoice').on('click', '.removeProd', function () {
    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').nextAll().slice(0,1).remove();
	$(this).closest('tr').remove();
	var temt = false;
    $('.amnt').each(function (index) {
        rowTotalNew(index);
		temt = true;
    });
	
	if(temt == false){
		var table = document.getElementById("last-item-row-taxs");
		table.innerHTML = '';
		$("#subttlform_in").text('0.00');
		$("#subttlform_val").val('0.00');
		$("#discs").text('0.00');
		$("#discs_come").val('0.00');
		
		$("#discs_tot_val").val('0.00');
		$("#discs_tot").text('0.00');
		$("#taxas_tota").val('0.00');
		$("#tota_items").val('0');
		$("#total_items_count").text('0');
		$("#invoiceyoghtml").val('0.00');
		$("#bigtotal").text('0.00');
	}
	billUpyogProduct();
    return false;
});


$('#saman-row-product').on('click', '.removeProd', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('.amnt').each(function (index) {
        rowTotalTax(index);
		billUpyogProduct();
    });
    return false;
});

$('#saman-row-taxs').on('click', '.removeProd', function () {

    var pidd = $(this).closest('tr').find('.pdIntax').val();
    var pqty = $(this).closest('tr').find('.taxin').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('.taxin').each(function (index) {
        //rowTotal(index);
    });

    return false;
});




$('#serie_n-0').autocomplete({
	source: function (request, response) {
		$.ajax({
			url: baseurl + 'settings/' + bill_serie,
			dataType: "json",
			method: 'post',
			data: 'name_startsWith=' + request.term + '&row_num=1'+'&' + d_csrf,
			success: function (data) {
				response($.map(data, function (item) {
					var serie_d = item[0];
					return {
						label: serie_d,
						value: serie_d,
						data: item
					};
				}));
			}
		});
	},
	autoFocus: true,
	minLength: 0,
	select: function (event, ui) {
		$('#pid-0').val(ui.item.data[1]);
		//rowTotal(0);
	}
});


var rowCopys = function (numb) {
	$('#serie_copy-'+numb).autocomplete({
		source: function (request, response) {
			$.ajax({
				url: baseurl + 'settings/' + bill_copys,
				dataType: "json",
				method: 'post',
				data: 'name_startsWith=' + request.term + '&row_num=1'+'&' + d_csrf,
				success: function (data) {
					response($.map(data, function (item) {
						var scopy = item[0];
						return {
							label: scopy,
							value: scopy,
							data: item
						};
					}));
				}
			});
		},
		autoFocus: true,
		minLength: 0,
		select: function (event, ui) {
			$('#pcopyid-'+numb).val(ui.item.data[1]);
			//rowTotal(0);
		}
	});
};


$('#serie_class-0').autocomplete({
	source: function (request, response) {
		$.ajax({
			url: baseurl + 'settings/' + bill_activ,
			dataType: "json",
			method: 'post',
			data: 'name_startsWith=' + request.term + '&row_num=1'+'&' + d_csrf,
			success: function (data) {
				response($.map(data, function (item) {
					var calsat_d = item[0];
					return {
						label: calsat_d,
						value: calsat_d,
						data: item
					};
				}));
			}
		});
	},
	autoFocus: true,
	minLength: 0,
	select: function (event, ui) {
		$('#pactid-0').val(ui.item.data[1]);
		//rowTotal(0);
	}
});

$('#serie_wareh-0').autocomplete({
	source: function (request, response) {
		$.ajax({
			url: baseurl + 'settings/' + bill_wareh,
			dataType: "json",
			method: 'post',
			data: 'name_startsWith=' + request.term + '&row_num=1'+'&' + d_csrf,
			success: function (data) {
				response($.map(data, function (item) {
					var warehs_d = item[0];
					return {
						label: warehs_d,
						value: warehs_d,
						data: item
					};
				}));
			}
		});
	},
	autoFocus: true,
	minLength: 0,
	select: function (event, ui) {
		$('#pwareid-0').val(ui.item.data[1]);
		//rowTotal(0);
	}
});

/*$('#saman-pos2').on('click', '.removeItem', function () {
    var pidd = $(this).attr('data-rowid');
    var pqty = accounting.unformat($('#amount-' + pidd).val(), accounting.settings.number.decimal);
    var old_amnt = $('#amount_old-' + pidd).val();
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $('#ppid-' + pidd).remove();
    $('.amnt').each(function (index) {
        rowTotalNew(index);
    });
    return false;
});*/


$('#saman-row-pos').on('click', '.removeItem', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = accounting.unformat($(this).closest('tr').find('.amnt').val(), accounting.settings.number.decimal);
    var old_amnt = accounting.unformat($(this).closest('tr').find('.old_amnt').val(), accounting.settings.number.decimal);
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $(this).closest('tr').nextAll().slice(0,1).remove();
	$(this).closest('tr').remove();
	var temt = false;
    $('.amnt').each(function (index) {
        rowTotalNew(index);
		temt = true;
    });
	
	if(temt == false){
		var table = document.getElementById("last-item-row-taxs");
		table.innerHTML = '';
		$("#subttlform_in").text('0.00');
		$("#subttlform_val").val('0.00');
		$("#discs").text('0.00');
		$("#discs_come").val('0.00');
		
		$("#discs_tot_val").val('0.00');
		$("#discs_tot").text('0.00');
		$("#taxas_tota").val('0.00');
		$("#tota_items").val('0');
		$("#total_items_count").text('0');
		$("#invoiceyoghtml").val('0.00');
		$("#bigtotal").text('0.00');
	}
    return false;

});

wait = true;

$(document).on('click', ".select_pos_item", function (e) {
	var pid = $(this).attr('data-pid');
	
	var verif_typ = $(this).attr('data-verif_typ');
	var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

	var discount = $(this).attr('data-discount');
	var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
	if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
	var flag = true;

	$('#search_bar').attr('readonly',false);
	$('#search_bar').val('');
	$('.pdIn').each(function () {

		if (pid == $(this).val()) {

			var pi = $(this).attr('id');
			var arr = pi.split('-');
			pi = arr[1];
			$('#discount-' + pi).val(discount);
			var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

			if (stotal <= stock || verif_typ == 0) {
				$('#amount-' + pi).val(accounting.formatNumber(stotal));
				$('#search_bar').val('').focus();
			} else {
				$('#stock_alert').modal('toggle');
			}
			rowTotalNew(pi,true);
			flag = false;
		}
	});
	var t_r = $(this).attr('data-tax');
	if ($("#taxformat option:selected").attr('data-trate')) {

		var t_r = $("#taxformat option:selected").attr('data-trate');
	}
	var sound = document.getElementById("beep");
	sound.play();
	if (flag) {
		var ganak = $('#ganak').val();
		var cvalue = parseInt(ganak);
		var functionNum = "'" + cvalue + "'";
		count = $('#saman-row-invoice div').length;
		//var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" inputmode="numeric" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up" id="qtdup-' + cvalue + '">+</div><div class="quantity-button quantity-down" id="qtddown-' + cvalue + '">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '" inputmode="numeric"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"></div>';
		var data = '<tr><td><div class="quantity-nav"><div class="input-group"><input type="text" inputmode="numeric" class="form-control p-mobile p-width req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off" value="1" ><span id="product_uni-' + cvalue + '" name="product_uni[]" class="lightMode" value="'+$(this).attr('data-unit')+'"></span></div><div class="quantity-button quantity-up" id="qtdup-' + cvalue + '">+</div><div class="quantity-button quantity-down" id="qtddown-' + cvalue + '">-</div></div></td> <td><input type="text" class="form-control p-width p-mobile req prc" name="product_price[]"  inputmode="numeric" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off"  value="' + $(this).attr('data-price') + '"></td><td><input type="text" class="form-control p-width p-mobile discount pos_w" name="product_discount[]" inputmode="numeric" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off"  value="' + discount + '" inputmode="numeric"></td> <td><input type="text" disabled class="form-control p-width p-mobile text-center" id="texttaxa-' + cvalue + '" value="0%"></td><td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInputsub" name="subtotal[]" id="subtotal-' + cvalue + '" value="0"><input type="hidden" class="ttInputtot2" name="product_tax[]" id="product_tax-' + cvalue + '" value="0"><input type="hidden" class="ttInputtot" name="total[]" id="total-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"><input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"><input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"><input type="hidden" name="taxacomo[]" id="taxacomo-' + cvalue + '" value=""><input type="hidden" name="taxavals[]" id="taxavals-' + cvalue + '" value=""><input type="hidden" name="taxaname[]" id="taxaname-' + cvalue + '" value=""><input type="hidden" name="taxaperc[]" id="taxaperc-' + cvalue + '" value=""><input type="hidden" name="taxacod[]" id="taxacod-' + cvalue + '" value=""><input type="hidden" name="taxaid[]" id="taxaid-' + cvalue + '" value=""><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" id="verif_typ-' + cvalue + '" value="' + $(this).attr('data-verif_typ') + '"  name="verif_typ[]"></tr><tr id="ppid-' + cvalue + '" class="m-0 pt-1 pb-1 border-bottom"><td colspan="2" ><input type="text" readonly class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') +'"><td colspan="4" ><input type="text" readonly class="form-control" id="product_description-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off" value="' + $(this).attr('data-disc') + '"></td></td></tr>';
		//ajax request
		// $('#saman-row').append(data);
		$('#pos_items').append(data);
		rowTotalNew(cvalue,true);
		$('#ganak').val(cvalue + 1);
		$('#amount-' + cvalue).focus();
	}
	var whr = $('#s_warehouses option:selected').val();
	var cat = $('#categories option:selected').val();
	$.ajax({
		type: "POST",
		url: baseurl + 'search_products/pos_search',
		data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash+'&bar=' + $('#bar_only').prop('checked')+'&bar=' + $('#bar_only').prop('checked'),
		beforeSend: function () {
			$("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
		},
		success: function (data) {
			$("#pos_item").html(data);

		}
	});
});

$(document).on('click', ".select_pos_item_bar", function (e) {
 if (!$('#search_bar').is('[readonly="true"]') ) {

     wait = false;
     var pid = $(this).attr('data-pid');
	 var verif_typ = $(this).attr('data-verif_typ');
     var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

     var discount = $(this).attr('data-discount');
     var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
     if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
     var flag = true;
     var barcode_flag = true;

     var bar = $(this).attr('data-bar');
     var search = $('#search_bar').val();
	 $('#search_bar').attr('readonly',false);
     $('#search_bar').val('');
     if (bar && search && bar == search) {

         $('.pdIn').each(function () {

             if (pid == $(this).val()) {
                 var pi = $(this).attr('id');
                 var arr = pi.split('-');
                 pi = arr[1];
                 $('#discount-' + pi).val(discount);
                 var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;
                 if (stotal <= stock && barcode_flag || verif_typ == 0) {
                     $('#amount-' + pi).val(accounting.formatNumber(stotal));
                     $('#search_bar').val('').focus();
                 } else {
					 $('#stock_alert').modal('toggle');
                 }
                 rowTotalNew(pi,true);
                 flag = false;
             }
         });
         var t_r = $(this).attr('data-tax');
         if ($("#taxformat option:selected").attr('data-trate')) {

             var t_r = $("#taxformat option:selected").attr('data-trate');
         }
         var sound = document.getElementById("beep");
         sound.play();
         if (flag && barcode_flag) {
             var ganak = $('#ganak').val();
             var cvalue = parseInt(ganak);
             var functionNum = "'" + cvalue + "'";
             count = $('#saman-row-invoice div').length;
             //var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" inputmode="numeric" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '" inputmode="numeric"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"></div>';
             var data = '<tr id="ppid-' + cvalue + '" class="m-0 pt-1 pb-1 border-bottom"><td colspan="6" ><input type="text" class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" id="verif_typ-' + cvalue + '" value="' + $(this).attr('data-verif_typ') + '"  name="verif_typ[]"></td></tr><tr><td><div class="quantity-nav"><div class="input-group"><input type="text" inputmode="numeric" class="form-control p-mobile p-width req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off" value="1" ><span id="product_uni-' + cvalue + '" name="product_uni[]" class="lightMode" value="'+$(this).attr('data-unit')+'"></span></div><div class="quantity-button quantity-up" id="qtdup-' + cvalue + '">+</div><div class="quantity-button quantity-down" id="qtddown-' + cvalue + '">-</div></div></td> <td><input type="text" class="form-control p-width p-mobile req prc" name="product_price[]"  inputmode="numeric" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off"  value="' + $(this).attr('data-price') + '"></td><td><input type="text" class="form-control p-width p-mobile discount pos_w" name="product_discount[]" inputmode="numeric" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotalNew(' + functionNum + ')" autocomplete="off"  value="' + discount + '" inputmode="numeric"></td> <td><input type="text" disabled class="form-control p-width p-mobile text-center" id="texttaxa-' + cvalue + '" value="0%"></td><td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInputsub" name="subtotal[]" id="subtotal-' + cvalue + '" value="0"><input type="hidden" class="ttInputtot2" name="product_tax[]" id="product_tax-' + cvalue + '" value="0"><input type="hidden" class="ttInputtot" name="total[]" id="total-' + cvalue + '" value="0"><input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"><input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"><input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"><input type="hidden" name="taxacomo[]" id="taxacomo-' + cvalue + '" value=""><input type="hidden" name="taxavals[]" id="taxavals-' + cvalue + '" value=""><input type="hidden" name="taxaname[]" id="taxaname-' + cvalue + '" value=""><input type="hidden" name="taxaperc[]" id="taxaperc-' + cvalue + '" value=""><input type="hidden" name="taxacod[]" id="taxacod-' + cvalue + '" value=""><input type="hidden" name="taxaid[]" id="taxaid-' + cvalue + '" value=""></tr>';
			 //ajax request
             // $('#saman-row').append(data);
             $('#pos_items').append(data);
             rowTotalNew(cvalue,true);
             $('#ganak').val(cvalue + 1);

         }
     }
     asyncFunctionCall();

     wait = true;
     return false;
}

});

$(document).on('click', ".quantity-up", function (e) {
	var pi = $(this).attr('id');
	var arr = pi.split('-');
	pi = arr[1];
	
	var verify_typ = $("#verif_typ-" + pi).val();
	var stock = accounting.unformat($('#alert-' + pi).val(), accounting.settings.number.decimal);
	var oldValue = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal);
	var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue + 1;
    }
	
	if (newVal <= stock || verify_typ == 0) {
		$('#amount-' + pi).val(accounting.formatNumber(newVal));
	} else {
		$('#stock_alert').modal('toggle');
	}
	rowTotalNew(pi,true);
    return false;
});

$(document).on('click', ".quantity-down", function (e) {
	var pi = $(this).attr('id');
	var arr = pi.split('-');
	pi = arr[1];
	
	var verify_typ = $("#verif_typ-" + pi).val();
	var stock = accounting.unformat($('#alert-' + pi).val(), accounting.settings.number.decimal);
	var oldValue = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal);
	var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue - 1;
    }
	
	if (newVal <= stock) {
		$('#amount-' + pi).val(accounting.formatNumber(newVal));
	} else {
		if(verify_typ == 1){
			$('#stock_alert').modal('toggle');
		}
	}
	rowTotalNew(pi,true);
    return false;
});


var billUpyogPOS = function () {
	var itempriceList = [];
    var idList = [];
	var r = 0;
    $('.ttInputsub').each(function () {
        var vv = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var vid = $(this).attr('id');
        vid = vid.split("-");
        itempriceList.push(vv);
        idList.push(vid[1]);
    });
	
	
}