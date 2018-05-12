<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty cat modifier plugin
 *
 * Type:     modifier<br>
 * Name:     cat<br>
 * Date:     Feb 24, 2003
 * Purpose:  catenate a value to a variable
 * Input:    string to catenate
 * Example:  {$var|cat:"foo"}
 * @link http://smarty.php.net/manual/en/language.modifier.cat.php cat
 *          (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @version 1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_hour2day($hours, $language='en')
{
    $days = floor($hours / 24);
    $hours = ceil($hours % 24);
    
    $return = '';
    if ($language == 'zh') {
        if ($days > 0) {
            $return = $days . '天';
        }
        if ($hours > 0) {
            $return .= $hours . '小时';
        }
    } else {
        if ($days == 1) {
            $return = $days . ' Day ';
        } elseif ($days > 1) {
            $return = $days . ' Days ';
        }
        if ($hours == 1) {
            $return .= $hours . ' Hour';
        } elseif ($hours > 1) {
            $return .= $hours . ' Hours';
        }
    }
    return $return;
}
