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
function smarty_modifier_money_format($money, $currency=null)
{
    $money = number_format($money, 2);
    $return = '';
    switch ($currency) {
        case 'MYR':
            $return = 'RM '.$money;
            break;
        case 'SGD':
            $return = 'SGD '.$money;
            break;
        case 'PHP':
            $return = 'PHP '.$money;
            break;
        case 'USD':
            $return = $money . ' USD';
            break;
        case 'IDR':
            $return = $money . ' Rupiah';
            break;
        case 'THB':
            $return = $money . ' Baht';
            break;
        case 'VND':
            $return = 'VND ' . $money;
            break;
        case 'HKD':
            $return = 'HK$ ' . $money;
            break;
        case 'CNY':
            $return = 'RMB ' . $money;
            break;
        case 'NTD':
            $return = 'NT$ ' . $money;
            break;
        default:
            return $money;
    }
    return $return;
}
