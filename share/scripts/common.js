// JavaScript Document

/**
 * get browser information of user
 */
var _ua = navigator.userAgent.toLowerCase();
var _tmp;
var Browser = {
    ie: (_tmp = _ua.match(/msie ([\d.]+)/)) ?  _tmp[1] : null,
    firefox: (_tmp = _ua.match(/firefox\/([\d.]+)/)) ? _tmp[1] : null,
    chrome: (_tmp = _ua.match(/chrome\/([\d.]+)/)) ? _tmp[1] : null,
    opera: (_tmp = _ua.match(/opera.([\d.]+)/)) ? _tmp[1] : null,
    safari: (_tmp = _ua.match(/version\/([\d.]+).*safari/)) ? _tmp[1] : null
};

/**
 * config, init system info.
 */
var Config = {
    filetypes: "doc|docx|pptx|xls|xlsx|gif|jpeg|jpg|pdf|png|ico|txt|rar|exe|zip|gz|accdb|psd|tif",
	swf_filetypes: "*.dwg;*.skp;*.3ds;*.pdf;*.doc;*.docx;*.xls;*.xlsx;*.ppt;*.pptx;*.avi;*.jpg;*.png;*.gif;*.tif;*.txt;*.jnt;*.odg;*.odp;*.odt;*.ods",
	filename:  "*.conf",
	extensionDef: "null",
	framename: "mainFrame",
	host: "",
	rootPath: "",
	assetPath: "share/assets/",
	imgPath: "share/images/",
	cssPath: "share/css/",
	jsPath: "share/scripts/",
	uploadPath: "source/tmp/",
	convertPath: "source/convert/",
	cookieName: "yov_userinfo",
	defdata: "NULL",
    filesize: "150 MB",
    uploadlimit: 50,
	attachMax: 5,
	fileListMax: 300,
	abort: 0,		// 0=not abort the operate, 1=abort
	rotate_deg: []	// rotate_deg[id_file] = 90/180
};

Config.winReload = function()
{
	location.reload();
}

Config.checkFileType = function(file, filetype)
{
	if(typeof(filetype) == "undefined"){
		filetype = Config.filetypes;
	}
	var typeArr = filetype.split("|");
	var filePArr = file.split("\\");

	var fileArr = filePArr[filePArr.length-1].toLowerCase().split(".");
	var fileT = fileArr[fileArr.length-1];
	
	for(var i = 0; i < typeArr.length; i++){
		if(fileT == typeArr[i]){
			return true;
		}
	}
	
	return false;
}

Config.goToLogin = function()
{
	setTimeout("javascript:top.location.href='/user/loginpage'", 1000);
	//setTimeout("javascript:top.location.href='login.php?login_action=login'", 1000);
};

Config.init = function()
{
    Config.rootPath = $("#_yovim_site_path").val();
    Config.jsPath = Config.rootPath+Config.jsPath;
    Config.cssPath = Config.rootPath+Config.cssPath;
    Config.imgPath = Config.rootPath+Config.imgPath;
    Config.uploadPath = Config.rootPath+Config.uploadPath;
    Config.assetPath = Config.rootPath+Config.assetPath;
    Config.convertPath = Config.rootPath+Config.convertPath;
};

Config.refreshCheck = function()
{
	$(document).bind("keydown", function(e){   
		e = window.event || e;
		if(e.keyCode == 116){
			if($('#file_editbox').css('display') != 'none'){
				if(confirm("You have not save the file information, are you sure to refresh page ?")){
					return true;
				}else{
					e.keyCode = 0;
					return false;// don't use F5
				}
			}
			
			return true; 
		}
	});

}

Config.resize = function(){

}

Config.windowInit = function()
{
	var resizeTimer = null;
	$(window).bind('resize', function(){
		//if(resizeTimer) clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function(){Config.resize()},100);	
	});
}
Config.dataInit = function(){
	User.cur_id = $("#_u_id").val();
	User.cur_level = $("#_u_lvl").val();
	User.cur_name = $("#_u_name").val();
	
	User.getList();
}

var Common = {
	jApplet_enable: 1,
	helpObj: 0,
    editor: new Array([])
};

/**
* date: 2014-04-12 12:00:00
* is_sec: 1=return the second time, or return millisecond
*/
Common.dateToTime = function(date, is_sec)
{
    var new_str = date.replace(/:/g,'-');
	
    new_str = new_str.replace(/ /g,'-');
	
    var arr = new_str.split("-");
    var datum = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
	
	if(typeof is_sec != 'undefined' && is_sec == 1){
		return datum.getTime()/1000;
	} else{
		return datum.getTime();
	}
}
Common.timeToDate = function(time, format)
{
	if(typeof format == 'undefined'){
		format = "yyyy-MM-dd";
	}
	var d = new Date(time);
	var date = d.format(format);
	
	return date;
}

Common.inputInfoFocus = function(obj, type, info)
{
	if(type == 'focus' && $(obj).val() == info){
		$(obj).val("");
		$(obj).css("color", "#000");
	}
	
	else if(type == 'blur' && ($(obj).val() == info || $(obj).val() == '')){
		$(obj).val(info);
		$(obj).css("color", "#999");
	}else if(type == 'onchange' && $(obj).val() != info){
		$(obj).css("color", "#000");
	}else{
		$(obj).css("color", "#000");
	}
}


Common.isJson = function(obj){
	return typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
}

Common.str2json = function(data){
    return eval("("+data+")");
}

Common.inArray = function(testArr, string)
{
	if((testArr instanceof Array) == false || string.length <= 0){
		return false;
	}
	
	var i = 0;
	var len = testArr.length;
	var in_array = false;
	string = string.toLowerCase();
	
	for(i = 0; i < len; i++){
		if(string == testArr[i].toLowerCase()){
			in_array = true;
			break;
		}
	}
	
	return in_array;
}

Common.multiSplit = function(str, delimt)
{
	for(var i = 0; i < delimt.length; i++){
		str = str.replace(/>/g, "/");
	}
	str = str.replace(/>/g, "/");
}

Common.getKeyboard = function()
{
	$(document).bind("keydown", function(e){   
		e = window.event || e;
		alert(e.keyCode);
		/*if(e.keyCode == 116){
			if($('#file_editbox').css('display') != 'none'){
				if(confirm("You have not save the file information, are you sure to refresh page ?")){
					return true;
				}else{
					e.keyCode = 0;
					return false;// don't use F5
				}
			}
			
			return true; 
		}*/
	});

}

Common.filter = function(str)
{
    str = str.replace(/\+/g,"%2B");
    str = str.replace(/\&/g,"%26");
	
    return str;
}

Common.removeHTMLTag = function(str) {
	str = str.replace(/<\/?[^>]*>/g,''); //去除HTML tag
	//str = str.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
	//str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
	//str=str.replace(/ /ig,'');//去掉 
	return str;
};

/**
 * init the kindeditor
 * @param key       : the instance of each the kindeditor
 * @param element   : the editor box
 * @param loadType  1=the js code is ready,2= js code is not ready
 */
Common.kindeditor = function(key, element, loadType)
{
    if(typeof(loadType) == 'undefined') {
        loadType = 1;
    }

    if(typeof(Common.editor[key]) != 'undefined'){
        return true;
    }

    if(loadType == 1){
        Common.editor[key] = KindEditor.create(element, {
            resizeType : 2,
            langType : 'en',
            minWidth : 680,
            themesPath: Config.jsPath+"themes_kindED/",
            langPath: Config.jsPath+"lang_kindED/",
            pluginsPath: Config.jsPath+"plugins_kindED/",
            allowPreviewEmoticons : false,
            allowImageUpload : false/*,
            items : [
                'source', 'undo', 'redo', 'preview', 'print', 'fontname', 'fontsize', '|', 'forecolor',
                'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'fullscreen']*/
        });
    } else if(loadType == 2) {
        KindEditor.ready(function(K) {
            Common.editor[key] = K.create(element, {
                resizeType : 2,
                langType : 'en',
                themesPath: Config.jsPath+"themes_kindED/",
                langPath: Config.jsPath+"lang_kindED/",
                pluginsPath: Config.jsPath+"plugins_kindED/",
                allowPreviewEmoticons : false,
                allowImageUpload : false/*,
                items : [
                    'source', 'undo', 'redo', 'preview', 'print','fontname', 'fontsize', '|', 'forecolor',
                    'hilitecolor', 'bold', 'italic', 'underline',
                    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                    'insertunorderedlist', '|', 'emoticons', 'image', 'link','fullscreen']*/
            });
        });
    }

    //Document.editor.sync();	// brefore submit, create new data
}

var Cookie = {
	pre: '',
	domain: '',
	path: '/'
};
Cookie.get = function(name){
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while(i < clen) {
		var j = i + alen;
		if(document.cookie.substring(i, j) == arg) return Cookie.getval(j);
		i = document.cookie.indexOf(" ", i) + 1;
		if(i == 0) break;
	}
	return null;
};

Cookie.set = function(name, value, time){
	if(typeof(name) == "undefined" || name == ""){
		name = Cookie.name;
	} else {
		Cookie.name = name;
	}
	
    name = Cookie.pre + name;
	
	var cookie = name + "=" + value + ("; path=" + Cookie.path) +
        ((Cookie.domain == '') ? "" : ("; domain=" + Cookie.domain));
		
	if(typeof(time) != "undefined"){
		var expire = new Date();
		expire.setTime(expire.getTime() + time);
		cookie += ";expires=" + expire.toGMTString();
	}
	
	document.cookie = cookie;
};

Cookie.getval = function(offset){
	var endstr = document.cookie.indexOf (";", offset);
	if(endstr == -1)
	endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
};

var User = {
	list: {},
	cur_id: 0,
	cur_level: 0,
	cur_name: ""
};

User.login = function(formId)
{
	var username = $(formId).find("input[name='username']").val();
	var password = $(formId).find("input[name='password']").val();
	
	if(username == '' || password == ''){
		MsgBox.show(0, "Input incorrect, check please!");
		$("#username").focus();
		return false;
	}
	
	$.ajax({
		url:'login.php',
		type:'post',
		data:'username='+username+'&password='+hex_md5(password)+'&user_action=login',
		dataType: 'json',
		beforeSend:function(){	
			MsgBox.show(3);
		},
		error:function()
		{
			MsgBox.show(0, 'Error: Page Load Error.');
		},
		success:function(rs)
		{
			if(rs.status == 1){
				MsgBox.show(1, rs.msg);
				
				$("#loginsubmit").focus();
				MsgBox.show(3);
				top.location.href = "index.php";
			}else{
				$("#username").focus();
				MsgBox.show(0, rs.msg);
			}
		}
	});
}

User.logout = function()
{
	Cookie.set('bpg_userinfo', '');
	var url = 'login.php?user_action=logout';
	
	top.location.href = url;
}

User.adminLogout = function()
{
	
}

User.getList = function()
{
	$.ajax({
		url:'user.php',
		type:'post',
		data:'user_action=list',
		dataType: 'json',
		beforeSend:function(){	
			//MsgBox.show(3);
		},
		error:function()
		{
			//MsgBox.show(0, 'Error: Page Load Error.');
		},
		success:function(rs)
		{
			if(rs.status == 1){
				User.list = rs.list;
			}
		}
	});
}

User.getById = function(id_user)
{
	if(User.list.length <= 0){
		return false;
	}
	for(var i=0; i<User.list.length; i++){
		if(User.list[i].user_id == id_user){
			return User.list[i];
		}
	}
	
	return false;
}

/**
 * form ......
 */
var Form = {};

Form.screenwh = function(){
    var body = (document.compatMode && document.compatMode.toLowerCase() == "css1compat") ? document.documentElement : document.body;
    var width = parseInt(body.clientWidth);
    var height = parseInt(body.clientHeight);
    return {width:width,height:height};
};

Form.reset = function(formID, exceptNameArr)
{
    $(formID)[0].reset();

    $(formID).find("input").each(function(){
        if(Common.inArray(exceptNameArr, $(this).attr("name"))){
            return true;
        }
        $(this).val("");
    });
}

var TableHeaderMenu = {};

TableHeaderMenu.fixWidthTable = function(percent){
	return TableHeaderMenu.getWidth(0.6) * percent;
}  
  
TableHeaderMenu.getWidth = function(percent){
	return $(window).width() * percent;  
} 

TableHeaderMenu.createColumnMenu = function(id_menu, id_list){
	var name_menu = id_menu.substr(1);
	var tmenu = $('<div id="'+name_menu+'" style="width:100px;"></div>').appendTo('body');  
	var fields = $(id_list).datagrid('getColumnFields'); 
	
	for(var i=0; i<fields.length; i++){ 
		var option = $(id_list).datagrid('getColumnOption', fields[i]); 
		
		$('<div iconCls="icon-ok"/>').html(option.title).appendTo(tmenu);  
	}  
	tmenu.menu({  
		onClick: function(item){  
			if (item.iconCls=='icon-ok'){  
				var fields = $(id_list).datagrid('getColumnFields');  
				for(var i=0; i<fields.length; i++){ 
					var option = $(id_list).datagrid('getColumnOption', fields[i]); 
					if(option.title == item.text){
						$(id_list).datagrid('hideColumn', option.field);  
					}
				} 
				
				tmenu.menu('setIcon', {  
					target: item.target,  
					iconCls: 'icon-empty'  
				});  
			} else {  
				var fields = $(id_list).datagrid('getColumnFields');  
				for(var i=0; i<fields.length; i++){ 
					var option = $(id_list).datagrid('getColumnOption', fields[i]); 
					if(option.title == item.text){
						$(id_list).datagrid('showColumn', option.field);  
					}
				} 
				tmenu.menu('setIcon', {  
					target: item.target,  
					iconCls: 'icon-ok'  
				});  
			}  
		}  
	});  
};

var Ak_Source = {
    name:   'source'
};

Ak_Source.laud = function(id_source, obj){
    $.AimsProcess.run({
        name    : Ak_Source.name,
        keyword : 'sourceLaud',
        url     : Config.rootPath+'recommend/laud',
        data    : 'id_source='+id_source,
        success :function(rs)
        {
            AdminMessager.show(rs.status, rs.msg);

            if(rs.status == 1){
                $(obj).find("span.laud_num").html("("+rs.data.laud_num+")");
            }
        }
    });
};