<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Department') . ' :' . $department['val1'] ?> <a
                        href="<?php echo base_url('employee/departments') ?>"
                        class="btn btn-primary btn-sm btn-new">
                    <?php echo $this->lang->line('Departments') ?>
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
                        <th><?php echo $this->lang->line('Salary') ?></th>


                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;

                    foreach ($department_list as $row) {
                        $aid = $row['id'];

                        echo "<tr>
<td>" . $i . "</td>
                    <td>" . $row['name'] . "</td>
                       <td>" . $row['basic_salary'] . "</td>
                 
                    <td><div class='action-btn'> <a href='" . base_url("employee/attendances?id=$aid") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Attendance') . "'><i class='bi bi-stopwatch'></i> </a>  <a href='" . base_url("employee/payroll_emp?id=$aid") . "' class='btn btn-outline-blue btn-sm' title='" . $this->lang->line('Payroll') . "'><i class='bi bi-cash-stack'></i> </a> <a href='" . base_url("employee/view?id=$aid") . "' class='btn btn-outline-success btn-sm' title='" . $this->lang->line('View') . "'><i class='bi bi-eye'></i> </a> <a href='" . base_url("employee/history?id=$aid") . "' class='btn btn-outline-purple btn-sm' title='" . $this->lang->line('History') . "'><i class='bi bi-clock-history'></i> </a></div></td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
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
