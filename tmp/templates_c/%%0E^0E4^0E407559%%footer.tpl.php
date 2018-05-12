<?php /* Smarty version 2.6.18, created on 2015-10-27 10:15:51
         compiled from footer.tpl */ ?>
<div id="footer">
    <div id="footer_wrap">
        <div id="partner">
            <p><strong>友情链接</strong>
                <?php $_from = $this->_tpl_vars['friendLink']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <span><a target="_blank" href="<?php echo $this->_tpl_vars['item']['url']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></span>
                <?php endforeach; endif; unset($_from); ?>
            </p>
        </div>
        <div id="footer_rights"> <span>蜀ICP备14022790号  Copyright&copy;2013-2014 All Rights Reserved. <a href="http://www.yovim.com">Yovim.com</a>
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253481605'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s6.cnzz.com/stat.php%3Fid%3D1253481605%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
        </span>
            <p><a href="/about.html">关于本站</a> | <a href="/gbook.html">留言</a> | <a href="/statement.html">网站声明</a> | <a href="/sitemap.html">网站地图</a> | <a href="<?php echo $this->_tpl_vars['_web_path']; ?>
source/list">资源一览表</a></p>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>