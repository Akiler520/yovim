/**
 * table controller
 *
 * Author: Akiler
 * Date: 2014-10-30
 */
(function($){
    $.fn.YovTable = function(settings) {
        settings = $.extend({}, $.fn.YovTable.sn.defaults, settings);

        if(settings.url == ''){
            return;
        }

        this.each(function() {
            if(typeof(settings.onHeaderContextMenu) == 'undefined'){
                settings.onHeaderContextMenu = function(e, field){
                    e.preventDefault();

                    var id_menu = "#yovim-admin-data-list-menu-"+new Date().getTime();

                    if (!$(id_menu).length){
                        TableHeaderMenu.createColumnMenu(id_menu, $(this));
                    }

                    $(id_menu).menu('show', {
                        left:e.pageX,
                        top:e.pageY
                    });
                }
            }
            // start to create table;
            $(this).datagrid(settings);
        });
    };

    $.fn.YovTable.sn = {
        defaults: {
            url             : '',
            width           : TableHeaderMenu.getWidth(0.6),
            height          : 'auto',
            fitColumns      : true,
            fit             : true,
            sortName        : "time_add",
            sortOrder       : "desc",
            remoteSort      : false,
            nowrap          : false,
            rownumbers      : true,
            pagination      : true,
            pageSize        : 10,
            singleSelect    : false,
            checkOnSelect   : true
        }
    };
})(jQuery);
