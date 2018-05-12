<div id="content">
    {foreach from=$list item=item}
        <div class="yov_li">
            <h1><a href="{$_web_path}source/detail/code/{$item.id}" target="_blank">{$item.name}</a></h1>
            <div class="yov_img"><a href="{$_web_path}{$item.link}{$item.url}"  target="_blank"><img alt="{$item.name}" src="{$_web_path}{$item.thumb}"></a></div>
            <div class="yov_txt">
                <p>作者： <span>{$item.username}</span> 时间：<span>{$item.time_add}</span><span>标签：{$item.keywords|source_keywords}&nbsp; </span> <a href="javascript:;" style="cursor: pointer; margin-left: 4px;" onclick="Ak_Source.laud({$item.id}, this);"><img src="{$_web_path}share/images/laud.png"><span class="laud_num">({$item.num_rec})</span></a></p>
                <p class="abstracts">{$item.summary|truncate_zh:200}<a href="{$_web_path}source/detail/code/{$item.id}"> （阅读全文）</a></p>
            </div>
            <div class="clear"></div>
        </div>
    {/foreach}
    {$pagination}
</div>
{include file='slider.tpl'}

