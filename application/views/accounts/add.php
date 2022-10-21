<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card card-block">
        <?php
        $attributes = array('class' => 'card-body', 'id' => 'data_form');
        echo form_open('', $attributes);
        ?>


        <h5><?php echo $this->lang->line('Add New Account') ?></h5>
        <hr>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label" for="holder"><?php echo $this->lang->line('Name') ?></label>
            <div class="col-sm-6">
                <input type="text" placeholder="Conta Receitas, Por exemplo.." class="form-control margin-bottom required" name="holder">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="accno"><?php echo $this->lang->line('Account No') ?> (IBAN)</label>
            <div class="col-sm-6">
                <input type="text" placeholder="PT50...Por exemplo" class="form-control margin-bottom required" name="accno">
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-2 col-form-label" for="acode">Código</label>
            <div class="col-sm-6">
                <input type="text" placeholder="CGD01...Por exemplo" class="form-control margin-bottom required" name="acode">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="intbal"><?php echo $this->lang->line('Intial Balance') ?></label>
            <div class="col-sm-6">
                <input type="text" placeholder="Valor em caixa inicial" onkeypress="return isNumber(event)" class="form-control margin-bottom required" name="intbal">
            </div>
        </div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="bank">Banco</label>
			<div class="col-sm-8">
				<input type="text" placeholder="Caixa, Montepio.." class="form-control margin-bottom  required" name="bank">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="branch">BICSWIFT</label>
			<div class="col-sm-8">
				<input type="text" placeholder="CGDIPTPL, Por exemplo..." class="form-control margin-bottom  required" name="branch">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="address"><?php echo $this->lang->line('Address') ?></label>
			<div class="col-sm-8">
				<input type="text" placeholder="Av. Central, 0000-000..." class="form-control margin-bottom  required" name="address">
			</div>
		</div>
		
		<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="lid"><?php echo $this->lang->line('Business Locations') ?></label>
					<div class="col-sm-6">
						<select name="lid" class="form-control">
							<option value=""><?php echo $this->lang->line('Please Select') ?></option>
							<?php
								if (!$this->aauth->get_user()->loc) echo "<option value='0'>" . $this->lang->line('All') . "</option>";
								foreach ($locations as $row) {
									$cid = $row['id'];
									$acn = $row['cname'];
									$holder = $row['address'];
									echo "<option value='$cid'>$acn - $holder</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row ">
					<label class="col-sm-2 col-form-label" for="account_type"><?php echo $this->lang->line('AccountType') ?></label>
					<div class="col-sm-6">
						<select name="account_type" class="form-control">
							<option value=""><?php echo $this->lang->line('Please Select') ?></option>
							<option value='Basic'><?php echo $this->lang->line('Default') ?></option>
							<option value='Assets'><?php echo $this->lang->line('Assets') ?></option>
							<option value='Expenses'><?php echo $this->lang->line('Expenses') ?></option>
							<option value='Income'><?php echo $this->lang->line('Income') ?></option>
							<option value='Liabilities'><?php echo $this->lang->line('Liabilities') ?></option>
							<option value='Equity'><?php echo $this->lang->line('Equity') ?></option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="enable"><?php echo $this->lang->line('Enable Account') ?></label>
					<div class="col-sm-8">
						<select class="form-control" name="enable">
							<option value=""><?php echo $this->lang->line('Please Select') ?></option>
							<option value="Yes"><?php echo $this->lang->line('Yes') ?></option>
							<option value="No"><?php echo $this->lang->line('No') ?></option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="enable">Pagamentos Online?</label>
					<div class="col-sm-8">
						<select class="form-control" name="payonline">
							<option value=""><?php echo $this->lang->line('Please Select') ?></option>
							<option value="Yes"><?php echo $this->lang->line('Yes') ?></option>
							<option value="No"><?php echo $this->lang->line('No') ?></option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="lcurrency">Moeda</label>
					<div class="col-sm-6">
						<select name="lcurrency" class="form-control">
							<option value=""><?php echo $this->lang->line('Please Select') ?></option>
							<?php
								foreach ($currencys as $row) {
									$cid = $row['id'];
									$acn = $row['code'];
									echo "<option value='$cid'>$acn</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="notes"><?php echo $this->lang->line('Note') ?></label>
					<div class="col-sm-6">
						<input type="text" placeholder="Note" class="form-control margin-bottom" name="notes">
					</div>
				</div>
		
        <div class="form-group row">

            <label class="col-sm-2 col-form-label"></label>

            <div class="col-sm-4">
                <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                       value="<?php echo $this->lang->line('Add Account') ?>" data-loading-text="Adding...">
                <input type="hidden" value="accounts/addacc" id="action-url">
            </div>
        </div>


        </form>
    </div>
</div>