<article class="">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Theme') ?>
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
        <form method="post" id="product_action" class="form-horizontal">

            <div class="card-content">
                <div class="card-body">
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name"><?php echo $this->lang->line('Theme Direction') ?></label>

                        <div class="col-sm-6"><select name="tdirection" class="form-control">

                                <?php switch (LTR) {
                                    case 'ltr' :
                                        echo '<option value="ltr">**' . $this->lang->line('LTR') . '**</option>';
                                        break;
                                    case 'rtl' :
                                        echo '<option value="rtl">**' . $this->lang->line('RTL') . '**</option>';
                                        break;

                                } ?>
                                <option value="ltr"><?php echo $this->lang->line('LTR') ?></option>
                                <option value="rtl"><?php echo $this->lang->line('RTL') ?></option>


                            </select>

                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name">Menu Style</label>

                        <div class="col-sm-6"><select name="menu" class="form-control">

                                <?php switch (MENU) {
                                    case '0' :
                                        echo '<option value="0">**Horizontal**</option>';
                                        break;
                                    case '1' :
                                        echo '<option value="1">** Vertical**</option>';
                                        break;

                                } ?>
                                <option value="0">Horizontal</option>
                                <option value="1">Vertical</option>


                            </select>

                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-6" id="paiCompanyUpdate">
                            <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Atualizando...">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-block yellow-top">

        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-header">
                <h5 class="title"><?php echo $this->lang->line('Theme') ?> Logo</h5>
            </div>
            <div class="card-body">

                <div class="ibox-content no-padding border-left-right">
                    <img alt="image" id="dpic" class="col-4"
                         src="<?php echo base_url('userfiles/theme/logo-header.png') . '?t=' . rand(5, 999) ?>">
                </div>

                <hr>
                <p><label for="fileupload">Change Theme Logo </label><input
                            id="fileupload" type="file"
                            name="files[]"></p>
                <div class="alert alert-info" id="alert-info-text">
                    <p><?php echo $this->lang->line('Message Upload Logo') ?></p>
                </div>
            </div>
        </form>
    </div>
</article>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/theme';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(function () {
        'use strict';
        var url = '<?php echo base_url() ?>settings/themelogo';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {


                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/theme/' + data.result + '?' + new Date().getTime());


            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

</script>

