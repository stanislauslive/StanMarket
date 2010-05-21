/*
  Copyright (c) 2002 - 2006 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.
*/

jQuery.fn.extend({
	tinyMCE: function(options) {
	    var o = {
	        mode : "none",
            theme : "advanced",
            add_form_submit_trigger: false,
            debug: false
	    };
	      
	    if (options){
	        $.extend(o, options);
	    }
	      
		return this.each(function() {
		    if (typeof tinyMCE != 'undefined'){
		        if (this.style.display != 'none'){
		            var editor = new tinymce.Editor($(this).attr('id'), o);
					$(this).parent().prepend('<a href="#" onclick="$(\'#' + $(this).attr('id') + '\').tinyMCE_toggle();return false;">Toggle Editor</a><br><br>');
		            $(this).data('tinyMCE', editor);
		            $(this).data('tinyMCE').render();
		        }
		    }
		});
	},
	tinyMCE_remove: function (){
	    return this.each(function (){
	        if ($(this).data('tinyMCE')){
	            var editor = $(this).data('tinyMCE');
	            if (editor.isHidden() == false){
	                if (editor.isDirty()){
	                    editor.save();
	                }
	                editor.remove();
	            }
	        };
	    });
	},
	tinyMCE_toggle: function (){
	    return this.each(function (){
	        if ($(this).data('tinyMCE')){
	            var editor = $(this).data('tinyMCE');
	            if (editor.isHidden()){
				    editor.show();
	            }else{
				    editor.hide();
	            }
			}
        });
	},
	tinyMCE_triggerSave: function (){
	    return this.each(function (){
	        if ($(this).data('tinyMCE')){
	            var editor = $(this).data('tinyMCE');
	            if (editor.isHidden() == false){
	                $(this).val(editor.getContent());
	            }
	        }
	    });
	}
});
