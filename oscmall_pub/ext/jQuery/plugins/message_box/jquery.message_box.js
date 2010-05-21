(function ($){
    $.message_box = function (options){
        var o = {
            url: false,
            boxType: 'error', //Options Are: error, message, alert
            buttons: 'ok', //Options Are: ok, ok|cancel, ok|cancel|submit
            allowClose: false,
            text: 'Error Reported',
            heading: 'Error',
            buttonTheme: 'olive',
            modal: false,
            zIndex: 999
        };
            
        var buttonText = {
            ok: 'Ok',
            cancel: 'Cancel',
            submit: 'Submit'
        };
            
        $.extend(o, options);
            
        var prefix = 'message_box_' + o.boxType;
        var $docBody = $(document.body);
        var $window = $(window);
        
        var boxTemplate = '<div class="' + prefix + '_window"><div class="' + prefix + '_container">' + 
                           (o.url != false ? '<form name="' + prefix + '_form" id="' + prefix + '_form" action="' + o.url + '" method="post">' : '') + 
                           '<div class="' + prefix + '_header" valign="top"></div>' + 
                           '<div class="' + prefix + '_content" align="center"></div>' + 
                           '<div class="' + prefix + '_footer" valign="bottom"></div>' + 
                           (o.url != false ? '</form>' : '') + 
                          '</div></div>';
        
        var $boxTemplate = $(boxTemplate);
        
        var getWindowSize = function (){
            return {
                height: $window.height(),
                width: $window.width()
            };
        }
        
        var getBackgroundCSS = function (){
            return {
                position: 'absolute',
                background: '#ffffff',
                zIndex: 1,
                border: 'none',
                top: 0,
                left: 0,
                width: '100%',
                height: '100%',
                opacity: 0
            };
        }
            
        var getIframe = function (frameID){
            var iFrame = $('<IFRAME src="javascript:\'\';" frameBorder="0" scrolling="no" id="' + frameID + '" />');
          return iFrame;
        }
        
        var getBoxSize = function (){
            return {
                height: parseInt($boxTemplate.height()),
                width: parseInt($boxTemplate.width())
            };
        }
        
        var positionWindow = function (){
            var winSize = getWindowSize();
            var boxSize = getBoxSize();

            var fromLeft = Math.round((winSize.width/2) - (boxSize.width/2));
            var fromTop = Math.round((winSize.height/2) - (boxSize.height/2));
            
            $boxTemplate.css({
                top: fromTop,
                left: fromLeft
            });
        }
        
        var flickerBox = function (){
            var i = 0;
            jqib.addClass(o.prefix +'warning');
            var intervalid = setInterval(function(){ 
                jqib.toggleClass(prefix +'warning');
                if (i++ > 1){
                    clearInterval(intervalid);
                    jqib.removeClass(prefix +'warning');
                }
            }, 100);
        }
        
        if (o.modal == true && $('#' + prefix + '_background').size() <= 0){
            var winSize = getWindowSize();
            if ($.browser.msie == true){
                var $bgDisable = getIframe(prefix + '_background');
            }else{
                var $bgDisable = $('<div id="' + prefix + '_background" />');
            }
            $bgDisable.css(getBackgroundCSS()).css('width', winSize.width).css('height', winSize.height).click(function (){
                
            });
            $docBody.append($bgDisable);
        }
        
        $('.' + prefix + '_header', $boxTemplate).append(o.heading);
        $('.' + prefix + '_content', $boxTemplate).append(o.text);
        
        if (o.buttons == 'submit'){
            var $button = $('<button type="submit" theme="' + o.buttonTheme + '"></button>');
            $button.append('<span>' + eval('buttonText.' + o.buttons) + '</span>');
            if (typeof $.button != undefined){
                $button.button();
            }
            $button.bind('successful', function (){
                $(this).parent().parent().parent().remove();
                if (o.modal == true){
                    $('#' + prefix + '_background').remove();
                }
            });
            $('.' + prefix + '_footer', $boxTemplate).append($button);
        }else if (o.buttons != false){
            var buttons = o.buttons.split('|');
            for(var i=0; i<buttons.length; i++){
                var $button = $('<button type="button" theme="' + o.buttonTheme + '"></button>');
                $button.append('<span>' + eval('buttonText.' + buttons[i]) + '</span>');
                if (typeof $.button != undefined){
                    $button.button();
                }
                $button.unbind('click').click(function (){
                    $(this).trigger('callback');
                    $(this).parent().parent().remove();
                    if (o.modal == true){
                        $('#' + prefix + '_background').remove();
                    }
                });
                var callback = eval('o.' + buttons[i] + '_function');
                if (typeof callback == 'function'){
                    $button.bind('callback', callback);
                }
                $('.' + prefix + '_footer', $boxTemplate).append($button);
            }
        }

        $boxTemplate.css({
            position: 'absolute',
            width: 300,
            zIndex: o.zIndex
        });
        
        $window.resize(positionWindow);
        $docBody.prepend($boxTemplate);
        positionWindow();
        
        if ($.browser.msie == true && o.modal != true){
            $('.' + prefix + '_container', $boxTemplate).bgiframe({ opacity: false });
        }
        
        if (typeof $.fn.jqDrag != 'undefined'){
            $('.' + prefix + '_window').jqDrag('.' + prefix + '_header');
            $('.' + prefix + '_header').hover(function (){
                this.style.cursor = 'move';
            }, function (){
                this.style.cursor = 'default';
            });
        }
    }
    
    $.ajax_error_message_box = function (XMLHttpRequest, textStatus, errorThrown){
        $.message_box({
            text: 'There was an error with the ajax Request.<br>Status: ' + textStatus + '<br>Error: ' + errorThrown + '<br>Return: <textarea rows="3" cols="50">' + XMLHttpRequest.responseText + '</textarea>',
            allowClose: false,
            modal: true,
            zIndex: 2000
        });
    }
    
    $.ajax_unsuccessful_message_box = function (data){
        if (typeof data.errorType != 'undefined'){
            if (data.errorType == 'login'){
                $.ajax_login_message_box(data);
            }
        }else{
            $.message_box({
                boxType: 'warning',
                text: data.errorMsg,
                allowClose: false,
                modal: true,
                zIndex: 1500
            });
        }
    }
    
    $.ajax_progress_message_box = function (percent, config){
        if ($('#message_box_progress_window').size() <= 0){
            $.message_box({
                heading: 'Operation Progress',
                boxType: 'progress',
                text: '<span class="progressBar" id="progressBar"></span>',
                buttons: false,
                allowClose: false,
                modal: true,
                zIndex: 1500
            });
        }
        
        var $windowObj = $('#message_box_progress_window');
        
        if (percent == 'close'){
            $windowObj.remove();
            if ($('#message_box_progress_background').size() > 0){
                $('#message_box_progress_background').each(function (){
                    $(this).remove();
                });
            }
        } else {
            $('#progressBar', $windowObj).each(function (){
                if (percent == 100){
                    $(this).progressBar(100, {
                        onComplete: function (){
                            $.ajax_progress_message_box('close');
                        }
                    });
                }else{
                    $(this).progressBar(percent, config);
                }
            });
        }
    }
    
    $.ajax_login_message_box = function (data){
        var html = '<table cellpadding="3" cellspacing="0" border="0">' + 
                    '<tr>' + 
                     '<td colspan="2" class="main">' + data.errorMsg + '</td>' + 
                    '</tr>' + 
                    '<tr>' + 
                     '<td class="main">Email Address: </td>' + 
                     '<td><input type="text" name="email_address" id="email_address"></td>' + 
                    '</tr>' + 
                    '<tr>' + 
                     '<td class="main">Password: </td>' + 
                     '<td><input type="password" name="password" id="password"></td>' + 
                    '</tr>' + 
                   '</table>';
                   
        $.message_box({
            url: 'login.php?action=process',
            boxType: 'login',
            text: html,
            buttons: 'submit',
            allowClose: false,
            modal: true,
            zIndex: 1250
        });
        
        $('#message_box_login_form').ajaxForm({
            cache: false,
            dataType: 'json',
            success: function (data){
                if (data.success == true){
                    $('button', $('#message_box_login_form')).trigger('successful');
                }else{
                    $.ajax_unsuccessful_message_box(data);
                    $('#message_box_login_form').parent().hide();
                    $('button', $('.message_box_warning_window')).unbind('click').click(function (){
                        $(this).parent().parent().remove();
                        $('#message_box_login_form').parent().show();
                    });
                }
            }
        });
    }
})(jQuery);