<?php

function converteUTF8($var)
{
        $cur_encoding = mb_detect_encoding($var) ; 

        if(!($cur_encoding == "UTF-8" && mb_check_encoding($var,"UTF-8")))
        $var = utf8_encode($var); 

        return $var;
}
    
function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    $contents = str_replace('encoding="ISO-8859-15', 'encoding="UTF-8', $contents);
    $contents = str_replace('encoding="ISO-8859-1', 'encoding="UTF-8', $contents);

    $contents = converteUTF8($contents); 
        
    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # /http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

	 if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();


        if(isset($value)) {
            if($priority == 'tag') $result = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $value);
            else $result['_valor_campo'] = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $value); //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $val); 
                else $result['attrib'][$attr] = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $val); //Set all the attributes in a array called 'attr'
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
			
			if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
				$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
				$repeated_tag_index[$tag.'_'.$level]++;
			} else {//This section will make the value an array if multiple tags with the same name appear together
				$current[$tag] = array($result);//This will combine the existing item and the new item together to make an array
				$repeated_tag_index[$tag.'_'.$level] = 1;
				
				if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
					$current[$tag]['0_attr'] = $current[$tag.'_attr'];
					unset($current[$tag.'_attr']);
				}

			}
			$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
			$current = &$current[$tag][$last_item_index];
  
        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            
			if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

				// ...push the new element into that array.
				$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
				
				if($priority == 'tag' and $get_attributes and $attributes_data) {
					$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
				}
				$repeated_tag_index[$tag.'_'.$level]++;

			} else { //If it is not an array...
				$current[$tag] = array($result); //...Make it an array using using the existing value and the new value
				$repeated_tag_index[$tag.'_'.$level] = 0;
				if($priority == 'tag' and $get_attributes) {
					if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
						
						$current[$tag]['0_attr'] = $current[$tag.'_attr'];
						unset($current[$tag.'_attr']);
					}
					
					if($attributes_data) {
						$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
					}
				}
				$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
			}

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
    
    return($xml_array);
}  

function array2xml($campo_arr, $array, $offset = 0)
{
    
    $temAttrib = false;
    $offset_str = "";
    for($x = 0; $x < $offset; $x++)
    {
        $offset_str .= "\t";
    }
    $valor_original = "";
    $tem_filhos = false;
    if(isset($array["_valor_campo"]))
    {
        $valor_original = $array["_valor_campo"];
        unset($array["_valor_campo"]); 
    }
           
    if(!isset($array["attrib"]))
    {
        $xml = "\n".$offset_str . "<".$campo_arr . ">" . $valor_original;
    }
    
    foreach($array as $elemento=>$valor)
    {
        if($elemento != "attrib")
        {
            $filho = $array[$elemento];

            $temAttrib = isset($filho[0]["attrib"]);
            
            $xml .= array2xml($elemento, $filho[0], $offset + 1);
            $tem_filhos = true;

        }else
        {
            $xml = "\n".$offset_str . "<".$campo_arr;
            
            foreach($array["attrib"] as $attrib=>$valor)
            {
                $xml .= " " . $attrib . '="'.htmlspecialchars(converteUTF8(trim($valor)), ENT_NOQUOTES, 'UTF-8').'"';
            }
            $xml .= ">";
        }
    } 
    if($tem_filhos)
    {
        $xml .= "\n".$offset_str;
    }
    $xml .= "</".$campo_arr.">";
    return $xml;
}

?>