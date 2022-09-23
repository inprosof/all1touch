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

class Cert extends CI_Controller
{
    public function certchk()
    {
        $ci =& get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT * FROM geopos_license WHERE l_stt='act' LIMIT 1");
        $row = $query->row_array();
		
		if($row){
			die("a");
			
			
		}else{ 
			die("b");
		}
    }

}

?>