var AdminSourceType = {
    listID: '#yovim-admin-data-source-type-list'
};

AdminSourceType.init = function(){
    $(AdminSourceType.listID).YovTable({
        url: 'admin_sourceType/list',
        toolbar: [{
            text: 'New',
            iconCls: 'icon-add',
            handler: function() {
                AdminSourceType.add();
            }
        }, '-', {
            text: 'Edit',
            iconCls: 'icon-edit',
            handler: function() {
                AdminSourceType.edit();
            }
        }, '-',{
            text: 'Delete',
            iconCls: 'icon-remove',
            handler: function(){
                AdminSourceType.delete();
            }
        }],
        columns:[[
            {field:'default_check', checkbox: true, width:TableHeaderMenu.fixWidthTable(0.06)},
            {field:'id',title:'ID', hidden: true, sortable:true, width:TableHeaderMenu.fixWidthTable(0.06)},
            {field:'name',title:'Name',sortable:true,width:TableHeaderMenu.fixWidthTable(0.08),align:'left'},
            {field:'description',title:'Description',sortable:true,width:TableHeaderMenu.fixWidthTable(0.12),align:'left'},
            {field:'time_add',title:'Add Time',sortable:true,width:TableHeaderMenu.fixWidthTable(0.1),align:'left'}
        ]]
    });
};

AdminSourceType.add = function(){
    var url_page = Config.rootPath+'admin_sourceType/addPage/';
    var url_submit = Config.rootPath+'admin_sourceType/add/';

    var winID = '#yovim-admin-source-type-window-add';
    var formID = '#yovim-admin-source-type-form-add';

    AdminWindow.init({
        title:      'Add Source type',
        winID:      winID,
        url_page:   url_page,
        width:      500,
        height:     300,
        submitCallback: function(){
            $(formID).form({
                url: url_submit,
                onSubmit: function(){
                    // check if the source file is uploaded
                    var formObj = $(formID);

                    return $(formID).form("validate");
                },
                success:function(data){
                    data = Common.str2json(data);

                    AdminMessager.show(data.status, data.msg);

                    if(data.status == 1){
                        $(AdminSourceType.listID).datagrid('reload');

                        // reset form and hide the window;
                        Form.reset(formID);

                        $(winID).window('close');
                    }
                }
            });
        },
        initCallback: function(){
            Form.reset(formID);
        }
    });
};

AdminSourceType.edit = function(){
    var url_page = Config.rootPath+'admin_sourceType/editPage/';
    var url_submit = Config.rootPath+'admin_sourceType/edit/';
    var url_data = Config.rootPath+'admin_sourceType/detail/';

    var winID = '#yovim-admin-source-type-window-edit';
    var formID = '#yovim-admin-source-type-form-edit';

    var rowSelected = $(AdminSourceType.listID).datagrid('getSelections');
    if(rowSelected.length <= 0){
        AdminMessager.show(0, "Select one source first!");
        return;
    }

    if(rowSelected.length > 1){
        AdminMessager.show(0, "You should only select one to edit!");
        return;
    }

    var sourceTypeID = rowSelected[0].id;

    AdminWindow.init({
        title:      'Edit Source',
        winID:      winID,
        url_page:   url_page,
        width:      500,
        height:     300,
        submitCallback: function(){
            $(formID).form({
                url: url_submit,
                onSubmit: function(){
                    return $(formID).form("validate");
                },
                success:function(data){
                    data = Common.str2json(data);

                    AdminMessager.show(data.status, data.msg);

                    if(data.status == 1){
                        $(AdminSourceType.listID).datagrid('reload');
                        Form.reset(formID);
                        $(winID).window('close');
                    }
                }
            });
        },
        initCallback: function(){
            Form.reset(formID);

            $.AimsProcess.run({
                name    : AdminSourceType.listID,
                keyword : 'sourceTypeEdit',
                url     : url_data,
                data    : 'id_source_type='+sourceTypeID,
                success :function(rs)
                {
                    AdminMessager.show(rs.status, rs.msg);

                    if(rs.status == 1){
                        var data = rs.data;
                        var formObj = $(formID);

                        formObj.find("input[name='name']").val(data.name);
                        formObj.find("input[name='id']").val(data.id);
                        formObj.find("textarea[name='description']").val(data.description);
                    }
                }
            });
        }
    });
};

AdminSourceType.delete = function(){
    var rowSelected = $(AdminSourceType.listID).datagrid('getSelections');

    if(rowSelected.length <= 0){
        AdminMessager.show(0, "Select one source first!");
        return;
    }

    if(!confirm("Are you sour to delete it?")){
        return;
    }

    var sourceTypeID = [];

    for(var i = 0; i < rowSelected.length; i++){
        var row = rowSelected[i];
        sourceTypeID.push(row.id);
    }

    var url_page = Config.rootPath+'admin_sourceType/delete/';

    $.AimsProcess.run({
        name    : AdminSourceType.listID,
        keyword : 'sourceTypeDelete',
        url     : url_page,
        data    : 'id_source_type='+sourceTypeID,
        success :function(rs)
        {
            AdminMessager.show(rs.status, rs.msg);

            if(rs.status == 1){
                $(AdminSourceType.listID).datagrid('reload');
            }
        }
    });
};
