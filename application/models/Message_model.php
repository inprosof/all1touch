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

class Message_model extends CI_Model
{
    public function employee_details($id)
    {
        $this->db->select('geopos_employees.*');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_pms.id', $id);
        $this->db->join('geopos_pms', 'geopos_employees.id = geopos_pms.sender_id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }


}