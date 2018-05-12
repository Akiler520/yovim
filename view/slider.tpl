<div id="sider">
    <h2>热门文章</h2>
    <ul class="hot_tag">
        {foreach from=$top10 item=item}
            <li><a href="{$_web_path}source/detail/code/{$item.id}">{$item.name}</a></li>
        {/foreach}
    </ul>

    <div class="hot_tag">
        <h2>热门标签</h2>
        <p>
            {foreach from=$top_tag item=item}
                <span><a href="{$_web_path}source/search/keyword/{$item.tag}" class="{$item.tag|hottag_class}">{$item.tag}</a></span>
            {/foreach}
        </p>
    </div>
</div>