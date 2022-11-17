<div class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('View Salary Process') ?>
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
        <?php if ($this->session->flashdata('message')) : ?>
            <div id="notify" class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"><?php echo $this->session->flashdata('message'); ?></div>
            </div>
        <?php endif; ?>

        <form method="post" id="product_action" class="card-body">
            <input type="hidden" name="employee_id" value="<?php echo $employee['id'] ?>">
            <div class="form-group row">
                <div class="col-sm-10">
                    <h4 class="title">Employee: <?php echo $employee['name'] ?></h4>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="salary_month" class="col-form-label"><?php echo $this->lang->line('Month') ?></label>
                    <input type="text" class="form-control" value="<?php echo $process['month'] ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="salary_year" class="col-form-label"><?php echo $this->lang->line('Year') ?></label>
                    <input type="text" class="form-control" value="<?php echo $process['year'] ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="basic_salary" class="col-form-label">Base Salary</label>
                    <code>Define in Employee</code>
                    <input type="text" class="form-control" id="basic_salary"
                           value="<?php echo $process['monthly_basic_salary'] ?>" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="number_day_work_month" class="col-form-label">Number of working day per month</label>
                    <code>Add field in company edit</code>
                    <input type="text" class="form-control" id="number_day_work_month"
                           value="<?php echo $process['number_day_work_month'] ?>" disabled="disabled">

                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="basic_salary" class="col-form-label">Single day value</label>
                    <code> </code>
                    <input type="text" class="form-control" id="single_day_val"
                           value="<?php echo $process['single_day_val'] ?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="basic_salary" class="col-form-label">Single hour value</label>
                    <code> </code>
                    <input type="text" class="form-control" id="Single_Hour_value"
                           value="<?php echo $process['single_hour_val'] ?>" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="meal_subsidy" class="col-form-label"><strong>Meal Subsidy Base</strong></label>
                    <code>Add field in employee table day</code>
                    <input type="text" class="form-control" id="meal_subsidy_month"
                           value="<?php echo $process['monthly_meal'] ?>" disabled="disabled">
                </div>
            </div>

            <hr>

            <?php if ($process['faults_month'] > 0) { ?>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Faults Days</label>
                        <code> </code>
                        <input type="text" class="form-control" name="fault_month"
                               value="<?php echo $process['faults_month'] ?>" disabled="disabled">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Faults Justificated Days</label>
                        <code> </code>
                        <input type="text" class="form-control" name="fault_just_month"
                               value="<?php echo $process['faults_month_just'] ?>" disabled="disabled">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Faults Not Justificated Days</label>
                        <code> </code>
                        <input type="text" class="form-control" name="fault_not_just_month"
                               value="<?php echo $process['faults_month_not_just'] ?>" disabled="disabled">
                    </div>
                </div>
            <?php } ?>

            <hr>
            <?php if ($process['monthly_vacations'] > 0) { ?>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="vacation" class="col-form-label">Vacation days in month</label>
                        <code> </code>
                        <input type="text" class="form-control" id="vacation_month_days"
                               value="<?php echo $process['monthly_vacations'] ?>" disabled="disabled">
                    </div>
                </div>
            <?php } ?>

            <div class="form-group row">
                <div class="col-12">
                    <label for="vacation" class="col-form-label">Vacation Used this Year</label>
                    <code> </code>
                    <input type="text" class="form-control" id="vacationDaysYear"
                           value="<?php echo $process['vacationDaysYear'] ?>" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="vacation" class="col-form-label">Vacation Still This Year</label>
                    <code> </code>
                    <input type="text" class="form-control" id="vacation_total_still"
                           value="<?php echo $process['vacationDaysYearstill'] ?>" disabled="disabled">
                </div>
            </div>


            <?php if ($process['monthly_message'] > 0) { ?>
                <hr>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Holiday Days</label>
                        <code> </code>
                        <input type="text" class="form-control" name="holidays_month"
                               value="<?php echo $process['holidaysDaysMonth'] ?>" disabled="disabled">
                    </div>
                </div>
            <?php } ?>

            <hr>
            <div class="form-group row">
                <div class="col-12">
                    <label for="basic_salary" class="col-form-label">Total Days Works</label>
                    <code> </code>
                    <input type="text" class="form-control" name="days_work_in_month"
                           value="<?php echo $process['days_work_in_month'] ?>" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="monthly_base_salary" class="col-form-label"><strong>Monthly Base Salary to days
                            Works</strong></label>
                    <code> monthly base salary = (base salary * working days) / 30</code>
                    <input type="text" class="form-control" id="monthly_base_salary"
                           value="<?php echo $process['matury_monthly_salary'] ?>" disabled="disabled">
                </div>
            </div>

            <?php if ($process['monthly_vacations'] > 0) { ?>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="vacation" class="col-form-label">Vacation Value in month</label>
                        <code> </code>
                        <input type="text" class="form-control" id="vacation_month_value"
                               value="<?php echo $process['vacations_value'] ?>" disabled="disabled">
                    </div>
                </div>
            <?php } ?>

            <div class="form-group row">
                <div class="col-12">
                    <label for="meal_subsidy" class="col-form-label"><strong>Meal Subsidy in month</strong></label>
                    <code>Add field in employee table day</code>
                    <input type="text" class="form-control" id="meal_subsidy_month"
                           value="<?php echo $process['monthly_meal_subsidy'] ?>" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="productivity" class="col-form-label">Productivity or Performance Reward</label>
                    <code>Add field in employee table for month</code>
                    <input type="text" class="form-control" id="productivity"
                           value="<?php echo $process['produtivity_month_value'] ?>" disabled="disabled">
                </div>
            </div>

            <?php if ($process['monthly_message'] > 0) { ?>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Attendance Hours</label>
                        <code></code>
                        <input type="text" class="form-control" name="attendance_hour_month"
                               value="<?php echo $process['attendance_hour_mont'] ?>" disabled="disabled">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Attendance Value</label>
                        <code></code>
                        <input type="text" class="form-control" name="attendance_hour_month_value"
                               value="<?php echo $process['attendance_hour_month_value'] ?>" disabled="disabled">
                    </div>
                </div>
            <?php } ?>


            <?php if ($process['saleData'] > 0) { ?>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Sales Comission Rate</label>
                        <code></code>
                        <input type="text" class="form-control" name="saleCommissionRate"
                               value="<?php echo $process['saleCommissionRate'] ?>" disabled="disabled">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Sales Employee Count</label>
                        <code></code>
                        <input type="text" class="form-control" name="saleData"
                               value="<?php echo $process['saleData'] ?>" disabled="disabled">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="basic_salary" class="col-form-label">Sales Commission Value</label>
                        <code></code>
                        <input type="text" class="form-control" name="saleDataCommissionsValue"
                               value="<?php echo $process['saleDataCommissionsValue'] ?>" disabled="disabled">
                    </div>
                </div>
            <?php } ?>

            <hr>
            <div class="form-group row">
                <div class="col-12">
                    <label for="credit_value" class="col-form-label">Credit Value</label>
                    <code>Values to add in salary</code>
                    <input type="text" name="credit_value" class="form-control" id="credit_value"
                           value="<?php echo $process['total_credit'] ?>" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="debit_value" class="col-form-label">Debit Value</label>
                    <code>Values to subtration in salary</code>
                    <input type="text" name="debit_value" class="form-control" id="debit_value"
                           value="<?php echo $process['total_debit'] ?>" disabled="disabled">
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <div class="col-12">
                    <label for="social_security" class="col-form-label"><strong>Social Sercurity</strong></label>
                    <code></code>
                    <input type="text" class="form-control" id="social_security"
                           value="<?php echo $process['monthly_social_security'] ?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="irs" class="col-form-label"><strong>Monthly IRS</strong></label>
                    <code></code>
                    <input type="text" class="form-control" id="irs_month" value="<?php echo $process['monthly_irs'] ?>"
                           disabled="disabled">
                </div>
            </div>

            <hr>
            <div class="form-group row">
                <div class="col-12">
                    <label for="irs" class="col-form-label"><strong>Total gross Amount</strong></label>
                    <code></code>
                    <input type="text" class="form-control" id="total_gross_month"
                           value="<?php echo $process['gross_income'] ?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="irs" class="col-form-label"><strong>Total Dedutions</strong></label>
                    <code>(SS+IRS)</code>
                    <input type="text" class="form-control" id="total_dedutions_month"
                           value="<?php echo $process['total_income'] ?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="irs" class="col-form-label"><strong>Total Gross Subtration Dedutions
                            Amount</strong></label>
                    <code>Total gross - (SS+IRS)</code>
                    <input type="text" class="form-control" id="total_minus_discont_month"
                           value="<?php echo $process['total_net'] ?>" disabled="disabled">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="basic_salary" class="col-form-label">Total Net Salary</label>
                    <code>Total to transfer this Month</code>
                    <input type="text" class="form-control" id="total_net_month"
                           value="<?php echo $process['total_transfer'] ?>" disabled="disabled">
                </div>
            </div>

            <hr>
            <div class="form-group row">
                <div class="col-12">
                    <label for="message" class="col-form-label">Message</label>
                    <p><?php echo $process['monthly_message'] ?></p>
                </div>
            </div>
        </form>
    </div>
</div>

