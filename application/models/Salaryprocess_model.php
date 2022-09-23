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


class Salaryprocess_model extends CI_Model
{
    var $table = 'geopos_salary_process';

    public function __construct()
    {
        parent::__construct();
    }

    public function save_salary($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_list($employee_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('employee_id', $employee_id);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_process_item($process_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $process_id);
        $query = $this->db->get();
        return $query->row_array();

    }

    public function getValueIrsMax($employee_id, $baseSalaryMeal)
    {
        $this->db->select('geopos_employees.name, geopos_irs.up_to, geopos_irs.value_x');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_irs', 'geopos_employees.type_irs = geopos_irs.type_irs');
        $this->db->where('geopos_employees.id', $employee_id);
        $this->db->where('geopos_irs.childrens', 'geopos_employees.number_children');
        $this->db->where('geopos_irs.up_to >=', $baseSalaryMeal);
        $this->db->order_by('geopos_irs.up_to', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getValueIrsMin($employee_id, $baseSalaryMeal)
    {
        $this->db->select('geopos_employees.name, geopos_irs.up_to, geopos_irs.value_x');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_irs', 'geopos_employees.type_irs = geopos_irs.type_irs');
        $this->db->where('geopos_employees.id', $employee_id);
        $this->db->where('geopos_irs.childrens', 'geopos_employees.number_children');
        $this->db->where('geopos_irs.up_to <=', $baseSalaryMeal);
        $this->db->order_by('geopos_irs.up_to', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_salary($data, $employee_id)
    {
        $this->db->set($data);
        $this->db->where('id', $employee_id);
        if ($this->db->update($this->table)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function get_last_process()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_process_by_id($process_id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $process_id);
        $query = $this->db->get();
        return $query->row_array();
    }
}