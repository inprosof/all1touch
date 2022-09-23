<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Business Location') ?></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">


                <form method="post" id="data_form" class="form-horizontal">
					<div class="card-body">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" id="base-tab1" data-toggle="tab"
								   aria-controls="tab1" href="#tab1" role="tab"
								   aria-selected="true">Geral</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
								   href="#tab2" role="tab"
								   aria-selected="false">Financeiro</a>
							</li>
							  <li class="nav-item">
								<a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
								   href="#tab3" role="tab"
								   aria-selected="false">Faturação</a>
							</li>
						</ul>
						<div class="tab-content px-1 pt-1">
							<div class="tab-pane active show" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label"
										   for="name"><?php echo $this->lang->line('Name') ?></label>
									<div class="col-sm-8">
										<input type="text" placeholder="Name"
											   class="form-control margin-bottom required" name="name"
											   value="<?php echo $cname ?>">
									</div>
								</div>
								<div class="form-group row">

									<label class="col-sm-2 col-form-label"
										   for="address"><?php echo $this->lang->line('Address') ?></label>

									<div class="col-sm-8">
										<input type="text" placeholder="Address"
											   class="form-control margin-bottom" name="address"
											   value="<?php echo $address ?>">
									</div>
								</div>

								<div class="form-group row">

									<label class="col-sm-2 col-form-label"
										   for="city"><?php echo $this->lang->line('City') ?></label>

									<div class="col-sm-8">
										<input type="text" placeholder="City"
											   class="form-control margin-bottom" name="city" value="<?php echo $city ?>">
									</div>
								</div>


								<div class="form-group row">

									<label class="col-sm-2 control-label"
										   for=region"><?php echo $this->lang->line('Region') ?></label>

									<div class="col-sm-8">
										<input type="text" placeholder="Region"
											   class="form-control margin-bottom" name="region" value="<?php echo $region ?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label"
										   for="country"><?php echo $this->lang->line('Country') ?></label>
									<div class="col-sm-6">
										<select name="country" class="form-control b_input">
											<?php
											echo '<option value="' . $country . '">-' . ucfirst($country) . '-</option>';
											echo $countrys;
											?>
										</select>
									</div>
								</div>
								<div class="form-group row">

									<label class="col-sm-2 control-label"
										   for="postbox"><?php echo $this->lang->line('Postbox') ?></label>

									<div class="col-sm-8">
										<input type="text" placeholder="postbox"
											   class="form-control margin-bottom" name="postbox" value="<?php echo $postbox ?>">
									</div>
								</div>

								<div class="form-group row">

									<label class="col-sm-2 control-label"
										   for="phone"><?php echo $this->lang->line('Phone') ?></label>

									<div class="col-sm-8">
										<input type="text" placeholder="Phone"
											   class="form-control margin-bottom" name="phone" value="<?php echo $phone ?>">
									</div>
								</div>

								<div class="form-group row">

									<label class="col-sm-2 control-label"
										   for="email"><?php echo $this->lang->line('Email') ?></label>

									<div class="col-sm-8">
										<input type="text" placeholder="Email"
											   class="form-control margin-bottom required" name="email" value="<?php echo $email ?>">
									</div>
								</div>
								
								<div class="form-group row"><label
									class="col-sm-2 col-form-label"><?php echo $this->lang->line('Company Logo') ?></label>
									<div class="col-sm-6">
										<table id="files" class="files">
											<tr>
												<td>
													<a data-url="<?php echo base_url() ?>locations/file_handling?op=delete&name=<?php echo $logo ?>"
													   class="aj_delete"><i
																class="btn-danger btn-sm icon-trash-a"></i> <?php echo $logo ?> </a><img
															style="max-height:200px;"
															src="<?php echo base_url() ?>userfiles/company/<?php echo $logo ?>">
												</td>
											</tr>
										</table>
										<br>
										<span class="btn btn-success fileinput-button">
											<i class="glyphicon glyphicon-plus"></i>
											<span>Select files...</span>
																	<!-- The file input field used as target for the file upload widget -->
											<input id="fileupload" type="file" name="files[]">
										</span>
										<br>
										<pre>Allowed: gif, jpeg, png</pre>
										<br>
										<!-- The global progress bar -->
										<div id="progress" class="progress">
											<div class="progress-bar progress-bar-success"></div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
								<div class="form-group row">

									<label class="col-sm-2 control-label"
										   for="taxid"><?php echo $this->lang->line('TAX ID') ?></label>

									<div class="col-sm-8">
										<input type="text" placeholder="taxid"
											   class="form-control margin-bottom required" name="taxid" value="<?php echo $taxid ?>">
									</div>
								</div>

								<div class="form-group row">

									<label class="col-sm-2 control-label"
										   for="warehouse"><?php echo $this->lang->line('Warehouse') ?> <?php echo $this->lang->line('Default') ?></label>
									<div class="col-sm-8">
										<select name="wid"
												class="selectpicker form-control round required">
											<?php 
												echo '<option value="' . $ware . '" selected>--' . $namewar . '--</option>';
												foreach ($warehouse as $row) {
													echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
												}
											?>

										</select>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-2 control-label"
										   for="typedoc">Documentos <?php echo $this->lang->line('Default') ?> e POS</label>
									<div class="col-sm-8">
										<select name="type_doc"
												class="selectpicker form-control round required">
											<?php
												echo '<option value="' . $doc_default . '" selected>--' . $nametipdoc . '--</option>';
												echo $irs_typ;
											?>

										</select>
									</div>
								</div>
								<div class="form-group row">

									<label class="col-sm-2 col-form-label"
										   for="account">Conta para Vendas Online</label>

									<div class="col-sm-5">
										<select name="account_v" class="form-control">

											<?php
											echo '<option value="' . $online_pay['id'] . '" selected>--' . $online_pay['holder'] . ' / ' . $online_pay['acn'] . '--</option>';
											foreach ($accounts as $row) {
												echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="rent_ab" id="rent_ab" value="<?php echo $rent_ab ?>" <?php if ($rent_ab == 1) echo 'checked="checked"' ?>>
									<label class="custom-control-label" for="rent_ab"><?php echo "Retalhista ou vendedor ambulante" ?></label>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label" for="taxid">Zona Fiscal</label>
									<div class="col-sm-4">
										<select name="zon_fis" class="selectpicker form-control required">
											<?php echo '<option value="' . $zon_fis . '">--';
											if($zon_fis == 0) 
												echo $this->lang->line('Default');
											else if($zon_fis == 1) 
												echo 'Açores';
											else 
												echo 'Madeira';
											echo '--</option>';
											?>
											<option value="0"><?php echo $this->lang->line('Default') ?></option>
											<option value="1">Açores</option>
											<option value="2">Madeira</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 control-label"
										   for="cur_id"><?php echo $this->lang->line('Payment Currency client') ?></label>
									<div class="col-sm-4">
										<select name="cur_id" class="selectpicker form-control required">
											<?php foreach ($currency as $row) {
												if ($cur == $row['id']) echo '<option value="' . $row['id'] . '" selected>--' . $row['symbol'] . ' (' . $row['code'] . ')--</option>';
												echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
											} ?>

										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					

                    

                    


                    

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Edit') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="locations/edit" id="action-url">
                            <input type="hidden" value="<?php echo $id ?>" name="id">
                        </div>
                    </div>

                    <input type="hidden" name="image" id="image" value="<?php echo $logo ?>">
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script>
        /*jslint unparam: true */
        /*global window, $ */
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '<?php echo base_url() ?>locations/file_handling';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                done: function (e, data) {
                    var img = 'default.png';
                    $.each(data.result.files, function (index, file) {
                        $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>locations/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/company/' + file.name + '"></td></tr>');
                        img = file.name;
                    });

                    $('#image').val(img);
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });

        $(document).on('click', ".aj_delete", function (e) {
            e.preventDefault();

            var aurl = $(this).attr('data-url');
            var obj = $(this);

            jQuery.ajax({

                url: aurl,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    obj.closest('tr').remove();
                    obj.remove();
                }
            });

        });
    </script>