<div style="padding:10px 0 10px 60px">
    <form id="yovim-admin-friendlink-form-add" name="yovim-admin-friendlink-form-add" method="post">
        <table width="100%" class="tbl-line">
            <tr>
                <td width="9%" align="right">Name: </td>
                <td width="91%"><input name="name" type="text" class="easyui-validatebox" value="" data-options="required:true" >
                </td>
            </tr>
            <tr>
                <td align="right">Url: </td>
                <td>
                    <input name="url" type="text" class="easyui-validatebox" value="" data-options="required:true,validType:'url'" >
                </td>
            </tr>
            <tr>
                <td align="right">Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="6" id="description"> </textarea>
                </td>
            </tr>
            <tr>
                <td align="right">Order: </td>
                <td>
                    <input name="order" type="text" class="easyui-validatebox" value="">
                </td>
            </tr>
            <tr>
                <td align="right">&nbsp;</td>
                <td>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#yovim-admin-friendlink-form-add').submit();">Submit</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#yovim-admin-friendlink-form-add')[0].reset();">Clear</a>
                </td>
            </tr>
        </table>
    </form>
</div>
