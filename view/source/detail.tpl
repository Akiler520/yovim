<div id="content">
    <div id="art_head">
        <h1><a href="{$_web_path}source/detail/code/{$info.id}" target="_blank">{$info.name}</a></h1>
        <div class="">
            <p class="art_info">作者：<span>{$info.username}</span> 时间：<span>{$info.time_add}</span><span> 标签：{$info.keywords|source_keywords}&nbsp; </span> <a href="javascript:;" style="cursor: pointer; margin-left: 4px;" onclick="Ak_Source.laud({$info.id}, this);"><img src="{$_web_path}share/images/laud.png"><span class="laud_num">({$info.num_rec})</span></a></p><p class="art_summary">{$info.summary}</p>
        </div>
    </div>
    <div class="clear"></div>
    {if $info.link != '' && ($info.url == 'index.html' || $info.url == 'index.htm')}
        <div id="art_view">
            <div class="button-main">
                <div class="button-inside">
                    <h1><a href="{$_web_path}{$info.link}{$info.url}" target="_blank">View</a></h1>
                </div>
            </div>
        </div>
    {/if}

    <div class="clear"></div>
    <div id="art_content">
        {$info.description}
    </div>

</div>

{include file='slider.tpl'}

{literal}
    <script language="javascript" type="text/javascript">
        $(document).ready(function(){
            prettyPrint();
        });
    </script>
{/literal}