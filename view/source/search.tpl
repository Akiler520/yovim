<div id="content"> {foreach from=$list item=item}
  <div class="yov_li">
    <h1><a href="{$_web_path}source/detail/code/{$item.id}" target="_blank">{$item.name_search}</a></h1>
      <p>作者： <span>{$item.username}</span> 时间：<span>{$item.time_add}</span><span>标签：{$item.keywords|source_keywords}&nbsp; </span> <a href="javascript:;" style="cursor: pointer; margin-left: 4px;" onclick="Ak_Source.laud({$item.id}, this);"><img src="{$_web_path}share/images/laud.png"><span class="laud_num">({$item.num_rec})</span></a></p>
    <div class="clear"></div>
  </div>
  {/foreach} 
  {$pagination}
  </div>
{include file='slider.tpl'}
