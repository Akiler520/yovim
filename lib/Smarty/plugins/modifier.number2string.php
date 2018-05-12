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
function smarty_modifier_number2string($amount , $show_number = false)
{
    if ($amount == 0) return 0;
    $return = '';
    if ($amount >= 1000000000) {
        $floor1  = floor($amount / 10000000) / 100;
        $amount = $amount - $floor1 * 1000000000;
        $return .= $floor1 . 'b';
    }
    if ($amount >= 1000000) {
        $floor2  = floor($amount / 10000) / 100;
        $amount = $amount - $floor2 * 1000000;
        $return .= $floor2 . 'm';
    }
    if ($amount >= 1000) {
        $floor3  = floor($amount / 10) / 100;
        $amount = $amount - $floor3 * 1000;
        $return .= $floor3 . 'k';
    }
    if ($amount > 0) $return .= $amount;
    return $return;
}

/* vim: set expandtab: */