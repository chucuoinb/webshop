$.validator.addMethod("valid_length", function (value, element) {
        var len = value.length;
        return len >= 8 && len <= 20;
    }, "Please enter a between 8 and 20 character."
);
$.validator.addMethod("valid_username", function (value, element) {

        return /^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})([a-zA-Z0-9._]+)(?![_.])$/.test(value);
    }, "Please enter a valid username."
);

$.extend({
    Webshop: function (options) {
        var defaults = {
            url: '',
            errorMsg: 'Request timeout or server isn\'t responding, please reload the page.',
            msgTryError: '<p class="console-error">Request timeout or server isn\'t responding, please try again.</p>',
            msgTryWarning: '<p class="console-warning">Please try again.</p>',
            msgTryInstall: '<p class="console-success"> - Resuming install ...</p>',
            delay: 1000,
            retry: 30000
        };
        var settings = $.extend(defaults, options);
        return run();
        function run() {
            $(document).on('click','#form-config-db-submit',function () {
                var check = $('#form-config-db').valid();
                if (!check) {
                    return false;
                }
                showElement($('#form-loading'));
                var from_data =  $('#form-config-db').serialize();
                $.ajax({
                    url: settings.url,
                    type: 'POST',
                    dataType: 'json',
                    data: from_data,
                    success: function (response, textStatus, errorThrown) {
                        hideElement($('#form-loading'));
                        if (response.result == 'success') {
                            $('#setup-install-database').html(response.data);
                            $('#install-content-title').text('Install Database')
                            $('#setup-install-database').show();
                            $('#setup-config-database').hide();
                            successInstall($('#install-title-config'));
                            activeInstall($('#install-title-install'));
                            setTimeout(installDatabase,settings.delay)
                        } else {
                            consoleLog(response.msg);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        hideElement($('#form-loading'));
                        consoleLog(settings.msgTryError);
                    }
                });
            })

            $(document).on('click','#form-setup-web-submit',function () {
                var check = $('#form-setup-web').valid();
                if (!check) {
                    return false;
                }
            })

            $(document).on('click','#btn-retry-install-wrap',function () {
                hideElement($('#form-install-retry'));
                consoleLog(settings.msgTryInstall);
                installDatabase();
            });
        }

        function installDatabase() {
            showElement($('#form-loading'));
            var from_data =  $('#form-install-database').serialize();
            $.ajax({
                url: settings.url,
                type: 'POST',
                dataType: 'json',
                data: from_data,
                success: function (response, textStatus, errorThrown) {
                    hideElement($('#form-loading'));
                    if (response.result == 'process') {
                        if(response.msg){
                            consoleLog(response.msg);
                        }
                        setTimeout(installDatabase,settings.delay);
                    } else {
                        consoleLog(response.msg);
                        showElement($('#form-install-retry'));

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    hideElement($('#form-loading'));
                    consoleLog(settings.msgTryError);
                    showElement($('#form-install-retry'));
                    autoRetry('btn-retry-install-wrap');
                }
            });
        }

        function hideElement(element) {
            if(element.hasClass('display-block')){
                element.removeClass('display-block');
            }
            if(!element.hasClass('display-none')){
                element.addClass('display-none')
            }
        }
        function showElement(element) {
            if(element.hasClass('display-none')){
                element.removeClass('display-none');
            }
            if(!element.hasClass('display-block')){
                element.addClass('display-block')
            }
        }
        function successInstall(element){
            if(element.hasClass('install-active')){
                element.removeClass('install-active');
            }
            if(!element.hasClass('install-success')){
                element.addClass('install-success')
            }
        }
        function activeInstall(element){
            if(element.hasClass('install-success')){
                element.removeClass('install-success');
            }
            if(!element.hasClass('install-active')){
                element.addClass('install-active')
            }
        }
        function consoleLog(msg) {
            var element = $('#console-log-install');
            if (element.length > 0) {
                element.append(msg);
                element.animate({scrollTop: element.prop("scrollHeight")});
            }
        }
        function autoRetry(elm){
            if(settings.retry > 0){
                setTimeout(function(){triggerClick(elm)}, settings.retry);
            }
        }
        function triggerClick(elm){
            var par_elm =  $('#form-install-retry');
            var check_show = checkElementShow(par_elm);
            var button = par_elm.children('div');
            if(check_show){
                button.trigger('click');
            }
        }
        function checkElementShow(elm){
            var check = $(elm).is(':visible');
            return check;
        }
        // function consoleSuccess(msg) {
        //     return '<p class="console-success">'+ msg +'</p>'
        // }
    }
});