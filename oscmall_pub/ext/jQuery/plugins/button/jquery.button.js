jQuery.fn.extend({
	button: function(options) {
		return this.each(function() {
			new jQuery.Button(this, options);
		});
	}
});

jQuery.Button = function(button, options) {
	var opt = options || {};
	var theme = $(button).attr('theme') || 'blue';
	opt.defaultClass = opt.defaultClass || 'jQuery-button_' + theme;
	opt.hoverClass = opt.hoverClass || 'jQuery-button_' + theme + '_hover';
	opt.downClass = opt.downClass || 'jQuery-button_' + theme + '_down';
	
    $(button).addClass(opt.defaultClass);
    if ($(button).attr('hidden') == 'true'){
        $(button).hide();
    }
    if (jQuery.browser.msie == true && jQuery.browser.version <= 6){
        $(button).hover(function() {
            $(this).addClass(opt.hoverClass);
        },function() {
            $(this).removeClass(opt.hoverClass);
            $(this).removeClass(opt.downClass);
        });
        $(button).mousedown(function() {
            $(this).addClass(opt.downClass);
        });
        $(button).mouseup(function() {
            $(this).removeClass(opt.downClass);
        });
    }
}