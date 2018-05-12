<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function get_tree_html($tree, $parentName = '') {
	$ret = '';
	foreach ($tree as $val) {
		if ($parentName != '') {
			$nameKey = $parentName.'/'.$val['name'];
		} else {
			$nameKey = $val['name'];
		}
		
		$name = $val['name'];
		if ($val['childid'] != null) {
			$ret .= sprintf('<div id="tree-%s" class="folder">', $nameKey);
			$ret .= sprintf('<a onClick="Tree.nodeToggle(\'tree-%s\'); this.blur();" href="javascript:void(0)">', $nameKey);
			$ret .= '<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-node-open.gif" id="tree-test1-node">';
			$ret .= '<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-folder-open.gif" id="tree-test1-icon">';
			$ret .= '</a>';
			$ret .= sprintf('<span onClick="Tree.nodeClick(\'tree-%s\')" class="text" id="tree-test1-text">%s</span>', $nameKey, $name);
			
			$ret .= '<div id="tree-test1-section" class="section" style="display: block;">';
			$ret .= get_tree_html($val['childid'], $nameKey);
			
			$ret .= '</div>';
			$ret .= '</div>';
		} else {
			$ret .= sprintf('<div id="tree-%s" class="folder">', $nameKey);
			$ret .= '<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-leaf-end.gif" id="tree-test1-node">';
			$ret .= '<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-folder.gif" id="tree-test1-icon">';
			$ret .= sprintf('<span onClick="Tree.nodeClick(\'tree-%s\')" class="text" id="tree-test1-text">%s</span>', $nameKey, $name);
			$ret .= '</div>';
		}
	}
	
	return $ret;
}

/**
 * Smarty {html_tree} modifier plugin
 *
 * Type:     modifier<br>
 * Name:     html_tree<br>
 * @author 	akiler <minyu1315@gmail.com>
 * @param 	array
 * @param 	Smarty
 */
function smarty_modifier_html_tree($tree = array())
{
	if (!is_array($tree)) {
		return false;
	}
	return get_tree_html($tree);
}

/* vim: set expandtab: */

?>
