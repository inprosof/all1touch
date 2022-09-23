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
        $account_type = $this->input->post('account_type');

        if ($this->aauth->get_user()->loc) {
            $lid = $this->aauth->get_user()->loc;
        }

        if ($accno) {
            $this->accounts->addnew($accno, $holder, $intbal, $acode, $lid, $account_type);

        }
    }

    public function delete_i()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
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
        $acode = $this->input->post('acode');
        $lid = $this->input->post('lid');
        $equity = numberClean($this->input->post('balance'));
		$account_type = $this->input->post('account_type');
		
        if ($this->aauth->get_user()->loc) {
            $lid = $this->aauth->get_user()->loc;
        }
        if ($acid) {
            $this->accounts->edit($acid, $accno, $holder, $acode, $lid, $equity, $account_type);
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
		if (!$this->aauth->premission(68) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
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
			if($prd->account_type == 'Basic') 
				$typ = $this->lang->line('Default'); 
			else 
				$typ = $this->lang->line($prd->account_type);
            $row[] = $typ;
            $row[] = $prd->adate;
			$option = '';			
			if ($this->aauth->premission(68) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="' . base_url() . 'accounts/view?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a>&nbsp;';
			}
			
			if ($this->aauth->premission(70) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="' . base_url() . 'accounts/edit?id=' . $pid . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a>&nbsp;';
			}
			
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
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