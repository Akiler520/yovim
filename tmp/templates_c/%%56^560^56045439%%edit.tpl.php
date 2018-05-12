<?php /* Smarty version 2.6.18, created on 2017-05-03 20:22:21
         compiled from admin_source/edit.tpl */ ?>

<div style="padding:10px 0 10px 60px">
    <form id="yovim-admin-source-form-edit" name="yovim-admin-source-form-add" method="post">
        <table width="100%" class="tbl-line">
            <tr>
                <td width="9%" align="right">Name: </td>
                <td width="91%"><input name="name" type="text" class="easyui-validatebox" value="" data-options="required:true" >
                    <input name="id" type="hidden" id="id">
                </td>
            </tr>
            <tr>
                <td align="right">Keywords: </td>
                <td><input name="keywords" type="text" class="easyui-validatebox" id="keywords" data-options="required:true"></td>
            </tr>
            <tr>
                <td align="right">Url: </td>
                <td><input name="url" type="text" class="easyui-validatebox" id="url">
                </td>
            </tr>
                        <tr>
                <td align="right">Snapshot:</td>
                <td>
                    <input name="snapshot" type="hidden" id="snapshot">
                    <input name="snapshot_hash" type="hidden" id="snapshot_hash">

                    <div class="DivUp">

                        <div class="row">
                            <input type="file" name="fileBarSnapshot" style="width: 200px;" id="fileBarSnapshot" multiple="multiple"/>
                            <a id="btn-upload-snapshot" style=" display:none" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'">上传</a>

                        </div>
                        <div id="" style="display: ;">
                            <div id="progress-bar-snapshot" class="easyui-progressbar" style="width: 400px; float: left; display: none;">
                            </div>
                            <a href="#" id="progress-cancel-snapshot" style="float: left; display: none;" title="cancel"> <img src="<?php echo $this->_tpl_vars['_web_path']; ?>
share/images/delete.gif"></a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">Type:</td>
                <td>
                    <select name="type">
                        <?php $_from = $this->_tpl_vars['source_type_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                            <option value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Origin Url :</td>
                <td><input name="origin" type="text" class="easyui-validatebox" id="origin">
                </td>
            </tr>
            <tr>
                <td align="right">Summary: </td>
                <td>
                    <div id="">
                        <textarea name="summary" cols="80" rows="20" id="summary" style="width:500px;height:400px;"> </textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">Description: </td>
                <td><div id="">
                        <textarea name="description" cols="80" rows="20" id="description" style="width:500px;height:400px;"> </textarea>
                    </div></td>
            </tr>
            <tr>
                <td align="right">&nbsp;</td>
                <td>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#yovim-admin-source-form-edit').submit();">Submit</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#yovim-admin-source-form-edit')[0].reset();">Clear</a>
                </td>
            </tr>
      </table>
    </form>
</div>

<?php echo '
<script type="text/javascript">
    $(document).ready(function(){

    });
</script>
'; ?>