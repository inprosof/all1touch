<style type="text/css">
	
	#items td.description div, #items td.item-name div {
		width: 100%;
	}
	
	#items {
		clear: both;
		width: 100%;
		margin: 0px 0 0 0;
		border:none;
	}
	
	#table2 {
		border-collapse: collapse;
	}

	#table2 td, #table2 th {
		border: 1px solid griz;
		padding: 1px;
	}
	
	#items td.total-inov {
		border-right: 0;
		border-left: 0;
		border-top: 0;
		padding: 10px;
		text-align: left;
		font-size: 16px;
	}

	#items th {
		background: #eee;
	}

	#items tr.item-row td {
		border: #ccc 1px solid;
		vertical-align: top;
	}
</style>
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="fa fa-file-text-o text-bold-200  font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-primary white media-body">
                        <h5><?php echo $this->lang->line('today_invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> <?php echo $todayin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="icon-notebook font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-danger white media-body">
                        <h5><?php echo $this->lang->line('this_month_invoices') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?php echo $monthin ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="icon-basket-loaded font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-warning white media-body">
                        <h5><?php echo $this->lang->line('today_sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i><?php echo amountExchange($todaysales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success bg-darken-2">
                        <i class="icon-wallet font-large-2 white"></i>
                    </div>
                    <div class="p-1 bg-gradient-x-success white media-body">
                        <h5><?php echo $this->lang->line('this_month_sales') ?></h5>
                        <h5 class="text-bold-400 mb-0"><i
                                    class="ft-arrow-up"></i> <?php echo amountExchange($monthsales, 0, $this->aauth->get_user()->loc) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row match-height">
    <div class="col-xl-7 col-lg-12">
        <div class="card match-height" role="tablist" aria-multiselectable="true">
            <div class="card-header">
                <h4 class="card-title"><i class="icon-arrow-right deep-orange"></i> Informação Inicial</h4><h3 class="primary">
            </div>
			<h4 class="modal-title">Olá Bem-Vindo(a) ao Mundo 
			<?php 
				$loc = location($this->aauth->get_user()->loc);
                echo $loc['cname'];
			?>
			</h4>   
			<a class="match-width match-height" href="<?php echo base_url(); ?>messages"><i class="ft-chevron-right"></i>Mensagem</a><br>
			<a class="match-width match-height" href="<?php echo base_url(); ?>manager/todo"><i class="ft-chevron-right"></i>Tarefa</a><br>
        </div>
    </div>
    <div class="col-xl-5 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('task_manager') . ' ' ?> <a
                            href="<?php echo base_url() ?>manager/todo"><i
                                class="icon-arrow-right deep-orange"></i></a></h4>
            </div>

            <div class="card-content">
                <div id="daily-activity">
                    <table class="table table-striped table-bordered base-style table-responsive" >
                        <thead>
                        <tr>
                            <th></th>
                            <th><?php echo $this->lang->line('Tasks') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $t = 0;
                        foreach ($tasks as $row) {
                            $name = '<a class="check text-default" data-id="' . $row['id'] . '" data-stat="' . $row['status'] . '"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $row['id'] . '" class="view_task" data-stat="' . $row['status'] . '"></a>';
                            echo ' <tr>
                                <td class="text-truncate">
                                   ' . $name . '
                                </td>
                            
                                <td class="text-truncate">' . $row['name'] . '</td>
                                <td class="text-truncate"><span id="st' . $t . '" class="badge badge-default task_' . $row['status'] . '">' . $row['status'] . '</span></td>
                            </tr>';
                            $t++;
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="task_model" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="task_title"><?php echo $this->lang->line('Details'); ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>

			<div class="modal-body">
				<form id="form_model">


					<div class="row">
						<div class="col mb-1" id="description">

						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col mb-1"><?php echo $this->lang->line('Priority') ?> <strong><span
										id="priority"></span></strong>

						</div>
					</div>
					<div class="row">
						<div class="col mb-1"><?php echo $this->lang->line('Assigned to') ?> <strong><span
										id="employee"></span></strong>

						</div>
					</div>
					<div class="row">
						<div class="col mb-1"><?php echo $this->lang->line('Assigned by') ?> <strong><span
										id="assign"></span></strong>

						</div>
					</div>

					<div class="modal-footer">
						<input type="hidden" class="form-control required"
							   name="tid" id="taskid" value="">
						<button type="button" class="btn btn-default"
								data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>