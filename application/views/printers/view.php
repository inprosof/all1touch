<article class="content-body">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-md-12">
            <div class="card card-block yellow-top">
                <div class="card-header">
                    <h5 class="title">
                        <a class="btn-back" onclick=history.go(-1)>
                            <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
                        </a>
                        <?php echo $this->lang->line('Printer Details') ?>
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
                <div class="card-body">
                    <div class="card-group">
                        <div class="card blue-top">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="primary">Printer Name</h3>
                                            <span class="font-medium-1">
                                                <?php echo $printer['val1'] ?>
                                            </span>
                                        </div>
                                        <div class="media-right media-middle">
                                            <i class="bi bi-printer primary font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card blue-top">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="primary">Printer Type</h3>
                                            <span class="font-medium-1">
                                                <?php echo $printer['val2'] ?>
                                            </span>
                                        </div>
                                        <div class="media-right media-middle">
                                            <i class="bi bi-printer primary font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card blue-top">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="primary">Connector</h3>
                                            <span class="font-medium-1">
                                                <?php echo $printer['val3'] ?>
                                            </span>
                                        </div>
                                        <div class="media-right media-middle">
                                            <i class="bi bi-usb-plug primary font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card blue-top">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body text-left w-100">
                                            <h3 class="primary"><?php echo $this->lang->line('Business Location') ?></h3>
                                            <span class="font-medium-1">
                                               <?php $loc = location($printer['val4']);
                                               echo $loc['cname']; ?>
                                            </span>
                                        </div>
                                        <div class="media-right media-middle">
                                            <i class="bi bi-building primary font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
</article>
