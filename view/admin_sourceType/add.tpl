<div style="padding:10px 0 10px 60px">
    <form id="yovim-admin-source-type-form-add" name="yovim-admin-source-type-form-add" method="post">
        <table width="100%" class="tbl-line">
            <tr>
                <td width="9%" align="right">Name: </td>
                <td width="91%"><input name="name" type="text" class="easyui-validatebox" value="" data-options="required:true" >
                </td>
            </tr>
            <tr>
                <td align="right">Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="6" id="description"> </textarea>
                </td>
            </tr>
            <tr>
                <td align="right">&nbsp;</td>
                <td>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#yovim-admin-source-type-form-add').submit();">Submit</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#yovim-admin-source-type-form-add')[0].reset();">Clear</a>
                </td>
            </tr>
        </table>
    </form>
</div>
