<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty size_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate_zh<br>
 * @author  akiler
 * 
 * changed in 2013-01-19
 *
 * @param string $string
 * @param integer $decimal	the number of the end 
 * @param string $toFormat	can be 'B, KB, MB, GB, TB'
 * 
 * @return string
 */
function smarty_modifier_size_format($string, $decimal = 2, $toFormat = 'auto'){
    if ($string == '' || !is_numeric($string)) {
    	return false;
    }
    
    if ($decimal > 6 || $decimal < 0) {
    	return $string.'B';
    }
    
    $size = $string;
    $unit = 'B';
    
    if ($toFormat == 'auto') {
    	if ($size < 1024) {
    		$size = $size;
    		$unit = 'B';
    	} elseif ($size < (1024*1024)) {
    		$size = $size/1024;
    		$unit = 'KB';
    	} elseif ($size < (1024*1024*1024)) {
    		$size = $size/1024/1024;
    		$unit = 'MB';
    	} elseif ($size < (1024*1024*1024*1024)) {
    		$size = $size/1024/1024/1024;
    		$unit = 'GB';
    	} else {
    		$size = $size/1024/1024/1024/1024;
    		$unit = 'TB';
    	}
    } else {
    	switch (strtoupper($toFormat)) {
    		case 'B':
    			$size = $size;
    			$unit = 'B';
	    	case 'KB':
	    		$size = $size/1024;
	    		$unit = 'KB';
	    		break;
	    	case 'MB':
	    		$size = $size/1024/1024;
	    		$unit = 'MB';
	    		break;
	    	case 'GB':
	    		$size = $size/1024/1024/1024;
	    		$unit = 'GB';
	    		break;
	    	case 'TB':
	    		$size = $size/1024/1024/1024/1024;
	    		$unit = 'GB';
	    		break;
	    	default:
	    		$size = $size/1024;
	    		$unit = 'KB';
	    		break;
	    }
    }
    
    if (($pos = stripos($size, '.')) !== false) {
    	$offset = $decimal+1;
    	$ceil = substr($size, $pos+$offset, 1);
    	$tmp = substr($size, 0, $pos+$offset);
    	
    	if ($ceil != '' && $ceil >= 5) {
    		$tmp = $tmp+(1/pow(10, $decimal));
    	}
    	
    	$size = $tmp;
    }
    
    $size = $size.$unit;

    return $size;
}

?>
