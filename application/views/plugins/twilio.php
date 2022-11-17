<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            Twilio SMS Service
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
    <form method="post" id="data_form" class="form-horizontal">
        <div class="card-body">
            <div class="alert alert-info" id="alert-info-text">
                <p>You can send bills as SMS to your customers using Twilio SMS Service. You can also setup urls
                    shorter plugin to convert long invoice urls to small and more user friendly in SMS.</p>
                <p>You can signup here for keys. <a href="https://www.twilio.com/">https://www.twilio.com/</a></p>
            </div>
            <div class="form-group row">


                <div class="col-sm-6"><label class="col col-form-label" for="terms">Account SID</label>
                    <input type="text"
                           class="form-control margin-bottom  required" name="key1"
                           value="<?php echo $universal['key1'] ?>">
                </div>


                <div class="col-sm-6"><label class="col col-form-label" for="terms">Auth Token</label>
                    <input type="text"
                           class="form-control margin-bottom  required" name="key2"
                           value="<?php echo $universal['key2'] ?>">
                </div>
            </div>

            <div class="form-group row">


                <div class="col-sm-6"><label class="col col-form-label" for="terms">Send Id</label>
                    <input type="text"
                           class="form-control margin-bottom  required" name="sender"
                           value="<?php echo $universal['url'] ?>">
                </div>


                <div class="col-sm-6"><label class="col col-form-label"
                                             for="terms"><?php echo $this->lang->line('Enable') ?></label>
                    <select name="enable" class="form-control">

                        <?php switch ($universal['active']) {
                            case 1 :
                                echo '<option value="1">--Yes--</option>';
                                break;
                            case 0 :
                                echo '<option value="0">--No--</option>';
                                break;

                        } ?>
                        <option value="1">Yes</option>
                        <option value="0">No</option>


                    </select>
                </div>
            </div>


            <div class="form-group row">


                <div class="col-sm-12" id="paiCompanyUpdate">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="plugins/twilio" id="action-url">
                </div>
            </div>

            <h5 class="mt-2">Other Universal SMS Service</h5>
            <hr>
            <div class="alert alert-info" id="alert-info-text">
                <p class="purple">You can send your bills as SMS to your customers using any SMS Service that is
                    available in your country. You can also setup urls
                    shorter plugin to convert long invoice urls to small and more user friendly in SMS. If your sms
                    provider has support for REST Based api like TextLocal,Clockwork you can enable in with some lines
                    of code editing.</p>
            </div>
        </div>
    </form>

</div>