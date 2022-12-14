<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Account') ?></h5>
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
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'data_form');
                echo form_open('', $attributes);
                ?>


                <input type="hidden" name="acid" value="<?php echo $account['id'] ?>">
				
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="holder"><?php echo $this->lang->line('Name') ?></label>
					<div class="col-sm-6">
						<input type="text" placeholder="Conta Receitas, Por exemplo.." value="<?php echo $account['holder'] ?>" class="form-control margin-bottom required" name="holder">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="accno"><?php echo $this->lang->line('Account No') ?> (IBAN)</label>
					<div class="col-sm-6">
						<input type="text" placeholder="PT50...Por exemplo" value="<?php echo $account['acn'] ?>" class="form-control margin-bottom required" name="accno">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="acode">Código</label>
					<div class="col-sm-6">
						<input type="text" placeholder="CGD01...Por exemplo" value="<?php echo $account['acn'] ?>" class="form-control margin-bottom required" name="acode">
					</div>
				</div>
				<?php if ($account['account_type'] == 'Equity') {
                    ?>
                    <div class="form-group row ">
                        <label class="col-sm-2 col-form-label" for="intbal"><?php echo $this->lang->line('AccountBalance') ?></label>
                        <div class="col-sm-6">
                            <input type="text" name="intbal" class="form-control" value="<?php echo amountFormat_general($account['lastbal']) ?>" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                <?php } ?>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="bank">Banco</label>
					<div class="col-sm-8">
						<input type="text" placeholder="Caixa Geral de Depósitos, Montepio.." value="<?php echo $account['name'] ?>" class="form-control margin-bottom required" name="bank">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="branch">BICSWIFT</label>
					<div class="col-sm-8">
						<input type="text" placeholder="CGDIPTPL, Por exemplo..." value="<?php echo $account['branch'] ?>" class="form-control margin-bottom  required" name="branch">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="address"><?php echo $this->lang->line('Address') ?></label>
					<div class="col-sm-8">
						<input type="text" placeholder="Av. Central, 0000-000..." value="<?php echo $account['adress'] ?>" class="form-control margin-bottom  required" name="address">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="lid"><?php echo $this->lang->line('Business Locations') ?></label>
					<div class="col-sm-6">
						<select name="lid" class="form-control">
							<option value='<?php echo $account['loc'] ?>'><?php echo $this->lang->line('Do not change') ?></option>
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
							<option value='<?php echo $account['account_type'] ?>'>--<?php if($account['account_type'] == 'Basic') echo $this->lang->line('Default'); else echo $this->lang->line($account['account_type']); ?>--</option>
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
							<option value="<?php echo $account['enable'] ?>">--<?php echo $this->lang->line($account['enable']); ?>--</option>
							<option value="Yes"><?php echo $this->lang->line('Yes') ?></option>
							<option value="No"><?php echo $this->lang->line('No') ?></option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="enable">Pagamentos Online?</label>
					<div class="col-sm-8">
						<select class="form-control" name="payonline">
						<option value="<?php echo $account['payonline'] ?>">--<?php echo $this->lang->line($account['payonline']); ?>--</option>
							<option value="Yes"><?php echo $this->lang->line('Yes') ?></option>
							<option value="No"><?php echo $this->lang->line('No') ?></option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="lcurrency">Moeda</label>
					<div class="col-sm-6">
						<select name="lcurrency" class="form-control">
							<option value='<?php echo $account['currency'] ?>'><?php echo $this->lang->line('Do not change') ?></option>
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
						<input type="text" placeholder="Note" class="form-control margin-bottom" value="<?php echo $account['note'] ?>" name="notes">
					</div>
				</div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="accounts/editacc" id="action-url">
                    </div>
                </div>
            </div>
            </form>
        </div>

    </div>
</div>

