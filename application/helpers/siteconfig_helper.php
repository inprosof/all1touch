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


if (!defined('BASEPATH')) exit('No direct script access allowed');


function dateformat($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat'));
    return $date;
}

function assets_url($input = '')
{
    return base_url($input);
}

function dateformat_time($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat') . ' H:i:s');
    return $date;
}

function datefordatabase($input)
{
    $date = new DateTime($input);
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}

function timefordatabase($input)
{

    $time = new DateTime($input);
    $time = $time->format('H:i:s');
    return $time;
}

function user_role($id = 5)
{
    $ci =& get_instance();
    switch ($id) {
        case 5:
            return $ci->lang->line('Business Owner');
            break;
        case 4:
            return $ci->lang->line('Business Manager');
            break;
        case 3:
            return $ci->lang->line('Sales Manager');
            break;
        case 2:
            return $ci->lang->line('Sales Person');
            break;
        case 1:
            return $ci->lang->line('Inventory Manager');
            break;
        case -1:
            return $ci->lang->line('Project Manager');
            break;
    }
}


function valorPorExtenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false)
{
	$singular = null;
	$plural = null;
	if ($bolExibirMoeda)
	{
		$singular = array("centímo", "euro", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centímos", "euros", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
	}
	else
	{
		$singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
	}
	$c = array("", "Cem", "Duzentos", "Trezentos", "Quatrocentos","Quinhentos", "Seiscentos", "Setecentos", "Oitocentos", "Novecentos");
	$d = array("", "Dez", "Vinte", "Trinta", "Quarenta", "Cinquenta","Sessenta", "Setenta", "Oitenta", "Noventa");
	$d10 = array("Dez", "Onze", "Doze", "Treze", "Catorze", "Quinze","Dezasseis", "Dezassete", "Dezoito", "Dezanove");
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
	if ($bolPalavraFeminina)
	{
		if ($valor == 1) 
		{
			$u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
		}
		else 
		{
			$u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
		}
		$c = array("", "Cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
	}
	$z = 0;
	$valor = number_format( $valor, 2, ".", "." );
	$inteiro = explode( ".", $valor );
	for ( $i = 0; $i < count( $inteiro ); $i++ ) 
	{
		for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
		{
			$inteiro[$i] = "0" . $inteiro[$i];
		}
	}
	// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
	$rt = null;
	$fim = count($inteiro) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
	for ( $i = 0; $i < count( $inteiro ); $i++)
	{
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "Cento" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
		$r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
		$t = count( $inteiro ) - 1 - $i;
		$r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if($valor == "000")
			$z++;
		elseif($z > 0)
			$z--;
		if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
			$r .= (($z > 1) ? " de " : "") . $plural[$t];
		if ($r)
			$rt = $rt.((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
	}
	$rt = mb_substr( $rt, 1 );
	
	$valueret = ($rt ? trim( $rt ) : "zero");
	return $valueret;
}

function amountFormat($number)
{
    $ci =& get_instance();
    $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
    $row = $query->row_array();
    $currency = $row['currency'];
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    if ($row['method'] == 'l') {
        return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
    } else {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
    }

}

function user_premission($input1, $input2)
{
    if (hash_equals($input1, $input2)) {
        return true;
    } else {
        return false;
    }
}


function amountFormat_s($number)
{
    $ci =& get_instance();
    $ci->load->database();
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country

    return @number_format($number, $row['url'], $row['key1'], $row['key2']);

}

function amountFormat_general($number=0)
{
    $ci =& get_instance();
    $ci->load->database();
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    $number = @number_format($number, $row['url'], $row['key1'], '');
    return $number;
}

function numberClean($number)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    $number = str_replace($row['key2'], "", $number);
    $number = str_replace($row['key1'], ".", $number);
    return (float)$number;
}


function amountExchange($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0 && $id == 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];
        $rate = $row['rate'];
        $thosand = $row['thous'];
        $dec_point = $row['dpoint'];
        $decimal_after = $row['decim'];
        $totalamount = $rate * $number;
        //get data from database
        //Format money as per country
        if ($row['cpos'] == 0) {
            return $currency . ' ' . @number_format($totalamount, $decimal_after, $dec_point, $thosand);
        } else {
            return @number_format($totalamount, $decimal_after, $dec_point, $thosand) . ' ' . $currency;
        }
    } else {

        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];

        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        //Format money as per country
        if ($row['method'] == 'l') {
            return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
        } else {
            return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
        }
    }

}

function amountExchange_s($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0 && $id == 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $dec_point = $row['dpoint'];
        $totalamount = $rate * $number;
		$decimal_after = $row['decim'];
        $totalamount = number_format($totalamount, $decimal_after, $dec_point, '');
        return $totalamount;
    } else {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        $number = number_format($number, $row['url'], $row['key1'], '');
        return $number;
    }

}

function edit_amountExchange_s($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $decimal_after = $row['decim'];
        $dec_point = $row['dpoint'];
        $number = str_replace($decimal_after, "", $number);
        $number = str_replace($dec_point, ".", $number);
        $totalamount = $rate * (float)$number;
        $totalamount = number_format($totalamount, $decimal_after, $dec_point, '');
        return $totalamount;
    } else {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
       // $number = str_replace($row['key2'], "", $number);
        //$number = str_replace($row['key1'], ".", $number);
        $number = number_format($number, $row['url'], $row['key1'], '');
        return $number;
    }

}

function rev_amountExchange_s($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT other FROM univarsal_api WHERE id=5 LIMIT 1");
    $row = $query2->row_array();
    $revers = $row['other'];

    if ($loc) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $lcid = $row['cur'];
        if ($lcid > 0) {
            $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$lcid' LIMIT 1");
            $row = $query->row_array();
			if($row['id']){
            $rate = $row['rate'];
            $number = str_replace($row['thous'], "", $number);
            $number = str_replace($row['dpoint'], ".", $number);
            $number = (float)$number / $rate;
			}
			else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        $number = str_replace($row['key2'], "", $number);
        $number = str_replace($row['key1'], ".", $number);

    }
        } elseif ($id) {
            $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
            $row = $query->row_array();
            $rate = $row['rate'];
            $number = str_replace($row['thous'], "", $number);
            $number = str_replace($row['dpoint'], ".", $number);
            $number = (float)$number / $rate;
        }
		else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        $number = str_replace($row['key2'], "", $number);
        $number = str_replace($row['key1'], ".", $number);

    }
    } elseif ($id) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $number = str_replace($row['thous'], "", $number);
        $number = str_replace($row['dpoint'], ".", $number);
        if (!$revers) {

            $number = (float)$number / $rate;
        }
    } else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        $number = str_replace($row['key2'], "", $number);
        $number = str_replace($row['key1'], ".", $number);

    }

    return (float)$number;
}

function rev_amountExchange($number, $id = 0)
{
    $ci =& get_instance();
    $query = $ci->db->query("SELECT other FROM univarsal_api WHERE id='5' LIMIT 1");
    $row = $query->row_array();
    $reverse = $row['other'];
    if ($reverse && $id > 0) {
        $query = $ci->db->query("SELECT rate FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $totalamount = $number / $rate;
        return $totalamount;
    } else {
        return $number;
    }
}

function array_compare()
{
    $criteriaNames = func_get_args();
    $compare = function ($first, $second) use ($criteriaNames) {
        while (!empty($criteriaNames)) {
            $criterion = array_shift($criteriaNames);
            $sortOrder = 1;
            if (is_array($criterion)) {
                $sortOrder = $criterion[1] == SORT_DESC ? -1 : 1;
                $criterion = $criterion[0];
            }
            if ($first[$criterion] < $second[$criterion]) {
                return -1 * $sortOrder;
            } else if ($first[$criterion] > $second[$criterion]) {
                return 1 * $sortOrder;
            }
        }
        return 0;
    };

    return $compare;
}

function locations()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_locations");
    return $query2->result_array();
}

function location($number = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($number > 0) {
        $query2 = $ci->db->query("SELECT * FROM geopos_locations WHERE id=$number");
        return $query2->row_array();
    } else {
        $query2 = $ci->db->query("SELECT * FROM geopos_system WHERE id=1 LIMIT 1");
        return $query2->row_array();
    }
}

function active($input1)
{

    $t_file = APPPATH . 'config' . DIRECTORY_SEPARATOR . 'lic.php';
    if (is_writeable($t_file)) {
        file_put_contents($t_file, $input1);
        $lc = file_get_contents($t_file);
        if (empty($lc)) {
            echo json_encode(array('status' => 'WError', 'message' => 'Server write permissions denied'));
        } else {
            if ($input1 == 2) {
                echo json_encode(array('status' => 'Error', 'message' => 'License error!'));
            } else {
                echo json_encode(array('status' => 'Success', 'message' => 'License updated!'));
            }
        }
    } else {
        echo json_encode(array('status' => 'WError', 'message' => 'Server write permissions denied!'));
    }

}

function currency($loc = 0, $id = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0 && $id == 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];
    } else {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
    }
    return $currency;
}

function plugins_checker()
{
    $path = FCPATH . 'application/plugins';
    $plugins = array_diff(scandir($path), array('.', '..'));
    foreach ($plugins as $row) {
        $url = file_get_contents($path . '/' . $row);
        $plug = json_decode($url, true);
        echo '    <li><a class="dropdown-item"
                                                           href="' . base_url() . $plug['path'] . '"><i
                                                                    class="ft-chevron-right"></i> ' . $plug['name'] . '
                                                        </a></li>';
    }
}

function custom_plugins_checker($name='sms')
{
    $path = FCPATH . 'application'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$name;
      if(file_exists($path)) {


          $plugins = array_diff(scandir($path), array('.', '..'));
          foreach ($plugins as $row) {
              $url = file_get_contents($path . '/' . $row);
              $plug = json_decode($url, true);
              echo '    <li><a class="dropdown-item"
                                                           href="' . base_url() . $plug['path'] . '"><i
                                                                    class="ft-chevron-right"></i> ' . $plug['name'] . '
                                                        </a></li>';
          }
      }
}

function datatable_lang()
{
    $ci =& get_instance();
    $result='';
   $lang= $ci->config->item('mylang');
   $dfile=FCPATH . 'application/language/'.$lang.'/datatable.php';
   if(file_exists($dfile)) $result=include_once($dfile);
    echo $result;
}

function accounting($loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
        if ($id > 0) {
            $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
            $row = $query->row_array();

            $thosand = $row['thous'];
            $dec_point = $row['dpoint'];
            $decimal_after = $row['decim'];
        }
    } else {
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();

        $thosand = $row['key2'];
        $dec_point = $row['key1'];
        $decimal_after = $row['url'];
    }

    echo " <script type='text/javascript'>accounting.settings = {number: {precision :$decimal_after,thousand: '$thosand',decimal : '$dec_point'}};
var two_fixed=$decimal_after; </script>";

}

if (!function_exists('dd')) {
    function dd($var)
    {
        print_r($var);
        exit;
    }
 }