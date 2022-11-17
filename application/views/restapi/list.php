<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Access Key List') ?> <a href="<?php echo base_url('restapi/add') ?>"
                                                                  class="btn btn-primary btn-sm btn-new">
                <?php echo $this->lang->line('Add new') ?>
            </a>
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
    <?php if ($message) {

        echo '<div id = "notify" class="alert alert-success"  >
            <a href = "#" class="close" data-dismiss = "alert" >&times;</a >

            <div class="message" >Api key added successfully!</div >
        </div >';
    } ?>
    <div class="card-body">
        <table id="acctable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Key') ?></th>
                <th><?php echo $this->lang->line('Created On') ?></th>
                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;

            foreach ($keys as $row) {
                $id = $row['id'];
                $key = $row['key'];
                $datec = $row['date_created'];

                echo "<tr>
                    <td>$i</td>
                    <td>$key</td>
                    <td>$datec</td>
                 
                    
                    <td><div class='action-btn'> <a href='#' data-object-id='" . $id . "' class='btn btn-outline-danger btn-sm delete-object' title='Delete'><i class='bi bi-trash'></i></a></div></td></tr>";
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({responsive: true});

    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this key') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="restapi/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>