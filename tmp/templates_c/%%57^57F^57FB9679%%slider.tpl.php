<?php /* Smarty version 2.6.18, created on 2015-10-27 10:15:51
         compiled from slider.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'hottag_class', 'slider.tpl', 13, false),)), $this); ?>
<div id="sider">
    <h2>热门文章</h2>
    <ul class="hot_tag">
        <?php $_from = $this->_tpl_vars['top10']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
            <li><a href="<?php echo $this->_tpl_vars['_web_path']; ?>
source/detail/code/<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>

    <div class="hot_tag">
        <h2>热门标签</h2>
        <p>
            <?php $_from = $this->_tpl_vars['top_tag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <span><a href="<?php echo $this->_tpl_vars['_web_path']; ?>
source/search/keyword/<?php echo $this->_tpl_vars['item']['tag']; ?>
" class="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['tag'])) ? $this->_run_mod_handler('hottag_class', true, $_tmp) : smarty_modifier_hottag_class($_tmp)); ?>
"><?php echo $this->_tpl_vars['item']['tag']; ?>
</a></span>
            <?php endforeach; endif; unset($_from); ?>
        </p>
    </div>
</div>