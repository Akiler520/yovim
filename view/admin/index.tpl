<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="all" />
    <meta name="description" content="互联网技术资源分享，包括WEB端，服务器端，各类技术资源" />
    <meta name="keywords" content="PHP,MYSQL,CSS3,HTML5,JQUERY,EASYUI,EXT,JAVASCRIPT,JS,CSS,HTML,移动WEB,移动应用,前端应用,服务器端应用" />
    <meta name="author" content="Akiler" />

    <title>优未 - 互联网技术资源分享 - 共同进步</title>
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/css/common.css" />
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/scripts/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/scripts/themes_kindED/default/default.css">
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/scripts/themes/icon.css">
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/jquery.easyui.min.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/common.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/admin.common.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/admin.source.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/admin.source.type.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/admin.friendlink.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/html5.upload.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/aims.process.manager v2.2.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/YovTable.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/spark-md5.min.js"></script>
    {*<script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/fckeditor/fckeditor.js"></script>
    <script type="text/javascript" charset="utf-8" src="{$_web_path}share/scripts/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{$_web_path}share/scripts/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="{$_web_path}share/scripts/ueditor/lang/zh-cn/zh-cn.js"></script>*}
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/kindeditor-min.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/kindeditor-en.js"></script>

    <link rel="shortcut icon" href="/fav.ico">
</head>

<body class="easyui-layout">
<input type="hidden" name="_yovim_site_path" id="_yovim_site_path" value="{$_web_path}">
<div data-options="region:'north',border:false" style="height:60px;background:#95b8e7;padding:10px;"><div class="admin-logo-text">Yovim Management</div> </div>
<div data-options="region:'west',split:true" style="width:200px;">
    <div class="easyui-accordion" data-options="fit:true,border:false">
        <div title="Setting" data-options="selected:true" style="padding:10px;">
            <ul>
                <li><a href="#" onclick="AdminTabs.add('System Setting')">System Setting</a></li>
                {*<li><a href="#" onclick="AdminTabs.add('Menu')">Menu</a></li>*}
                <li><a href="#" onclick="AdminTabs.add('Friend link', 'yovim-admin-data-friendlink-list')">Friend Link</a></li>
                <li><a href="#" onclick="AdminTabs.add('Log')">Log</a></li>
            </ul>
        </div>
        <div title="Source" style="padding:10px;">
            <ul>
                <li><a href="#" onclick="AdminTabs.add('Source List', 'yovim-admin-data-source-list')">Source List</a></li>
                <li><a href="#" onclick="AdminTabs.add('Source Type', 'yovim-admin-data-source-type-list')">Source Type</a></li>
                <li><a href="#" onclick="AdminTabs.add('Recommend')">Recommend</a></li>
            </ul>
        </div>
        <div title="User" style="padding:10px">
            <ul>
                <li><a href="#" onclick="AdminTabs.add('User List')">User List</a></li>
                <li><a href="#" onclick="AdminTabs.add('User Group')">User Group</a></li>
            </ul>
        </div>
        <div title="Source Type" style="padding:10px">
            content3
        </div>
    </div>
</div>
<div data-options="region:'south',border:false" style="height:20px;background:#95b8e7;padding:2px; text-align: center;">蜀ICP备14022790号 Copyright©2013-2014 All Rights Reserved. Yovim.com</div>
<div data-options="region:'center'">
    <div id="yovim_tabs_admin" class="easyui-tabs" style="height:100%">
    </div>
</div>

{*<div id="yovim-toolbar-source-list" style="padding:5px;height:auto">
    <div style="margin-bottom:5px">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true">Add</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Edit</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true">Save</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-cut" plain="true">Cut</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Delete</a>
    </div>
    <div>
        Date From: <input class="easyui-datebox" style="width:80px">
        To: <input class="easyui-datebox" style="width:80px">
        Keywords: <input type="text" name="keywords" style="width:80px">
        <a href="#" class="easyui-linkbutton" iconCls="icon-search">Search</a>
    </div>
</div>*}

{literal}
    <script type="text/javascript">
        $(function(){
            AdminConfig.resize();
            AdminConfig.windowInit();
            Config.init();
        });
    </script>
{/literal}
</body>

</html>
