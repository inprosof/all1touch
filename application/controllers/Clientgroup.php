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

class Clientgroup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('clientgroup_model', 'clientgroup');
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(39) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {

            exit($this->lang->line('translate19'));
        }

        $this->li_a = 'crm';
    }

    //groups
    public function index()
    {
        if (!$this->aauth->premission(39) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $data['group'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Client Groups';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groups', $data);
        $this->load->view('fixed/footer');
    }

    //view
    public function groupview()
    {
        if (!$this->aauth->premission(39) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $data['group'] = $this->clientgroup->details($id);
        $head['title'] = 'Group View';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupview', $data);
        $this->load->view('fixed/footer');
    }

    //datatable
    public function grouplist()
    {
        if (!$this->aauth->premission(39) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->get('id');
        $list = $this->customers->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle"  src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="' . base_url() . 'customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
            $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
            $row[] = $customers->email;
            $row[] = $customers->phone;

            $option = '';
            if ($this->aauth->premission(39) || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) {
                $option .= '<a href="' . base_url() . 'customers/view?id=' . $customers->id . '" class="btn btn-outline-success btn-sm"><span class="bi bi-eye"></span>  ' . '</a>';
            }

            if ($this->aauth->premission(41) || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) {
                $option .= '<a href="' . base_url() . 'customers/edit?id=' . $customers->id . '" class="btn btn-outline-primary btn-sm"><span class="icon-pencil"></span> ' . '</a>';
            }
            if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7) {
                $option .= "<a href='#' data-object-id='" . $customers->id . "' class='btn btn-outline-danger btn-sm delete-object' title='Delete'><i class='bi bi-trash'></i></a>";
            }

            $row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all($id),
            "recordsFiltered" => $this->customers->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //datatable
    public function group_clientlist()
    {
        if (!$this->aauth->premission(39) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->get('id');
        $list = $this->clientgroup->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $group) {
            $no++;
            $cid = $group->id;
            $row = array();
            $row[] = $no;
            $row[] = $group->title . '<br>' . $group->summary;
            $numlis = $this->clientgroup->grup_clin_sum($cid);
            $row[] = $numlis['num_cli'];
            $row[] = $group->disc_rate;

            $option = '';
            if ($this->aauth->premission(39) || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) {
                $option .= "<div class='action-btn'><a href='" . base_url("clientgroup/groupview?id=$cid") . "' class='btn btn-outline-success btn-sm' title=" . $this->lang->line('View') . "><i class='bi bi-eye'></i>  " . "</a>";
            }

            if ($this->aauth->premission(41) || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) {
                $option .= "<a href='" . base_url("clientgroup/editgroup?id=$cid") . "' class='btn btn-outline-primary btn-sm' title=" . $this->lang->line('Edit') . "><i class='bi bi-pencil'></i> " . "</a>";
            }

            if ($this->aauth->premission(39) || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7) {
                $option .= "<a href='#' data-object-id='" . $cid . "'  class='btn btn-outline-info btn-sm discount-object' title=" . $this->lang->line('Discount') . "><i class='bi bi-lightning-fill'></i> " . "</a>";
            }

            if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7) {
                $option .= "<a href='#' data-object-id='" . $cid . "' class='btn btn-outline-danger btn-sm delete-object' title=" . $this->lang->line('Delete') . "><i class='bi bi-trash'></i></a></div>";
            }

            $row[] = $option;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->clientgroup->count_all($id),
            "recordsFiltered" => $this->clientgroup->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->aauth->premission(40) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create Group';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/add');
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if (!$this->aauth->premission(40) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $group_name = $this->input->post('group_name', true);
        $group_desc = $this->input->post('group_desc', true);

        if ($group_name) {
            $this->clientgroup->add($group_name, $group_desc);
        }
    }

    public function editgroup()
    {
        if (!$this->aauth->premission(41) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $gid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_cust_group');
        $this->db->where('id', $gid);
        $query = $this->db->get();
        $data['group'] = $query->row_array();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Group';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupedit', $data);
        $this->load->view('fixed/footer');

    }

    public function editgroupupdate()
    {
        if (!$this->aauth->premission(41) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $gid = $this->input->post('gid', true);
        $group_name = $this->input->post('group_name', true);
        $group_desc = $this->input->post('group_desc', true);
        if ($gid) {
            $this->clientgroup->editgroupupdate($gid, $group_name, $group_desc);
        }
    }

    public function delete_i()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }

        $id = $this->input->post('deleteid');
        if ($id != 1) {
            $this->db->delete('geopos_cust_group', array('id' => $id));
            $this->db->set(array('gid' => 1));
            $this->db->where('gid', $id);
            $this->db->update('geopos_customers');
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else if ($id == 1) {
            echo json_encode(array('status' => 'Error', 'message' => 'You can not delete the default group!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));


        }
    }

    function sendGroup()
    {
        $id = $this->input->post('gid');
        $subject = $this->input->post('subject', true);
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $recipients = $this->clientgroup->recipients($id);
        $this->load->model('communication_model');
        $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
    }

    public function discount_update()
    {
        $gid = $this->input->post('gid', true);
        $disc_rate = (float)$this->input->post('disc_rate', true);

        if ($gid) {
            $this->clientgroup->editgroupdiscountupdate($gid, $disc_rate);
        }
    }
}