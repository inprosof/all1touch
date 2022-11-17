<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Departments') ?> <a href="<?php echo base_url('employee/adddep') ?>"
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
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <table id="emptable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>


                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;

                    foreach ($department_list as $row) {
                        $aid = $row['id'];
                        $username = $row['val1'];
                        $name = $row['val2'];


                        echo "<tr>
<td>" . $i . "</td>
                    <td>" . $row['val1'] . "</td>
                    
                 
                    <td><div class='action-btn'><a href='" . base_url("employee/department?id=$aid") . "' class='btn btn-outline-success btn-sm' title='" . $this->lang->line('View') . "'><i class='bi bi-eye'></i> </diva> <a href='" . base_url("employee/editdep?id=$aid") . "' class='btn btn-outline-primary  btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i> </a> <a href='#' data-object-id='$aid' class='btn btn-outline-danger delete-object  btn-sm' title='" . $this->lang->line('Delete') . "'><span class='bi bi-trash'></span></a></td></tr></div>";
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>


                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#emptable').DataTable({responsive: true});


        });

        $('.delemp').click(function (e) {
            e.preventDefault();
            $('#empid').val($(this).attr('data-object-id'));

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
                    <?php echo $this->lang->line('Delete');
                    echo ' ' . $this->lang->line('Department'); ?>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="employee/delete_dep">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Yes') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('No') ?></button>
                </div>
            </div>
        </div>
    </div>