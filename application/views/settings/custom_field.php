<article class="content-body">
    <div class="card card-block yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Custom') ?>  <?php echo $this->lang->line('Fields') ?> <a
                        href="<?php echo base_url('settings/add_custom_field') ?>"
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
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">

            <div class="m-1">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" <?php if (CUSTOM) echo 'checked=""'; ?>
                           name="customCheck" id="customCheck">
                    <label class="custom-control-label"
                           for="customCheck"> <?php echo $this->lang->line('Enable') . " " ?><?php echo $this->lang->line('Custom') . " " ?><?php echo $this->lang->line('Fields') . " " ?></label>
                </div>

            </div>
            <hr>
            <div class="table-responsive">
                <table id="catgtable" class="table table-striped table-bordered zero-configuration"
                       cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Type') ?></th>
                        <th><?php echo $this->lang->line('Module') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($customfields as $row) {
                        switch ($row['f_module']) {
                            case 2 :
                                $m = 'Faturas';
                                break;
                            case 3 :
                                $m = 'Orçamentos';
                                break;
                            case 4 :
                                $m = 'Fornecedores';
                                break;
                            case 5 :
                                $m = 'Produtos';
                                break;
                            case 6 :
                                $m = 'Funcionário';
                                break;
                            case 7 :
                                $m = 'Avenças';
                                break;
                            default:
                                $m = 'Clientes';

                        }

                        echo "<tr>
                    <td>$i</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['f_type'] . "</td>
                    <td>$m</td>
                 
                    <td><div class='action-btn'> <a href='" . base_url("settings/edit_custom_field?id=" . $row['id']) . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i> </a><a href='#' data-object-id='" . $row['id'] . "' class='btn btn-outline-danger btn-sm delete-object' title='Delete'><i class='bi bi-trash'></i></a></div></td></tr>";


                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Type') ?></th>
                        <th><?php echo $this->lang->line('Module') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#catgtable').DataTable({responsive: true});

    });
    $("#customCheck").click(function (e) {

        var enable = 0;
        var actionurl = baseurl + 'settings/allow_custom';
        if ($('#customCheck').is(":checked")) {
            enable = 1;
        }
        $.ajax({
            type: "POST",
            url: actionurl,
            data: {
                'enable': enable,
                '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'
            },
            cache: false,
            success: function (data) {
                return data;
            }
        });
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
                <p><strong>Atenção:</strong> Irá apagar o campo e todos os dados armazenados
                    neste.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="settings/delete_custom_field">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>