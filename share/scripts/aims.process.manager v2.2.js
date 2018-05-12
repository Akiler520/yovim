/**
 * Manager of ajax request
 *
 * Author: Akiler
 * Date: 2014-08-15
 */
/**
 * usage: (key = name+keyword)
 *      runBar = $.AimsProcess.run({
                key: processID,
                url: 'testProcess.php',
                data: 'test=processTest',
                timeout: 12000,
                priority: priority,
                loop: -1,
                interval: 5000,
                success: function(data) {
                    console.log("Get Info: "+data.test);
                }
            });
        or
        runBar = $.AimsProcess.run({
                name: "test",
                keyword: "test keyword",
                url: 'testProcess.php',
                data: 'test=processTest',
                timeout: 12000,
                priority: priority,
                loop: -1,
                interval: 5000,
                success: function(data) {
                    console.log("Get Info: "+data.test);
                }
            });
 */
(function($){
    var AimsProcess = {
        managerBar: 0,      // time interval to manage the running process
        store: new Array([]), // store the registered process
        /**
         * parameters of ajax request
         */
        param: {
            url: '',
            type: 'POST',
            data: '',
            dataType: 'JSON',
            timeout: 15000,     // 15 seconds
            beforeSend: function(){
                $.messager.progress({
                    title   :'Please waiting',
                    msg     :'Loading data...'
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                // Reset the status of process function

                for(var key_store in AimsProcess.store){
                    if(!AimsProcess.store.hasOwnProperty(key_store)){
                        continue;
                    }
                    if(XMLHttpRequest == AimsProcess.store[key_store].processXHR){
                        AimsProcess.abort(key_store);
                        break;
                    }
                }

                AdminMessager.show(2, 'Error: ' + textStatus + '.');
            },
            success: function(data, textStatus, XMLHttpRequest){
//                console.log("status:"+XMLHttpRequest.status);
//                console.log("readyState:"+XMLHttpRequest.readyState);

                // Reset the status of process function after success process;
                for(var key_store in AimsProcess.store){
                    if(!AimsProcess.store.hasOwnProperty(key_store)){
                        continue;
                    }
                    if(XMLHttpRequest == AimsProcess.store[key_store].processXHR){
                        AimsProcess.abort(key_store);
                        break;
                    }
                }

                $.messager.progress('close');
            }
        },
        /**
         * register new process function
         *
         * @param name      required
         * @param keyword   required
         * @param timeout   not required
         *
         * @returns {string}
         */
        register: function(name, keyword, timeout){
            if(typeof name == 'undefined' || typeof keyword == 'undefined'){
                return false;
            }

            // use default timeout setting, if user don't set it
            if(typeof timeout == 'undefined'){
                timeout = this.param.timeout;
            }

            var key = name+'-'+keyword;

            if(typeof  this.store[key] == 'undefined'){
                this.store[key] = {name: name, priority: 0, timeout: timeout, start:0, processXHR:0};
            }

            return key;
        },
        /**
         * run the process request
         *
         * @param param
         * @returns {boolean}
         */
        run: function(param){
            // check key, or check name and priority
            if(typeof param.key == 'undefined' && (typeof param.name == 'undefined' || typeof param.keyword == 'undefined')){
                return false;
            }

            // register the process, if the process is not registered
            if(typeof  this.store[param.key] == 'undefined'){
                param.key = this.register(param.name, param.keyword, param.timeout);
            }

            /**
             * check if the process request is running:
             *      yes: check the priority of new process, if the equal or litter, ignore it, or abort old one.
             *      no: create new process
             */

            // process is running
            if(this.store[param.key].start > 0){
                if(typeof param.priority != 'undefined' && param.priority > this.store[param.key].priority){
                    this.store[param.key].priority = param.priority;
                    if(!this.abort(param.key)){
                        return false;
                    }
                }else{
                    return false;
                }
            }

            // start to run the process
            var dt = new Date();

            this.store[param.key].start = dt.getTime();

            // combine the parameters of user and system
            var ajax_param = $.extend({}, this.param, param);

            // run both beforeSend function of user and system
            ajax_param.beforeSend = function(data, textStatus, XMLHttpRequest){
                if(typeof param.beforeSend != 'undefined') param.beforeSend(data, textStatus, XMLHttpRequest);
                AimsProcess.param.beforeSend(data, textStatus, XMLHttpRequest);
            };

            // run both success function of user and system
            ajax_param.success = function(data, textStatus, XMLHttpRequest){
                if(typeof param.success != 'undefined') param.success(data, textStatus, XMLHttpRequest);
                AimsProcess.param.success(data, textStatus, XMLHttpRequest);
            };

            // run both error function of user and system
            ajax_param.error = function(XMLHttpRequest, textStatus, errorThrown){
                if(typeof param.error != 'undefined') param.error(XMLHttpRequest, textStatus, errorThrown);
                AimsProcess.param.error(XMLHttpRequest, textStatus, errorThrown);
            };

            // setting of loop
            if(typeof param.loop != 'undefined' && param.loop >= 0){
                this.store[param.key].loop = param.loop;    // -1: never loop, 0: loop forever, 0 < : loop by times

                // the interval of loop, must greater or equal 1 second;
                var loop_interval = (typeof param.interval != 'undefined' && param.interval >= 1000) ? param.interval: 10000;
                this.store[param.key].loopCount = 1;

                // run it once first
                AimsProcess.store[param.key].processXHR = $.ajax(ajax_param);

                // start to loop
                this.store[param.key].loopBar = setInterval(function(){
                    AimsProcess.store[param.key].processXHR = $.ajax(ajax_param);
                    AimsProcess.store[param.key].loopCount++;
                }, loop_interval);
            }else{
                this.store[param.key].loop = -1;    // -1= not loop
                this.store[param.key].loopBar = -1;
                this.store[param.key].loopCount = 0;

                // run ajax request
                this.store[param.key].processXHR = $.ajax(ajax_param);
            }

            return this.store[param.key];
        },
        /**
         * manage the processing function
         * check if is expired, if so, abort it
         */
        manager: function(){
            this.managerBar = setInterval(function(){
                var dt = new Date();
                var curTime = dt.getTime();

                for(var key_store in AimsProcess.store){
                    if(!AimsProcess.store.hasOwnProperty(key_store)){
                        continue;
                    }
                    var processObj = AimsProcess.store[key_store];

                    if(typeof processObj.start == 'undefined' || processObj.start <= 0){
                        continue;
                    }

                    // abort the process, when the process is running and expired
                    if(processObj.start > 0 && (curTime-processObj.start) > processObj.timeout){
                        AimsProcess.abort(key_store);
                    }

                    // abort the process, when the loop is reached
                    if(processObj.loop > 0 && processObj.loop <= processObj.loopCount){
                        clearInterval(processObj.loopBar);
                        //AimsProcess.abort(key_store);
                    }
                }
            }, 1000);
        },
        /**
         * get the object of process
         * @param key_process
         * @returns {*}
         */
        getProcessByKey: function(key_process){
            for(var key_store in AimsProcess.store){
                if(!AimsProcess.store.hasOwnProperty(key_store)){
                    continue;
                }
                if(key_process == key_store){
                    return AimsProcess.store[key_store];
                }
            }

            return null;
        },
        /**
         * abort a pointed process function
         * @param key_store
         */
        abort: function(key_store){
            // get object of process
            var processObj = this.getProcessByKey(key_store);

            if(!processObj){
                return false;
            }

            // block to abort when the loop is running
            if(processObj.loop >= 0){
                return false;
            }
            processObj.processXHR.abort();
            processObj.processXHR = -1;
            processObj.start = 0;
            processObj.loop = -1;
            processObj.loopCount = 0;
            processObj.loopBar = -1;

            return true;
        },
        /**
         * abort all the registered process
         */
        abortAll:function(){
            for(var key_store in AimsProcess.store){
                if(!AimsProcess.store.hasOwnProperty(key_store)){
                    continue;
                }
                this.abort(key_store);
            }
        }
    };

    $.AimsProcess = AimsProcess;
    window.AimsProcess = AimsProcess;
})(jQuery);