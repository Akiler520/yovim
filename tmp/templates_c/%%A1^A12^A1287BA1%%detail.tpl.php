<?php /* Smarty version 2.6.18, created on 2015-10-27 10:18:27
         compiled from source/detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'source_keywords', 'source/detail.tpl', 5, false),)), $this); ?>
<div id="content">
    <div id="art_head">
        <h1><a href="<?php echo $this->_tpl_vars['_web_path']; ?>
source/detail/code/<?php echo $this->_tpl_vars['info']['id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['info']['name']; ?>
</a></h1>
        <div class="">
            <p class="art_info">作者：<span><?php echo $this->_tpl_vars['info']['username']; ?>
</span> 时间：<span><?php echo $this->_tpl_vars['info']['time_add']; ?>
</span><span> 标签：<?php echo ((is_array($_tmp=$this->_tpl_vars['info']['keywords'])) ? $this->_run_mod_handler('source_keywords', true, $_tmp) : smarty_modifier_source_keywords($_tmp)); ?>
&nbsp; </span> <a href="javascript:;" style="cursor: pointer; margin-left: 4px;" onclick="Ak_Source.laud(<?php echo $this->_tpl_vars['info']['id']; ?>
, this);"><img src="<?php echo $this->_tpl_vars['_web_path']; ?>
share/images/laud.png"><span class="laud_num">(<?php echo $this->_tpl_vars['info']['num_rec']; ?>
)</span></a></p><p class="art_summary"><?php echo $this->_tpl_vars['info']['summary']; ?>
</p>
        </div>
    </div>
    <div class="clear"></div>
    <?php if ($this->_tpl_vars['info']['link'] != '' && ( $this->_tpl_vars['info']['url'] == 'index.html' || $this->_tpl_vars['info']['url'] == 'index.htm' )): ?>
        <div id="art_view">
            <div class="button-main">
                <div class="button-inside">
                    <h1><a href="<?php echo $this->_tpl_vars['_web_path']; ?>
<?php echo $this->_tpl_vars['info']['link']; ?>
<?php echo $this->_tpl_vars['info']['url']; ?>
" target="_blank">View</a></h1>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="clear"></div>
    <div id="art_content">
        <?php echo $this->_tpl_vars['info']['description']; ?>

    </div>

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'slider.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
    <script language="javascript" type="text/javascript">
        $(document).ready(function(){
            prettyPrint();
        });
    </script>
'; ?>