<?php /* Smarty version 2.6.18, created on 2015-10-27 10:15:51
         compiled from header.tpl */ ?>
<div id="header">
  <div id="header_wrap">
     <div id="logo"><h1 title="YovIM"><a href="http://www.yovim.com">YovIM</a></h1></div>
     <ul id="nav">
         <li><a class="cur" href="<?php echo $this->_tpl_vars['_web_path']; ?>
">首页</a></li>         <?php $_from = $this->_tpl_vars['menuType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
             <li><a href="<?php echo $this->_tpl_vars['_web_path']; ?>
source/list/type/<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a> </li>
         <?php endforeach; endif; unset($_from); ?>

     </ul>
  </div>
</div>

<div id="page_banner"></div>