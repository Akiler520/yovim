<div id="header">
  <div id="header_wrap">
     <div id="logo"><h1 title="YovIM"><a href="http://www.yovim.com">YovIM</a></h1></div>
     <ul id="nav">
         <li><a class="cur" href="{$_web_path}">首页</a></li>{*
         <li><a href="{$_web_path}source/list">PHP/MySQL</a></li>
         <li><a href="{$_web_path}source/list">HTML5/移动WEB应用</a></li>
         <li><a href="{$_web_path}source/list">Javascript/jQuery</a></li>
         <li><a href="{$_web_path}source/list">HTML/CSS</a></li>*}
         {foreach from=$menuType item=item}
             <li><a href="{$_web_path}source/list/type/{$item.id}">{$item.name}</a> </li>
         {/foreach}

     </ul>
  </div>
</div>

<div id="page_banner"></div>