<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Employee') . ' : ' . $employee['name'] ?> <a
                        href="<?php echo base_url('employee/view?id=' . $employee['id']) ?>"
                        class="btn btn-primary btn-sm btn-new">
                    <?php echo $this->lang->line('View') ?>
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

                        <th><?php echo $this->lang->line('Month') ?></th>
                        <th><?php echo $this->lang->line('Year') ?></th>
                        <th><?php echo $this->lang->line('Total Salary') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($salary_process as $salary) : ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $salary['month'] ?></td>
                            <td><?php echo $salary['year'] ?></td>
                            <td><?php echo $salary['total_transfer'] ?></td>
                            <td>
                                <div class="action-table">
                                    <div class="action-btn">
                                        <a href="<?php echo base_url('employee/view_salary_process?id=' . $salary['id']) ?>"
                                           class="btn btn-sm btn-outline-info"
                                           title="<?php echo $this->lang->line('View Salary') ?>"><i
                                                    class="bi bi-cash-stack"></i>

                                        </a>
										<a id="generate_salary"
                                           href="<?php echo base_url('export/employee_salary?id=' . $salary['id']) ?>"
                                           title="<?php echo $this->lang->line('Export PDF') ?>"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-filetype-pdf"></i>

                                        </a>
                                        <a id="generate_salary_print"
                                           href="<?php echo base_url('export/employee_salary?id=' . $salary['id'].'&d=0') ?>"
                                           title="<?php echo $this->lang->line('Print') ?>"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="fa fa-print"></i>

                                        </a>
                                        <a href="#" data-object-id="<?php echo $salary['id'] ?>"
                                           data-object-tid="<?php echo $salary['id'] ?>" data-object-draft="0"
                                           class="btn btn-sm btn-outline-danger delete-object"
                                           title="<?php echo $this->lang->line('Delete') ?>"><i
                                                    class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="salary_month" class="col-form-label">Mês:</label>
                        <select name="salary_month" id="salary_month" class="form-control">
                            <?php for ($i = 1; $i < 13; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="salary_year" class="col-form-label">Ano</label>
                        <select name="salary_year" id="salary_year" class="form-control">
                            <?php for ($i = 2021; $i < 2030; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="col-12">
                            <label for="credit_value" class="col-form-label">Valor A Crédito</label>
                            <code><?php echo $this->lang->line('Values to add in salary') ?></code>
                            <input type="text" name="credit_value" class="form-control" id="credit_value" value="0">
                        </div>
                        <div class="col-12">
                            <label for="debit_value" class="col-form-label">Valor a Débito</label>
                            <code><?php echo $this->lang->line('Values to subtration in salary') ?></code>
                            <input type="text" name="debit_value" class="form-control" id="debit_value" value="0">
                        </div>
                        <div class="col-sm-12" id="paiCompanyUpdate">
                            <a id="generate_salary_form" style="margin-top: 20px"
                               href="<?php echo base_url('employee/salary_generate?id=' . $eid) ?>"
                               class="btn btn-primary ">
                                <?php echo $this->lang->line('Salary Generate') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            //datatables
            $('#emptable').DataTable({responsive: true});
        });

        $('#generate_salary_form').click(function (e) {
            // e.preventDefault();
            var month = $("#salary_month").val();
            var year = $("#salary_year").val();
            var debit = $("#debit_value").val();
            var credit = $("#credit_value").val();
            var actionurl = $(this).attr('href');

            var newUrl = actionurl + "&month=" + month + "&year=" + year + "&debit_value=" + debit + "&credit_value=" + credit;

            $(this).attr('href', newUrl);
        });


    </script>


    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Apagar Geramento de Salário</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Tem a certeza que pretende apagar este registo ? <br></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="object-tid" value="">
                    <input type="hidden" id="object-tdraft" value="">
                    <input type="hidden" id="action-url" value="employee/delete_history">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Confirm
                    </button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>