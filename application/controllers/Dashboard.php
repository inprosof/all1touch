<?php
/**
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above PCTECKSERV notice.
 *  *
 *  *
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }
        $this->load->model('dashboard_model');
        $this->load->model('tools_model');


    }


    public function index()
    {
        $today = date("Y-m-d");
        $month = date("m");
        $year = date("Y");
		$data['todayin'] = $this->dashboard_model->todayInvoice($today);
		$data['todayprofit'] = $this->dashboard_model->todayProfit($today);
		$data['incomechart'] = $this->dashboard_model->incomeChart($today, $month, $year);
		$data['expensechart'] = $this->dashboard_model->expenseChart($today, $month, $year);
		$data['tasks'] = $this->dashboard_model->tasks($this->aauth->get_user()->id);
		$data['monthin'] = $this->dashboard_model->monthlyInvoice($month, $year);
		$data['todaysales'] = $this->dashboard_model->todaySales($today);
		$data['monthsales'] = $this->dashboard_model->monthlySales($month, $year);
		$data['todayinexp'] = $this->dashboard_model->todayInexp($today);
		$data['recent_payments'] = $this->dashboard_model->recent_payments();
        if ($this->aauth->get_user()->roleid == 4 || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) {
			$data['tot_pos_invoice'] = $this->dashboard_model->tot_pos_invoice();
			$data['tot_employees'] = $this->dashboard_model->tot_employees();
			$data['tot_supliers'] = $this->dashboard_model->tot_supliers();
			$data['tot_projects'] = $this->dashboard_model->tot_projects();
			$data['tot_invoice'] = $this->dashboard_model->tot_invoice();
			$data['tot_artigos'] = $this->dashboard_model->tot_artigos();
			$data['get_all_info_done'] = $this->dashboard_model->get_all_info_done();
			//var_dump($data['get_all_info_done']);
			//exit();
			$data['get_ativ_saft'] = $this->dashboard_model->get_ativ_saft();
			$data['get_caixa_activ'] = $this->dashboard_model->get_caixa_activ();
            $data['countmonthlychart'] = $this->dashboard_model->countmonthlyChart();
            $data['recent'] = $this->dashboard_model->recentInvoices();
            $data['recent_buy'] = $this->dashboard_model->recentBuyers();
            $data['goals'] = $this->tools_model->goals(1);
            $data['stock'] = $this->dashboard_model->stock();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Dashboard');
            $this->load->view('fixed/header', $head);
            $this->load->view('dashboard', $data);
            $this->load->view('fixed/footer');
        } else if ($this->aauth->premission(61)) {
			$head['title'] = $this->lang->line('Entrada Projectos');
            $this->load->model('projects_model', 'projects');
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['totalt'] = $this->projects->project_count_all();
            $this->load->view('fixed/header', $head);
            $this->load->view('projects/index', $data);
            $this->load->view('fixed/footer');
        } else if ($this->aauth->get_user()->roleid == 1) {
			$head['title'] = $this->lang->line('Entrada Armazém');
			$data['stock'] = $this->dashboard_model->stock();
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('dashboardInv', $data);
            $this->load->view('fixed/footer');
        } else {
            $head['title'] = $this->lang->line('Entrada Funcionário');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('dashboardEmployee', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function clock_in()
    {
        $id = $this->aauth->get_user()->id;
        if ($this->aauth->auto_attend()) {
            $this->dashboard_model->clockin($id);
        }

        redirect('dashboard');
    }

    public function clock_out()
    {
        $id = $this->aauth->get_user()->id;

        if ($this->aauth->auto_attend()) {
            $this->dashboard_model->clockout($id);
        }


        redirect('dashboard');
    }
}