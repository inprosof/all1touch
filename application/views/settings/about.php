<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <form method="post" id="product_action" class="card-body">
        <div class="card-body">

            <h5><?php echo $this->lang->line('About') ?></h5>
            <hr>
            <div class="form-group row">


                <div class="col-sm-12 text-center">
                    <h3><?php echo $this->lang->line('name_soft') ?></h3><h5><?php $url = file_get_contents(FCPATH . '/version.json');
                        $version = json_decode($url, true);
                        echo 'V ' . $version['version'] . ' (b' . $version['build'] . ')'; ?></h5> <h6>
                        Copyright <?php echo date('Y') ?> <a
                                href="https://pcteckserv.com">PCTECKSERV</a>
                    </h6>

                </div>
            </div>
			
			<h3>Novidades 2022</h3>
			<div class='box-content position-relative ch__box'> <img class="ch__img" src="<?php echo assets_url() ?>/app-assets/images/news/2022/qrcode_fact.jpg"/>
				<div class="ch__content">
					<a class="ch__link" href="/qweqw/"><h1 class="bold mt-5 ch__title mb-5"> QR Code nas Faturas</h1> </a>
					<p class="mt-3 d-block ch__desc"> Os documentos fiscalmente relevantes deverão incluir um QR Code, opcionalmente durante 2021, e em definitivo a partir de 1 de Janeiro de 2022 (Lei n.º 75-B/2020). O PCTECKSERV-CRM é compatível com as exigências legais e criou ferramentas para tornar o processo de transição mais simples.</p> 
					<a href="/qweqw/" class="btn ch__btn mt-5 mb-5"> Consultar </a>
				</div>
			</div>

			<div class='box-content position-relative ch__box'> <img class="ch__img" src="<?php echo assets_url() ?>/app-assets/images/news/2022/fact_assin.jpg"/>
				<div class="ch__content">
					<a class="ch__link" href="/dqwdqwd/"><h1 class="bold mt-5 ch__title mb-5"> Fatura Eletrónica</h1> </a>
					<p class="mt-3 d-block ch__desc"> O PCTECKSERV-CRM irá suportar a Assinatura Digital Qualificada através da integração com a AMA e a DigitalSign. Todas as faturas e documentos fiscais enviados eletronicamente serão obrigados a estar assinados digitalmente a partir de 1 de julho de 2022.</p> 
					<a href="/dqwdqwd/" class="btn ch__btn mt-5 mb-5"> Consultar </a>
				</div>
			</div>
	
			<div class='box-content position-relative ch__box'> <img class="ch__img" src="<?php echo assets_url() ?>/app-assets/images/news/2022/fact_series.jpg"/>
				<div class="ch__content">
					<a class="ch__link" href="/qwdq/"><h1 class="bold mt-5 ch__title mb-5"> Comunicação de Séries ATCUD</h1> </a>
					<p class="mt-3 d-block ch__desc"> O PCTECKSERV-CRM irá suportar Faturação com ATCUD! A partir de 1 de Janeiro 2023, todas as faturas deverão incluir o Código Único de Documento (ATCUD), após a comunicação das séries de faturação à Autoridade Tributária.</p> 
					<a href="/qwdq/" class="btn ch__btn mt-5 mb-5"> Consultar </a>
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

