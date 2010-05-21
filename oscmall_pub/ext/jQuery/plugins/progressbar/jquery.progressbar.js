/*
 * jQuery Progress Bar plugin
 * Version 1.1.0 (06/20/2008)
 * @requires jQuery v1.2.1 or later
 *
 * Copyright (c) 2008 Gary Teo
 * http://t.wits.sg

USAGE:
	$(".someclass").progressBar();
	$("#progressbar").progressBar();
	$("#progressbar").progressBar(45);							// percentage
	$("#progressbar").progressBar({showText: false });			// percentage with config
	$("#progressbar").progressBar(45, {showText: false });		// percentage with config
*/

(function (){
    $.fn.progressBar = function (percent, config){
        var o = {
            id          : $(this).attr('id'),
            increment   : 1,
		    speed       : 'fast',
			showText    : true,
			width       : 120,
			boxImage    : '/peter/oscmall_dev/ext/jQuery/plugins/progressbar/images/progressbar.gif',
			barImage    : '/peter/oscmall_dev/ext/jQuery/plugins/progressbar/images/progressbg_green.gif',
			height      : 12
        }
            
        config = config || {};
        $.extend(o, config);
            
        var bar = {
            barObj: $(this),
            config: o,
            buildBarObj: function (){
                bar.barObj = $('<img />').attr({
                    id: o.id + '_percentImage',
                    src: o.boxImage
                }).css({
                    width: o.width,
                    height: o.height,
                    backgroundImage: 'url(' + o.barImage + ')',
                    backgroundPosition: -(o.width),
                    padding: '0',
                    margin: '0'
                });
                
                bar.barText = $('<span />').attr('id', o.id + '_percentText');
            },
            updateBarPercent: function (percentage){
                var pixels = o.width / 100;
                bar.barObj.animate({
                    backgroundPosition: (((o.width * -1)) + (percentage * pixels))
                }, { 
                    duration: o.speed,
                    complete: (typeof o.onComplete != 'undefined' ? o.onComplete : false)
                });
            }
        };
        
        return $(this).each(function (){
            if (typeof $(this).data('bar') == 'undefined'){
                bar.buildBarObj();
                $(this).append(bar.barObj);
                $(this).append(bar.barText);
                $(this).data('bar', bar);
            }
            
            $(this).data('bar').updateBarPercent(percent);
        });
    }
})(jQuery);
/*
(function($) {
	$.extend({
		progressBar: new function() {

			this.defaults = {
				increment	: 1,
				speed		: 20,
				showText	: true,											// show text with percentage in next to the progressbar? - default : true
				width		: 120,											// Width of the progressbar - don't forget to adjust your image too!!!
				boxImage	: '/peter/oscmall_dev/ext/jQuery/plugins/progressbar/images/progressbar.gif',		// boxImage : image around the progress bar
				barImage	: '/peter/oscmall_dev/ext/jQuery/plugins/progressbar/images/progressbg_green.gif',	// Image to use in the progressbar. Can be an array of images too.
				height		: 12											// Height of the progressbar - don't forget to adjust your image too!!!
			};
			
			this.construct = function(arg1, arg2) {
				var argpercentage	= null;
				var argconfig		= null;
				
				if (arg1 != null) {
					if (!isNaN(arg1)) {
						argpercentage 	= arg1;
						if (arg2 != null) {
							argconfig	= arg2; }
					} else {
						argconfig		= arg1; 
					}
				}
				
				return this.each(function(child) {
					var $this	= $(this);
					if (argpercentage != null && this.bar != null && this.config != null) {
						this.config.tpercentage	= argpercentage;
						if (argconfig != null)
							this.config			= $.extend(this.config, argconfig);
					} else {
						var config				= $.extend({}, $.progressBar.defaults, argconfig);
						var percentage			= argpercentage;
						if (argpercentage == null)
							var percentage		= $this.html().replace("%","");	// parsed percentage
						
						
						$this.html("");
						var bar					= document.createElement('img');
						var text				= document.createElement('span');
						bar.id 					= this.id + "_percentImage";
						text.id 				= this.id + "_percentText";
						bar.src					= config.boxImage;
						bar.width				= config.width;
						var $bar				= $(bar);
						var $text				= $(text);
						
						this.bar				= $bar;
						this.text				= $text;
						this.config				= config;
						this.config.cpercentage	= 0;
						this.config.tpercentage	= percentage;
						
						$bar.css("width", config.width + "px");
						$bar.css("height", config.height + "px");
						$bar.css("background-image", "url(" + config.barImage + ")");
						$bar.css("padding", "0");
						$bar.css("margin", "0");
						$this.append($bar);
						$this.append($text);
						
						bar.alt				= this.tpercentage;
						bar.title			= this.tpercentage;
					}
					
					var config		= $this[0].config;
					var cpercentage = config.cpercentage;
					var tpercentage = config.tpercentage;
					var text		= $this[0].text;
					var pixels		= config.width / 100;			// Define how much pixels go into 1%
						
					this.bar.animate({ 
					    backgroundPosition: (percentage * pixels)
					}, this.config.speed);

					if (config.showText)
						text.html(" " + cpercentage + "%");

					
					
					
					var t = setInterval(function() {
						
						bar.css("background-position", (((config.width * -1)) + (cpercentage * pixels)) + 'px 50%');
						
						if (config.showText)
							text.html(" " + cpercentage + "%");
						
						if (cpercentage > tpercentage)
							$this[0].config.cpercentage -= config.increment;
						else if (cpercentage < tpercentage)
							$this[0].config.cpercentage += config.increment;
						else {
							clearInterval(t);
							if (typeof arg2 != 'undefined' && typeof arg2.onComplete != 'undefined' && tpercentage == 100){
							    arg2.onComplete();
							}
						}
					}, this.config.speed);
				});
			};
		}
	});
		
	$.fn.extend({
        progressBar: $.progressBar.construct
	});
	
})(jQuery);
*/