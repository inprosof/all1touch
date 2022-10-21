<div class="card card-block">
    <?php if ($message) {

        echo '<div id = "notify" class="alert alert-success"  >
            <a href = "#" class="close" data - dismiss = "alert" >&times;</a >

            <div class="message" >Token updated successfully!</div >
        </div >';
    } ?>
    <div class="card-body">
        <div class="card-block"><h4><?php echo $this->lang->line('translate18') ?> </h4>

            <hr>
            <p><?php echo $this->lang->line('translate1') ?></p><br><a
                    href="<?php echo base_url('cronjob/generate'); ?>" class="btn btn-primary btn-md rounded"> <i
                        class="icon icon-refresh2"></i>
                <?php echo $this->lang->line('translate2') ?> 
            </a>
            <p></p>
            <h4 class="text-gray-dark"><?php echo $corn['cornkey']; ?></h4>

            <hr>
            <a
                    data-toggle="collapse" href="#a001"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate3') ?></a>

            <div id="a001" role="tabpanel"
                 class="card-collapse collapse">


                <pre class="card-block card">WGET <?php echo base_url('cronjob/subscription?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/subscription?token=' . $corn['cornkey']) ?></pre>


            </div>
			<hr>

            <a
                    data-toggle="collapse" href="#a1"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate4') ?></a>

            <div id="a1" role="tabpanel"
                 class="card-collapse collapse">
                <pre class="card-block card">GET <?php echo base_url('cronjob/send_message_manage_asset?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/send_message_manage_asset?token=' . $corn['cornkey']) ?></pre>


            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a01"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate5') ?></a>

            <div id="a01" role="tabpanel"
                 class="card-collapse collapse">
                <pre class="card-block card">GET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>


            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a2"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate6') ?></a>

            <div id="a2" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                    <small><?php echo $this->lang->line('translate7') ?></small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>


            </div>


            <hr>


            <a
                    data-toggle="collapse" href="#a3"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate8') ?></a>

            <div id="a3" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                    <small><?php echo $this->lang->line('translate9') ?></small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>


            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a4"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate10') ?></a>

            <div id="a4" role="tabpanel"
                 class="card-collapse collapse">

                <pre class="card-block card">WGET <?php echo base_url('cronjob/cleandrafts?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/cleandrafts?token=' . $corn['cornkey']) ?></pre>

            </div>
            <hr>


            <a
                    data-toggle="collapse" href="#a5"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate11') ?></a>

            <div id="a5" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/promo?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/promo?token=' . $corn['cornkey']) ?></pre>

            </div>
            <hr>
            <a
                    data-toggle="collapse" href="#a6"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                <?php echo 'Alerta de Baixo Stock ou Falta de Stock'?></a>

            <div id="a6" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/stock_alert?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/stock_alert?token=' . $corn['cornkey']) ?></pre>

            </div>
            <hr>
            <a
                    data-toggle="collapse" href="#a7"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate13') ?></a>

            <div id="a7" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/expiry_alert?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/expiry_alert?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a8"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate14') ?></a>

            <div id="a8" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/dbbackup?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/dbbackup?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr>
            <a
                    data-toggle="collapse" href="#a9"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                <?php echo $this->lang->line('translate15') ?></a>

            <div id="a9" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/cleanlog?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/cleanlog?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr>
            <a style="display: none"
                    data-toggle="collapse" href="#a10"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
               <?php echo $this->lang->line('translate16') ?></a>

            <div id="a10" role="tabpanel" style="display: none"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/anniversary_mail?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/anniversary_mail?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr style="display: none">
               <a style="display: none"
                    data-toggle="collapse" href="#a11"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
               <?php echo $this->lang->line('translate17') ?></a>

            <div id="a11" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/anniversary_sms?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/anniversary_sms?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr style="display: none">


        </div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({responsive: true});

    });
</script>