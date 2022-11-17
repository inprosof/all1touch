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

class Register extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(114) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }

        $this->load->library("Registerlog");
        $this->load->model('register_model', 'register');
        $this->li_a = 'data';


    }

    public function index()
    {
        if (!$this->aauth->premission(114) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $head['title'] = "Register";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('register/index');
        $this->load->view('fixed/footer');

    }


    public function view()
    {
        if (!$this->aauth->premission(114) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $status = $this->registerlog->view($this->input->post('rid'));
        echo json_encode(array('cash' => $status['cash'], 'card' => $status['card'], 'bank' => $status['bank'], 'cheque' => $status['cheque'], 'mbway' => $status['mbway'], 'paypal' => $status['paypal'], 'balanco' => $status['balanco'], 'cupoes' => $status['cupoes'], 'outros' => $status['outros'], 'change' => $status['r_change'], 'date' => $status['o_date'], 'operator' => $status['name'], 'tot_start' => $status['tot_start']));
    }


    public function status()
    {
        $status = $this->registerlog->check($this->aauth->get_user()->id);
        if ($status) {
            echo json_encode(array('cash' => $status['cash'], 'card' => $status['card'], 'bank' => $status['bank'], 'cheque' => $status['cheque'], 'mbway' => $status['mbway'], 'paypal' => $status['paypal'], 'balanco' => $status['balanco'], 'cupoes' => $status['cupoes'], 'outros' => $status['outros'], 'change' => $status['r_change'], 'date' => $status['o_date'], 'operator' => $status['name'], 'tot_start' => $status['tot_start']));
        }
    }


    public function close()
    {
        $this->registerlog->close($this->aauth->get_user()->id);
        redirect('dashboard');
    }

    public function create()
    {
        if (!$this->aauth->premission(5) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }

        if ($this->registerlog->check($this->aauth->get_user()->id)) {
            redirect('pos_invoices/create');
        }
        if ($this->input->post()) {
            $cash = (float)$this->input->post('cash');
            $card = (float)$this->input->post('card');
            $bank = (float)$this->input->post('bank');
            $cheque = (float)$this->input->post('cheque');
            $tot_start = ((float)$cash + $card + $bank + $cheque);
            if ($this->registerlog->create($this->aauth->get_user()->id, $cash, $card, $bank, $cheque, $tot_start)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . " <a href='" . base_url() . "pos_invoices/create' class='btn btn-info btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('POS') . "  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['title'] = "Add Register";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('register/create');
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->post('deleteid');
        if ($id) {

            $this->db->delete('geopos_register', array('id' => $id));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function load_list()
    {
        if (!$this->aauth->premission(114) && (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $list = $this->register->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $promo) {
            $no++;
            switch ($promo->active) {
                case 1 :
                    $promo_status = '<span class="st-paid">' . $this->lang->line('Active') . '</a>';
                    break;
                case 0 :
                    $promo_status = '<span class="st-due">' . $this->lang->line('Close') . '</a>';
                    break;
            }
            $row = array();
            $row[] = $no;
            $row[] = $promo->username;
            $row[] = $promo->o_date;
            $row[] = $promo->c_date;
            $row[] = $promo_status;

            $option = '<div class="action-btn"><a href="#" class="btn btn-outline-primary btn-sm set-reg" data-id="' . $promo->id . '" data-stat="0"  data-toggle="modal" data-target="#view_register" title="' . $this->lang->line('View') . '"><i class="bi bi-eye"></i> </a> ';
            if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7) {
                $option .= '<a href="#" data-object-id="' . $promo->id . '" class="btn btn-outline-danger btn-sm delete-object" title="' . $this->lang->line('Delete') . '"><i class="bi bi-trash"></i></a></div>';
            }
            $row[] = $option;
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->register->count_all(),
            "recordsFiltered" => $this->register->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}