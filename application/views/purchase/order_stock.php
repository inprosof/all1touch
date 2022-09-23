<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<div class="message"><?php echo $this->session->flashdata('message'); ?></div>
			</div>
            <div class="card-body">
				
                <form method="post" id="data_form">
                    <input type="hidden" name="order_id" value="<?php echo $id; ?>" readonly />
					<input type="hidden" name="order_inst" value="<?php echo $tinst; ?>" readonly />
                    <input type="hidden" name="order_status" value="<?php echo $invoice['status']; ?>">
                    <div class="form-group row">

                        <div class="col-sm-12"><h3
                                    class="title"> <?php echo $this->lang->line('Purchase Order Properties') ?></h3>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption"> <?php echo $this->lang->line('Purchase Order') ?>: #<?php echo $invoice['tid']; ?></label>

                        </div>
                    </div>
                    <div class="row">
                        <div id="saman-row">
                            <table class="table-responsive tfr my_stripe">
                                <thead>
                                <tr class="item_header bg-gradient-directional-amber">
                                    <th width="80%"
                                        class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                    <th width="20%" class="text-center">QTD</th>
                                    <th width="20%" class="text-center">QTD. Rea</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;
                                /*if($invoice['status'] == 'paid') {
                                    $show_hide = 'disabled';
                                }*/
								
								$show_hide = '';
								if($tinst == 0) {
                                    $show_hide = '';
                                }else{
									 $show_hide = 'disabled="disabled"';
								}
                                foreach ($products as $row) {
                                    echo '<tr>
                                        <td><input type="text" disabled="disabled" class="form-control" name="product_name[]" placeholder=""  value="' . $row['product'] . '">
                                        </td>
                                        <td><input type="text" '.$show_hide.' class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                                   autocomplete="off" value="' . amountFormat_general($row['qty']) . '" >
                                                   </td>
                                        <td><input '.$show_hide.' type="number" class="form-control req amnt" value="'.$row['qty'].'" name="product_qty_'.$row['pid'].'" id="amount-stock-' . $i . '"></td>
                                    </tr>';
                                $i++;
                                } ?>
									<tr class="sub_c" style="display: table-row;">
                                        <td colspan=""></td>
                                        <td colspan=""></td>
                                        <td align="right" colspan="4">
											<?php if($tinst == 0){ ?>
											<input type="submit" id="submit-data" class="btn btn-success margin-bottom" value="Update Order" data-loading-text="Adding...">
											<input type="hidden" value="purchase/order_stock_update_2" id="action-url">
											<?php } ?>
											
											<?php if($tinst == 1){ ?>
											<input type="submit" id="submit-data" class="btn btn-success margin-bottom" value="Insert in Stock" data-loading-text="Adding...">
											<input type="hidden" value="purchase/order_stock_update" id="action-url">
											<?php } ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
