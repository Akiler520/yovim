var AdminSource = {
    listID: '#yovim-admin-data-source-list'
};

AdminSource.init = function(){
    var listObj = $(AdminSource.listID);

    $(AdminSource.listID).YovTable({
        url: 'admin_source/list',
        pageSize: 20,
        toolbar: [{
            text: 'New',
            iconCls: 'icon-add',
            handler: function() {
                AdminSource.add();
            }
        }, '-', {
            text: 'Edit',
            iconCls: 'icon-edit',
            handler: function() {
                AdminSource.edit();
            }
        }, '-',{
            text: 'Delete',
            iconCls: 'icon-remove',
            handler: function(){
                AdminSource.delete();
            }
        }],
        columns:[[
            {field:'default_check', checkbox: true, width:TableHeaderMenu.fixWidthTable(0.06)},
            {field:'id',title:'ID', hidden: true, sortable:true, width:TableHeaderMenu.fixWidthTable(0.06)},
            {field:'name',title:'Name',sortable:true,width:TableHeaderMenu.fixWidthTable(0.12),align:'left'},
            {field:'keywords',title:'Keywords',sortable:true,width:TableHeaderMenu.fixWidthTable(0.12),align:'left'},
            {field:'summary',title:'Summary',sortable:true,width:TableHeaderMenu.fixWidthTable(0.4),align:'left'},
            {field:'username',title:'UserName',sortable:true,width:TableHeaderMenu.fixWidthTable(0.12),align:'center'},
            {field:'time_add',title:'Add Time',sortable:true,width:TableHeaderMenu.fixWidthTable(0.1),align:'left'}
        ]]
    });
};

AdminSource.add = function(){
    var url_page = Config.rootPath+'admin_source/addPage/';
    var url_submit = Config.rootPath+'admin_source/add/';

    var winID = '#yovim-admin-source-window-add';
    var formID = '#yovim-admin-source-form-add';

    AdminWindow.init({
        title:      'Add Source',
        winID:      winID,
        url_page:   url_page,
        submitCallback: function(){
            $(formID).form({
                url: url_submit,
                onSubmit: function(){
                    Common.editor['source-description'].sync();
                    Common.editor['source-summary'].sync();
                    // check if the source file is uploaded
                    var formObj = $(formID);

                    if(formObj.find("input[name='source']").val().length <= 0
                        || formObj.find("input[name='source_hash']").val().length <= 0
                        ){
                        if(!confirm('Oh my dear, you missed the source file, do you want to continue?')){
                            return false;
                        }
                    }

                    return $(formID).form("validate");
                },
                success:function(data){
                    data = Common.str2json(data);

                    if(data.status == 1){
                        $(AdminSource.listID).datagrid('reload');

                        // reset form and hide the window;
                        Form.reset(formID);
                        Common.editor['source-description'].html("");
                        Common.editor['source-summary'].html("");

                        var formObj = $(formID);

                        formObj.find("#btn-upload-source").hide();
                        formObj.find("#btn-upload-snapshot").hide();

                        $(winID).window('close');
                    }
                }
            });
        },
        initCallback: function(){
            Form.reset(formID);
            Common.kindeditor('source-description', $(formID).find('textarea[name="description"]'), 1);
            Common.kindeditor('source-summary', $(formID).find('textarea[name="summary"]'), 1);
        }
    });
};

AdminSource.delete = function(){
    var rowSelected = $(AdminSource.listID).datagrid('getSelections');

    if(rowSelected.length <= 0){
        AdminMessager.show(2, "Select one source first!");
        return;
    }

    if(!confirm("Are you sour to delete it?")){
        return;
    }

    var sourceID = [];

    for(var i = 0; i < rowSelected.length; i++){
        var row = rowSelected[i];
        sourceID.push(row.id);
    }

    var url_page = Config.rootPath+'admin_source/delete/';

    $.AimsProcess.run({
        name    : AdminSource.listID,
        keyword : 'sourceDelete',
        url     : url_page,
        data    : 'id_source='+sourceID,
        success :function(rs)
        {
            AdminMessager.show(rs.status, rs.msg);

            if(rs.status == 1){
                $(AdminSource.listID).datagrid('reload');
            }
        }
    });
};

AdminSource.edit = function(){
    var url_page = Config.rootPath+'admin_source/editPage/';
    var url_submit = Config.rootPath+'admin_source/edit/';
    var url_data = Config.rootPath+'admin_source/detail/';

    var winID = '#yovim-admin-source-window-edit';
    var formID = '#yovim-admin-source-form-edit';

    var rowSelected = $(AdminSource.listID).datagrid('getSelections');
    if(rowSelected.length <= 0){
        AdminMessager.show(2, "Select one source first!");
        return;
    }

    if(rowSelected.length > 1){
        AdminMessager.show(0, "You should only select one to edit!");
        return;
    }

    var sourceID = rowSelected[0].id;

    AdminWindow.init({
        title:      'Edit Source',
        winID:      winID,
        url_page:   url_page,
        submitCallback: function(){
            $(formID).form({
                url: url_submit,
                onSubmit: function(){
                    Common.editor['source-description-edit'].sync();
                    Common.editor['source-summary-edit'].sync();
                    return $(formID).form("validate");
                },
                success:function(data){
                    data = Common.str2json(data);

                    AdminMessager.show(data.status, data.msg);

                    if(data.status == 1){
                        $(AdminSource.listID).datagrid('reload');
                        Form.reset(formID);
                        $(winID).window('close');
                    }
                }
            });
        },
        initCallback: function(){
            Common.kindeditor('source-description-edit', $(formID).find('textarea[name="description"]'), 1);
            Common.kindeditor('source-summary-edit', $(formID).find('textarea[name="summary"]'), 1);

            Form.reset(formID);

            $.AimsProcess.run({
                name    : AdminSource.listID,
                keyword : 'sourceEdit',
                url     : url_data,
                data    : 'id_source='+sourceID,
                success :function(rs)
                {
                    AdminMessager.show(rs.status, rs.msg);

                    if(rs.status == 1){
                        var data = rs.data;
                        var formObj = $(formID);

                        formObj.find("input[name='name']").val(data.name);
                        formObj.find("input[name='keywords']").val(data.keywords);
                        formObj.find("input[name='url']").val(data.url);
                        formObj.find("input[name='origin']").val(data.origin);
                        formObj.find("input[name='id']").val(data.id);

                        formObj.find("select[name='type'] option").each(function(){
                            if($(this).val() == data.id_source_type){
                                $(this).attr("selected", true);
                            }else{
                                $(this).removeAttr("selected");
                            }
                        });

                        Common.editor['source-description-edit'].html(data.description);
                        Common.editor['source-summary-edit'].html(data.summary);

                        AdminSource.snapshotUpload(formID, true);
                    }
                }
            });
        }
    });
};

AdminSource.fileUpload = function(formID)
{

};

AdminSource.sourceUpload = function(formID)
{
    var site_path = $("#_yovim_site_path").val();

    $(formID).find('#fileBarSource').YovUpload({
        url         : site_path+"admin_source/addSource",
        mainID      : formID,
        progressBar : '#progress-bar-source',
        triggerBtn  : '#btn-upload-source',
        cancelBtn   : '#progress-cancel-source',
        fileType    : ['zip'],
        maxSize     : 10,
        isUnique    : true,
        onSuccess   : function(data){
            AdminMessager.show(data.status, data.msg);

            if(data.status == 1){
                $(formID).find('#source').val(data.data.filename);
            }
        },
        uniqueCheck : function(hashCode, callBack){
            AdminSource.uniqueCheck(formID, hashCode, "source", callBack);
        }
    });
};

AdminSource.snapshotUpload = function(formID, isUpdate)
{
    var site_path = $("#_yovim_site_path").val();

    var postData = new Array([]);

    var url = site_path+"admin_source/addSnapshot";

    if(isUpdate){
        postData['id'] = $(formID).find("input[name='id']").val();
        url = site_path+"admin_source/editSnapshot";
    }

    $(formID).find('#fileBarSnapshot').YovUpload({
        url         : url,
        mainID      : formID,
        progressBar : '#progress-bar-snapshot',
        triggerBtn  : '#btn-upload-snapshot',
        cancelBtn   : '#progress-cancel-snapshot',
        fileType    : ['jpg', 'jpeg', 'gif', 'png', 'bmp'],
        postData    : postData,
        maxSize     : 2,
        isUnique    : true,
        isUpdate    : isUpdate,
        onSuccess   : function(data){
            AdminMessager.show(data.status, data.msg);

            if(data.status == 1){
                $(formID).find('#snapshot').val(data.data.filename);
            }
        },
        uniqueCheck : function(hashCode, callBack){
            AdminSource.uniqueCheck(formID, hashCode, "snapshot", callBack);
        }
    });
};

AdminSource.uniqueCheck = function(formID, hashCode, type, callBack)
{
    var data_check = 'hash='+hashCode+"&type="+type;

    // send md5 hash to server, and check if the file exist, if not exist, upload, or skip
    $.AimsProcess.run({
        name    : AdminSource.listID,
        keyword : 'sourceUniqueCheck',
        url     : Config.rootPath+'admin_source/unique/',
        data    : data_check,
        success :function(rs)
        {
            if(rs.status == 1){
                // not exist
                if(rs.data.count <= 0){
                    // set the hash code to the form in order to be submit
                    $(formID).find('#'+type+'_hash').val(hashCode);

                    // call back process
                    callBack();
                }else{
                    // file exist, the new source will use it

                    AdminMessager.show(2, "Oh goodness, you have the same file with SERVER, you can free to use the one on SERVER.");
                }
            }else{
                AdminMessager.show(0, "Unique check error, try again please!");
            }
        }
    });
};