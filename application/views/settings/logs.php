<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Application Activity Log') ?>
        </h5>
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
    <div class="card-header">

    </div>
    <div class="card-body">

        <div class="alert alert-info" id="alert-info-text">
            <p><?php echo $this->lang->line('Application Activity Log cleanup can be managed in Cron Job Settings.') ?></p>
        </div>
        <table class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo $this->lang->line('Description') ?></th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Name') ?></th>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($acts as $row) {

                echo "<tr><td>" . $row['note'] . "</td><td>" . $row['created'] . "</td><td>" . $row['user'] . "</td></tr>";
            }
            ?>
            </tbody>

        </table>
    </div>
</div>


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('Delete') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="settings/taxslabs_delete">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>