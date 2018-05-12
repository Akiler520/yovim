var AdminFriendLink = {
    listID: '#yovim-admin-data-friendlink-list'
};

AdminFriendLink.init = function(){
    $(AdminFriendLink.listID).YovTable({
        url: 'admin_friendLink/list',
        toolbar: [{
            text: 'New',
            iconCls: 'icon-add',
            handler: function() {
                AdminFriendLink.add();
            }
        }, '-', {
            text: 'Edit',
            iconCls: 'icon-edit',
            handler: function() {
                AdminFriendLink.edit();
            }
        }, '-',{
            text: 'Delete',
            iconCls: 'icon-remove',
            handler: function(){
                AdminFriendLink.delete();
            }
        }],
        columns:[[
            {field:'default_check', checkbox: true, width:TableHeaderMenu.fixWidthTable(0.06)},
            {field:'id',title:'ID', hidden: true, sortable:true, width:TableHeaderMenu.fixWidthTable(0.06)},
            {field:'name',title:'Name',sortable:true,width:TableHeaderMenu.fixWidthTable(0.08),align:'left'},
            {field:'url',title:'Url',sortable:true,width:TableHeaderMenu.fixWidthTable(0.12),align:'left'},
            {field:'description',title:'Description',sortable:true,width:TableHeaderMenu.fixWidthTable(0.12),align:'left'},
            {field:'order',title:'Order',sortable:true,width:TableHeaderMenu.fixWidthTable(0.12),align:'left'},
            {field:'time_add',title:'Add Time',sortable:true,width:TableHeaderMenu.fixWidthTable(0.1),align:'left'}
        ]]
    });
};

AdminFriendLink.add = function(){
    var url_page = Config.rootPath+'admin_friendLink/addPage/';
    var url_submit = Config.rootPath+'admin_friendLink/add/';

    var winID = '#yovim-admin-friendlink-window-add';
    var formID = '#yovim-admin-friendlink-form-add';

    AdminWindow.init({
        title:      'Add friend link',
        winID:      winID,
        url_page:   url_page,
        width:      500,
        height:     340,
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
                        $(AdminFriendLink.listID).datagrid('reload');

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

AdminFriendLink.edit = function(){
    var url_page = Config.rootPath+'admin_friendLink/editPage/';
    var url_submit = Config.rootPath+'admin_friendLink/edit/';
    var url_data = Config.rootPath+'admin_friendLink/detail/';

    var winID = '#yovim-admin-friendlink-window-edit';
    var formID = '#yovim-admin-friendlink-form-edit';

    var rowSelected = $(AdminFriendLink.listID).datagrid('getSelections');
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
        title:      'Edit friend link',
        winID:      winID,
        url_page:   url_page,
        width:      500,
        height:     340,
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
                        $(AdminFriendLink.listID).datagrid('reload');
                        Form.reset(formID);
                        $(winID).window('close');
                    }
                }
            });
        },
        initCallback: function(){
            Form.reset(formID);

            $.AimsProcess.run({
                name    : AdminFriendLink.listID,
                keyword : 'friendlinkEdit',
                url     : url_data,
                data    : 'id_friendlink='+sourceTypeID,
                success :function(rs)
                {
                    AdminMessager.show(rs.status, rs.msg);

                    if(rs.status == 1){
                        var data = rs.data;
                        var formObj = $(formID);

                        formObj.find("input[name='id']").val(data.id);
                        formObj.find("input[name='name']").val(data.name);
                        formObj.find("input[name='url']").val(data.url);
                        formObj.find("input[name='order']").val(data.order);
                        formObj.find("textarea[name='description']").val(data.description);
                    }
                }
            });
        }
    });
};

AdminFriendLink.delete = function(){
    var rowSelected = $(AdminFriendLink.listID).datagrid('getSelections');

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

    var url_page = Config.rootPath+'admin_friendLink/delete/';

    $.AimsProcess.run({
        name    : AdminFriendLink.listID,
        keyword : 'friendLinkDelete',
        url     : url_page,
        data    : 'id_friendlink='+sourceTypeID,
        success :function(rs)
        {
            AdminMessager.show(rs.status, rs.msg);

            if(rs.status == 1){
                $(AdminFriendLink.listID).datagrid('reload');
            }
        }
    });
};
