<div class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <div class="message"></div>
        </div>
		<div class="card card-block">
            <form method="post" id="data_form" class="card-body">
				<input type="hidden" name="employee_id" value="<?php echo $employee['id']?>">
				<h5> <?php echo $this->lang->line('Salary Generate') ?> </h5>
				<hr>
				<div class="form-group row">
					<div class="col-sm-10">
						<h4>Employee: <?php echo $employee['name'] ?></h4>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="salary_month" class="col-form-label">Month:</label>
						<select name="salary_month" id="salary_month" class="form-control">
							<?php for($i = 1; $i < 13; $i++):?>
								<option value="<?php echo $i;?>" <?php echo $this->input->get('month') == $i ? 'selected': ''?>><?php echo $i;?></option>
							<?php endfor;?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="salary_year" class="col-form-label">Year</label>
						<select name="salary_year" id="salary_year" class="form-control">
							<?php for($i = 2021; $i < 2030; $i++):?>
								<option value="<?php echo $i;?>" <?php echo $this->input->get('year') == $i ? 'selected': ''?>><?php echo $i;?></option>
							<?php endfor;?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="basic_salary" class="col-form-label">Base Salary</label>
						<code>Define in Employee</code>
						<input type="text" class="form-control" id="basic_salary" value="<?php echo $basic_salary?>" readonly>
					</div>
				</div>
		
				<div class="form-group row">
					<div class="col-12">
						<label for="number_day_work_month" class="col-form-label">Number of working day per month</label>
						<code>Add field in company edit</code>
						<input type="text" class="form-control" id="number_day_work_month" value="<?php echo $number_day_work_month?>" readonly>
						
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="basic_salary" class="col-form-label">Single day value</label>
						<code> </code>
						<input type="text" class="form-control" id="single_day_val" value="<?php echo $single_day_val?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="basic_salary" class="col-form-label">Single hour value</label>
						<code> </code>
						<input type="text" class="form-control" id="Single_Hour_value" value="<?php echo $single_hour_val?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="meal_subsidy" class="col-form-label"><strong>Meal Subsidy</strong></label>
						<code>Add field in employee table day</code>
						<input type="text" class="form-control" id="meal_subsidy" value="<?php echo $meal_sub ?>" readonly>
					</div>
				</div>

				<hr>

				<?php if($fault_month > 0){ ?>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Faults Days</label>
							<code> </code>
							<input type="text" class="form-control" name="fault_month" value="<?php echo $fault_month?>" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Faults Justificated Days</label>
							<code> </code>
							<input type="text" class="form-control" name="fault_just_month" value="<?php echo $fault_just_month?>" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Faults Not Justificated Days</label>
							<code> </code>
							<input type="text" class="form-control" name="fault_not_just_month" value="<?php echo $fault_not_just_month?>" readonly>
						</div>
					</div>
				<?php } ?>

				<hr>
				<?php if($vacation_month_days > 0){ ?>
					<div class="form-group row">
						<div class="col-12">
							<label for="vacation" class="col-form-label">Vacation days in month</label>
							<code> </code>
							<input type="text" class="form-control" id="vacation_month_days" value="<?php echo $vacation_month_days ?>" readonly>
						</div>
					</div>
				<?php } ?>

				<div class="form-group row">
					<div class="col-12">
						<label for="vacation" class="col-form-label">Vacation Used this Year</label>
						<code> </code>
						<input type="text" class="form-control" id="vacationDaysYear" value="<?php echo $vacationDaysYear?>" readonly>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<label for="vacation" class="col-form-label">Vacation Still This Year</label>
						<code> </code>
						<input type="text" class="form-control" id="vacation_total_still" value="<?php echo $vacation_total_still?>" readonly>
					</div>
				</div>

				
				<?php if($holidays_month > 0){ ?>
					<hr>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Holiday Days</label>
							<code> </code>
							<input type="text" class="form-control" name="holidays_month" value="<?php echo $holidays_month?>" readonly>
						</div>
					</div>
				<?php } ?>

				<hr>
				<div class="form-group row">
					<div class="col-12">
						<label for="basic_salary" class="col-form-label">Total Days Works</label>
						<code> </code>
						<input type="text" class="form-control" name="days_work_in_month" value="<?php echo $days_work_in_month?>" readonly>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<label for="monthly_base_salary" class="col-form-label"><strong>Monthly Base Salary to days Works</strong></label>
						<code> monthly base salary = (base salary * working days) / 30</code>
						<input type="text" class="form-control" id="monthly_base_salary" value="<?php echo $matury_monthly_salary ?>" readonly>
					</div>
				</div>

				<?php if($vacation_month_days > 0){ ?>
					<div class="form-group row">
						<div class="col-12">
							<label for="vacation" class="col-form-label">Vacation Value in month</label>
							<code> </code>
							<input type="text" class="form-control" id="vacation_month_value" value="<?php echo $vacation_month_value ?>" readonly>
						</div>
					</div>
				<?php } ?>

				<div class="form-group row">
					<div class="col-12">
						<label for="meal_subsidy" class="col-form-label"><strong>Meal Subsidy in month</strong></label>
						<code>Add field in employee table day</code>
						<input type="text" class="form-control" id="meal_subsidy_month" value="<?php echo $meal_month_value ?>" readonly>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<label for="productivity" class="col-form-label">Productivity or Performance Reward</label>
						<code>Add field in employee table for month</code>
						<input type="text" class="form-control" id="productivity" value="<?php echo $produtivity_month_value ?>" readonly>
					</div>
				</div>

				<?php if($attendance_hour_month > 0){ ?>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Attendance Hours</label>
							<code></code>
							<input type="text" class="form-control" name="attendance_hour_month" value="<?php echo $attendance_hour_month?>" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Attendance Value</label>
							<code></code>
							<input type="text" class="form-control" name="attendance_hour_month_value" value="<?php echo $attendance_hour_month_value?>" readonly>
						</div>
					</div>
				<?php } ?>


				<?php if($saleData > 0){ ?>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Sales Comission Rate</label>
							<code></code>
							<input type="text" class="form-control" name="saleCommissionRate" value="<?php echo $saleCommissionRate?>" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Sales Employee Count</label>
							<code></code>
							<input type="text" class="form-control" name="saleData" value="<?php echo $saleData?>" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<label for="basic_salary" class="col-form-label">Sales Commission Value</label>
							<code></code>
							<input type="text" class="form-control" name="saleDataCommissionsValue" value="<?php echo $saleDataCommissionsValue?>" readonly>
						</div>
					</div>
				<?php } ?>

				<hr>
				<div class="form-group row">
					<div class="col-12">
						<label for="credit_value" class="col-form-label">Credit Value</label>
						<code>Values to add in salary</code>
						<input name="credit_value" type="text" rows="4" class="form-control" id="credit_value" value="<?php echo $credit_value?>" readonly></input>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<label for="debit_value" class="col-form-label">Debit Value</label>
						<code>Values to subtration in salary</code>
						<input name="debit_value" type="text" rows="4" class="form-control" id="debit_value" value="<?php echo $debit_value?>" readonly></input>
					</div>
				</div>
				<hr>

				<div class="form-group row">
					<div class="col-12">
						<label for="social_security" class="col-form-label"><strong>Social Sercurity</strong></label>
						<code></code>
						<input type="text" class="form-control" id="social_security" value="<?php echo $social_secur_month ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="irs" class="col-form-label"><strong>Monthly IRS</strong></label>
						<code></code>
						<input type="text" class="form-control" id="irs_month" value="<?php echo $irs_month ?>" readonly>
					</div>
				</div>
				
				<hr>
				<div class="form-group row">
					<div class="col-12">
						<label for="irs" class="col-form-label"><strong>Total gross Amount</strong></label>
						<code></code>
						<input type="text" class="form-control" id="total_gross_month" value="<?php echo $total_gross_month ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="irs" class="col-form-label"><strong>Total Dedutions</strong></label>
						<code>(SS+IRS)</code>
						<input type="text" class="form-control" id="total_dedutions_month" value="<?php echo $total_dedutions_month ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12">
						<label for="irs" class="col-form-label"><strong>Total Gross Subtration Dedutions Amount</strong></label>
						<code>Total gross - (SS+IRS)</code>
						<input type="text" class="form-control" id="total_minus_discont_month" value="<?php echo $total_minus_discont_month ?>" readonly>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-12">
						<label for="basic_salary" class="col-form-label">Total Net Salary</label>
						<code>Total to transfer this Month</code>
						<input type="text" class="form-control" id="total_net_month" value="<?php echo $total_net_month;?>" readonly>
					</div>
				</div>

				<hr>
				<div class="form-group row">
					<div class="col-12">
						<label for="message" class="col-form-label">Message</label>
						<textarea name="message" type="text" rows="4" class="form-control" id="message" ></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label"></label>
					<div class="col-sm-4">
						<input type="submit" id="submit-data" class="btn btn-success margin-bottom"
							   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
						<input type="hidden" value="employee/save_salary_process" id="action-url">
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

<script type="text/javascript">
    $("#salary_month").on("change", function () {
        var month = $(this).val();
        var year = $("#salary_year").val();
        location.href = location.href + "&month=" + month + "&year=" + year ;
    })

    $("#salary_year").on("change", function () {
        var year = $(this).val();
        var month = $("#salary_month").val();
        location.href = location.href + "&month=" + month + "&year=" + year ;
    })
</script>