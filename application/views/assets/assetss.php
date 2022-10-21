<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5> <?php echo $this->lang->line('Assets') ?><a href="<?php echo base_url('assests/add') ?>" class="btn btn-primary btn-sm rounded" <?php if($this->aauth->premission(93) || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) echo ''; else echo 'hidden' ?>>
                    <?php echo $this->lang->line('New Assets') ?>
                </a></h5>
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
                <table id="asstable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Category') ?></th>
						<th><?php echo $this->lang->line('Qty') ?></th>
                        <th><?php echo $this->lang->line('Description') ?></th>
                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>

                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Category') ?></th>
						<th><?php echo $this->lang->line('Qty') ?></th>
                        <th><?php echo $this->lang->line('Description') ?></th>
						<th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
	 </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#asstable').DataTable({
			'processing': true,
			'serverSide': true,
			'stateSave': true,
			<?php datatable_lang();?>
			responsive: true,
			'order': [],
			'ajax': {
				'url': "<?php echo site_url('assests/assets_list')?>",
				'type': 'POST',
				'data': {
					'<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
				}
			},
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
						columns: [2, 3, 4, 5, 6]
					}
				}
			],
		});
	});
</script>
<div id="delete_model" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p><?php echo $this->lang->line('delete this assets') ?></p>
			</div>
			<div class="modal-footer">
				<input type="hidden" id="object-id" value="">
				<input type="hidden" id="action-url" value="assests/delete_i">
				<button type="button" data-dismiss="modal" class="btn btn-primary"
						id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
				<button type="button" data-dismiss="modal"
						class="btn"><?php echo $this->lang->line('Cancel') ?></button>
			</div>
		</div>
	</div>
</div>