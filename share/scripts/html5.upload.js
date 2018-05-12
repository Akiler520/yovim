/**
 * Html5 upload function
 *
 * Author: Akiler
 * Date: 2014-10-30
 */
(function($){
    $.fn.YovUpload = function(settings) {
        settings = $.extend({}, $.fn.YovUpload.sn.defaults, settings);

        this.each(function() {
            var fileBarObj = $(this);

            fileBarObj.off('change');

            fileBarObj.on('change', function(){
                YovUpload.fileCheck();
            });

            var YovUpload = {
                /**
                 * settings of upload function
                 */
                settings: settings,

                /**
                 * init upload function
                 */
                init    : function(){
                    $(YovUpload.settings.mainID).find(YovUpload.settings.triggerBtn).off('click');
                    $(YovUpload.settings.mainID).find(YovUpload.settings.cancelBtn).off('click');

                    $(YovUpload.settings.mainID).find(YovUpload.settings.triggerBtn).on('click', function(){
                        YovUpload.upload();
                    });

                    $(YovUpload.settings.mainID).find(YovUpload.settings.cancelBtn).on('click', function(){
                        YovUpload.cancel(fileBarObj);
                    });

                    if(YovUpload.settings.isUnique && YovUpload.settings.isUpdate){
                        YovUpload.settings.postData['hash'] = YovUpload.settings.hashCode;
                    }
                },
                /**
                 * gather data and begin to upload
                 * @returns {boolean}
                 */
                upload: function () {
//                  var fd = document.getElementById(YovUpload.settings.formID).getFormData();
                    var fd = new FormData();

                    /*fd.append("author", "Shiv Kumar");
                     fd.append("name", "Html 5 File API/FormData");
                     fd.append("fileToUpload", document.getElementById('fileToUpload').files[0]);*/

                    if(YovUpload.settings.postData != null){
                        for(formKey in YovUpload.settings.postData){
                            if(!YovUpload.settings.postData.hasOwnProperty(formKey)){
                                continue;
                            }

                            fd.append(formKey, YovUpload.settings.postData[formKey]);
                        }
                    }

                    // document.getElementById(fileBarObj.attr('name')) = fileBarObj.get(0)
                    fd.append(fileBarObj.attr('name'), fileBarObj.get(0).files[0]);

                    YovUpload.settings.xhr = new XMLHttpRequest();
                    YovUpload.settings.xhr.upload.addEventListener("progress", YovUpload.progress, false);
                    YovUpload.settings.xhr.addEventListener("load", YovUpload.completed, false);
                    YovUpload.settings.xhr.addEventListener("error", YovUpload.failed, false);
                    YovUpload.settings.xhr.addEventListener("abort", YovUpload.cancel, false);
                    YovUpload.settings.xhr.open("POST", YovUpload.settings.url);
                    YovUpload.settings.xhr.send(fd);

                    $(YovUpload.settings.mainID).find(YovUpload.settings.triggerBtn).show();
                    $(YovUpload.settings.mainID).find(YovUpload.settings.progressBar).show();
                    $(YovUpload.settings.mainID).find(YovUpload.settings.progressBar).next().show();

                    return true;
                },

                /**
                 * check if the file is valid
                 * @returns {boolean}
                 */
                fileCheck: function () {
                    var file = fileBarObj.get(0).files[0];
                    var fileName = file.name;
                    var file_typename = fileName.substring(fileName.lastIndexOf('.')+1, fileName.length);
                    var msg = '';

                    $(YovUpload.settings.mainID).find(YovUpload.settings.triggerBtn).hide();

                    // check the type of file
                    if (Common.inArray(YovUpload.settings.fileType, file_typename)) {
                        if (file) {
                            if(file.size > (1024 * 1024 * YovUpload.settings.maxSize)){
                                msg = "<span style='color:Red'>Error: Max support size: "+YovUpload.settings.maxSize+" MB</span>";
                                $.messager.alert('Error', msg,'error');
                                return false;
                            }

                            if(YovUpload.settings.isUnique){
                                YovUpload.getMd5();
                            }else{
                                YovUpload.init();
                                $(YovUpload.settings.mainID).find(YovUpload.settings.triggerBtn).show();
                            }
                        }
                    }
                    else {
                        msg = "<span style='color:Red'>Error: File type incorrect, support: " + YovUpload.settings.fileType + "</span>";
                        $.messager.alert('Error', msg,'error');

                        return false;
                    }

                    return true;
                },

                getMd5: function(){
                    //声明必要的变量
                    var fileReader = new FileReader();
                    //文件分割方法（注意兼容性）
                    var blobSlice = File.prototype.mozSlice || File.prototype.webkitSlice || File.prototype.slice;
                    var file = fileBarObj.get(0).files[0];

                    //文件每块分割 1M=1048576, 2M=2097152 ，计算分割详情
                    var chunkSize = 1048576;   // 2097152
                    var chunks = Math.ceil(file.size / chunkSize);
                    var currentChunk = 0;

                    //创建md5对象（基于SparkMD5）
                    var spark = new SparkMD5();

                    //每块文件读取完毕之后的处理
                    fileReader.onload = function(e) {
                        console.log("hashed ", currentChunk + 1, "/", chunks);
                        //每块交由sparkMD5进行计算
                        spark.appendBinary(e.target.result);
                        currentChunk++;

                        //如果文件处理完成计算MD5，如果还有分片继续处理
                        if (currentChunk < chunks) {
                            loadNext();
                        } else {
                            console.log("finished hash");

                            var hashCode = spark.end();
                            YovUpload.settings.hashCode = hashCode;

                            YovUpload.settings.uniqueCheck(hashCode, function(){
                                YovUpload.init();
                                $(YovUpload.settings.mainID).find(YovUpload.settings.triggerBtn).show();
                            });
                        }
                    };

                    //处理单片文件的上传
                    function loadNext() {
                        var start = currentChunk * chunkSize;
                        var end = start + chunkSize >= file.size ? file.size : start + chunkSize;

                        // read binary string by slice, when success, call fileReader.onload
                        fileReader.readAsBinaryString(blobSlice.call(file, start, end));
                    }

                    // trigger
                    loadNext();
                },

                /**
                 * run when uploading
                 * @param evt
                 */
                progress: function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                        $(YovUpload.settings.mainID).find(YovUpload.settings.progressBar).progressbar('setValue', percentComplete);
                    }
                    else {
                        $(YovUpload.settings.mainID).find(YovUpload.settings.progressBar).html("Error");
                    }
                },

                /**
                 * run when upload complete
                 * @param evt
                 */
                completed: function (evt) {
                    // get response data
                    var message = evt.target.responseText;

                    $(YovUpload.settings.mainID).find(YovUpload.settings.triggerBtn).hide();
                    $(YovUpload.settings.mainID).find(YovUpload.settings.progressBar).hide();
                    $(YovUpload.settings.mainID).find(YovUpload.settings.progressBar).next().hide();

                    YovUpload.settings.onSuccess(Common.str2json(message));
                },

                /**
                 * run when error happened
                 * @param evt
                 */
                failed: function (evt) {
                    var msg = "Error happen on upload!.";

                    YovUpload.settings.onError();
                    $.messager.alert('Error', msg,'error');
                },

                /**
                 * run when the upload function is aborted
                 * @param evt
                 */
                cancel: function (evt) {
                    YovUpload.settings.onCancel();
                    if(YovUpload.settings.xhr) YovUpload.settings.xhr.abort();
                }
            };
        });
    };

    $.fn.YovUpload.sn = {
        defaults: {
            triggerBtn      : "#uploadFile",                // the id of button to trigger the upload
            cancelBtn       : '#process-cancel-snapshot',   // the id of button to cancel upload
            progressBar     : "#process-bar-snapshot",      // the id of element to show the progress
            url             : "/admin_source/addfile",      // the url of server which data upload to
            fileType        : ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'rar', 'zip'],   // allowed extension
            maxSize         : 10,                   // allowed max file size, default is 10 MB
            mainID          : "#fileUploadForm",    // the id of main box to contains all of the upload elements
            postData        : new Array([]),        // data need to transfer to server: key=>value
            uniqType        : "source_file",
            hashCode        : "",
            isUnique        : false,                // if to do unique check
            isUpdate        : false,                // if true, send the hash code to server
            xhr             : null,                 // XMLHttpRequest
            /**
             * run when upload successful
             */
            onComplete: function(){},

            /**
             * run when error happened
             */
            onError: function(){},

            /**
             * run when error happened
             */
            onCancel: function(){},

            /**
             * check if the file is exist on server
             */
            uniqueCheck: function(hash, callBack){
                callBack();
            }
        }
    };
})(jQuery);
