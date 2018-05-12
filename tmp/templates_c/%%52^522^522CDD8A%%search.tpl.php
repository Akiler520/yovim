<?php /* Smarty version 2.6.18, created on 2015-10-27 11:03:13
         compiled from source/search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'source_keywords', 'source/search.tpl', 4, false),)), $this); ?>
<div id="content"> <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <div class="yov_li">
    <h1><a href="<?php echo $this->_tpl_vars['_web_path']; ?>
source/detail/code/<?php echo $this->_tpl_vars['item']['id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['name_search']; ?>
</a></h1>
      <p>作者： <span><?php echo $this->_tpl_vars['item']['username']; ?>
</span> 时间：<span><?php echo $this->_tpl_vars['item']['time_add']; ?>
</span><span>标签：<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['keywords'])) ? $this->_run_mod_handler('source_keywords', true, $_tmp) : smarty_modifier_source_keywords($_tmp)); ?>
&nbsp; </span> <a href="javascript:;" style="cursor: pointer; margin-left: 4px;" onclick="Ak_Source.laud(<?php echo $this->_tpl_vars['item']['id']; ?>
, this);"><img src="<?php echo $this->_tpl_vars['_web_path']; ?>
share/images/laud.png"><span class="laud_num">(<?php echo $this->_tpl_vars['item']['num_rec']; ?>
)</span></a></p>
    <div class="clear"></div>
  </div>
  <?php endforeach; endif; unset($_from); ?> 
  <?php echo $this->_tpl_vars['pagination']; ?>

  </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'slider.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>