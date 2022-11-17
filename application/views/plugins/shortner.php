<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            Bit.ly URL Shortener Service
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
                <p>Bit.ly URL Shortener is a free service from Bit.ly that convert long ulrs to short. It is very useful
                    when you want send invoice as SMS. Your customer will get a short URL in SMS. You can signup here
                    for key.<a href="https://bitly.com">https://bitly.com</a>
                </p>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="terms">API Key</label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="key1"
                           value="<?php echo $universal['key1'] ?>">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="terms"><?php echo $this->lang->line('Enable') ?></label>

                <div class="col-sm-6">
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

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-6" id="paiCompanyUpdate">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="plugins/shortner" id="action-url">
                </div>
            </div>

        </div>
    </form>
</div>