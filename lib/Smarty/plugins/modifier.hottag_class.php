<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty hottag_class modifier plugin
 *
 * Type:     modifier<br>
 * Name:     hottag_class<br>
 * @author  akiler
 * 
 * changed in 2014-02-01
 *
 * @param string $string
 * @return string
 */

function smarty_modifier_hottag_class($string){
    $classArr = array('red', 'bold', 'bigsize');

    $get_num = rand(1, 3);

    $classStr = array();

    $count = count($classArr);

    for($i = 0; $i < $get_num; $i++){
        $rand_key = rand(0, $count-1);
        if(in_array($classArr[$rand_key], $classStr)){
            $i--;
            continue;
        }

        $classStr[] = $classArr[$rand_key];
    }

    return implode(' ', $classStr);
}

?>
