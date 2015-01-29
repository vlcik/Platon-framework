/*
* jQuery SimpleTree Drag&Drop plugin
* Update on 22th May 2008
* Version 0.3
*
* Licensed under BSD <http://en.wikipedia.org/wiki/BSD_License>
* Copyright (c) 2008, Peter Panov <panov@elcat.kg>, IKEEN Group http://www.ikeen.com
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*     * Redistributions of source code must retain the above copyright
*       notice, this list of conditions and the following disclaimer.
*     * Redistributions in binary form must reproduce the above copyright
*       notice, this list of conditions and the following disclaimer in the
*       documentation and/or other materials provided with the distribution.
*     * Neither the name of the Peter Panov, IKEEN Group nor the
*       names of its contributors may be used to endorse or promote products
*       derived from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY Peter Panov, IKEEN Group ``AS IS'' AND ANY
* EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
* DISCLAIMED. IN NO EVENT SHALL Peter Panov, IKEEN Group BE LIABLE FOR ANY
* DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
* (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
* ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
* SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/


$.fn.simpleTree = function(opt){
	return this.each(function(){
		var TREE = this;
		var ROOT = $('.root',this);
		var mousePressed = false;
		var mouseMoved = false;
		var dragMoveType = false;
		var dragNode_destination = false;
		var dragNode_source = false;
		var dragDropTimer = false;
		var ajaxCache = Array();
		
		var imagesPath='/js/jquery/plugins/tree/images/';

		TREE.option = {
			multiselect : false, // JAN ADDED
			drag :		true,
			animate :	false,
			autoclose :	false,
			speed :		'fast',
			afterAjax :	false,
			afterMove :	false,
			afterClick : false,
			nodeClick :	false, // jan added (selection handler)
			afterDropCheck : false, // jan added (do not execute drop but runs function)
			dragStartCheck : false, // jan added (do not execute drag if returns false)
			afterDblClick:	false,
			// added by Erik Dohmen (2BinBusiness.nl) to make context menu cliks available
			afterContextMenu:	false,
			docToFolderConvert:false
		};
		TREE.option = $.extend(TREE.option,opt);
		$.extend(this, {getSelected: function(){
			// JAN changed								  
			// return $('span.active', this).parent();
			return $('span.active', this).parent();
		}});
		TREE.closeNearby = function(obj)
		{
			$(obj).siblings().filter('.folder-open, .folder-open-last').each(function(){
				var childUl = $('>ul',this);
				var className = this.className;
				this.className = className.replace('open','close');
				if(TREE.option.animate)
				{
					childUl.animate({height:"toggle"},TREE.option.speed);
				}else{
					childUl.hide();
				}
			});
		};
		TREE.nodeToggle = function(obj)
		{
			var childUl = $('>ul',obj);
			if(childUl.is(':visible')){
				obj.className = obj.className.replace('open','close');

				if(TREE.option.animate)
				{
					childUl.animate({height:"toggle"},TREE.option.speed);
				}else{
					childUl.hide();
				}
			}else{
				obj.className = obj.className.replace('close','open');
				if(TREE.option.animate)
				{
					childUl.animate({height:"toggle"},TREE.option.speed, function(){
						if(TREE.option.autoclose)TREE.closeNearby(obj);
						if(childUl.is('.ajax'))TREE.setAjaxNodes(childUl, obj.id);
					});
				}else{
					childUl.show();
					if(TREE.option.autoclose)TREE.closeNearby(obj);
					if(childUl.is('.ajax'))TREE.setAjaxNodes(childUl, obj.id);
				}
			}
		};
		TREE.setAjaxNodes = function(node, parentId, callback)
		{
			if($.inArray(parentId,ajaxCache) == -1){
				ajaxCache[ajaxCache.length]=parentId;
				var url = $.trim($('>li', node).text());
				if(url && url.indexOf('url:'))
				{
					url=$.trim(url.replace(/.*\{url:(.*)\}/i ,'$1'));
					$.ajax({
						type: "GET",
						url: url,
						contentType:'html',
						cache:false,
						success: function(responce){
							node.removeAttr('class');
							node.html(responce);
							$.extend(node,{url:url});
							TREE.setTreeNodes(node, true);
							if(typeof TREE.option.afterAjax == 'function')
							{
								TREE.option.afterAjax(node);
							}
							if(typeof callback == 'function')
							{
								callback(node);
							}
						}
					});
				}
				
			}
		};
		
		// jan added
		TREE.updateTree=function(html)
		{
			ROOT.html(html);
			TREE.setTreeNodes(ROOT, false);
		};
		
		// jan added
		TREE.getSelection=function(nParseSubstrLength)
		{
			var nParseSubstrLength=nParseSubstrLength || false;
			
			var sel=[];
			
			$('.active',TREE).each(
				function()
				{
					if(nParseSubstrLength)
						sel.push($(this).parent().attr("id").substr(nParseSubstrLength));
					else
						sel.push($(this).parent().attr("id"));
				}
			);
			
			return sel;
		};
		
		// g added 
		TREE.getBranch=function(nParseSubstrLength)
		{
			var nParseSubstrLength=nParseSubstrLength || false;
			
			var aSel=TREE.getSelection();
			
			if(aSel.length>1)
				return false;
				
			var aBranch=[];
						
			if(nParseSubstrLength)
				aBranch.push($("#"+aSel[0]).attr("id").substr(nParseSubstrLength));
			else
				aBranch.push($("#"+aSel[0]).attr("id"));
			
			$("#"+aSel[0]).parents("LI").each(
				function()
				{
					
					if($(this).hasClass('root')) return false;
					
					if(nParseSubstrLength)
						aBranch.push($(this).attr("id").substr(nParseSubstrLength));
					else
						aBranch.push($(this).attr("id"));					
				}
			)
									
			return 	aBranch;				
		};
		
		// jan added
		TREE.isSameLevelSelection=function()
		{
			var aSel=TREE.getSelection();
			
			if(aSel.length==0)
				return true;
			
			// get first li parent get all LI children Ids
			var jParent=$("#"+aSel[0]).parent();
			var aSiblingIds=[];
			$(">li",jParent).each(
				function()
				{
					var sId=$(this).attr("id");
					
					// ignore empty IDs - lines 
					if(sId)
						aSiblingIds.push(sId);
				}
			);
			
			// do check
			for(var i=0; i<aSel.length; i++)
			{
				if(aSiblingIds.indexOf(aSel[i])==-1)
					return false;
			}
			
			return true;
		};
		
		
		// jan added
		TREE.resetSelection=function()
		{
			$('.active',TREE).attr('class','text');
		};
		
		// jan added
		TREE.selectNodes=function(aSelection)
		{
			TREE.resetSelection();
			
			var jSel;
			
			for(var i=0; i<aSelection.length; i++)
			{
				jSel=$("#"+aSelection[i]+" > span");
				
				if(jSel.size()>0)
					jSel.get(0).className='active'; 
			}
		};
		
		
		TREE.getOpenNodesIds=function(nParseSubstrLength)
		{
			var nParseSubstrLength=nParseSubstrLength || false;
			
			var aIds=[];
			$('li.folder-open, li.folder-open-last', ROOT).each(
				function()
				{
					if(nParseSubstrLength)
						aIds.push($(this).attr("id").substr(nParseSubstrLength));
					else
						aIds.push($(this).attr("id"));		
				}
			);
			return aIds; 
		};
		
		
		// jan added
		TREE.moveNodeToTarget=function(jSource,jTarget)
		{
			dragNode_source=jSource;
			TREE.moveNodeToFolder (jTarget);
			dragNode_source=false;
		}
		
		// jan added
		TREE.moveNodeBeforeTarget=function(jSource,jBeforeTarget)
		{
			dragNode_source=jSource;
			
			var beforeLine = jBeforeTarget.prev('li.line,li.line-over');
			if(beforeLine.size()>0)
			{
				TREE.moveNodeToLine(beforeLine[0]);
			}
			
			dragNode_source=false;
		}
		
		
		/*
		 * jan added
		 * returns jquery selection by type, retuns "span elements" !!!
		 */
		TREE.getNodeSelection=function(sGroup,cntxt)
		{
			var jSel;
			var context=cntxt || ROOT;
			
			switch(sGroup)
			{
				case "doc" :
					jSel=$('li.doc>span, li.doc-last>span', context);
				break;
				
				case "folder" :
					jSel=$('li.folder-close>span, li.folder-open>span, li.folder-close-last>span, li.folder-open-last>span', context);
				break;
				
				case "folder-level1" :
					var jContext2=$(">ul",context);
					jSel=$('>li.folder-close>span, >li.folder-open>span, >li.folder-close-last>span, >li.folder-open-last>span', jContext2);
				break;
				
				case "folder-with-doc" :
					jSel=$('li.folder-close>span, li.folder-open>span, li.folder-close-last>span, li.folder-open-last>span', context);
					jSel=jSel.filter(
						function()
						{
							var parent_li=$(this).parent();
							var s=$('>ul>li.doc, >ul>li.doc-last',parent_li);
							return s.size()!=0;
						}
					)									
				break;
				
				case "folder-level2" :
					var jContext2=$(">ul",context);
					var jContext3=$(">li>ul",jContext2);
					jSel=$('>li.folder-close>span, >li.folder-open>span, >li.folder-close-last>span, >li.folder-open-last>span', jContext3);														
				break;
				
				case "all" :
				default:
					jSel=$('li>span', context);	
				break;
			}
					
			return jSel;	
		}
		
		
		TREE.getNodeSelectionIds = function(sGroup, cntxt,nParseSubstrLength)
		{
			var nParseSubstrLength=nParseSubstrLength || false;
			var aSel=[]
			
			TREE.getNodeSelection(sGroup,cntxt).each(
				function()
				{		
					if(nParseSubstrLength)
						aSel.push($(this).parent().attr("id").substr(nParseSubstrLength));						
					else
						aSel.push($(this).parent().attr("id"));					
				}
			);			
			
			return aSel;
		}
		
		
		TREE.setTreeNodes = function(obj, useParent){
			obj = useParent? obj.parent():obj;
			$('li>span', obj).addClass('text')
			.bind('selectstart', function() {
				return false;
			}).click(function(){
				
				// jan added
				if(typeof TREE.option.nodeClick == 'function')
				{
					var a=$(this);
					TREE.option.nodeClick($(this));
				}
				
				// JAN CHANGED	
				if(TREE.option.multiselect)
				{
					
					if(this.className=='text')
					{
						this.className='active';
						
					}else if(this.className=='active') // JAN ADDED
					{
						this.className='text';
					}
				}else
				{
					$('.active',TREE).attr('class','text');
					
				
					if(this.className=='text')
					{
						this.className='active';						
					}
				}				
				// JAN CHANGED END
				
				if(typeof TREE.option.afterClick == 'function')
				{
					TREE.option.afterClick($(this).parent());
				}
				return false;
			}).dblclick(function(){
				mousePressed = false;
				TREE.nodeToggle($(this).parent().get(0));
				if(typeof TREE.option.afterDblClick == 'function')
				{
					TREE.option.afterDblClick($(this).parent());
				}
				return false;
				// added by Erik Dohmen (2BinBusiness.nl) to make context menu actions
				// available
			}).bind("contextmenu",function(){
				
				// JAN CHANGED	
				if(TREE.option.multiselect)
				{
					
					if(this.className=='text')
					{
						this.className='active';
						
					}else if(this.className=='active') // JAN ADDED
					{
						this.className='text';
					}
				}else
				{
					$('.active',TREE).attr('class','text');
					
					if(this.className=='text')
					{
						this.className='active';
						
					}
				}				
				// JAN CHANGED END
				
				if(typeof TREE.option.afterContextMenu == 'function')
				{
					TREE.option.afterContextMenu($(this).parent());
				}
				return false;
			}).mousedown(function(event){
				mousePressed = true;
				cloneNode = $(this).parent().clone();
				var LI = $(this).parent();
				if(TREE.option.drag)
				{
					// JAN added
					// make check if drag is enabled				
					if(typeof(TREE.option.dragStartCheck) == 'function')
					{
						var bOk=TREE.option.dragStartCheck(LI);
						
						if(!bOk)
						{
							TREE.eventDestroy(); // reset stuff
							return false;
						}							
					}					
					// JAN end		
					
					$('>ul', cloneNode).hide();
					$('body').append('<div id="drag_container"><ul></ul></div>');
					$('#drag_container').hide().css({opacity:'0.8'});
					$('#drag_container >ul').append(cloneNode);
					$("<img>").attr({id	: "tree_plus",src	: imagesPath+"plus.gif"}).css({width: "7px",display: "block",position: "absolute",left	: "5px",top: "5px", display:'none'}).appendTo("body");
					$(document).bind("mousemove", {LI:LI}, TREE.dragStart).bind("mouseup",TREE.dragEnd);
				}
				return false;
			}).mouseup(function(){
				if(mousePressed && mouseMoved && dragNode_source)
				{
					// JAN added drop check
					 
					// if is checker checkni alebo rovno presun
					if(typeof TREE.option.afterDropCheck == 'function')
					{
						var oInf={
							source : dragNode_source,
							target :  $(this).parent(),
							before : null // move to folder (no sorting)
						};
						TREE.option.afterDropCheck(oInf);
						// TREE.eventDestroy(); // neskor sa pusta
					}else
					{
						TREE.moveNodeToFolder($(this).parent());	
					}										
					
				}
				TREE.eventDestroy();
			});
			$('li', obj).each(function(i){
				var className = this.className;
				var open = false;
				var cloneNode=false;
				var LI = this;
				var childNode = $('>ul',this);
				if(childNode.size()>0){
					var setClassName = 'folder-';
					if(className && className.indexOf('open')>=0){
						setClassName=setClassName+'open';
						open=true;
					}else{
						setClassName=setClassName+'close';
					}
					this.className = setClassName + ($(this).is(':last-child')? '-last':'');

					if(!open || className.indexOf('ajax')>=0)childNode.hide();

					TREE.setTrigger(this);
				}else{
					var setClassName = 'doc';
					this.className = setClassName + ($(this).is(':last-child')? '-last':'');
				}
			}).before('<li class="line">&nbsp;</li>')
			.filter(':last-child').after('<li class="line-last"></li>');
			TREE.setEventLine($('.line, .line-last', obj));
		};
		TREE.setTrigger = function(node){
			$('>span',node).before('<img class="trigger" src="'+imagesPath+'spacer.gif" border=0>');
			var trigger = $('>.trigger', node);
			trigger.click(function(event){
				TREE.nodeToggle(node);
			});
			if(!$.browser.msie)
			{
				trigger.css('float','left');
			}
		};
		TREE.dragStart = function(event){
			var LI = $(event.data.LI);
			if(mousePressed)
			{
				mouseMoved = true;
				if(dragDropTimer) clearTimeout(dragDropTimer);
				if($('#drag_container:not(:visible)')){
					$('#drag_container').show();
					LI.prev('.line').hide();
					dragNode_source = LI;
				}
				$('#drag_container').css({position:'absolute', "left" : (event.pageX + 5), "top": (event.pageY + 15) });
				if(LI.is(':visible'))LI.hide();
				var temp_move = false;
				if(event.target.tagName.toLowerCase()=='span' && $.inArray(event.target.className, Array('text','active','trigger'))!= -1)
				{
					var parent = event.target.parentNode;
					var offs = $(parent).offset({scroll:false});
					var screenScroll = {x : (offs.left - 3),y : event.pageY - offs.top};
					var isrc = $("#tree_plus").attr('src');
					var ajaxChildSize = $('>ul.ajax',parent).size();
					var ajaxChild = $('>ul.ajax',parent);
					screenScroll.x += 19;
					screenScroll.y = event.pageY - screenScroll.y + 5;

					if(parent.className.indexOf('folder-close')>=0 && ajaxChildSize==0)
					{
						if(isrc.indexOf('minus')!=-1)$("#tree_plus").attr('src',imagesPath+'plus.gif');
						$("#tree_plus").css({"left": screenScroll.x, "top": screenScroll.y}).show();
						dragDropTimer = setTimeout(function(){
							parent.className = parent.className.replace('close','open');
							$('>ul',parent).show();
						}, 700);
					}else if(parent.className.indexOf('folder')>=0 && ajaxChildSize==0){
						if(isrc.indexOf('minus')!=-1)$("#tree_plus").attr('src',imagesPath+'plus.gif');
						$("#tree_plus").css({"left": screenScroll.x, "top": screenScroll.y}).show();
					}else if(parent.className.indexOf('folder-close')>=0 && ajaxChildSize>0)
					{
						mouseMoved = false;
						$("#tree_plus").attr('src',imagesPath+'minus.gif');
						$("#tree_plus").css({"left": screenScroll.x, "top": screenScroll.y}).show();

						$('>ul',parent).show();
						
						TREE.setAjaxNodes(ajaxChild,parent.id, function(){
							parent.className = parent.className.replace('close','open');
							mouseMoved = true;
							$("#tree_plus").attr('src',imagesPath+'plus.gif');
							$("#tree_plus").css({"left": screenScroll.x, "top": screenScroll.y}).show();
						});

					}else{
						if(TREE.option.docToFolderConvert)
						{
							$("#tree_plus").css({"left": screenScroll.x, "top": screenScroll.y}).show();
						}else{
							$("#tree_plus").hide();
						}
					}
				}else{
					$("#tree_plus").hide();
				}
				return false;
			}
			return true;
		};
		TREE.dragEnd = function(){
			if(dragDropTimer) clearTimeout(dragDropTimer);
			TREE.eventDestroy();
		};
		TREE.setEventLine = function(obj){
			obj.mouseover(function(){
				if(this.className.indexOf('over')<0 && mousePressed && mouseMoved)
				{
					this.className = this.className.replace('line','line-over');
				}
			}).mouseout(function(){
				if(this.className.indexOf('over')>=0)
				{
					this.className = this.className.replace('-over','');
				}
			}).mouseup(function(){
				if(mousePressed && dragNode_source && mouseMoved)
				{
					// JAN added drop check					 
					// if is checker checkni alebo rovno presun
					if(typeof TREE.option.afterDropCheck == 'function')
					{
						var jBeforeNode=$(this).next("li.doc,li.doc-last,li.folder-close,li.folder-open,li.folder-close-last,li.folder-open-last");
						
						if(jBeforeNode.size()==0)
							jBeforeNode=null;
							
						var oInf={
							source : dragNode_source,
							target : $(this).parents('li:first'),
							before : jBeforeNode // move to line (move and sort ...)
						};
						TREE.option.afterDropCheck(oInf);	
						TREE.eventDestroy();					
					}else
					{
						dragNode_destination = $(this).parents('li:first');
						TREE.moveNodeToLine(this);
						TREE.eventDestroy();	
					}					
				}
			});
		};
		TREE.checkNodeIsLast = function(node)
		{
			if(node.className.indexOf('last')>=0)
			{
				var prev_source = dragNode_source.prev().prev();
				if(prev_source.size()>0)
				{
					prev_source[0].className+='-last';
				}
				node.className = node.className.replace('-last','');
			}
		};
		TREE.checkLineIsLast = function(line)
		{
			if(line.className.indexOf('last')>=0)
			{
				var prev = $(line).prev();
				if(prev.size()>0)
				{
					prev[0].className = prev[0].className.replace('-last','');
				}
				dragNode_source[0].className+='-last';
			}
		};
		TREE.eventDestroy = function()
		{
			// added by Erik Dohmen (2BinBusiness.nl), the unbind mousemove TREE.dragStart action
			// like this other mousemove actions binded through other actions ain't removed (use it myself
			// to determine location for context menu)
			$(document).unbind('mousemove',TREE.dragStart).unbind('mouseup').unbind('mousedown');
			$('#drag_container, #tree_plus').remove();
			if(dragNode_source)
			{
				$(dragNode_source).show().prev('.line').show();
			}
			dragNode_destination = dragNode_source = mousePressed = mouseMoved = false;
			//ajaxCache = Array();
		};
		TREE.convertToFolder = function(node){
			node[0].className = node[0].className.replace('doc','folder-open');
			node.append('<ul><li class="line-last"></li></ul>');
			TREE.setTrigger(node[0]);
			TREE.setEventLine($('.line, .line-last', node));
		};
		TREE.convertToDoc = function(node){
			$('>ul', node).remove();
			$('img', node).remove();
			node[0].className = node[0].className.replace(/folder-(open|close)/gi , 'doc');
		};
		TREE.moveNodeToFolder = function(node)
		{
			var a=dragNode_source;
			
			if(!TREE.option.docToFolderConvert && node[0].className.indexOf('doc')!=-1)
			{
				return true;
			}else if(TREE.option.docToFolderConvert && node[0].className.indexOf('doc')!=-1){
				TREE.convertToFolder(node);
			}
			TREE.checkNodeIsLast(dragNode_source[0]);
			var lastLine = $('>ul >.line-last', node);
			if(lastLine.size()>0)
			{
				TREE.moveNodeToLine(lastLine[0]);
			}
		};
		TREE.moveNodeToLine = function(node){
			
			var a=dragNode_source;
			
			TREE.checkNodeIsLast(dragNode_source[0]);
			TREE.checkLineIsLast(node);
			var parent = $(dragNode_source).parents('li:first');
			var line = $(dragNode_source).prev('.line');
			$(node).before(dragNode_source);
			$(dragNode_source).before(line);
			node.className = node.className.replace('-over','');
			var nodeSize = $('>ul >li', parent).not('.line, .line-last').filter(':visible').size();
			if(TREE.option.docToFolderConvert && nodeSize==0)
			{
				TREE.convertToDoc(parent);
			}else if(nodeSize==0)
			{
				parent[0].className=parent[0].className.replace('open','close');
				$('>ul',parent).hide();
			}

			// added by Erik Dohmen (2BinBusiness.nl) select node
			if($('span:first',dragNode_source).attr('class')=='text')
			{
				// JAN CHANGED	// added if
				if(!TREE.option.multiselect)
				{
					$('.active',TREE).attr('class','text');
				}							
				$('span:first',dragNode_source).attr('class','active');
			}

			if(typeof(TREE.option.afterMove) == 'function')
			{
				var pos = $(dragNode_source).prevAll(':not(.line)').size();
				TREE.option.afterMove($(node).parents('li:first'), $(dragNode_source), pos);
			}
		};

		TREE.addNode = function(id, text, callback)
		{
			var temp_node = $('<li><ul><li id="'+id+'"><span>'+text+'</span></li></ul></li>');
			TREE.setTreeNodes(temp_node);
			dragNode_destination = TREE.getSelected();
			dragNode_source = $('.doc-last',temp_node);
			TREE.moveNodeToFolder(dragNode_destination);
			temp_node.remove();
			if(typeof(callback) == 'function')
			{
				callback(dragNode_destination, dragNode_source);
			}
		};
		TREE.delNode = function(callback)
		{
			dragNode_source = TREE.getSelected();
			TREE.checkNodeIsLast(dragNode_source[0]);
			dragNode_source.prev().remove();
			dragNode_source.remove();
			if(typeof(callback) == 'function')
			{
				callback(dragNode_destination);
			}
		};

		TREE.init = function(obj)
		{
			TREE.setTreeNodes(obj, false);
		};
		TREE.init(ROOT);
	});
}
