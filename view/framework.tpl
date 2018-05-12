<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="all" />
<meta name="description" content="互联网技术资源分享，包括WEB端，服务器端，各类技术资源" />
<meta name="keywords" content="PHP,MYSQL,CSS3,HTML5,JQUERY,EASYUI,EXT,JAVASCRIPT,JS,CSS,HTML,移动WEB,移动应用,前端应用,服务器端应用" />
<meta name="author" content="Akiler" />

<title>优未 - 互联网技术资源分享 - 共同进步</title>
<link media="screen" href="{$_web_path}share/css/common.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/scripts/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/scripts/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/scripts/plugins_kindED/code/prettify.css">
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/jquery.easyui.min.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/common.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/admin.common.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/html5.upload.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/plugins_kindED/code/prettify.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/aims.process.manager v2.2.js"></script>

<link rel="shortcut icon" href="/fav.ico">
</head><body>
<input type="hidden" name="_yovim_site_path" id="_yovim_site_path" value="{$_web_path}">
{include file='header.tpl'}
  <div id="main">
  	<div id="main_wrap">
    	{include file=$tplfile}
        <div class="clear"></div>
    </div>
  </div>
{include file='footer.tpl'}
{literal}
<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        Config.init();
    });
</script>
{/literal}
</body>
</html>
