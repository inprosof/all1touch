<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('Customer Invoice Payment') ?> <a
                    href="<?php echo base_url('paymentgateways/add_currency') ?>"
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

        <div class="alert alert-info" id="alert-info-text">
            <p><?php echo $this->lang->line('You can add invoice currencies here, these currencies can be selected during an invoice creation. The
                exchange rate and other tasks will automatically handled by application. Please make sure enter correct
                ISO currency code to get automatic exchange rate updates and receive payment using payment gateways with
                converted amount.') ?></p>
        </div>
        <table id="datgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>ISO CODE</th>
                <th>Symbol</th>
                <th>Exchange Rate</th>
                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($currency_list as $row) {
                $cid = $row['id'];
                $title = $row['code'];
                $enable = $row['symbol'];
                $dev_mode = $row['rate'];

                echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    <td>$enable</td>
                    <td>$dev_mode</td>
                  
                    <td><div class='action-btn'> <a href='" . base_url("paymentgateways/edit_currency?id=$cid") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='icon-pencil'></i></a> <a href='#' data-object-id='" . $cid . "' class='btn btn-outline-danger btn-sm delete-object' title='" . $this->lang->line('Delete') . "'><i class='bi bi-trash'></i></a></div></td></tr>";
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="paymentgateways/delete_currency">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#datgtable').DataTable({responsive: true});

    });
</script>
