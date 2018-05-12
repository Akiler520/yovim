<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function get_tree_html($tree, $parent=array()) {
	$ret = '';
	foreach ($tree as $key => $val) {
		if (is_array($parent) && !empty($parent)) {
//			$nameKey = sprintf('<a href="javascript:;" onclick="Tree.nodeClick(\'%s\')">%s</a>>%s', $parent['pid'], $parent['pname'], $val['name']);
			$nameKey = $parent['pname'].'>'.$val['name'];
		} else {
			$nameKey = $val['name'];
		}
		
		$name = $val['name'];
		if ($val['childid'] != null) {
			$ret .= sprintf('<div id="tree-%s" class="folder" next="%s" child=%s>', $val['id'], (isset($tree[$key+1]) ? 1 : 0), count($val['childid']));
			$ret .= sprintf('<a onClick="Tree.nodeToggle(\'tree-%s\'); this.blur();" href="javascript:void(0)">', $val['id']);
			if (isset($tree[$key+1])) {
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-node.gif" id="tree-%s-node">', $val['id']);
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-folder.gif" id="tree-%s-icon">', $val['id']);
			} else {
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-node-end.gif" id="tree-%s-node">', $val['id']);
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-folder.gif" id="tree-%s-icon">', $val['id']);
			}
			
			$ret .= '</a>';
			
			$ret .= sprintf('<span onClick="Tree.nodeClick(\'%s\')" class="text" curid="%s" curpath="%s" id="tree-%s-text">%s</span>', $val['id'], $val['id'], $nameKey, $val['id'], $name);
			
			$section_display = ($val['id'] == 1) ? 'block' : 'none';
			if (isset($tree[$key+1])) {
				$ret .= sprintf('<div id="tree-%s-section" class="section" style="display: %s;">', $val['id'], $section_display);
			} else {
				$ret .= sprintf('<div id="tree-%s-section" class="section last" style="display: %s;">', $val['id'], $section_display);
			}
			
			$ret .= get_tree_html($val['childid'], array('pid'=>$val['id'], 'pname'=>$nameKey));
			
			$ret .= '</div>';
			$ret .= '</div>';
		} else {
			$ret .= sprintf('<div id="tree-%s" class="folder" next=%s child=0>', $val['id'], (isset($tree[$key+1]) ? 1 : 0));
			if (isset($tree[$key+1])) {
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-leaf.gif" id="tree-%s-node">', $val['id']);
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-folder.gif" id="tree-%s-icon">', $val['id']);
			} else {
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-leaf-end.gif" id="tree-%s-node">', $val['id']);
				$ret .= sprintf('<img width="18" height="18" alt="" src="'.WEB_PATH.'administration/share/images/tree-folder.gif" id="tree-%s-icon">', $val['id']);
			}
			$ret .= sprintf('<span onClick="Tree.nodeClick(\'%s\')" class="text" curid="%s" curpath="%s" id="tree-%s-text">%s</span>', $val['id'], $val['id'], $nameKey, $val['id'], $name);
			$ret .= '</div>';
		}
	}
	
	return $ret;
}

function get_tree_option($tree, $parent=array()) {
	$ret = '';

	if (!empty($parent)) {
		$space = $parent['space'];
	} else {
		$space = '';
	}
	foreach ($tree as $key => $val) {
		$name = $val['name'];
		if ($val['childid'] != null) {
			$ret .= sprintf('<option value="%s">%s%s</option>', $val['id'], $space, $name);
			$space .= '&nbsp;&nbsp;';
			$ret .= get_tree_option($val['childid'], array('space' => $space));
		} else {
			$ret .= sprintf('<option value="%s">%s%s</option>', $val['id'], $space, $name);
		}
	}
	
	return $ret;
}

/**
 * Smarty {html_tree} function plugin
 * 
 * usage: {html_tree tree=$tree}, or {html_tree tree=$tree type='option'}
 *
 * Type:     function<br>
 * Name:     html_tree<br>
 * @author 	akiler <minyu1315@gmail.com>
 * @param 	array
 * @param 	Smarty
 */
function smarty_function_html_tree($params, &$smarty)
{
	if (!isset($params['tree']) || !is_array($params['tree'])) {
		return false;
	}
//	return $params['type'];
	if (isset($params['type'])) {
		if ($params['type'] == 'option') {
			$result = get_tree_option($params['tree']);
		} else {
			$result = get_tree_html($params['tree']);			// just set a default data.
		}
	} else {
		$result = get_tree_html($params['tree']);
	}
	
	return $result;
}
?>
