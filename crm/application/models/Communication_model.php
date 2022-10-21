<?php
/**
 * 
 * 
 * ***********************************************************************
 *
 *  
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


class Communication_model extends CI_Model
{

    public function __construct()
    {
        // parent::__construct();
    }

    public function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password');
        $this->db->from('geopos_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfromtilte = '';
		$mailfrom = '';
		
		$this->db->select("emailo_remet, email_app");
		$this->db->from('geopos_system_permiss');
		$this->db->where('loc', 0);
		$query = $this->db->get();
		$vals = $query->row_array();
		$mailfromtilte = $vals['emailo_remet'];
		if($mailfromtilte == '')
		{
			$mailfromtilte = $this->config->item('ctitle');
		}
		$mailfrom = $vals['email_app'];		
		if($mailfrom == ''){
			return 1;
		}else{
			$this->ultimatemailer->load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
		}
    }

    public function send_corn_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password');
        $this->db->from('geopos_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
		
		$mailfromtilte = '';
		$mailfrom = '';
		
		$this->db->select("emailo_remet, email_app");
		$this->db->from('geopos_system_permiss');
		if($this->aauth->get_user()->loc > 0){
			$this->db->where('loc', $this->aauth->get_user()->loc);
		}else{
			$this->db->where('loc', 0);
		}
		$query = $this->db->get();
		$vals = $query->row_array();
		$mailfromtilte = $vals['emailo_remet'];
		if($mailfromtilte == '')
		{
			$mailfromtilte = $this->config->item('ctitle');
		}
		$mailfrom = $vals['email_app'];		
		if($mailfrom == ''){
			return 1;
		}else{
			$this->ultimatemailer->corn_mail($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);
		}
    }

    public function group_email($recipients, $subject, $message, $attachmenttrue, $attachment)
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('geopos_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfromtilte = '';
		$mailfrom = '';
		
		$this->db->select("emailo_remet, email_app");
		$this->db->from('geopos_system_permiss');
		if($this->aauth->get_user()->loc > 0){
			$this->db->where('loc', $this->aauth->get_user()->loc);
		}else{
			$this->db->where('loc', 0);
		}
		$query = $this->db->get();
		$vals = $query->row_array();
		$mailfromtilte = $vals['emailo_remet'];
		if($mailfromtilte == '')
		{
			$mailfromtilte = $this->config->item('ctitle');
		}
		$mailfrom = $vals['email_app'];		
		if($mailfrom == ''){
			return 1;
		}else{
			$this->ultimatemailer->group_load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment);
		}
    }
}