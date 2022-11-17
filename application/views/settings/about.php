<div class="card yellow-top">
    <div class="card-header">
        <h5 class="title">
            <a class="btn-back" onclick=history.go(-1)>
                <i class="bi bi-arrow-left-circle text-info" style="font-size: 1.4rem;"></i>
            </a>
            <?php echo $this->lang->line('About') ?>
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
    <form method="post" id="product_action" class="card-body">


        <div class="card-body">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
        </div>
        <div class="form-group row">


            <div class="col-sm-12 text-center">
                <h3><?php echo $this->lang->line('name_soft') ?></h3>
                <h5><?php $url = file_get_contents(FCPATH . '/version.json');
                    $version = json_decode($url, true);
                    echo 'V ' . $version['version'] . ' (b' . $version['build'] . ')'; ?></h5> <h6>
                    Copyright <?php echo date('Y') ?> <a
                            href="https://pcteckserv.com">PCTECKSERV</a>
                </h6>

            </div>
        </div>

        <h3 class="title">Novidades 2022</h3>
        <div class="col-sm-12">
            <div class="card-group">
                <div class="card">
                    <img src="<?php echo assets_url() ?>/app-assets/images/news/2022/qrcode_fact.jpg"
                         class="card-img-top" alt="QRCODE">
                    <div class="card-body">
                        <h5 class="card-title">QR Code nas Faturas</h5>
                        <p class="card-text">Os documentos fiscalmente relevantes deverão incluir um QR Code,
                            opcionalmente durante 2021, e em definitivo a partir de 1 de Janeiro de 2022 (Lei n.º
                            75-B/2020). O PCTECKSERV-CRM é compatível com as exigências legais e criou ferramentas
                            para tornar o processo de transição mais simples.</p>
                        <a href="#" class="btn btn-primary"><?php echo $this->lang->line('Consult') ?></a>
                    </div>
                </div>
                <div class="card">
                    <img src="<?php echo assets_url() ?>/app-assets/images/news/2022/fact_assin.jpg"
                         class="card-img-top" alt="Fatura">
                    <div class="card-body">
                        <h5 class="card-title">Fatura Eletrónica</h5>
                        <p class="card-text">O PCTECKSERV-CRM irá suportar a Assinatura Digital Qualificada
                            através da integração com a AMA e a DigitalSign. Todas as faturas e documentos fiscais
                            enviados eletronicamente serão obrigados a estar assinados digitalmente a partir de 1 de
                            julho de
                            2022.</p>
                        <a href="#" class="btn btn-primary"><?php echo $this->lang->line('Consult') ?></a>
                    </div>
                </div>
                <div class="card">
                    <img src="<?php echo assets_url() ?>/app-assets/images/news/2022/fact_series.jpg"
                         class="card-img-top" alt="Fatura">
                    <div class="card-body">
                        <h5 class="card-title">Comunicação de Séries ATCUD</h5>
                        <p class="card-text">O PCTECKSERV-CRM irá suportar Faturação com ATCUD! A partir de 1
                            de Janeiro 2023, todas as faturas deverão incluir o Código Único de Documento (ATCUD),
                            após a comunicação das séries de faturação à Autoridade Tributária.</p>
                        <a href="#" class="btn btn-primary"><?php echo $this->lang->line('Consult') ?></a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    $("#time_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/dtformat';
        actionProduct(actionurl);
    });
</script>

