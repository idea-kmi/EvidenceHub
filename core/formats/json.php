<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2010 - 2024 The Open University UK                            *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/

class format_json extends format_base {

    //default to plain text
    function get_header(){
        return "Content-Type: text/plain";
    }


    /**
     * Format the output to JSON
     *
     * @param Object $object - the data to format
     * @return string
     */
    function format($object){
        $callback = optional_param("callback","",PARAM_TEXT);

        $str = '';
        if ($callback != ''){
            $str .= $callback.'(';
        }
        if(!is_array($object)){
            $objects = array();
            $objects[0] = $object;
        }
        if (isset($objects) && is_object($object)){
            $str .= '{"'. strtolower(get_class($object)).'":[';
            $okeys = array_keys($objects);
            for ($i=0; $i< count($okeys); $i++){
                $myobj = $objects[$okeys[$i]];
                $attr = get_object_vars($myobj);

                $keys = array_keys($attr);
                if(is_countable($keys) && count($keys) > 0 ){
                    $str .= '{';
                }
                for($j=0;$j< count($keys); $j++){
                	$next = $attr[$keys[$j]];
                	$isArray = false;
                	if (is_array($next)) {
                		$isArray = true;
                	} else if (is_object($next)) {
						$attr2 = get_object_vars($next);
						if(is_array($attr2)){
							$isArray = true;
						}
                	}

					if($isArray){
						$str .= $this->phpToJSONInner($keys[$j],$next);
					} else {
						$str .= '"'. $keys[$j] .'":"'. parseToJSON($next) .'"';
					}

					if (is_countable($keys) && $j != (count($keys)-1)){
						$str .= ',';
					}
                }
                if(is_countable($keys) && count($keys) > 0 ){
                    $str .= '}';
                }
                if (is_countable($objects) && $i != (count($objects)-1)){
                    $str .= '},{';
                }
            }
            $str .= ']}';
        }
        if ($callback != ''){
            $str .= ');';
        }
        return $str;
    }

    /**
     * Helper function for formatting the output to JSON
     *
     * @param string $node name of the node
     * @param Object $objects data to format
     * @return string
     */
    function phpToJSONInner($node,$objects){
        $str = '"'.$node.'":';
        $str .= "[";
        if (is_array($objects) && is_countable($objects) && count($objects)>0){
            $str .="{";
            for ($i=0; $i< count($objects); $i++){
                $obj = $objects[$i];
                $attr = get_object_vars($obj);
                $keys = array_keys($attr);
                $str .= '"'.strtolower(get_class($obj)).'":';
                $str .= '{';
                for($j=0;$j< count($keys); $j++){
                	$next = $attr[$keys[$j]];
                	$isArray = false;
                	if (is_array($next)) {
                		$isArray = true;
                	} else if (is_object($next)) {
						$attr2 = get_object_vars($next);
						if(is_array($attr2)){
							$isArray = true;
						}
                	}

					if($isArray){
						$str .= $this->phpToJSONInner($keys[$j],$next);
					} else {
						$str .= '"'. $keys[$j] .'":"'. parseToJSON($next) .'"';
					}
					if ($j != (count($keys)-1)){
						$str .= ',';
					}
                }
                $str .= '}';
                if ($i != (count($objects)-1)){
                    $str .= '},{';
                }
            }
            $str .="}";
        } else if (!is_array($objects)){
            $str .= '{';
            $obj = $objects;
            $attr = get_object_vars($obj);
            $keys = array_keys($attr);
            $str .= '"'.strtolower(get_class($obj)).'":';
            $str .= '{';

            for($j=0;$j< count($keys); $j++){
				$next = $attr[$keys[$j]];
				$isArray = false;
				if (is_array($next)) {
					$isArray = true;
				} else if (is_object($next)) {
					$attr2 = get_object_vars($next);
					if(is_array($attr2)){
						$isArray = true;
					}
				}

				if($isArray){
					$str .= $this->phpToJSONInner($keys[$j],$next);
				} else {
					$str .= '"'. $keys[$j] .'":"'. parseToJSON($next) .'"';
				}

                if ($j != (count($keys)-1)){
                    $str .= ',';
                }
            }
            $str .= '}}';
        }
        $str .= "]";

        return $str;

    }

}
?>