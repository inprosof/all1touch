<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><h4><?php echo $this->lang->line('Supplier Details') ?><?php echo ': '.$details['name'] ?></h4>
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


                <div class="row">
                    <div class="col-md-4 border-right border-right-grey">
						<div class="ibox-content mt-2">
                            <img alt="image" id="dpic" class="card-img-top img-fluid"
                                 src="<?php echo base_url('userfiles/suppliers/') . $details['picture'] ?>">
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="<?php echo base_url('supplier/view?id=' . $details['id']) ?>"
                                   class="btn btn-blue btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-user"></i> <?php echo $this->lang->line('View') ?></a>
                                <a href="<?php echo base_url('supplier/invoices?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-file-text"></i> <?php echo $this->lang->line('View Invoices') ?>
                                </a>
								<a href="<?php echo base_url('supplier/statement?id=' . $details['id']) ?>"
                                   class="btn btn-primary btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Account Statements') ?>
                                </a>
								<a href="<?php echo base_url('supplier/products?id=' . $details['id']) ?>"
                                  class="btn btn-purple btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-quote-left"></i> Ver Produtos Associados
                                </a>
								<a href="<?php echo base_url('supplier/purchaseorder?id=' . $details['id']) ?>"
                                   class="btn btn-primary btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-bullhorn"></i> Ver Notas de Encomendas
                                </a>
								<a href="<?php echo base_url('supplier/invoices?id=' . $details['id']) ?>&t=sub"
                                   class="btn btn-flickr btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('Subscriptions') ?>
                                </a>
								<a href="<?php echo base_url('supplier/transactions?id=' . $details['id']) ?>"
                                   class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                                            class="fa fa-money"></i> <?php echo $this->lang->line('View Transactions') ?>
                                </a>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-8">
                        <div id="mybutton" class="mb-1">

                            <div class="">
                                <a href="#sendMail" data-toggle="modal" data-remote="false"
								   class="btn btn-primary btn-md  " data-type="reminder"><i
											class="icon-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
								</a>
								<a href="<?php echo base_url('supplier/bulkpayment?id=' . $details['id']) ?>"
                                   class="btn btn-grey-blue btn-md"><i
                                            class="fa fa-money"></i> <?php echo $this->lang->line('Bulk Payment') ?>
                                </a>
								<a href="<?php echo base_url('supplier/edit?id=' . $details['id']) ?>"
								   class="btn btn-warning btn-md"><i
											class="icon-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
								</a>
                            </div>

                        </div>
                        <hr>
                        <h4><?php echo $this->lang->line('Transactions') ?></h4>
                        <hr>
                        <table id="ts_table" class="table table-striped table-bordered zero-configuration"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th><?php echo $this->lang->line('Debit') ?></th>
                                <th><?php echo $this->lang->line('Credit') ?></th>
                                <th><?php echo $this->lang->line('Account') ?></th>
                                <th><?php echo $this->lang->line('Method') ?></th>
                                <th><?php echo $this->lang->line('Action') ?></th>


                            </tr>
                            </thead>
                            <tbody>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th><?php echo $this->lang->line('Debit') ?></th>
                                <th><?php echo $this->lang->line('Credit') ?></th>
                                <th><?php echo $this->lang->line('Account') ?></th>

                                <th><?php echo $this->lang->line('Method') ?></th>
                                <th><?php echo $this->lang->line('Action') ?></th>
                            </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="sendMail" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title">Email</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-body">
				<form id="sendmail_form"><input type="hidden"
												name="<?php echo $this->security->get_csrf_token_name(); ?>"
												value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="col">
							<div class="input-group">
								<div class="input-group-addon"><span class="icon-envelope-o"
																	 aria-hidden="true"></span></div>
								<input type="text" class="form-control" placeholder="Email" name="mailtoc"
									   value="<?php echo $details['email'] ?>">
							</div>

						</div>

					</div>


					<div class="row">
						<div class="col mb-1"><label
									for="shortnote"><?php echo $this->lang->line('Name') ?></label>
							<input type="text" class="form-control"
								   name="suppliername" value="<?php echo $details['name'] ?>"></div>
					</div>
					<div class="row">
						<div class="col mb-1"><label
									for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
							<input type="text" class="form-control"
								   name="subject" id="subject">
						</div>
					</div>
					<div class="row">
						<div class="col mb-1"><label
									for="shortnote"><?php echo $this->lang->line('Message') ?></label>
							<textarea name="text" class="summernote" id="contents" title="Contents"></textarea>
						</div>
					</div>

					<input type="hidden" class="form-control"
						   id="cid" name="tid" value="<?php echo $details['id'] ?>">
					<input type="hidden" id="action-url" value="communication/send_general_s">


				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"
						data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
				<button type="button" class="btn btn-primary"
						id="sendNow"><?php echo $this->lang->line('Send') ?></button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

    var table;

    $(document).ready(function () {

        //datatables
        table = $('#ts_table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            responsive: true,
            <?php datatable_lang();?>

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('supplier/translist')?>",
                "type": "POST",
                "data": {'cid':<?php echo $_GET['id'] ?>, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": true, //set not orderable
                },
            ],

        });

    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>