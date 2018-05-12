<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate_zh modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate_zh<br>
 * @author  akiler
 * 
 * changed in 2010-02-01
 *
 * @param string $string
 * @param integer $length
 * @param string $etc
 * @param boolean $break_words
 * @param boolean $middle
 * @return string
 */

function smarty_modifier_truncate_zh($string, $length = 80, $etc = '...', $break_words = false, $middle = false){
    if ($length <= 0) return '';

    /*if (strlen($string) > $length) {
        $length -= min($length, strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
        }
        if ( !$middle) {
        	for( $i=0 ; $i< $length; $i++){
	        	$string_one = substr( $string, $i, 1);
	        	if ( ord( $string_one) < 0xa0) {
			        $string_result .= $string_one;
			      
	        	}else {
	        		$string_result .= substr( $string, $i, 3);
	        		$i +=2;
	        	}
	        }
        }
		
        $string_result = $string_result.$etc;
    } else {
        $string_result = $string;
    }*/
    
    $string_result = Ak_String::csubstr($string, 0, $length, 'utf-8', $etc);
    
    return $string_result;
}

?>
