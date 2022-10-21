<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model
{
	public $arrglobal = [];
	public $arrglobalfalta = [];
	function category_list_completa($typ = 0)
    {
        $query = $this->db->query("SELECT geopos_product_cat.id, geopos_product_cat.title, geopos_product_cat.rel_id
		FROM geopos_product_cat 
		ORDER BY geopos_product_cat.id,geopos_product_cat.rel_id DESC");
		$resultd = $query->result_array();
		
		global $arrglobal;
		global $arrglobalfalta;
		
		$i = 0;
		foreach ($resultd as $prd) {
			if($resultd[$i]['rel_id'] == 0){
				$row = array();
				$row['id'] = $prd['id'];
				$row['title'] = $prd['title'];
				$row['rel_id'] = 0;
				$row['pai'] = 0;
				$row2['num'] = 0;
				$row['filhos'] = [];
				$arrglobal[] = $row;
			}else{
				$enco1 = $this->getpaiiglobal($resultd[$i],0);
				if(!$enco1)
				{
					$enco2 = $this->getpaiiglobal($resultd[$i],1);
					if(!$enco2)
					{
						$enco3 = $this->getpaiiglobal($resultd[$i],2);
					}
				}
			}
			
			$i++;
		}
		
		if($arrglobalfalta != null){
			for($iz = 0; $iz < count($arrglobalfalta); $iz++)
			{
				$enco1 = $this->getpaiiglobal($arrglobalfalta[$iz],0);
				if(!$enco1)
				{
					$enco2 = $this->getpaiiglobal($arrglobalfalta[$iz],1);
					if(!$enco2)
					{
						$enco3 = $this->getpaiiglobal($arrglobalfalta[$iz],2);
					}
				}
			}
		}
		
		$classi = '';
		if(!is_null($arrglobal)){
			for($ico = 0; $ico < count($arrglobal); $ico++)
			{
				$classi .= '<option value="'.$arrglobal[$ico]['id'].'">'.$arrglobal[$ico]['title'].'</option>';
				for($it = 0; $it < count($arrglobal[$ico]['filhos']); $it++)
				{
					$classi .= '<option value="'.$arrglobal[$ico]['filhos'][$it]['id'].'">->'.$arrglobal[$ico]['filhos'][$it]['title'].'</option>';
					for($ite = 0; $ite < count($arrglobal[$ico]['filhos'][$it]['filhos']); $ite++)
					{
						$classi .= '<option value="'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['id'].'">-->'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['title'].'</option>';
						for($itef = 0; $itef < count($arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['filhos']); $itef++)
						{
							$classi .= '<option value="'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['filhos'][$itef]['id'].'">--->'.$arrglobal[$ico]['filhos'][$it]['filhos'][$ite]['filhos'][$itef]['title'].'</option>';
						}
					}
				}
			}
		}
		
        return $classi;
    }
	
	public function gettypsproducts()
	{
		$query = $this->db->query("SELECT id,val1 as title,val2 as cod FROM geopos_config WHERE type=1 ORDER BY id ASC");
        return $query->result_array();
	}	
	
	public function getpaiiglobal($objpesq, $val = 0)
	{
		global $arrglobal;
		global $arrglobalfalta;
		$encontrei = false;
		if($val == 0)
		{
			for($i = 0; $i < count($arrglobal); $i++)
			{
				if($arrglobal[$i]['id'] == $objpesq['rel_id'])
				{
					$row2 = array();
					$row2['id'] = $objpesq['id'];
					$row2['title'] = $objpesq['title'];
					$row2['pai'] = $objpesq['rel_id'];
					$row2['filhos'] = [];
					$arrglobal[$i]['filhos'][] = $row2;
					$encontrei = true;
					break;
				}else if($arrglobal[$i]['pai'] == $objpesq['rel_id'])
				{
					$row2 = array();
					$row2['id'] = $objpesq['id'];
					$row2['title'] = $objpesq['title'];
					$row2['pai'] = $objpesq['rel_id'];
					$row2['filhos'] = [];
					$arrglobal[$i]['filhos'][] = $row2;
					$encontrei = true;
				}
			}
		}else if($val == 1)
		{
			for($i2 = 0; $i2 < count($arrglobal); $i2++)
			{
				for($i3 = 0; $i3 < count($arrglobal[$i2]['filhos']); $i3++)
				{
					if($arrglobal[$i2]['filhos'][$i3]['id'] == $objpesq['rel_id'])
					{
						$row2 = array();
						$row2['id'] = $objpesq['id'];
						$row2['title'] = $objpesq['title'];
						$row2['pai'] = $objpesq['rel_id'];
						$row2['filhos'] = [];
						$arrglobal[$i2]['filhos'][$i3]['filhos'][] = $row2;
						$encontrei = true;
					}else if($arrglobal[$i2]['filhos'][$i3]['pai'] == $objpesq['rel_id'])
					{
						$row2 = array();
						$row2['id'] = $objpesq['id'];
						$row2['title'] = $objpesq['title'];
						$row2['pai'] = $objpesq['rel_id'];
						$row2['filhos'] = [];
						$arrglobal[$i2]['filhos'][$i3]['filhos'][] = $row2;
						$encontrei = true;
					}
				}
			}
		}else if($val == 2)
		{
			for($i4 = 0; $i4 < count($arrglobal); $i4++)
			{
				for($i5 = 0; $i5 < count($arrglobal[$i4]['filhos']); $i5++)
				{
					for($i6 = 0; $i6 < count($arrglobal[$i4]['filhos'][$i5]['filhos']); $i6++)
					{
						if($arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['id'] == $objpesq['rel_id'])
						{
							$row2 = array();
							$row2['id'] = $objpesq['id'];
							$row2['title'] = $objpesq['title'];
							$row2['pai'] = $objpesq['rel_id'];
							$row2['filhos'] = [];
							$arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['filhos'][] = $row2;
							$encontrei = true;
							break;
						}else if($arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['pai'] == $objpesq['rel_id'])
						{
							$row2 = array();
							$row2['id'] = $objpesq['id'];
							$row2['title'] = $objpesq['title'];
							$row2['pai'] = $objpesq['rel_id'];
							$row2['filhos'] = [];
							$arrglobal[$i4]['filhos'][$i5]['filhos'][$i6]['filhos'][] = $row2;
							$encontrei = true;
						}
					}
				}
			}
			
			if(!$encontrei)
			{
				$arrglobalfalta[] = $objpesq;
			}
		}
		
		return $encontrei;
	}
	
    public function category_list($rel = 0)
    {
        $query = $this->db->query("SELECT id,title FROM geopos_product_cat WHERE rel_id='$rel' ORDER BY id DESC");
        return $query->result_array();
    }

    public function warehouse_list()
    {
        $where = '';
        if (!BDATA) $where = "WHERE  (loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $where = "WHERE  (loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }


        $query = $this->db->query("SELECT id,title FROM geopos_warehouse $where ORDER BY id DESC");
        return $query->result_array();
    }

    public function category_stock()
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty 
		FROM geopos_product_cat AS c 
		LEFT JOIN ( SELECT geopos_products.pcat,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price*geopos_products.qty) AS salessum, 
			SUM(geopos_products.fproduct_price*geopos_products.qty) AS worthsum,
			SUM(geopos_products.qty) AS qty FROM geopos_products 
			LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id 
			$whr GROUP BY geopos_products.pcat ) AS p ON c.id=p.pcat WHERE c.rel_id = 0");
        return $query->result_array();
    }

    public function category_sub_stock($id = 0)
    {
        $whr = '';
        if (!BDATA) $whr = "WHERE  (geopos_warehouse.loc=0) ";
        if ($this->aauth->get_user()->loc) {
            $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " ) ";
            if (BDATA) $whr = "WHERE  (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) ";
        }
        $whr2 = '';
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty,p.pcat FROM geopos_product_cat AS c 
		LEFT JOIN ( SELECT geopos_products.pcat,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price*geopos_products.qty) AS salessum, 
			SUM(geopos_products.fproduct_price*geopos_products.qty) AS worthsum,SUM(geopos_products.qty) AS qty FROM geopos_products 
			LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id $whr GROUP BY geopos_products.pcat ) AS p ON c.id=p.pcat 
		WHERE c.rel_id='$id'");
        return $query->result_array();
    }

    public function warehouse()
    {
        $where = '';
        if ($this->aauth->get_user()->loc) {
            $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc;
           /* if (BDATA) 
				$where = ' WHERE c.loc=' . $this->aauth->get_user()->loc . ' OR c.loc=0';*/
        } elseif (!BDATA) {
            $where = ' WHERE c.loc=0';
        }
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_warehouse AS c LEFT JOIN ( SELECT warehouse,COUNT(pid) AS pc,SUM(product_price*qty) AS salessum, SUM(fproduct_price*qty) AS worthsum,SUM(qty) AS qty FROM  geopos_products GROUP BY warehouse ) AS p ON c.id=p.warehouse $where");
        return $query->result_array();
    }

    public function cat_ware($id, $loc = 0)
    {
        $qj = '';
        if ($loc) 
			$qj = "AND w.loc='$loc'";
        $query = $this->db->query("SELECT c.id AS cid,c.title AS catt,
		w.id AS wid,w.title AS watt, 
		case when uu.id is null then '0' else uu.id end as subclassifid, case when uu.id is null then 'Sem Classificação' else uu.title end as subclassif, 
		ty.id as typ_id, ty.val1 as typ, ty.val2 as typcod,
		cla.id as cla_id, cla.title as claname
		FROM geopos_products AS p 
		LEFT JOIN geopos_product_cat AS c ON p.pcat=c.id
		LEFT JOIN geopos_config AS ty ON p.b_id=ty.id
		LEFT JOIN geopos_product_cat_type AS uu ON p.sub_id=uu.id 
		LEFT JOIN geopos_products_class AS cla ON p.p_cla=cla.id 
		LEFT JOIN geopos_warehouse AS w ON p.warehouse=w.id 
		WHERE p.pid='$id' $qj ");
        return $query->row_array();
    }
	
    public function addnew($cat_name, $cat_desc, $cat_rel = 0, $image, $vis_pos, $fav_pos)
    {
        if (!$cat_rel) 
			$cat_rel = 0;
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc,
            'rel_id' => $cat_rel,
			'image' => $image,
			'vis_pos' => $vis_pos,
			'fav_pos' => $fav_pos
        );

        if ($cat_rel) {
            $url = "<a href='" . base_url('productcategory/add_sub') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory/view?id=' . $cat_rel) . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        } else {
            $url = "<a href='" . base_url('productcategory/add') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
        }

        if ($this->db->insert('geopos_product_cat', $data)) {
            $this->aauth->applog("[Category Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . " $url"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function addwarehouse($cat_name, $cat_desc, $lid)
    {
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc,
            'loc' => $lid
        );

        if ($this->db->insert('geopos_warehouse', $data)) {
            $this->aauth->applog("[WareHouse Created] $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);
               $url = "<a href='" . base_url('productcategory/addwarehouse') . "' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='" . base_url('productcategory/warehouse') . "' class='btn btn-grey-blue btn-lg'><span class='fa fa-list-alt' aria-hidden='true'></span>  </a>";
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . $url));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($catid, $product_cat_name, $product_cat_desc, $cat_rel, $image, $vis_pos, $fav_pos)
    {
        if (!$cat_rel) 
			$cat_rel = 0;
		$data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc,
            'rel_id' => $cat_rel,
			'image' => $image,
			'vis_pos' => $vis_pos,
			'fav_pos' => $fav_pos
        );
        $this->db->set($data);
        $this->db->where('id', $catid);
        if ($this->db->update('geopos_product_cat')) {
            $this->aauth->applog("[Category Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editwarehouse($catid, $product_cat_name, $product_cat_desc, $lid)
    {
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc,
            'loc' => $lid
        );
        $this->db->set($data);
        $this->db->where('id', $catid);

        if ($this->db->update('geopos_warehouse')) {
            $this->aauth->applog("[Warehouse Edited] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
}