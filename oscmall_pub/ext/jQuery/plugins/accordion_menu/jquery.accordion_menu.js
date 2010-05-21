(function($) {
    $.fn.accordion_menu = function (settings){
        var $selected = null;
        var largestContent = 0
        $(this).find('div.accordion_menu_block_content').each(function(){
            var check = parseFloat($(this).height());
            if (check > largestContent){
                largestContent = check;
            }
        });
        
        $(this).find('div.accordion_menu_block').each(function (){
            $(this).find('div.accordion_menu_block_content').each(function(){
                /* Commented Out Until Everything Can Be Upgraded To Be Compatible With AJAX Page Loading
                $(this).find('a').each(function (){
                    $(this).unbind('click').click(function (){
                        var loadingDiv = jQuery('<div style="width:100%;height:100%;color:white;font-size:30px;" align="center" valign="middle">LOADING, PLEASE WAIT</div>');
                        $('#contentColumn').empty().append(loadingDiv);
                        jQuery.ajax({
                            url: this.href,
                            type: 'get',
                            cache: false,
                            data: { ajaxContent: 'true' },
                            dataType: 'html',
                            success: function (html){
                                $('#contentColumn').empty().append(html);
                            }
                        });
                      return false;
                    });
                });*/
                $(this).hide();
            });
            
            $(this).find('div.accordion_menu_block_header').each(function(){
                var $blockHeader = $(this);
                
                $('.accordion_menu_block_content', $blockHeader.parent()).each(function (){
                    $('a', $(this)).each(function (){
                        $(this).click(function (){
                            $.cookie('accordion_menu_block_content_link', $(this).attr('id'));
                        });
                        if ($.cookie('accordion_menu_block_content_link') == $(this).attr('id')){
                            $(this).addClass('accordion_menu_block_content_link_selected');
                        }
                    });
                });
                
                $blockHeader.unbind('click').click(function (){
                    if ($selected != null){
                        $selected.parent().find('div.accordion_menu_block_content').hide();
                        $selected.parent().find('div.accordion_menu_block_header_tools_expand_selected').get(0).className = 'accordion_menu_block_header_tools_expand';
                        $selected.attr('id', '');
                        $selected.trigger('mouseout');
                    }
                    
                    $.cookie('accordion_menu_selected_header', $(this).attr('id'));
                    
                    $(this).parent().find('div.accordion_menu_block_content').show();
                    $(this).parent().find('div.accordion_menu_block_header_tools_expand').get(0).className = 'accordion_menu_block_header_tools_expand_selected';
                    this.className = 'accordion_menu_block_header_over';
                    this.id = 'selected';
                    $selected = $(this);
                });
                
                $blockHeader.unbind('mouseover').mouseover(function (){
                    if (this.id != 'selected'){
                        this.className = 'accordion_menu_block_header_over';
                    }
                });
                $blockHeader.unbind('mouseout').mouseout(function (){
                    if (this.id != 'selected'){
                        this.className = 'accordion_menu_block_header';
                    }
                });
                
                if ($.cookie('accordion_menu_selected_header') == $blockHeader.attr('id')){
                    $blockHeader.trigger('click');
                }
            });
        });
        
    }
})(jQuery);