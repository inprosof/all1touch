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

class Customers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(36) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $this->load->library("Custom");
        $this->li_a = 'crm';
    }

    public function index()
    {
		if (!$this->aauth->premission(36) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/clist');
        $this->load->view('fixed/footer');
    }

    public function create()
    {
		if (!$this->aauth->premission(37) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $this->load->library("Common");
        $data['langs'] = $this->common->languagesSystem();
		$data['countrys'] = $this->common->countrys();
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['custom_fields'] = $this->custom->add_fields(1);
        $head['title'] = 'Create Customer';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/create', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        if (!$this->aauth->premission(36) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
        $data['money'] = $this->customers->money_details($custid);
        $data['due'] = $this->customers->due_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['activity'] = $this->customers->activity($custid);
        $data['custom_fields'] = $this->custom->view_fields_data($custid, 1);
        $head['title'] = 'View Customer';
        $this->load->view('fixed/header', $head);
        if ($data['details']['id']) $this->load->view('customers/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
        $no = $this->input->post('start');

        $list = $this->customers->get_datatables();
        $data = array();
        if ($this->input->post('due')) {
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';
                $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = amountExchange($customers->total - $customers->pamnt, 0, $this->aauth->get_user()->loc);
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
				$option = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> ';
				if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(38))
				{
					$option .= '<a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a>';
				}
				if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
					$option .= '<a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
				}
				$row[] = $option;
                $data[] = $row;
            }
        } else {
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';
                $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
				$option = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a>';
				
				if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(38))
				{
					$option .= '<a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a>';
				}
				if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
					$option .= '<a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
				}
				$row[] = $option;
                $data[] = $row;
            }
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->count_all(),
            "recordsFiltered" => $this->customers->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    //edit section
    public function edit()
    {
		if (!$this->aauth->premission(38) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $pid = $this->input->get('id');
        $data['customer'] = $this->customers->details($pid);
        $data['customergroup'] = $this->customers->group_info($data['customer']['gid']);
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['custom_fields'] = $this->custom->view_edit_fields($pid, 1);
        $head['title'] = 'Edit Customer';
		$this->load->library("Common");
        $data['langs'] = $this->common->languagesSystem();
		$data['countrys'] = $this->common->countrys();
		$data['viesCT'] = [];
		
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/edit', $data);
        $this->load->view('fixed/footer');
    }

	public function validaNIF($nif, $ignoreFirst=true) {
		//Limpamos eventuais espaços a mais
		$nif=trim($nif);
		//Verificamos se é numérico e tem comprimento 9
		if (!is_numeric($nif) || strlen($nif)!=9) {
			return false;
		} else {
			$nifSplit=str_split($nif);
			//O primeiro digíto tem de ser 1, 2, 3, 5, 6, 8 ou 9
			//Ou não, se optarmos por ignorar esta "regra"
			if(in_array($nifSplit[0], array(1, 2, 3, 5, 6, 8, 9)) || $ignoreFirst){
				//Calculamos o dígito de controlo
				$checkDigit=0;
				for($i=0; $i<8; $i++) {
					$checkDigit+=$nifSplit[$i]*(10-$i-1);
				}
				$checkDigit=11-($checkDigit % 11);
				//Se der 10 então o dígito de controlo tem de ser 0
				if($checkDigit>=10) $checkDigit=0;
				//Comparamos com o último dígito
				if ($checkDigit==$nifSplit[8]) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	public function searchnif($nif, $country='PT')
    {
		$eid = $this->input->post('eid');
		$validani = $this->validaNIF($taxid);
		if(!$validani){
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('nifpt')));
		}else{
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('nifpt2')));
		}
		
	}
	
	public function searchnif2()
    {
		$taxid = $this->input->post('taxid');
		$validani = $this->validaNIF($taxid);
		if(!$validani){
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('nifpt')));
		}else{
			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('nifpt2')));
		}
	}
	
	
	public function searchvies()
    {
		$nif = $this->input->post('taxid');
		$country = $this->input->post('country');
		echo $this->customers->ValidaVIES($nif,$country);
	}
	
	
    public function addcustomer()
    {
		$taxid = $this->input->post('taxid');
		//$validani = $this->validaNIF($taxid);
		/*if(!$validani){
			echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('nifpt')));
			return;
		}*/
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        
        $customergroup = $this->input->post('customergroup');
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
        $language = $this->input->post('language', true);
        $create_login = $this->input->post('c_login', true);
        $password = $this->input->post('password_c', true);
        $docid = $this->input->post('docid', true);
        $custom = $this->input->post('c_field', true);
        $discount = $this->input->post('discount', true);
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $language, $create_login, $password, $docid, $custom, $discount);


    }

    function sendSelected()
    {
        if (!$this->aauth->premission(36) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}

        if ($this->input->post('cust')) {
            $ids = $this->input->post('cust');

            $subject = $this->input->post('subject', true);
            $message = $this->input->post('text');
            $attachmenttrue = false;
            $attachment = '';
            $recipients = $this->customers->recipients($ids);
            $this->load->model('communication_model');
            $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
        }
    }

    function sendSmsSelected()
    {
        if (!$this->aauth->premission(36) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}

        if ($this->input->post('cust')) {
            $ids = $this->input->post('cust');
            $message = $this->input->post('message', true);
            $recipients = $this->customers->recipients($ids);
            $this->config->load('sms');
            $this->load->model('sms_model');
            foreach ($recipients as $row) {

                $this->sms_model->send_sms($row['phone'], $message);

            }
        }
    }

    public function editcustomer()
    {
        if (!$this->aauth->premission(38) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->post('id');
        $name = $this->input->post('name', true);
        $company = $this->input->post('company', true);
        $phone = $this->input->post('phone', true);
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city', true);
        $region = $this->input->post('region', true);
        $country = $this->input->post('country', true);
        $postbox = $this->input->post('postbox', true);
        $customergroup = $this->input->post('customergroup', true);
        $taxid = $this->input->post('taxid', true);
        $name_s = $this->input->post('name_s', true);
        $phone_s = $this->input->post('phone_s', true);
        $email_s = $this->input->post('email_s', true);
        $address_s = $this->input->post('address_s', true);
        $city_s = $this->input->post('city_s', true);
        $region_s = $this->input->post('region_s', true);
        $country_s = $this->input->post('country_s', true);
        $postbox_s = $this->input->post('postbox_s', true);
        $docid = $this->input->post('docid', true);
        $custom = $this->input->post('c_field', true);
        $language = $this->input->post('language', true);
        $discount = $this->input->post('discount', true);
        if ($id) {
            $this->customers->edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s, $docid, $custom, $language, $discount);
        }
    }

    public function changepassword()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        if ($id = $this->input->post()) {
            $id = $this->input->post('id');
            $password = $this->input->post('password', true);
            if ($id) {
                $this->customers->changepassword($id, $password);
            }
        } else {
            $pid = $this->input->get('id');
            $data['customer'] = $this->customers->details($pid);
            $data['customergroup'] = $this->customers->group_info($pid);
            $data['customergrouplist'] = $this->customers->group_list();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/edit_password', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
		$id = $this->input->post('deleteid');
		if ($id > 1) {
			if ($this->customers->delete($id)) {
				echo json_encode(array('status' => 'Success', 'message' => 'Customer details deleted Successfully!'));
			} else {
				echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
			}
		} else if ($this->input->post('cust')) {
			$customers = $this->input->post('cust');
			foreach ($customers as $row) {
				$this->customers->delete($row);
			}
			echo json_encode(array('status' => 'Success', 'message' => 'Customer details deleted Successfully!'));
		}
    }

    public function displaypic()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->customers->editpicture($id, $img);
        }
    }


    public function translist()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $list = $this->customers->trans_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->cod_cat;
			$row[] = $prd->date;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;
            $row[] = $prd->methodname;
			
			$option = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a>';
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';
			}
			$row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->trans_count_all($cid),
            "recordsFiltered" => $this->customers->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');

        $list = $this->customers->inv_datatables($cid, $tid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
			$row[] = $invoices->serie_name;
			if($invoices->i_class == 0)
			{
				$row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '">&nbsp; ' .$invoices->irs_type_s.': '. $invoices->tid . '</a>';
			}else if($invoices->i_class == 1)
			{
				$row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '">&nbsp; ' .$invoices->irs_type_s.': '. $invoices->tid . '</a>';
			}else
			{
				$row[] = '<a href="' . base_url("subscriptions/view?id=$invoices->id") . '">&nbsp; ' .$invoices->irs_type_s.': '. $invoices->tid . '</a>';
			}
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->subtotal, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->tax, 0, $this->aauth->get_user()->loc);
			$row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            
			if($invoices->i_class == 0)
			{
				$row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';
			}else if($invoices->i_class == 1)
			{
				$row[] = '<a href="' . base_url("pos_invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';
			}else{
				$row[] = '<a href="' . base_url("subscriptions/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View"><i class="fa fa-file-text"></i> </a> <a href="' . base_url("subscriptions/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';
			}
			
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function transactions()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function quotes()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Quotes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/quotes', $data);
        $this->load->view('fixed/footer');
    }

    public function qto_list()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $list = $this->customers->qto_datatables($cid, $tid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
			$row[] = $invoices->serie_name;
			$row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '">&nbsp; ' . $invoices->tid . '</a>';
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
			
			$option = '';
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(7))
			{
				$option .= '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="View Invoice"><i class="fa fa-file-text"></i> </a><a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';
			}
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object" title="Delete"><span class="fa fa-trash"></span></a>';
			}
			$row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->qto_count_all($cid),
            "recordsFiltered" => $this->customers->qto_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function balance()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $amount = $this->input->post('amount', true);
            if ($this->customers->recharge($id, $amount)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Balance Added')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
            }
        } else {
            $custid = $this->input->get('id');
            $data['details'] = $this->customers->details($custid);
            $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
            $data['money'] = $this->customers->money_details($custid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['activity'] = $this->customers->activity($custid);
            $head['title'] = 'View Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/recharge', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function projects()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/projects', $data);
        $this->load->view('fixed/footer');
    }

    public function prj_list()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $list = $this->customers->project_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {
            $no++;
            $name = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '">' . $project->name . '</a>';

            $row = array();
            $row[] = $no;
            $row[] = $name;
            $row[] = dateformat($project->sdate);
            $row[] = $project->customer;
            $row[] = '<span class="project_' . $project->status . '">' . $this->lang->line($project->status) . '</span>';
			$option = '';
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(61)) {
				$option .= '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"> ' . $this->lang->line('View') . ' </a>';
			}
			
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(64)) {
				$option .= '<a class="btn btn-info btn-sm" href="' . base_url() . 'projects/edit?id=' . $project->id . '" data-object-id="' . $project->id . '"> <i class="fa fa-pencil"></i> </a>&nbsp;';
			}
			
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $project->id . '"> <i class="fa fa-trash"></i> </a>';
			}
			$row[] = $option;
            $row[] = ' ';


            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->project_count_all($cid),
            "recordsFiltered" => $this->customers->project_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function notes()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $custid = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['details'] = $this->customers->details($custid);
        $this->session->set_userdata("cid", $custid);
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/notes', $data);
        $this->load->view('fixed/footer');
    }
	
    public function notes_load_list()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $list = $this->customers->notes_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $note) {
            $row = array();
            $no++;
            $row[] = $no;
			$row[] = dateformat($note->cdate);
			$row[] = dateformat($note->last_edit);
            $row[] = $note->title;
            $row[] = $note->name_add;
			$option = '';
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(80))
			{
				 $option .= '<a href="#" data-id="' . $note->id . '" class="view_note"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a> ';
			}
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(82))
			{
				$option .= ' <a href="editnote?id=' . $note->id . '&cid=' . $note->fid . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('Edit') . '</a>';
			}
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= ' <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="fa fa-trash"></i> </a>';
			}
			$row[] = $option;
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->notes_count_all($cid),
            "recordsFiltered" => $this->customers->notes_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function editnote()
    {
		if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $content = $this->input->post('content');
            $cid = $this->input->post('cid');
            if ($this->customers->editnote($id, $title, $content, $cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . " <a href='notes?id=$cid' class='btn btn-indigo btn-lg'><span class='icon-user' aria-hidden='true'></span>  </a> <a href='editnote?id=$id&cid=$cid' class='btn btn-indigo btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $id = $this->input->get('id');
            $cid = $this->input->get('cid');
            $data['note'] = $this->customers->note_v($id, $cid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/editnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function addnote()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        if ($this->input->post('title')) {

            $title = $this->input->post('title', true);
            $cid = $this->input->post('id');
            $content = $this->input->post('content');

            if ($this->customers->addnote($title, $content, $cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addnote?id=" . $cid . "' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='notes?id=" . $cid . "' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Note';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/addnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function delete_note()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');
        if ($this->customers->deletenote($id, $cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    function statement()
    {
		if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        if ($this->input->post()) {

            $this->load->model('reports_model');
			$this->load->model('settings_model', 'settings');
			$this->load->model('invoices_model', 'invocies');
            $customer = $this->input->post('customer');
            $trans_type = $this->input->post('trans_type');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));
			
            $data['customer'] = $this->customers->details($customer);
			$data['company'] = $this->settings->company_details2($this->aauth->get_user()->loc);
            $data['list'] = $this->reports_model->get_customer_statements($customer, $trans_type, $sdate, $edate);
			$data['employee'] = $this->customers->employee($this->aauth->get_user()->id);
			$debitPreviousCustomer = $this->reports_model->get_customer_previous_debit($customer, $trans_type, $sdate, $edate);
			if($debitPreviousCustomer['debit'] == null)
			{
				$data['debitPrevious'] = '0.00';
			}else{
				$data['debitPrevious'] = $debitPreviousCustomer['debit'];
			}
			$creditPreviousCustomer = $this->reports_model->get_customer_previous_credit($customer, $trans_type, $sdate, $edate);
			if($creditPreviousCustomer['credit'] == null)
			{
				$data['creditPrevious'] = '0.00';
			}else{
				$data['creditPrevious'] = $creditPreviousCustomer['credit'];
			}
			
			$debitCustomer = $this->reports_model->get_costumer_debit($customer);
			if($debitCustomer['debit'] == null)
			{
				$data['debit'] = '0.00';
			}else{
				$data['debit'] = $debitCustomer['debit'];
			}
			$creditCustomer = $this->reports_model->get_costumer_credit($customer);
			if($creditCustomer['credit'] == null)
			{
				$data['credit'] = '0.00';
			}else{
				$data['credit'] = $creditCustomer['credit'];
			}
            $html = $this->load->view('customers/statementpdf', $data, true);
            ini_set('memory_limit', '64M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output('Statement' . $customer . '.pdf', 'I');
        } else {
            $data['id'] = $this->input->get('id');
            $this->load->model('transactions_model');

            $data['details'] = $this->customers->details($data['id']);
            $head['title'] = "Account Statement";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/statement', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function documents()
    {
		if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->customers->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->session->set_userdata("cid", $data['id']);
        $head['title'] = 'Documents';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/documents', $data);
        $this->load->view('fixed/footer');
    }

    public function document_load_list()
    {
		if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $cid = $this->input->post('cid');
        $list = $this->customers->document_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = dateformat($document->cdate);
			$row[] = $document->title;
			$row[] = $document->name_add;
            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="fa fa-trash"></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->document_count_all($cid),
            "recordsFiltered" => $this->customers->document_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function adddocument()
    {
		if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $data['id'] = $this->input->get('id');
        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Document';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title', true);
            $cid = $this->input->post('id');
            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 3000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully. <a href="documents?id=' . $cid . '"
                                       class="btn btn-indigo btn-md"><i
                                                class="icon-folder"></i>
                                    </a>';
                $filename = $this->upload->data()['file_name'];
                $this->customers->adddocument($title, $filename, $cid);
            }

            $this->load->view('customers/adddocument', $data);
        } else {


            $this->load->view('customers/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_document()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');

        if ($this->customers->deletedocument($id, $cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function bulkpayment()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
		$this->load->library("Common");
		$data['metodos_pagamentos'] = $this->common->smetopagamento();
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->customers->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $this->session->set_userdata("cid", $data['id']);
        $head['title'] = 'Bulk Payment Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/bulkpayment', $data);
        $this->load->view('fixed/footer');
    }

    public function bulk_post()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $csd = $this->input->post('customer', true);
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $trans_type = $this->input->post('trans_type', true);
        $data['details'] = $this->customers->sales_due($sdate, $edate, $csd, $trans_type);

        $due = $data['details']['total'] - $data['details']['pamnt'];
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Calculated') . ' ' . amountExchange($due), 'due' => amountExchange_s($due)));
    }

    public function bulk_post_payment()
    {
        if (!$this->aauth->premission(120) && !$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $csd = $this->input->post('customer', true);
        $account = $this->input->post('account', true);
        $pay_method = $this->input->post('pmethod', true);
        $amount = numberClean($this->input->post('amount', true));
        $sdate = datefordatabase($this->input->post('sdate_2'));
        $edate = datefordatabase($this->input->post('edate_2'));

        $trans_type = $this->input->post('trans_type_2', true);
        $note = $this->input->post('note', true);
        $data['details'] = $this->customers->sales_due($sdate, $edate, $csd, $trans_type, false, $amount, $account, $pay_method, $note);

        $due = 0;
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Paid') . ' ' . amountExchange($amount), 'due' => amountExchange_s($due)));
    }

}