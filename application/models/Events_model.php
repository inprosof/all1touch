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

class Events_model extends CI_Model
{


    /*Read the data from DB */
    public function getEvents($start, $end)
    {
        $e2=date('Y-m-d', strtotime($end. ' - 60 days'));
        $sql = "SELECT * FROM geopos_events WHERE (geopos_events.start BETWEEN ? AND ?) OR (geopos_events.end > ? ) ORDER BY geopos_events.start ASC";
        return $this->db->query($sql, array($start, $end,$e2))->result();
    }

    /*Create new events */

    public function addEvent($title, $start, $end, $description, $color, $event_type, $event_repeat, $event_associated, $event_all_day, $employee_id)
    {
        $data = array(
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'description' => $description,
            'color' => $color,
            'event_type' => $event_type,
			'event_repeat' => $event_repeat,
			'event_associated' => $event_associated,
            'allDay' => $event_all_day,
            'employee_id' => $employee_id
        );

        if ($this->db->insert('geopos_events', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /*Update  event */

    public function updateEvent($id, $title, $description, $color, $event_type, $event_repeat, $event_associated, $employee_id)
    {
        $sql = "UPDATE geopos_events SET title = ?, description = ?, color = ?, event_type = ?,  event_repeat = ?, event_associated = ?, employee_id = ? WHERE id = ?";
        $this->db->query($sql, array($title, $description, $color, $event_type, $event_repeat, $event_associated, $employee_id, $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    /*Delete event */

    public function deleteEvent()
    {
		//d´ont forget the repeat events if have
        $sql = "DELETE FROM geopos_events WHERE id = ?";
        $this->db->query($sql, array($_GET['id']));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /*Update  event */

    public function dragUpdateEvent()
    {
        $sql = "UPDATE geopos_events SET  geopos_events.start = ? ,geopos_events.end = ?  WHERE id = ?";
        $this->db->query($sql, array($_POST['start'], $_POST['end'], $_POST['id']));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function select_event_of_month($month, $year, $employee_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('event_type', 1);
        $this->db->where('employee_id', $employee_id);
        $this->db->where('YEAR(start)', $year);
        $this->db->where('YEAR(end)', $year);
        $this->db->where('(MONTH(start) = '.$month.' or MONTH(end) = '.$month.')');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function select_event_of_month_row($month, $year, $employee_id, $type)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        if($type == 0){
            $this->db->where('event_type', 0);
        }else if($type == 1)
        {
            $this->db->where('event_type', 1);
        }
        
        $this->db->where('employee_id', $employee_id);
        $this->db->where('YEAR(start)', $year);
        $this->db->where('YEAR(end)', $year);
        $this->db->where('(MONTH(start) = '.$month.' or MONTH(end) = '.$month.')');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function select_vacation_of_year($year, $employee_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('event_type', 1);
        $this->db->where('employee_id', $employee_id);
        $this->db->where('YEAR(start)', $year);
        $this->db->where('YEAR(end)', $year);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function select_vacation_of_year_row($year, $employee_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('event_type', 1);
        $this->db->where('employee_id', $employee_id);
        $this->db->where('YEAR(start)', $year);
        $this->db->where('YEAR(end)', $year);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	
	public function select_vacation_evry_of_year($month, $year)
    {
		$sql = "SELECT f.*, t.name FROM `geopos_events` as f inner join geopos_employees as t on f.employee_id = t.id WHERE f.event_type = 1 and YEAR(start) = ".$year." and YEAR(end) = ".$year." and ( MONTH(start) = ".$month." or MONTH(end) = ".$month.")";
        return $this->db->query($sql)->result();
    }


    public function select_attendance_of_month($month, $year, $employee_id)
    {
        $sql = "SELECT tto, tfrom FROM `geopos_attendance` WHERE (emp='$employee_id') AND YEAR(adate) = ".$year." and YEAR(adate) = ".$year." and ( MONTH(adate) = ".$month." or MONTH(adate) = ".$month.")";
        return $this->db->query($sql)->result();
    }   
	
	public function select_holidays_of_year($year)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('event_type', 2);
        $this->db->where('YEAR(start)', $year);
        $this->db->where('YEAR(end)', $year);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	public function select_holidays_of_month($month, $year)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('event_type', 2);
        $this->db->where('YEAR(start)', $year);
        $this->db->where('YEAR(end)', $year);
        $this->db->where('(MONTH(start) = '.$month.' or MONTH(end) = '.$month.')');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function select_holidays_of_month_row($month, $year)
    {
        $this->db->select('*');
        $this->db->from('geopos_events');
        $this->db->where('event_type', 2);
        $this->db->where('YEAR(start)', $year);
        $this->db->where('YEAR(end)', $year);
        $this->db->where('(MONTH(start) = '.$month.' or MONTH(end) = '.$month.')');
        $query = $this->db->get();
        return $query->num_rows();
    }

	public function list_employee()
    {
        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid,geopos_users.loc');
        $this->db->from('geopos_employees');

        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        }
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	
	
    /*Create new events Types */
	/*Read the data from DB */
    public function getEventsType()
    {
        $sql = "SELECT * FROM geopos_events_type ORDER BY geopos_events_type.name ASC";
        return $this->db->query($sql)->result();
    }

    public function addEventType($name, $paid)
    {
        $data = array(
			'name' => $name,
			'paid' => $paid,
            'delete' => 1
        );

        if ($this->db->insert('geopos_events_type', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /*Update  event */

    public function updateEventType($id, $name, $paid)
    {
        $sql = "UPDATE geopos_events_type SET name = ?, paid = ? WHERE id = ?";
        $this->db->query($sql, array($name, $paid, $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    /*Delete event */

    public function deleteEventType($id)
    {
		//d´ont forget the repeat events if have
        return $this->db->delete('geopos_events_type', array('id' => $id));
    }
	


    function ecttyppp_datatables()
    {
        $this->_ecttyppp_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }



    private function _ecttyppp_datatables_query()
    {
        $this->db->from('geopos_events_type');
        $i = 0;

        foreach ($this->evtypcolumn_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->evtypcolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    var $column_search = array('name');
    var $evtypcolumn_order = array(null, 'name', 'paid', null);
    var $evtypcolumn_search = array('id', 'name', 'paid');
    var $order = array('id' => 'asc');
    

    function ecttyppp_count_filtered()
    {
        $this->_ecttyppp_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function ecttyppp_count_all()
    {
        $this->_ecttyppp_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	public function eventtype_view($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_events_type');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }
}