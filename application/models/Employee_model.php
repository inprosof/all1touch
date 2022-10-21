<?php
/**

 * 
 * ***********************************************************************
 *
 
 
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * 
 *  * 
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model
{

    public function list_employee()
    {
        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid,geopos_users.loc, geopos_countrys.name as namecountry');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
		$this->db->join('geopos_countrys', 'geopos_employees.country = geopos_countrys.prefix', 'left');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);
			$this->db->where('geopos_users.system', 0);
            if (BDATA) 
				$this->db->or_where('loc', 0);
            $this->db->group_end();
        }
		$this->db->where('geopos_employees.system', 0);
		$this->db->where('geopos_users.banned', 0);
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_project_employee($id)
    {
        $this->db->select('geopos_employees.*');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_project_meta.meta_key', 19);
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_project_meta.meta_data', 'left');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
		$this->db->where('geopos_users.system', 0);
		$this->db->where('geopos_employees.system', 0);
		$this->db->where('geopos_users.banned', 0);
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee_details($id)
    {
        $this->db->select("geopos_employees.*, geopos_countrys.name as namecountry,geopos_users.email,geopos_users.loc,geopos_users.roleid, geopos_hrm.val1 as departament, geopos_locations.cname as locname, geopos_type_irs.name as type_irsname,");
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.id', $id);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
		$this->db->join('geopos_countrys', 'geopos_employees.country = geopos_countrys.prefix', 'left');
        $this->db->join('geopos_hrm', 'geopos_employees.dept = geopos_hrm.id', 'left');
		$this->db->join('geopos_locations', 'geopos_users.loc = geopos_locations.id', 'left');
		$this->db->join('geopos_type_irs', 'geopos_employees.type_irs = geopos_type_irs.id', 'left'); 
		
        $query = $this->db->get();
        return $query->row_array();
    }

    public function salary_history($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_salary_process');
        $this->db->where('typ', 1);
        $this->db->where('year', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_employee($id, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $location, $basic_salary = 0,$subsidy_meal=0,$medical_allowance,$department = -1, $commission = 0, $roleid = false, $irs, $niss,$type_employee,$type_irs,$married,$account_bank,$number_children,$productivity,$mess_ativos)
    {
        $this->db->select('roleid');
        $this->db->from('geopos_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $role = $query->row_array();

        $data = array(
            'name' => $name,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'basic_salary' => $basic_salary,
            'subsidy_meal' => $subsidy_meal,
            'medical_allowance' => $medical_allowance,
            'c_rate' => $commission,
            'irs_number' => $irs,
            'niss' => $niss,
            'type_irs' => $type_irs,
            'married' => $married,
			'number_children' => $number_children,
			'productivity' => $productivity,
            'account_bank' => $account_bank,
            'type_employee' => $type_employee,
			'mess_ativos' => $mess_ativos
        );
        if ($department > -1) {
            $data = array(
                'name' => $name,
                'phone' => $phone,
                'phonealt' => $phonealt,
                'address' => $address,
                'city' => $city,
                'region' => $region,
                'country' => $country,
                'postbox' => $postbox,
                'basic_salary' => $basic_salary,
				'subsidy_meal' => $subsidy_meal,
				'medical_allowance' => $medical_allowance,
                'dept' => $department,
                'c_rate' => $commission,
                'irs_number' => $irs,
                'niss' => $niss,
                'type_irs' => $type_irs,
                'married' => $married,
				'number_children' => $number_children,
				'productivity' => $productivity,
                'account_bank' => $account_bank,
                'type_employee' => $type_employee,
				'mess_ativos' => $mess_ativos
            );
        }


        $this->db->set($data);
        $this->db->where('id', $id);


        if ($this->db->update('geopos_employees')) {
			$this->custom->edit_save_fields_data($id, 6);
            //if ($roleid && $role['roleid'] != 5) {
			if ($roleid) {
                $this->db->set('loc', $location);
                $this->db->set('roleid', $roleid);
                $this->db->where('id', $id);
                $this->db->update('geopos_users');
            }
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	
	public function update_employee2($id, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $location)
    {
        $this->db->select('roleid');
        $this->db->from('geopos_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $role = $query->row_array();

        $data = array(
            'name' => $name,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox
        );
        /*if ($department > -1) {
            $data = array(
                'name' => $name,
                'phone' => $phone,
                'phonealt' => $phonealt,
                'address' => $address,
                'city' => $city,
                'region' => $region,
                'country' => $country,
                'postbox' => $postbox
            );
        }*/


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('geopos_employees')) {
			$this->db->set('loc', $location);
            $this->db->where('id', $id);
            $this->db->update('geopos_users');
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }

    public function update_password($id, $cpassword, $newpassword, $renewpassword)
    {


    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from('geopos_employees');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_employees')) {
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('geopos_users');
            unlink(FCPATH . 'userfiles/employee/' . $result['picture']);
            unlink(FCPATH . 'userfiles/employee/thumbnail/' . $result['picture']);
        }


    }


    public function editsign($id, $pic)
    {
        $this->db->select('sign');
        $this->db->from('geopos_employees');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'sign' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_employees')) {

            unlink(FCPATH . 'userfiles/employee_sign/' . $result['sign']);
            unlink(FCPATH . 'userfiles/employee_sign/thumbnail/' . $result['sign']);
        }


    }


    var $table = 'geopos_invoices';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status');
    var $column_search = array('geopos_invoices.tid', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status');
    var $order = array('geopos_invoices.tid' => 'asc');


    private function _invoice_datatables_query($id)
    {
        $this->db->select('geopos_invoices.*,geopos_customers.name');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.eid', $id);
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function invoice_datatables($id)
    {
        $this->_invoice_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function invoicecount_filtered($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_invoices.eid', $id);
        }
        return $query->num_rows($id);
    }

    public function invoicecount_all($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_invoices.eid', $id);
        }
        return $query->num_rows($id = '');
    }

    //transaction


    var $tcolumn_order = array(null, 'account', 'type', 'cat', 'amount', 'stat');
    var $tcolumn_search = array('id', 'account');
    var $torder = array('id' => 'asc');
    var $eid = '';

    private function _get_datatables_query()
    {
        $this->db->from('geopos_transactions');
        $this->db->where('eid', $this->eid);

        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($eid)
    {
        $this->eid = $eid;
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('geopos_transactions');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('geopos_transactions');
        $this->db->where('eid', $this->eid);
        return $this->db->count_all_results();
    }

    public function add_employee($id, $username, $name, $roleid, $phone, $address, $city, $region, $country, $postbox, $location, $basic_salary = 0,$subsidy_meal=0,$medical_allowance,$commission = 0, $department = 0, $irs, $niss,$type_employee,$type_irs,$married, $account_bank, $number_children, $productivity, $mess_ativos)
    {
        $data = array(
            'id' => $id,
            'username' => $username,
            'name' => $name,
            'phone' => $phone,
            'dept' => $department,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'basic_salary' => $basic_salary,
            'subsidy_meal' => $subsidy_meal,
            'medical_allowance' => $medical_allowance,
            'c_rate' => $commission,
            'irs_number' => $irs,
            'niss' => $niss,
            'type_irs' => $type_irs,
            'married' => $married,
            'account_bank' => $account_bank,
            'type_employee' => $type_employee,
			'number_children' => $number_children,
			'productivity' => $productivity,
			'system' => 0,
			'mess_ativos' => $mess_ativos
        );

        if ($this->db->insert('geopos_employees', $data)) {
			$this->custom->save_fields_data($id, 6);
            $data1 = array(
                'roleid' => $roleid,
                'loc' => $location
            );
            $this->db->set($data1);
            $this->db->where('id', $id);
            $this->db->update('geopos_users');
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED')."<a href='".base_url('employee')."' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }

    public function employee_validate($email)
    {
        $this->db->select('*');
        $this->db->from('geopos_users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function money_details($eid)
    {
        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('geopos_transactions');
        $this->db->where('eid', $eid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sales_details($eid)
    {
        $this->db->select('SUM(pamnt) AS total');
        $this->db->from('geopos_invoices');
        $this->db->where('eid', $eid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sales_details_month($month,$year,$eid)
    {
        $this->db->select('SUM(pamnt) AS total');
        $this->db->from('geopos_invoices');
        $this->db->where('eid', $eid);
        $this->db->where('YEAR(invoicedate)', $year);
        $this->db->where('MONTH(invoicedate)', $month);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function get_gross_month($year,$eid,$type)
    {
        $pesque = "";
        if($type == 1){
            $pesque = 'SUM(gross_income) AS total';
        }else if($type == 2){
            $pesque = 'SUM(total_transfer) AS total';
        }else if($type == 3){
            $pesque = 'SUM(monthly_social_security) AS total';
        }else if($type == 4){
            $pesque = 'SUM(monthly_irs) AS total';
        }

        
        $this->db->select($pesque);
        $this->db->from('geopos_salary_process');
        $this->db->where('employee_id', $eid);
        $this->db->where('year', $year);
        $query = $this->db->get();
        return $query->row_array();
    }

    
    public function sales_num_month($month,$year,$eid)
    {
        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('eid', $eid);
        $this->db->where('YEAR(invoicedate)', $year);
        $this->db->where('MONTH(invoicedate)',$month);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function employee_permissions()
    {
        $this->db->select('*');
        $this->db->from('geopos_premissions');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    //documents list

    var $doccolumn_order = array(null, 'val1', 'val2', null);
    var $doccolumn_search = array('val1', 'val2');


    function addholidays($loc, $hday, $hdayto, $note)
    {
        $data = array('typ' => 2, 'rid' => $loc, 'val1' => $hday, 'val2' => $hdayto, 'val3' => $note);
        return $this->db->insert('geopos_hrm', $data);

    }

    function deleteholidays($id)
    {

        if ($this->db->delete('geopos_hrm', array('id' => $id, 'typ' => 2))) {


            return true;
        } else {
            return false;
        }

    }


    function holidays_datatables()
    {
        $this->holidays_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function holidays_datatables_query()
    {
        $this->db->from('geopos_events');
        $this->db->where('event_type', 2);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('employee_id', $this->aauth->get_user()->loc);
        }
        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->doccolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->doccolumn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function holidays_count_filtered()
    {
        $this->holidays_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function holidays_count_all()
    {
        $this->holidays_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function hday_view($id, $loc)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('id', $id);
        $this->db->where('event_type', 2);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('employee_id', $loc);
        }

        $query = $this->db->get();
        return $query->row_array();
    }

    public function edithday($id, $loc, $from, $todate, $note)
    {
        $data = array('typ' => 2, 'val1' => $from, 'val2' => $todate, 'val3' => $note);
		
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('employee_id', $loc);
        }

        $this->db->update('geopos_events');
        return true;

    }

    public function department_list($id = 0, $loc = 0)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('typ', 3);
        if ($loc) {
            $this->db->where('rid', $loc);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function department_elist($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_employees');

        $this->db->where('dept', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function department_view($id, $loc)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('id', $id);
        $this->db->where('typ', 3);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $loc);
        }


        $query = $this->db->get();
        return $query->row_array();
    }

    function adddepartment($loc, $name)
    {
        $data = array('typ' => 3, 'rid' => $loc, 'val1' => $name);
        return $this->db->insert('geopos_hrm', $data);

    }

    function deletedepartment($id)
    {
        if ($this->db->delete('geopos_hrm', array('id' => $id, 'typ' => 3))) {


            return true;
        } else {
            return false;
        }
    }

    public function editdepartment($id, $loc, $name)
    {
        $data = array(
            'val1' => $name
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $loc);
        }

        $this->db->update('geopos_hrm');
        return true;

    }

    //payroll

    private function _pay_get_datatables_query($eid)
    {
		$this->db->select('geopos_transactions.*, geopos_config.val1 as methodname');
        $this->db->from('geopos_transactions');
		$this->db->join('geopos_config', 'geopos_transactions.method=geopos_config.id', 'left');		
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        $this->db->where('ext', 4);
        if ($eid) {
            $this->db->where('payerid', $eid);
        }


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function pay_get_datatables($eid)
    {

        $this->_pay_get_datatables_query($eid);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function pay_count_filtered($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('ext', 4);
        if ($eid) {
            $this->db->where('payerid', $eid);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function pay_count_all($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('ext', 4);
        if ($eid) {
            $this->db->where('payerid', $eid);
        }
        return $this->db->count_all_results();
    }


    function addattendance($emp, $adate, $tfrom, $tto, $note)
    {
        foreach ($emp as $row) {

            $this->db->where('emp', $row);
            $this->db->where('DATE(adate)', $adate);
            $num = $this->db->count_all_results('geopos_attendance');

            if (!$num) {
                $data = array('emp' => $row, 'created' => date('Y-m-d H:i:s'), 'adate' => $adate, 'tfrom' => $tfrom, 'tto' => $tto, 'note' => $note);
                $this->db->insert('geopos_attendance', $data);
            }
        }

        return true;

    }

    function deleteattendance($id)
    {

        if ($this->db->delete('geopos_attendance', array('id' => $id))) {
            return true;
        } else {
            return false;
        }

    }

    var $acolumn_order = array(null, 'geopos_attendance.emp', 'geopos_attendance.adate', null, null);
    var $acolumn_search = array('geopos_employees.name', 'geopos_attendance.adate');

    function attendance_datatables($cid)
    {
        $this->attendance_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function attendance_datatables_query($cid = 0)
    {
        $this->db->select('geopos_attendance.*,geopos_employees.name');
        $this->db->from('geopos_attendance');
        $this->db->join('geopos_employees', 'geopos_employees.id=geopos_attendance.emp', 'left');
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_users', 'geopos_users.id=geopos_attendance.emp', 'left');
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);

        }
        if ($cid) $this->db->where('geopos_attendance.emp', $cid);
        $i = 0;

        foreach ($this->acolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->acolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order)) {
            $order = $this->acolumn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function attendance_count_filtered($cid)
    {
        $this->attendance_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function attendance_count_all($cid)
    {
        $this->attendance_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAttendance($emp, $start, $end)
    {
        $sql = "SELECT  CONCAT('De: ', tfrom, ' - Até: ', tto) AS title, DATE(adate) as start ,DATE(adate) as end,CASE
					WHEN note = '' THEN 'Sem Notas definidas.'
					ELSE note
				END AS description FROM geopos_attendance WHERE (emp='$emp') AND (DATE(adate) BETWEEN ? AND ? ) ORDER BY DATE(adate) ASC";
        return $this->db->query($sql, array($start, $end))->result();
    }
	
	public function getHoliday($loc, $start, $end)
    {
        $sql = "SELECT title,DATE(start) as start ,DATE(end) as end,description FROM geopos_events WHERE (event_type='2') AND (DATE(start) BETWEEN ? AND ?) ORDER BY DATE(start) ASC";
        return $this->db->query($sql, array($start, $end))->result();
    }
	
	public function getVacation($loc, $start, $end)
    {
		$sql = "SELECT title,DATE(start) as start ,DATE(end) as end,description FROM geopos_events WHERE (event_type='1') AND (employee_id=?) AND (DATE(start) BETWEEN ? AND ? ) ORDER BY DATE(start) ASC";
        return $this->db->query($sql, array($loc, $start, $end))->result();
    }
	
	
	function vacations_datatables()
    {
        $this->vacations_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function vacations_datatables_query()
    {
		$this->db->select("geopos_employees.name as name_emp,geopos_events.*");
        $this->db->from('geopos_events');
        $this->db->where('geopos_events.event_type', 1);
		$this->db->join('geopos_employees', 'geopos_employees.id = geopos_events.employee_id', 'left');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_events.employee_id', $this->aauth->get_user()->loc);
        }
        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->doccolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->doccolumn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function vacations_count_filtered()
    {
        $this->vacations_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function vacations_count_all()
    {
        $this->vacations_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function vacation_view($id, $loc)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('id', $id);
        $this->db->where('event_type', 1);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('employee_id', $loc);
        }

        $query = $this->db->get();
        return $query->row_array();
    }

    public function editvacations($id, $loc, $from, $todate, $note)
    {

        $data = array('event_type' => 1, 'val1' => $from, 'val2' => $todate, 'val3' => $note);
		
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('employee_id', $loc);
        }

        $this->db->update('geopos_events');
        return true;

    }
	
	
	public function edithfault($id, $emp, $adate, $edate, $justified, $note)
    {
        $data = array('emp' => $emp, 'adate' => $adate, 'edate' => $edate, 'justified' => $justified, 'note' => $note);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('geopos_faults');
        return true;

    }
	
	
	public function fault_view($id, $loc)
    {
		$this->db->select("geopos_faults.*, geopos_employees.name as emp_nome, CASE WHEN geopos_faults.justified = 0 THEN 'Não' ELSE 'Sim' END AS justifiedname");
        $this->db->from('geopos_faults');
        $this->db->where('geopos_faults.id', $id);
		$this->db->join('geopos_employees', 'geopos_employees.id=geopos_faults.emp', 'left');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('emp', $loc);
        }

        $query = $this->db->get();
        return $query->row_array();
    }
	
	
	public function getFault($emp, $start, $end)
    {
        $sql = "SELECT CASE
					WHEN justified = 0 THEN 'Falta não Justificada'
					ELSE 'Falta Justificada'
				END AS title, DATE(adate) as start ,DATE(adate) as end,CASE
					WHEN note = '' THEN 'Sem Notas definidas.'
					ELSE note
				END AS description FROM geopos_faults WHERE (emp='$emp') AND (DATE(adate) BETWEEN ? AND ? ) ORDER BY DATE(adate) ASC";
        return $this->db->query($sql, array($start, $end))->result();
    }


    public function select_fault_of_month($month, $year, $employee_id, $type)
    {
        $sql = "";
        if($type == -1){
            $sql = "SELECT DATE(adate) as start ,DATE(adate) as end,CASE
					WHEN note = '' THEN 'Sem Notas definidas.'
					ELSE note
				END AS description FROM geopos_faults WHERE (emp='$emp') AND (DATE(adate) BETWEEN ? AND ? ) ORDER BY DATE(adate) ASC";
        }else
        {
            $sql = "SELECT DATE(adate) as start ,DATE(adate) as end,CASE
					WHEN note = '' THEN 'Sem Notas definidas.'
					ELSE note
				END AS description FROM geopos_faults WHERE (emp='$emp') AND (justified='$type') AND (DATE(adate) BETWEEN ? AND ? ) ORDER BY DATE(adate) ASC";
        }
        return $this->db->query($sql, array($start, $end))->num_rows();
    }
	
	function addfault($emp, $adate, $edate, $justified, $note)
    {
		foreach ($emp as $row) {
            $data = array('emp' => $row, 'adate' => $adate, 'edate' => $edate, 'justified' => $justified, 'note' => $note);
            $this->db->insert('geopos_faults', $data);
        }
		return true;
    }

    function deletefault($id)
    {
        if ($this->db->delete('geopos_faults', array('id' => $id))) {
            return true;
        } else {
            return false;
        }

    }

    var $acolumn_order_fault = array(null, 'geopos_faults.emp', 'geopos_faults.adate', null, null);
    var $acolumn_search_fault = array('geopos_employees.name', 'geopos_faults.adate');

    function fault_datatables($cid)
    {
        $this->fault_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function fault_datatables_query($cid = 0)
    {
        $this->db->select('geopos_faults.*,geopos_employees.name');
        $this->db->from('geopos_faults');
        $this->db->join('geopos_employees', 'geopos_employees.id=geopos_faults.emp', 'left');
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_users', 'geopos_users.id=geopos_faults.emp', 'left');
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);

        }
        if ($cid) $this->db->where('geopos_faults.emp', $cid);
        $i = 0;

        foreach ($this->acolumn_search_fault as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->acolumn_search_fault) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order_fault[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order_fault)) {
            $order = $this->acolumn_order_fault;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function fault_count_filtered($cid)
    {
        $this->fault_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function fault_count_all($cid)
    {
        $this->fault_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function salary_view($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('ext', 35);
        $this->db->where('payerid', $eid);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function autoattend($opt)
    {
        $this->db->set('key1', $opt);
        $this->db->where('id', 62);

        $this->db->update('univarsal_api');
        return true;
    }

    public function list_type_irs(){
        $this->db->from('geopos_type_irs');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_assign_assets($eid)
    {
        $this->db->from('geopos_assets');
        $this->db->where('employee_id', $eid);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_assets()
    {
        $this->db->from('geopos_assets');
        $query = $this->db->get();
        return $query->result_array();
    }
}