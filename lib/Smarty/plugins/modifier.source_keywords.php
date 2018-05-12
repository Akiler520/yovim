<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty source keywords modifier plugin
 *
 * Type:     modifier<br>
 * Name:     source_keywords<br>
 * @author  akiler
 *
 * changed in 2014-11-05
 *
 * @param string $string
 * @return string
 */

function smarty_modifier_source_keywords($string){
    $splitArr = array(',', ' ', '，');
    $split_key = Ak_String::multiexplode($splitArr, $string);

    $keywords_arr = array();

    foreach($split_key as $keyword){
        $keyword = trim($keyword, ' ');
        if(!empty($keyword)){
            $keywords_arr[] = '<a href="'.WEB_PATH.'source/search/keyword/'.$keyword.'" target="_blank" >'.$keyword.'</a>';
        }
    }

    $string_result = implode('&nbsp;', $keywords_arr);

    return $string_result;
}

?>
