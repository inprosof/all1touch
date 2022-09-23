<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <h5 class="title">
                <?php echo $this->lang->line('Withholding') ?> <a
                        href="<?php echo base_url('settings/taxwithholdings_new') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>

            <p>&nbsp;</p>
            <table class="table display" cellspacing="0" width="100%">
                <thead>
                <tr>
					<th><?php echo 'Cod.' ?></th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Rate') ?></th>
                    <th><?php echo $this->lang->line('Type') ?></th>
                    <th><?php echo $this->lang->line('Action') ?></th>
                </tr>
                </thead>
                <tbody>
					<?php foreach ($catlist as $row) {
						$cid = $row['id'];
						switch ($row['val3']) {
							case 'yes' :
								$t1 = 'Exclusive';
								break;
							case 'inclusive' :
								$t1 = 'Inclusive';
								break;
						}
						echo "<tr><td>" . $row['taxcode'] . "</td><td>" . $row['val1'] . "</td><td>" . $row['val2'] . "%</td><td>" . $t1 . "</td>
						<td><a href='" . base_url("settings/taxwithholdings_edit?id=$cid") . "' class='btn btn-warning btn-sm'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-sm delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
					}
                ?>
                </tbody>

            </table>
        </div>
    </div>
</article>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('Delete') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="settings/taxwithholdings_delete">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>