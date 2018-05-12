<div id="footer">
    <div id="footer_wrap">
        <div id="partner">
            <p><strong>友情链接</strong>
                {foreach from=$friendLink item=item}
                    <span><a target="_blank" href="{$item.url}">{$item.name}</a></span>
                {/foreach}
            </p>
        </div>
        <div id="footer_rights"> <span>蜀ICP备14022790号  Copyright&copy;2013-2014 All Rights Reserved. <a href="http://www.yovim.com">Yovim.com</a>
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253481605'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s6.cnzz.com/stat.php%3Fid%3D1253481605%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
        </span>
            <p><a href="/about.html">关于本站</a> | <a href="/gbook.html">留言</a> | <a href="/statement.html">网站声明</a> | <a href="/sitemap.html">网站地图</a> | <a href="{$_web_path}source/list">资源一览表</a></p>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
