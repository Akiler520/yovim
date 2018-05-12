<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty extension modifier plugin
 *
 * Type:     modifier<br>
 * Name:     extension<br>
 * @author  akiler
 * 
 * changed in 2013-01-17
 *
 * @param string $string
 * @return string
 */

function smarty_modifier_extension($string){
	$find = 0;
	$string = strtolower($string);
    $def_ext = array('avi', 'bmp', 'db', 'dir', 'dll', 'doc', 'docx', '3ds', 'ara', 'project',
    				'dwf', 'dwg', 'fla', 'gif', 'html', 'jpeg', 'jpg', 'mp3', 'mpeg', 
    				'mpp', 'other', 'pdf', 'png', 'ppt', 'pptx', 'psd', 'rar', 
    				'rte', 'skp', 'swf', 'txt', 'vsd', 'wma', 'xls', 'xlsx', 
    				'zip', 'odt', 'eml', 'tif', 'ods', 'odp', 'odd');
    for ($i = 0; $i < count($def_ext); $i++) {
    	if ($string == $def_ext[$i]) {
    		$find = 1;
    		break;
    	}
    }

    $compressFileExt = array('rar', 'zip', 'tar', '7z');
    if (in_array($string, $compressFileExt)) {
    	$string = 'arch';
    	$find = 1;
    }
    
    return ($find == 1) ? $string : 'other';
}

?>
