(function($) {
    var j = 0;
    $.fn.slideView = function(settings) {
        settings = $.extend({
            easeFunc: "linear",
            easeTime: 750,
            toolTip: false
        }, settings);
      return this.each(function(){
          var $container = $(this);
          $container.find("img.ldrgif").remove(); // removes the preloader gif
          $container.removeClass("svw").addClass("stripViewer");
          
          var pictWidth = $container.find("li").find("img").width();
          var pictHeight = $container.find("li").find("img").height();
          var pictEls = $container.find("li").size();
          var stripViewerWidth = pictWidth*pictEls;
          var currentLi = 0;
          
          $container.find("ul").css("width" , stripViewerWidth); //assegnamo la larghezza alla lista UL	
          $container.css("width" , pictWidth);
          $container.css("height" , pictHeight);
          $container.each(function(i) {
              $('#' + this.id + '_next a').unbind('click').click(function (){
                  if ((currentLi + 1) >= pictEls) return false;
                  currentLi++;
                  var cnt = -(pictWidth*currentLi);
                  $container.find("ul").animate({left: cnt}, settings.easeTime, settings.easeFunc);
                return false;
              });
              $('#' + this.id + '_prev a').unbind('click').click(function (){
                  if ((currentLi - 1) < 0) return false;
                  currentLi--;
                  var cnt = -(pictWidth*currentLi);
                  $container.find("ul").animate({left: cnt}, settings.easeTime, settings.easeFunc);
               return false;
              });
              if (settings.toolTip){
                  $container.next(".stripTransmitter ul").find("a").Tooltip({
                      track: true,
                      delay: 0,
                      showURL: false,
                      showBody: false
                  });
              }
          });
          j++;
      });
    };
})(jQuery);