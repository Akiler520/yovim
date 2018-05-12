<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Default Examples</title>

    {*<link rel="stylesheet" href="../themes_kindED/default/default.css" />*}
    <link rel="stylesheet" type="text/css" href="{$_web_path}share/scripts/themes_kindED/default/default.css">
    {*<script charset="utf-8" src="../kindeditor-min.js"></script>
    <script charset="utf-8" src="../lang/zh_CN.js"></script>*}
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/kindeditor-min.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/kindeditor-en.js"></script>
    <script language="javascript" type="text/javascript" src="{$_web_path}share/scripts/common.js"></script>
    {literal}
    <style>
        form {
            margin: 0;
        }
        textarea {
            display: block;
        }
    </style>
    <script>
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name="content"]', {
                allowFileManager : true,
                themesPath: Config.jsPath+"themes_kindED/",
                langPath: Config.jsPath+"lang_kindED/",
                pluginsPath: Config.jsPath+"plugins_kindED/"
            });
            K('input[name=getHtml]').click(function(e) {
                alert(editor.html());
            });
            K('input[name=isEmpty]').click(function(e) {
                alert(editor.isEmpty());
            });
            K('input[name=getText]').click(function(e) {
                alert(editor.text());
            });
            K('input[name=selectedHtml]').click(function(e) {
                alert(editor.selectedHtml());
            });
            K('input[name=setHtml]').click(function(e) {
                editor.html('<h3>Hello KindEditor</h3>');
            });
            K('input[name=setText]').click(function(e) {
                editor.text('<h3>Hello KindEditor</h3>');
            });
            K('input[name=insertHtml]').click(function(e) {
                editor.insertHtml('<strong>插入HTML</strong>');
            });
            K('input[name=appendHtml]').click(function(e) {
                editor.appendHtml('<strong>添加HTML</strong>');
            });
            K('input[name=clear]').click(function(e) {
                editor.html('');
            });
        });
    </script>

    {/literal}
</head>
<body>
<h3>默认模式</h3>
<form>
    <textarea name="content" style="width:800px;height:400px;visibility:hidden;">KindEditor</textarea>
    <p>
        <input type="button" name="getHtml" value="取得HTML" />
        <input type="button" name="isEmpty" value="判断是否为空" />
        <input type="button" name="getText" value="取得文本(包含img,embed)" />
        <input type="button" name="selectedHtml" value="取得选中HTML" />
        <br />
        <br />
        <input type="button" name="setHtml" value="设置HTML" />
        <input type="button" name="setText" value="设置文本" />
        <input type="button" name="insertHtml" value="插入HTML" />
        <input type="button" name="appendHtml" value="添加HTML" />
        <input type="button" name="clear" value="清空内容" />
        <input type="reset" name="reset" value="Reset" />
    </p>
</form>
</body>
</html>
