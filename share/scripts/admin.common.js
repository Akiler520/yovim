var AdminTabs = {
    tabsID: '#yovim_tabs_admin'
};

AdminTabs.add = function(title, dataKey){
    var tabsObj = $(AdminTabs.tabsID);

    if(tabsObj.tabs('exists', title)){
        tabsObj.tabs('select', title);
    }else{
        tabsObj.tabs('add', {
            title: title,
            selected: true,
            content: '<table id="'+dataKey+'"></table>',
            closable: true
        });

        AdminTabs.load(dataKey);
    }
};

AdminTabs.load = function(dataKey){
    switch (dataKey){
        case 'yovim-admin-data-source-list':
            AdminSource.init();
            break;
        case 'yovim-admin-data-source-type-list':
            AdminSourceType.init();
            break;
        case 'yovim-admin-data-friendlink-list':
            AdminFriendLink.init();
            break;
        default :
            break;
    }
};

var AdminConfig = {};

AdminConfig.init = function(){

};

AdminConfig.resize = function(){
    var tabsObj = $(AdminTabs.tabsID);

    tabsObj.tabs({
        width:tabsObj.parent().width(),
        height:tabsObj.parent().height()
    });
};

AdminConfig.windowInit = function()
{
    var resizeTimer = null;
    $(window).bind('resize', function(){
        resizeTimer = setTimeout(function(){AdminConfig.resize()},300);
    });
};

var AdminForm = {};

AdminForm.submit = function(fromID){
//    $('#upload_contact_list').attr('disabled',true);
    $(obj).ajaxSubmit({
        type:'post',
        url:'contactlist.php?contact_action=upload',
        dataType:'json',
        success:function(rs){
            if(rs.status == 1) {
                $('#contact_list').val('');
                DmsAction.checkContactListFile('#contact_list');
            } else if(rs.status == 0) {
                $('#upload_contact_list').attr('disabled',false);
            }
            MsgBox.show(rs.status, rs.msg);
        },
        error:function(XmlHttpRequest,textStatus,errorThrown){
            console.log(XmlHttpRequest);
            console.log(textStatus);
            console.log(errorThrown);
            $('#upload_contact_list').attr('disabled',false);
            MsgBox.show(0, 'Error: Connection Error.');
        }
    });
};

var AdminWindow = {};

AdminWindow.init = function(params){
    var winObj = $(params.winID);

    if(winObj.length <= 0){
        var winHtml = '<div id="'+params.winID.substring(1)+'"></div>';
        $('body').append(winHtml);

        var width = (typeof(params.width) == 'undefined') ? 900 : params.width;
        var height = (typeof(params.height) == 'undefined') ? 600 : params.height;

        $(params.winID).window({
            title:      params.title,
            href:       params.url_page,
            width:      width,
            height:     height,
            modal:      true,
            onLoad:     function(){
                if(params.submitCallback){
                    (params.submitCallback)();
                }

                if(params.initCallback){
                    (params.initCallback)();
                }
            }
        });
    }else{
        $(params.winID).window('open');
        if(params.initCallback){
            (params.initCallback)();
        }
    }
};

var AdminMessager = {};

/**
 * messager
 * type: 0=error, 1=info, 2=warning
 *
 * @param type
 * @param info
 */
AdminMessager.show = function(type, info){
    switch (type){
        case 0: // error info, don't close automatically
            $.messager.alert("Error", info, 'error');
            break;
        case 1: // info, close it in 2 seconds automatically
            $.messager.show({
                title   : "Message",
                msg     : info,
                showType:'slide',
                style   :{
                    right   :'',
                    top     :document.body.scrollTop+document.documentElement.scrollTop,
                    bottom  :''
                }
            });
            break;
        case 2: // warning, don't close automatically
            $.messager.alert('Warning', info,'warning');
            break;
        default :
            $.messager.alert('Warning', info,'warning');
            break;
    }

    $.messager.progress('close');
};