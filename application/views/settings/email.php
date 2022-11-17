<article class="content-body">
    <div class="card yellow-top">
        <div class="card-header">
            <h5 class="title">
                <a class="btn-back" onclick=history.go(-1)>
                    <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                </a>
                <?php echo $this->lang->line('Edit Email Configuration') ?>
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
        </div>

        <form method="post" id="product_action" class="form-horizontal">

            <div class="card-body">

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="host">Host</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="host"
                               class="form-control margin-bottom  required" name="host"
                               value="<?php echo $email['host'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="port">Port</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="port"
                               class="form-control margin-bottom  required" name="port"
                               value="<?php echo $email['port'] ?>">
                        <small>Port 587 recommended with TLS</small>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="auth">Auth</label>

                    <div class="col-sm-6">
                        <select name="auth" class="form-control">
                            <?php if ($email['auth']) {
                                echo ' <option value="true">--True--
                                
                            </option>';
                            } else {
                                echo ' <option value="false">--False--
                                
                            </option>';
                            }
                            ?>
                            <option value="true">True

                            </option>
                            <option value="false">False

                            </option>
                        </select>

                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="auth_type">Auth Type</label>

                    <div class="col-sm-6">
                        <select name="auth_type" class="form-control">
                            <?php
                            echo ' <option value="' . $email['auth_type'] . '">--' . $email['auth_type'] . '--
                                
                            </option>';

                            ?>
                            <option value="none">None

                            </option>
                            <option value="tls">TLS

                            </option>
                            <option value="ssl">SSL

                            </option>
                        </select>

                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="username">Username</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="username"
                               class="form-control margin-bottom  required" name="username"
                               value="<?php echo $email['username'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="password">Password</label>

                    <div class="col-sm-6">
                        <input type="password" placeholder="password"
                               class="form-control mb-3  required" name="password"
                               value="<?php echo $email['password'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-6" id="paiCompanyUpdate">
                        <input type="submit" id="email_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line("Update") ?>" data-loading-text=" Atualizando...">

                    </div>
                    <div class="col-sm-12"><span id="email_update_m"></span></div>
                </div>

            </div>
        </form>

        <div class="col-sm-8">
            <div class="alert alert-info" id="alert-info-text">
                <p><?php echo $this->lang->line('Refer to documentation to configure email templates.') ?></p>
            </div>
        </div>
    </div>
</article>

<script type="text/javascript">
    $("#email_update").click(function (e) {

        $('#email_update_m').html('Please wait...<br>In case of <strong>incorrect</strong> settings, it may take time and application may hang for some period, due to multiple retries to SMTP host. If your settings are <strong>valid</strong> than you will get response within 5 to 15 sec. Status messsage will appear soon on top of this page.');
        e.preventDefault();

        var actionurl = baseurl + 'settings/email';
        actionProduct(actionurl);


    });
</script>