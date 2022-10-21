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
 ************************************************************************
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Export_model extends CI_Model
{
    public function customers()
    {
        $this->db->select('*');

        $this->db->from('geopos_customers');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

    // This is the function for the geting the product data start by Eyno 

    public function getProductDataByTid($tid = null) {
        $this->db->select('geopos_order_stock.*');
        $this->db->from('geopos_order_stock');
        $this->db->where('geopos_order_stock.tid',$tid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    // This is the function for the getting the product data end by eyno


    // This is the function for the getting the product type name start by the eyno

    public function getProductTypeBycatid($cat_id = null){
      $this->db->select('geopos_product_cat.title');
      $this->db->from('geopos_product_cat');
      $this->db->where('geopos_product_cat.id',$cat_id);
      $query = $this->db->get();
      if ($query->num_rows()>0) {
      $ret = $query->row();
      return $ret->title;
     // echo $ret->title;
      } 
    }

    // This is the function for the getting the product type name ends by the eyno
}