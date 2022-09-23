<div class="card card-block">
	<div class="card-header">
		<h4 class="card-title"><?php echo $this->lang->line('saft1') ?></h4>

		<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
				<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
				<li><a data-action="close"><i class="ft-x"></i></a></li>
			</ul>
		</div>
	</div>
	<div id="notify" class="alert alert-success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert">&times;</a>
	  <div class="message"></div>
	</div>
	
	<div class="card">
		<div class="card-content">
			<div class="card-body">
				<form method="post" id="product_action" action="<?php echo base_url('export/exportSaft'); ?>" class="form-horizontal">
					<div class="grid_3 grid_4">
						<h5><?php echo $this->lang->line('saft2')?></h5>
						<hr>
						<h6><?php echo $this->lang->line('saft3')?></h6>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label"
								   for="pay_cat"><?php echo $this->lang->line('Business Locations') ?></label>
							<div class="col-sm-6">

								<select name="pay_acc" class="form-control">

									<option value='0'><?php echo $this->lang->line('All') ?></option>
									<?php
									foreach ($locations as $row) {
										$cid = $row['id'];
										$acn = $row['cname'];
										$holder = $row['address'];
										echo "<option value='$cid'>$acn - $holder</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label"
								   for="sdate"><?php echo $this->lang->line('From Date') ?></label>
							<div class="col-sm-4">
								<input type="text" class="form-control required"
									   placeholder="Start Date" name="sdate" id="sdate"
									   data-toggle="datepicker" autocomplete="false">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label"
								   for="edate"><?php echo $this->lang->line('To Date') ?></label>
							<div class="col-sm-4">
								<input type="text" class="form-control required"
									   placeholder="End Date" name="edate"
									   data-toggle="datepicker" autocomplete="false">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-labe"
								   for="version"><?php echo $this->lang->line('saft5') ?>*</label>
							<div class="col-sm-4">
								<select name="version" class="form-control required">
									<option value="0">1.03</option>
									<option value="1">1.04</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label"></label>
							<div class="col-sm-4">
								<input type="hidden" name="check" value="ok">
								<input type="submit" class="btn btn-success margin-bottom"
									   value="<?php echo $this->lang->line('saft4') ?>"
									   data-loading-text="Calculating...">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="card card-block">
		<div class="card-body">
			<h5><?php echo $this->lang->line('saft6') ?></h5>
			<hr>
			<h6><?php echo $this->lang->line('saft7') ?></h6>
			<div class="form-group row">
				<div class="col-sm-4">
					<h3 class="title">
						<a href='#' class="btn btn-primary btn-sm round" data-toggle="modal" data-target="#ativation">
							<?php echo $this->lang->line('saft8') ?>
						</a>
				</div>

			</div>

		</div>

	</div>



	<div class="card card-block">
		<div class="card-body">
			<h5><?php echo $this->lang->line('saft15') ?></h5>
			<hr>
			<h6><?php echo $this->lang->line('saft16') ?></h6>
			<div class="form-group row">
				<div class="col-sm-4">
					<h3 class="title">
						<a href='#' class="btn btn-primary btn-sm round" data-toggle="modal" data-target="#ativationcaixa">
							<?php echo $this->lang->line('saft8') ?>
						</a>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="ativationcaixa" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content ">
				<form method="post" id="save_val_ativate_caixa" class="form-horizontal">
					<input type="hidden" name="caixa_id_saft" id="caixa_id_saft" value="<?php echo $activation_caixa['idsaftcaixa'] ?>">
					<div class="modal-header bg-gradient-directional-purple white">
						<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('saft15') ?></h4>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
						</button>
					</div>
					<!-- Modal Body -->
					<div class="modal-body">
						<p id="statusMsgCaixa"></p><input type="hidden" name="mstivateCaixa" id="mstivateCaixa" value="0">
						<div class="row">
							<div class="col-sm-6">
								<h5><?php echo $this->lang->line('saft17') ?></h5>
								<h6><?php echo $this->lang->line('saft18') ?></h6>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="caixa_1" id="caixa_1_t" value="<?php echo $activation_caixa['saft18'] ?>" <?php if ($activation_caixa['saft18'] == 1) echo 'checked="checked"' ?>>
									<label class="custom-control-label" for="caixa_1_t"><?php echo $this->lang->line('saft23') ?></label>
								</div>
								
								<h5><?php echo $this->lang->line('saft19') ?></h5>
								<h6><?php echo $this->lang->line('saft20') ?></h6>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="caixa_2" id="caixa_2_t" value="<?php echo $activation_caixa['saft20'] ?>" <?php if ($activation_caixa['saft20'] == 1) echo 'checked="checked"' ?>>
									<label class="custom-control-label" for="caixa_2_t"><?php echo $this->lang->line('saft24') ?></label>
								</div>
								
								<h5><?php echo $this->lang->line('saft21') ?></h5>
								<h6><?php echo $this->lang->line('saft22') ?></h6>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="caixa_3" id="caixa_3_t" value="<?php echo $activation_caixa['saft22'] ?>" <?php if ($activation_caixa['saft22'] == 1) echo 'checked="checked"' ?>>
									<label class="custom-control-label" for="caixa_3_t"><?php echo $this->lang->line('saft24') ?></label>
								</div>

								<div class="custom-control custom-checkbox">
									<input type="hidden" name="caixa_doc_date" id="caixa_doc_date" value="<?php echo $activation_caixa['saft26'] ?>">
									<input type="checkbox" class="custom-control-input" name="caixa_4" id="caixa_4_t" value="<?php echo $activation_caixa['saft25'] ?>" <?php if ($activation_caixa['saft25'] == 1) echo 'checked="checked"' ?> <?php if ($activation_caixa['saft18'] == 0 || $activation_caixa['saft20'] == 0 || $activation_caixa['saft22'] == 0) echo 'disabled' ?>>
									<label class="custom-control-label" for="caixa_4_t"><?php echo $this->lang->line('saft25') ?></label>
								</div>
							</div>
						</div>
					</div>

					<!-- Modal Footer -->

					<div class="modal-footer">
						<button type="button" class="btn btn-default"
								data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
								<button class="btn btn-primary submitBtn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<div class="modal fade" id="ativation" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content ">
				<form method="post" id="save_val_ativate" class="form-horizontal">
					<input type="hidden" name="id_saft_activ" id="id_saft_activ" value="<?php echo $activation['idsaftdocs'] ?>">
					<div class="modal-header bg-gradient-directional-purple white">
						<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('saft9') ?></h4>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
						</button>
					</div>
					<!-- Modal Body -->
					<div class="modal-body">
						<p id="statusMsg"></p><input type="hidden" name="mstivate" id="mstivate" value="0">
						<div class="row">
							<div class="col-sm-6">
								<h5><?php echo $this->lang->line('saft10') ?></h5>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="billing_doc" id="billing_doc" value="<?php echo $activation['saft11'] ?>" <?php if ($activation['saft11'] == 1) echo 'checked="checked"' ?>>
									<label class="custom-control-label" for="billing_doc"><?php echo $this->lang->line('saft11') ?></label>
								</div>
								
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="transport_doc_date" id="transport_doc_date" value="<?php echo $activation['saft16'] ?>">
									<input type="checkbox" class="custom-control-input" name="transport_doc" id="transport_doc" value="<?php echo $activation['saft12'] ?>" <?php if ($activation['saft12'] == 1) echo 'checked="checked"' ?>>
									<label class="custom-control-label" for="transport_doc"><?php echo $this->lang->line('saft12') ?></label>
								</div>

								<h5><?php echo $this->lang->line('saft13') ?></h5>

								<div class="form-group row">
									<label class="col-sm-2 col-form-label" for="username"><?php echo $this->lang->line('UserName') ?></label>
									<div class="col-sm-10">
										<input type="text" placeholder="Username" class="form-control margin-bottom crequired" name="username" id="username_a" value="<?php echo $activation['saft13'] ?>">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-2 col-form-label" for="email"><?php echo $this->lang->line('Your Password') ?></label>
									<div class="col-sm-10">
										<input type="password" placeholder="Password" class="form-control margin-bottom crequired" name="password" id="password_a" value="<?php echo $activation['saft14'] ?>">
									</div>
								</div>

								<h5><?php echo $this->lang->line('saft14') ?></h5>
								<div class="form-group row">
									<label class="col-sm-3 control-label" for="adate"><?php echo $this->lang->line('Date') ?></label>
									<div class="col-sm-4">
										<input type="text" class="form-control required" placeholder="Date" name="adate" id="adate" data-toggle="datepicker" autocomplete="false" value="<?php echo $activation['saft15'] ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal Footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
						<button class="btn btn-primary submitBtn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">

    $("#calculate_profit").click(function (e) {

        e.preventDefault();
		//Define the adress correct create the code in Controllers Export
        var actionurl = baseurl + 'export/exportSaft/';
        actionCaculate(actionurl);
    });

	$(document).on('submit', '#save_val_ativate', function (e) {
            e.preventDefault();
            var formdata = new FormData($("#save_val_ativate")[0]);
            $.ajax({
                url: baseurl + 'export/save_val_ativate',
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('.loader').hide();
                    if (data.status == 'Success') {
						$("#ativation").modal('hide');
						$('#response').html(data.message)
                    } else {
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
            
        });
		
	$(document).on('submit', '#save_val_ativate_caixa', function (e) {
            e.preventDefault();
            var formdata = new FormData($("#save_val_ativate_caixa")[0]);
            $.ajax({
                url: baseurl + 'export/save_val_ativate_caixa',
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('.loader').hide();
                    if (data.status == 'Success') {
						$("#ativationcaixa").modal('hide');
						$('#response').html(data.message)
                    } else {
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
            
        });
    setTimeout(function () {

        $.ajax({
			//Define the adress correct create the code in Controllers Export
            // url: baseurl + 'export/.......?p=saft',
			url: baseurl + 'export/?p=saft',
            dataType: 'json',
            success: function (data) {
                $('#p1').html(data.p1);
                $('#p2').html(data.p2);
            },

            error: function (data) {

                $('#response').html('Error')

            }
        });

    }, 2000);

</script>