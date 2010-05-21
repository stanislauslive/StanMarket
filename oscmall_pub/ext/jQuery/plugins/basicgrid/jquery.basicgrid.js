(function($) {
    
    $.fn.basicGrid = function (o){
        var prefix = 'basicGrid_';
        var config = {
            pagerClass: prefix + 'pager',
            pagerContainerClass: prefix + 'pager_container',
            hoverClass: prefix + 'rowOver',
            selectedClass: prefix + 'rowSelected',
            defaultClass: prefix + 'rowOut',
            loadingClass: prefix + 'loading',
            firstColClass: prefix + 'firstColumn',
            lastColClass: prefix + 'lastColumn',
            hiddenClass: prefix + 'hidden',
            headerClass: prefix + 'header',
            headerOverClass: prefix + 'header_over',
            headerSelectedClass: prefix + 'header_selected',
            
            allowMultiSelect: false,
            resizable: true,
            minheight: 100,
            minwidth: 100,
            cgwidth: 100,
            minColToggle: 1,
            showToggleBtn: true,
            pageStatMessage: 'Displaying {from} to {to} of {total} items'
        };
                
        o = $.extend(config, o);
        
 	    var contextMenuDefaults = {
 	        menuStyle: {
 	            listStyle: 'none',
 	            padding: '1px',
 	            margin: '0px',
 	            backgroundColor: '#fff',
 	            border: '1px solid #999',
 	            width: '100px'
 	        },
 	        itemStyle: {
 	            margin: '0px',
 	            color: '#000',
 	            display: 'block',
 	            cursor: 'default',
 	            padding: '3px',
 	            border: '1px solid #fff',
 	            backgroundColor: 'transparent',
 	            'font-size': '12px',
 	            'white-space': 'nowrap'
 	        },
 	        itemHoverStyle: {
 	            border: '1px solid #0a246a',
 	            backgroundColor: '#b6bdd2'
 	        },
 	        eventPosX: 'pageX',
 	        eventPosY: 'pageY',
 	        shadow : true,
 	        onContextMenu: null,
 	        onShowMenu: null
 	    };
        
        var grid = {
            config: o,
            gridObj: $(this),
            addRowEvents: function (singleRow){
                if (singleRow){
                    var $selector = singleRow;
                }else{
                    var $selector = $('tbody[id!="loading"] > tr', grid.gridObj);
                }
                return $selector.each(function (){
                    this.getRowValues = function (){
                        var grid = $($(this).parent().parent()).data('gridObj');
                        var $row = $(this);
                        
                        var returnValues = {};
                        $('th', grid.gridObj).each(function (i, arr){
                            eval('returnValues.' + $(this).attr('id') + ' = "' + $('td:eq("' + i + '")', $row).html() + '"');
                        });
                      return returnValues;
                    };
                    
                    this.getColValue = function (id){
                        var $row = $(this);
                        var returnValue = 'undefined';
                        $('th', grid.gridObj).each(function (i, arr){
                            if ($(this).attr('id') == id){
                                returnValue = $('td:eq("' + i + '")', $row).html();
                            }
                        });
                      return returnValue;
                    };
                    
                    this.updateValues = function (data){
                        var grid = $($(this).parent().parent()).data('gridObj');
                        var row = this;
                        $('th', grid.gridObj).each(function (i, arr){
                            $('td:eq(' + i + ')', row).html(eval('data.' + $(this).attr('id')));
                        });
                    };
                    
                    $(this).mouseover(function(){
                        if (this.className != o.selectedClass){
                            this.className = o.hoverClass;
                        }
                    }).mouseout(function(){
                        if (this.className != o.selectedClass){
                            this.className = o.defaultClass;
                        }
                    }).click(function(e){
                        e = e||event;
                        if (this.className == o.selectedClass){
                            this.className = o.defaultClass;
                            $(this).trigger('unselect');
                        }else{
                            if (o.allowMultiSelect == false){
                                $('.' + o.selectedClass, grid.gridObj).each(function (){
                                    $(this).removeClass(o.selectedClass);
                                });
                            }
                            this.className = o.selectedClass;
                            $(this).trigger('select');
                        }
                        e.preventdefault? e.preventdefault() : e.returnValue = false;
                      return false;
                    }).noSelect();
                });
            },
            addRow: function (data){
                var cols = new Array();
                $('th', grid.gridObj).each(function (i, element){
                    cols.push({
                        text: eval('data.' + $(this).attr('id')),
                        hidden: $(this).hasClass(o.hiddenClass)
                    });
                });
                
                var $tr = $('<tr>');
                grid.addRowEvents($tr);
                
                jQuery.each(cols, function (i, arr){
                    var column = '<td class="basicGrid_column';
                    if (arr.hidden){
                        column = column + ' ' + o.hiddenClass;
                    }
                    
                    column = column + '">' + (this.text == '' ? '&nbsp;' : this.text) + '</td>';
                    $tr.append(column);
                });
                $('tbody[id!="loading"]', grid.gridObj).append($tr);
              return $tr;
            },
            getSelectedRows: function (){
                var rows = false;
                if (o.allowMultiSelect == true){
                    rows = new Array();
                    $('tbody[id!="loading"] > tr.' + o.selectedClass, grid.gridObj).each(function (i, arr){
                        rows[i] = this;
                    });
                }else{
                    rows = $('tbody[id!="loading"] > tr.' + o.selectedClass, grid.gridObj).get(0);
                }
              return rows;
            },
            addColumnControl: function (){
                grid.columnMenu = $('<div class="basicGrid_columnMenu" />').hide();
                grid.columnMenu.append('<ul />');
                
                $('th', grid.gridObj).each(function (i, arr){
                    var chk = 'checked="checked"';
                    if ($(this).css('display') == 'none') chk = '';
                    
                    $('ul:first', grid.columnMenu).append('<li><input type="checkbox" ' + chk + ' class="togCol" value="' + i + '" /><span>' + $('#colText', $(this)).html() + '</span></li>');
                });
                
                if ($.browser.msie && $.browser.version < 7.0)
                    $('li', grid.columnMenu).hover(function () {
                        $(this).addClass('ndcolover');
                    },function () {
                        $(this).removeClass('ndcolover');
                    });
                    
/*                $('span', grid.columnMenu).each(function (){
                    $(this).click(function (){
                        $('input.togCol', $(this).parent()).trigger('click');
                    });
                });
*/                
                $('input.togCol', grid.columnMenu).each(function (){
                    $(this).click(function (){
                      return grid.toggleCol($(this).val());
                    });
                });

                $(grid.gridObj).after(grid.columnMenu);
                
                contextMenu.create();
            },
			toggleCol: function(cid, visible) {
				var ncol = $('th:eq(' + cid + ')', grid.gridObj);
				var n = $('thead th', grid.gridObj).index(ncol);
				var cb = $('input[value=' + cid + ']', grid.columnMenu)[0];
				var cb1 = $('input[value=' + cid + ']', grid.columnMenu)[0];
				
				if (visible == null){
				    visible = (ncol.css('display') == 'none');
				}
				
				if ($('input:checked', grid.contextMenu).length < o.minColToggle && !visible) return false;
				
				if (visible){
					$(ncol).show();
					cb.checked = true;
					cb1.checked = true;
				}else{
					$(ncol).hide();
					cb.checked = false;
					cb1.checked = false;
				}
				
				$('tbody[id!="loading"] tr', grid.gridObj).each(function (){
				    if (visible)
						$('td:eq('+n+')',this).show();
					else
						$('td:eq('+n+')',this).hide();
				});
					
                $('tfoot td.' + prefix + 'footer', grid.gridObj).attr('colSpan', $('th:visible', grid.gridObj).size());
				
				return true;
			},
			showWindow: function (config){
			    var gridObj = grid.gridObj;
			    
			    var $windowObj = $(config.selector).clone();
			    if (typeof config.onLoad != 'undefined'){
			        $windowObj.bind('onload', config.onLoad);
			    }
			    
			    function populateFields(values){
			        $.each(values, function (key, value){
			            var $element = $('#' + key, $windowObj);
			            if ($element.size() > 0){
			                $element.each(function (){
			                    if (this.tagName == 'B'){
			                        $(this).html(value);
			                    }else{
			                        $(this).val(value);
			                    }
			                });
			            }
			        });
			    }
			    
			    function populateHeader(windowTitle, values){
			        if (config.selectedRow){
			            var PH = windowTitle.substr(0, windowTitle.lastIndexOf('%'));
			            if (PH){
			                PH = PH.substr(windowTitle.indexOf('%')+1);
			                windowTitle = windowTitle.replace('%' + PH + '%', values[PH]);
			            }
			        }
                    $('.basicGrid_windowHeader', $windowObj).html(windowTitle);
			    }
			    
			    function cloneFields(){
			        $('div[id!=""], li a, select, textarea, input[type="text"]', $windowObj).each(function (){
			            if (this.className == 'tabLink'){
			                $(this).attr('href', $(this).attr('href') + '_clone');
			            }else{
			                $(this).attr('id', $(this).attr('id') + '_clone');
			            }
			        });
			    }
			    
			    function finishLoad(values){
			        if (config.title){
			            populateHeader(config.title, values);
			        }
			        cloneFields();
			        
			        gridObj.hide();
			        $windowObj.appendTo(gridObj.parent()).show();
			        if (typeof config.onLoad != 'undefined'){
			            $windowObj.trigger('onload', $windowObj);
			        }
			    }
			    
			    if (config.selectedRow){
			        if (typeof config.remoteDataUrl != 'undefined' && config.remoteDataUrl != false){
			            $.ajax_progress_message_box(55);
			            $.ajax({
			                cache: false,
			                url: config.remoteDataUrl,
			                dataType: 'json',
			                success: function (data){
			                    if (data.success == true){
 			                        populateFields(data);
 			                        $.ajax_progress_message_box(70);
                                    finishLoad(data);
			                    }else{
			                        $.ajax_progress_message_box('close');
			                        $.ajax_unsuccessful_message_box(data);
			                    }
			                }
			            });
			        }else{
			            var values = config.selectedRow.getRowValues();
			            populateFields(values);
			            finishLoad(values);
			        }
			    } else {
			        finishLoad();
			    }
			},
			showLoading: function (){
			    var $gridObj = grid.gridObj;
			    var loadingDiv = $('<tbody id="loading"><tr><td colspan="4" class="basicGrid_ajaxLoader" align="center" valign="middle"><img src="images/pixel_trans.gif" alt="Loading" title="Loading" width="31" height="31"></td></tr></tbody>');
			    loadingDiv.css('height', $('tbody[id!="loading"]', $gridObj).height());
			    loadingDiv.css('width', $('tbody[id!="loading"]', $gridObj).width());
                $('tbody[id!="loading"]', $gridObj).hide();
			    $gridObj.append(loadingDiv);
			},
			removeLoading: function (){
                $('tbody[id!="loading"]', grid.gridObj).show();
			    $('tbody[id="loading"]', grid.gridObj).remove();
			}
        };
        
        var contextMenu = {
            rendered: false,
            shadowRendered: false,
            create: function (){
                if (!contextMenu.rendered) {
                    contextMenu.rendered = true;
                    grid.contextMenu = $('<div id="basicGrid_ContextMenu"></div>');
                    
                    grid.contextMenu.hide().css({
                        position:'absolute',
                        zIndex:'500'
                    }).appendTo('body').bind('click', function(e) {
                        e.stopPropagation();
                    });
                }
                if (!contextMenu.shadowRendered) {
                    contextMenu.shadowRendered = true;
                    grid.contextMenuShadow = $('<div></div>');
                    
                    grid.contextMenuShadow.css({
                        backgroundColor:'#000',
                        position:'absolute',
                        opacity:0.2,
                        zIndex:499
                    }).appendTo('body').hide();
                }
                
                grid.contextMenuHash = grid.contextMenuHash || [];
                grid.contextMenuHash.push({
                    id : 'basicGrid_columnMenu',
                    menuStyle: $.extend({}, contextMenuDefaults.menuStyle, o.menuStyle || {}),
                    itemStyle: $.extend({}, contextMenuDefaults.itemStyle, o.itemStyle || {}),
                    itemHoverStyle: $.extend({}, contextMenuDefaults.itemHoverStyle, o.itemHoverStyle || {}),
                    bindings: o.bindings || {},
                    shadow: o.shadow || o.shadow === false ? o.shadow : contextMenuDefaults.shadow,
                    onContextMenu: o.onContextMenu || contextMenuDefaults.onContextMenu,
                    onShowMenu: o.onShowMenu || contextMenuDefaults.onShowMenu,
                    eventPosX: o.eventPosX || contextMenuDefaults.eventPosX,
                    eventPosY: o.eventPosY || contextMenuDefaults.eventPosY
                });
                
                var index = grid.contextMenuHash.length - 1;
                
                $('th > #colMenu', grid.gridObj).each(function (i, arr){
                    $(this).unbind('click').click(function(e) {
                        var grid = $($(this).parent().parent().parent().parent()).data('gridObj');
                        // Check if onContextMenu() defined
                        var bShowContext = (!!grid.contextMenuHash[index].onContextMenu) ? grid.contextMenuHash[index].onContextMenu(e) : true;
                        if (bShowContext){
                            contextMenu.showMenu(index, this, e, o);
                        }
                      return false;
                    });
                });
              return this;
            },
            showMenu: function (index, trigger, e, options){
                var cur = grid.contextMenuHash[index];
                
                $(trigger).parent().one('click', contextMenu.hideMenu);
                
                var content = $('ul:first', grid.columnMenu).clone(true);
                content.css(cur.menuStyle).find('li').css(cur.itemStyle).hover(function() {
                    $(this).css(cur.itemHoverStyle);
                },function(){
                    $(this).css(cur.itemStyle);
                }).find('img').css({
                    verticalAlign:'middle',
                    paddingRight:'2px'
                });
                
                grid.contextMenu.html(content);
                if (!!cur.onShowMenu) grid.contextMenu = cur.onShowMenu(e, grid.contextMenu);

                var menuLeft = trigger.offsetLeft;
                menuLeft -= grid.contextMenu.width();
                grid.contextMenu.css({
                    left: menuLeft,
                    top: e[cur.eventPosY]
                }).show();
                
                if (cur.shadow){
                    grid.contextMenuShadow.css({
                        width: grid.contextMenu.width(),
                        height: grid.contextMenu.height(),
                        left: menuLeft + 2,
                        top: e.pageY+2
                    }).show();
                }
                $(document).one('click', contextMenu.hideMenu);
            },
            hideMenu: function (){
                grid.contextMenu.hide();
                grid.contextMenuShadow.hide();
            }
        }
        
        var pager = {
            create: function (){
                grid.pagerObj = pager;
                grid.pagerObj.currentPage = 1;
                grid.pagerObj.totalRows = $('tbody[id!="loading"] > tr', grid.gridObj).size();
                grid.pagerObj.pageSize = $('.' + o.pagerClass).attr('page_size');
                grid.pagerObj.buildCache();
                
			    var opt = "";
			    var rpOptions = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50];
			    for (var nx in rpOptions){
			        if (grid.pagerObj.pageSize == rpOptions[nx]) sel = 'selected="selected"'; else sel = '';
			        opt += "<option value='" + rpOptions[nx] + "' " + sel + " >" + rpOptions[nx] + "&nbsp;&nbsp;</option>";
			    };
			    grid.pagerObj.PageSizer = $('<div id="group"><select name="pageSizer">' + opt + '</select></div>');
			    $('select', grid.pagerObj.PageSizer).change(function (){
			        if (pager.onPageSizeChange) 
						grid.pagerObj.onPageSizeChange(this.value);
					else{
					    grid.pagerObj.currentPage = 1;
						grid.pagerObj.pageSize = this.value;
					}
			    });
                
                grid.pagerObj.container = $('<div class="' + o.pagerContainerClass + '" />');
                grid.pagerObj.PrevSet = $('<div id="group"><div id="first" class="pageButton"><span></span></div><div id="prev" class="pageButton"><span></span></div></div>');
                grid.pagerObj.NextSet = $('<div id="group"><div id="next" class="pageButton"><span></span></div><div id="last" class="pageButton"><span></span></div></div>');
                grid.pagerObj.PageSet = $('<div id="group"><span class="pageControl">Page <input name="newPage" type="text" size="3" value="1" /> of <span> 1</span></span></div>');
                grid.pagerObj.reloadButton = $('<div id="group"><div id="reload" class="pageButton"><span></span></div></div>');
                grid.pagerObj.displayInfo = $('<div id="group"><span class="pageStat"></span></div>');
                
                grid.pagerObj.fullBar = grid.pagerObj.container.clone();
                grid.pagerObj.fullBar
                .append(grid.pagerObj.PageSizer)
                .append('<div id="btnseparator"></div>')
                .append(grid.pagerObj.PrevSet)
                .append('<div id="btnseparator"></div>')
                .append(grid.pagerObj.PageSet)
                .append('<div id="btnseparator"></div>')
                .append(grid.pagerObj.NextSet)
                .append('<div id="btnseparator"></div>');
                
                if (o.mode == 'remote'){
                    grid.pagerObj.fullBar.append(grid.pagerObj.reloadButton).append('<div id="btnseparator"></div>');
                }
                
                grid.pagerObj.fullBar.append(grid.pagerObj.displayInfo);
                
                $('#first', grid.pagerObj.fullBar).click(function(){
                    grid.pagerObj.previousPage(true);
                });
                
                $('#prev', grid.pagerObj.fullBar).click(function(){
                    grid.pagerObj.previousPage(false);
                });
                
                $('#next', grid.pagerObj.fullBar).click(function(){
                    grid.pagerObj.nextPage(false);
                });
                
                $('#last', grid.pagerObj.fullBar).click(function(){
                    grid.pagerObj.nextPage(true);
                });
                
                $('.pageControl input', grid.pagerObj.fullBar).keydown(function(e){
                    if (e.keyCode == 13) grid.pagerObj.jumpToPage($(this).val());
                });
                
                if ($.browser.msie && $.browser.version < 7){
                    $('.pageButton', grid.pagerObj.fullBar).each(function (){
                        $(this).hover(function(){
                            $(this).addClass('pageButtonOver');
                        },function(){
                            $(this).removeClass('pageButtonOver');
                        });
                    });
                }
                
                $('.basicGrid_pager', grid.gridObj).append(grid.pagerObj.fullBar);
                grid.pagerObj.changePage();
            },
            buildCache: function (){
                grid.pagerObj.pageCache = new Array();
                
                var page = 1;
                var index = 0;
                $('tbody[id!="loading"] > tr', grid.gridObj).each(function (i, arr){
                    if (typeof grid.pagerObj.pageCache[page] == 'undefined'){
                        grid.pagerObj.pageCache[page] = new Array();
                    }
                    
                    if (page > 1){
                        $(this).hide();
                    }
                    grid.pagerObj.pageCache[page].push(this);
                    index++;
                    if (index > (grid.pagerObj.pageSize - 1)){
                        index = 0;
                        page++;
                    }
                });
            },
            hidePage: function (page){
                $(grid.pagerObj.pageCache[page]).each(function (i, arr){
                    $(arr).hide();                
                });
            },
            nextPage: function (end){
                var previousPage = grid.pagerObj.currentPage;
                if (end == true){
                    grid.pagerObj.currentPage = (grid.pagerObj.pageCache.length - 1);
                }else{
                    grid.pagerObj.currentPage++;
                }
                if (typeof grid.pagerObj.pageCache[grid.pagerObj.currentPage] == 'undefined'){
                    grid.pagerObj.currentPage--;
                    return;
                }
                
                grid.pagerObj.hidePage(previousPage);
                grid.pagerObj.changePage();
            },
            previousPage: function (begin){
                var previousPage = grid.pagerObj.currentPage;
                if (begin == true){
                    grid.pagerObj.currentPage = 1;
                }else{
                    grid.pagerObj.currentPage--;
                }
                if (typeof grid.pagerObj.pageCache[grid.pagerObj.currentPage] == 'undefined'){
                    grid.pagerObj.currentPage++;
                    return;
                }
                
                grid.pagerObj.hidePage(previousPage);
                grid.pagerObj.changePage();
            },
            changePage: function (){
                $(grid.pagerObj.pageCache[grid.pagerObj.currentPage]).each(function (i, arr){
                    $(arr).show();
                });
                
                if (typeof grid.pagerObj.pageCache[(grid.pagerObj.currentPage - 1)] == 'undefined'){
                  //  $('#prev', grid.pagerObj).addClass('disabled');
                }
                
                if (typeof grid.pagerObj.pageCache[(grid.pagerObj.currentPage + 1)] != 'undefined'){
                 //   $('#next', grid.pagerObj).removeClass('disabled');
                }

                $('.' + o.selectedClass, grid.gridObj).each(function (){
                    $(this).trigger('unselect').removeClass(o.selectedClass);
                });
                
                var pageStart = ((grid.pagerObj.currentPage - 1) * grid.pagerObj.pageSize + 1);
                var pageEnd = (grid.pagerObj.currentPage * grid.pagerObj.pageSize);
                if (pageEnd > grid.pagerObj.totalRows){
                    pageEnd = grid.pagerObj.totalRows;
                }
                
                $('.pageControl input', grid.pagerObj.fullBar).val(grid.pagerObj.currentPage);
                $('.pageControl span', grid.pagerObj.fullBar).html((grid.pagerObj.pageCache.length - 1));
                
                var stat = o.pageStatMessage;
			    stat = stat.replace(/{from}/, pageStart);
			    stat = stat.replace(/{to}/, pageEnd);
			    stat = stat.replace(/{total}/, grid.pagerObj.totalRows);
			    
			    $('.pageStat', grid.pagerObj.fullBar).html(stat);
            },
            onPageSizeChange: function (newPageSize){
				grid.pagerObj.currentPage = 1;
				grid.pagerObj.pageSize = newPageSize;
                grid.pagerObj.buildCache();
                grid.pagerObj.changePage();
            },
            jumpToPage: function (page){
                if (typeof grid.pagerObj.pageCache[page] == 'undefined'){
                    return;
                }
                var previousPage = grid.pagerObj.currentPage;
                grid.pagerObj.currentPage = page;
                grid.pagerObj.hidePage(previousPage);
                grid.pagerObj.changePage();
            },
            onGridContentUpdate: function (){
                $('.' + o.pagerContainerClass, grid.gridObj).remove();
                grid.pagerObj.create();
            },
            refreshGrid: function (){
                alert('Not Implemented Yet');
            }
        };
        
        return $(this).each(function() {
            if (o.paging == true){
                pager.create();
            }
            
            grid.addColumnControl();
            grid.addRowEvents();
            
            $('th', grid.gridObj).each(function (i){
                $(this).noSelect();
                
                $('#colExpander', this).Draggable({
                    axis: 'horizontally',
                    containment: 'document',
                    ghosting: true,
                    opacity: 0.8,
                    onStop: function (){
                        var plusWidth = parseInt(this.style.left);
                        var $whichParent = $(this).parent().prev().getPreviousShown();
                        var curWidth = parseInt($whichParent.width());
                        $whichParent.width(curWidth + plusWidth);
                        this.style.left = '-4px';
                    }
                });
            });
            
            $(this).data('gridObj', grid);
        });
    }
    
    $.fn.getPreviousShown = function (){
        var $elem = $(this);
        if ($elem.is(':hidden')){
            $elem = $(this).prev().getPreviousShown();
        }
      return $elem;
    }
    
	$.fn.noSelect = function(p) { //no select plugin by me :-)
		if (p == null) 
			prevent = true;
		else
			prevent = p;

		if (prevent) {
		    return this.each(function (){
		        if ($.browser.msie||$.browser.safari) $(this).bind('selectstart',function(){return false;});
				else if ($.browser.mozilla){
				    $(this).css('MozUserSelect','none');
					$('body').trigger('focus');
				}else if ($.browser.opera) $(this).bind('mousedown',function(){return false;});
				else $(this).attr('unselectable','on');
		    });
		} else {
		    return this.each(function (){
		        if ($.browser.msie||$.browser.safari) $(this).unbind('selectstart');
				else if ($.browser.mozilla) $(this).css('MozUserSelect','inherit');
				else if ($.browser.opera) $(this).unbind('mousedown');
				else $(this).removeAttr('unselectable','on');
			});
		}
	}; //end noSelect
    
})(jQuery);