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

class Accounts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(68) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $this->load->model('accounts_model', 'accounts');
        $this->li_a = 'accounts';
    }

    public function index()
    {
        if (!$this->aauth->premission(68) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $data['accounts'] = $this->accounts->accountslist();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('Accounts');
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/list', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        if (!$this->aauth->premission(68) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $acid = $this->input->get('id');
        $data['account'] = $this->accounts->details($acid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('View Account');
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/view', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if (!$this->aauth->premission(69) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('locations_model');
        $data['currencys'] = $this->common->currencies();
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = $this->lang->line('Add Account');
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/add', $data);
        $this->load->view('fixed/footer');
    }

    public function addacc()
    {
        if (!$this->aauth->premission(69) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $accno = $this->input->post('accno');
        $holder = $this->input->post('holder');
        $intbal = numberClean($this->input->post('intbal'));
        $acode = $this->input->post('acode');
        $lid = $this->input->post('lid');
        $bank = $this->input->post('bank');
        $branch = $this->input->post('branch');
        $address = $this->input->post('address');
        $account_type = $this->input->post('account_type');
        $enable = $this->input->post('enable');
        $payonline = $this->input->post('payonline');
        $notes = $this->input->post('notes');
        $lcurrency = $this->input->post('lcurrency');
        if ($this->aauth->get_user()->loc) {
            $lid = $this->aauth->get_user()->loc;
        }

        $this->load->library("form_validation");
        $rules = array(
            array(
                'field' => 'accno',
                'label' => 'Nome da Conta',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor Insira um %s.')
            ),
            array(
                'field' => 'holder',
                'label' => 'IBAN',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor preencha o seu %s.')
            ),
            array(
                'field' => 'intbal',
                'label' => 'Valor Inicial',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor insira um %s.')
            ),
            array(
                'field' => 'acode',
                'label' => 'Código',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor insira um %s.')
            ),
            array(
                'field' => 'lid',
                'label' => 'Localização',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor Seleccione uma %s.')
            ),
            array(
                'field' => 'bank',
                'label' => 'Banco',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor insira o nome do %s.')
            ),
            array(
                'field' => 'branch',
                'label' => 'BICSWIFT',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor insira o %s.')
            ),
            array(
                'field' => 'address',
                'label' => 'Endereço',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor insira o %s do banco da conta.')
            ),
            array(
                'field' => 'account_type',
                'label' => 'Tipologia',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor Selecione uma %s.')
            ),
            array(
                'field' => 'enable',
                'label' => 'Habilitar',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor Selecione se pretende %s ou não esta conta.')
            ),
            array(
                'field' => 'payonline',
                'label' => 'Pagamentos Online',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor Selecione se pretende que aparece para %s.')
            ),
            array(
                'field' => 'lcurrency',
                'label' => 'Moeda',
                'rules' => 'required',
                'errors' => array('required' => 'Por favor Selecione a %s para esta Conta.')
            )
        );

        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            $this->accounts->addnew($accno, $holder, $intbal, $acode, $lid, $bank, $branch, $address, $account_type, $enable, $payonline, $notes, $lcurrency);
        } else {
            echo json_encode(array('status' => 'Dados de Formulário', 'message' => $this->form_validation->error_string()));
        }
    }

    public function delete_i()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->post('deleteid');
        if ($id) {
            $whr = array('id' => $id);
            if ($this->aauth->get_user()->loc) {
                $whr = array('id' => $id, 'loc' => $this->aauth->get_user()->loc);
            }
            $this->db->delete('geopos_accounts', $whr);
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ACC_DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

//view for edit
    public function edit()
    {
        if (!$this->aauth->premission(70) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $catid);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        $query = $this->db->get();
        $data['account'] = $query->row_array();
        $this->load->model('locations_model');
        $data['currencys'] = $this->common->currencies();
        $data['locations'] = $this->locations_model->locations_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('Edit Account');
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editacc()
    {
        if (!$this->aauth->premission(70) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $acid = $this->input->post('acid');
        $accno = $this->input->post('accno');
        $holder = $this->input->post('holder');
        $intbal = numberClean($this->input->post('intbal'));
        $acode = $this->input->post('acode');
        $lid = $this->input->post('lid');
        $bank = $this->input->post('bank');
        $branch = $this->input->post('branch');
        $address = $this->input->post('address');
        $account_type = $this->input->post('account_type');
        $enable = $this->input->post('enable');
        $payonline = $this->input->post('payonline');
        $notes = $this->input->post('notes');
        $lcurrency = $this->input->post('lcurrency');

        if ($this->aauth->get_user()->loc) {
            $lid = $this->aauth->get_user()->loc;
        }
        if ($acid) {
            $this->accounts->edit($acid, $accno, $holder, $intbal, $acode, $lid, $bank, $branch, $address, $account_type, $enable, $payonline, $notes, $lcurrency);
        }
    }

    public function balancesheet()
    {
        if (!$this->aauth->premission(73) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $head['title'] = $this->lang->line('Balance Summary');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['accounts'] = $this->accounts->accountslist();

        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/balance', $data);
        $this->load->view('fixed/footer');
    }

    public function account_list()
    {
        if (!$this->aauth->premission(68) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $cid = $this->input->post('cid');
        $list = $this->accounts->acco_datatables($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $no;
            $row[] = $prd->acn;
            $row[] = $prd->holder;
            $row[] = amountExchange($prd->lastbal, 0, $this->aauth->get_user()->loc);
            $typ = "";
            if ($prd->account_type == 'Basic')
                $typ = $this->lang->line('Default');
            else
                $typ = $this->lang->line($prd->account_type);
            $row[] = $typ;
            $row[] = $prd->adate;
            $option = '';
            if ($this->aauth->premission(68) || $this->aauth->get_user()->roleid == 7) {
                $option .= '<div class="action-btn"><a href="' . base_url() . 'accounts/view?id=' . $pid . '" class="btn btn-outline-success btn-sm" title="' . $this->lang->line('View') . '"><span class="bi bi-eye"></span>  ' . '</a>';
            }

            if ($this->aauth->premission(70) || $this->aauth->get_user()->roleid == 7) {
                $option .= '<a href="' . base_url() . 'accounts/edit?id=' . $pid . '" class="btn btn-outline-primary btn-sm" title="' . $this->lang->line('Edit') . '"><span class="bi bi-pencil"></span>  ' . '</a>';
            }

            if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7) {
                $option .= '<a href="#" data-object-id="' . $pid . '" class="btn btn-outline-danger btn-sm delete-object" title="' . $this->lang->line('Delete') . '"><span class="bi bi-trash"></span></a></div>';
            }
            $row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->accounts->acco_count_all($cid),
            "recordsFiltered" => $this->accounts->acco_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }


    public function account_stats()
    {
        $this->accounts->account_stats();
    }
}