<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            Google reCaptcha <?php echo $this->lang->line('Settings') ?>
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
                <p>reCAPTCHA is a free service from Google that protects your application login page from spam and
                    abuse. reCAPTCHA uses an advanced risk analysis engine and adaptive CAPTCHAs to keep automated
                    software from engaging in abusive activities on your site. It does this while letting your valid
                    users pass through with ease. You can signup here for keys.<a
                            href="https://www.google.com/recaptcha">https://www.google.com/recaptcha</a></p>
                <p>reCAPTCHA will appear when a user try multiple login attempts.</p>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="terms">Public Key</label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="publickey"
                           value="<?php echo $captcha['recaptcha_p'] ?>">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="terms">Private Key</label>

                <div class="col-sm-6">
                    <input type="text"
                           class="form-control margin-bottom  required" name="privatekey"
                           value="<?php echo $captcha['recaptcha_s'] ?>">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="terms"><?php echo $this->lang->line('Enable') ?></label>

                <div class="col-sm-6">
                    <select name="captcha" class="form-control">

                        <?php switch ($captcha['captcha']) {
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
                    <input type="hidden" value="plugins/recaptcha" id="action-url">
                </div>
            </div>

        </div>
    </form>
</div>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']]

            ]
        });
    });
</script>


