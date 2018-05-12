<?php /* Smarty version 2.6.18, created on 2015-10-27 10:16:11
         compiled from user/login.tpl */ ?>
<div class="easyui-panel" title="New Topic" style="width:400px">
    <div style="padding:10px 0 10px 60px">
        <form id="yov_form_login" method="post">
            <table>
                <tr>
                    <td>Name:</td>
                    <td><input class="easyui-validatebox" type="text" name="username" data-options="required:true"></input></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input class="easyui-validatebox" type="password" name="password" data-options="required:true"></input></td>
                </tr>

            </table>
        </form>
    </div>
    <div style="text-align:center;padding:5px">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Submit</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">Clear</a>
    </div>
</div>

<?php echo '
<script>
function submitForm(){
$(\'#yov_form_login\').form(\'submit\',{
    url: $("#_yovim_site_path").val()+\'user/login\',
    dataType: \'json\',
    success: function(data){
        data = Common.str2json(data);
        if(data.status == 1){
            Config.winReload();
        }
    }
});
}
function clearForm(){
$(\'#yov_form_login\').form(\'clear\');
}
</script>

'; ?>