<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty htmlspecialchars modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate_zh<br>
 * @author  akiler
 * 
 * changed in 2013-02-01
 *
 * @param string $string
 * 
 * @return string
 */
function smarty_modifier_htmlspecialchars($string)
{
    if(!is_array($string)) {
        $string = preg_replace('!&(#?\w+);!', '%%%SMARTY_START%%%\\1%%%SMARTY_END%%%', $string);
        $string = htmlspecialchars($string);
        $string = str_replace(array('%%%SMARTY_START%%%','%%%SMARTY_END%%%'), array('&',';'), $string);
    }
    return $string;
}

/* vim: set expandtab: */

?>
