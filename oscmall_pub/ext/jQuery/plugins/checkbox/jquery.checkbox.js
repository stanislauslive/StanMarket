/**
 * jQuery custom checkboxes
 * 
 * Copyright (c) 2008 Khavilo Dmitry (http://widowmaker.kiev.ua/checkbox/)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * @version 1.0.0
 * @author Khavilo Dmitry
 * @mailto wm.morgun@gmail.com
**/
(function ($){
    $.fn.checkbox = function(options) {
        /* IE < 7.0 background flicker fix */
        if (jQuery.browser.msie && (parseFloat(jQuery.browser.version) < 7)){
            document.execCommand('BackgroundImageCache', false, true);	
        }
        
        /* Default settings */
        var settings = {
            theme: 'default', /* Theme */
            cls: 'jquery-checkbox-',  /* checkbox  */
            empty: 'images/pixel_trans.gif'  /* checkbox  */
        };
        
        /* Processing settings */
        settings = $.extend(settings, options || {});
        
        /* Wrapping all passed elements */
        var className = settings.cls + settings.theme;
        
        return this.each(function (){
            var $boxDiv = $('<div id="checkbox_container" class="' + className + '-box">');
            var $boxDiv1 = $('<div class="' + className + '">');
            var $boxDiv2 = $('<div class="mark">');
            var $checkboxImage = $('<img src="' + settings.empty + '">');
            
            /* Creating div for checkbox and assigning "hover" event */
            $boxDiv2.hover(function() {
                $('.' + className, this).addClass(className + '-hover');
            }, function() {
                $('.' + className, this).removeClass(className + '-hover');
            });
            
            /* Creating "click" event handler for checkbox wrapper*/
            $boxDiv.click(function(){
                $(':checkbox', this).trigger('togglecheck');
                var $checkBox = $(':checkbox', this);
                $checkBox.click();
            });
            
            if ($(this).attr('alt')){
                $checkboxImage.attr('alt', $(this).attr('alt'));
            }

            if ($(this).attr('title')){
                $checkboxImage.attr('title', $(this).attr('title'));
            }

            /* Disable image drag-n-drop  */
            $checkboxImage.bind('dragstart', function () {
                return false;
            }).bind('mousedown', function () {
                return false;
            });
            
            $boxDiv2.append($checkboxImage);
            $boxDiv1.append($boxDiv2);
            $boxDiv.append($boxDiv1);
            
            /* Wrapping checkbox */
            $(this).after($boxDiv).css({ display: 'none' }).appendTo($boxDiv2);
            
            $(this).bind('togglecheck', function (){
                if ($boxDiv.hasClass(className + '-checked')){
                    $boxDiv.removeClass(className + '-checked');
                    $(this).attr('checked', false);
                }else{
                    $boxDiv.addClass(className + '-checked');
                    $(this).attr('checked', true);
                }
            });
            
            if (this.disabled){
                $('.' + className, $boxDiv2).addClass(className + '-disabled');
            }else{
                $('.' + className, $boxDiv2).removeClass(className + '-disabled');
            }
            
            /* Firefox div antiselection hack */
            if (window.getSelection){
                $boxDiv.css('MozUserSelect', 'none');
            }
            
            /* Applying checkbox state */
            if (jQuery.browser.msie == true){
                if (this.wasChecked == 'true'){
                    this.checked = true;
                }
            }
            
            if (this.checked == true){
                $boxDiv.addClass(className + '-checked');
            }
            
            if (this.disabled){
                $('.' + className, $boxDiv2).addClass(className + '-disabled');
            }
        });
    };
})(jQuery);