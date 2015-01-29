/**
 * colapsible element - stores state in cookie
 * 
 * head (class colapsible-head)
 * body (class colapsible-body)
 * trigger (class "colapsible-trigger")
 * 
 * @author janko
 */

(function($) {
	//
	// plugin definition
	//
	$.fn.collapsible = function(options) {
		
		// build main options before element iteration
		var opts = $.extend({}, $.fn.collapsible.defaults, options);
		
		// iterate and reformat each matched element
		return this.each(function() {
			
			var $this = $(this);
			var COLLAPSIBLE = this;
			
			var bOpened;
			
			var jBody=$(".collapsible-body",$this); 
			
			var jTrigger=$(".collapsible-trigger",$this).click(
				function(e)
				{
					e.preventDefault();
					
					if(bOpened)
						hide(true)
					else
						show(true);								
				}
			);
			
			var c=$.cookie("collapsible-"+opts['name']);
			
			if(c && c=="1")
			{				
				show();
			}
			else
			{				
				hide();
			}
			
			function show(bMove)
			{
				var bMove=bMove==true;
				
				if(bMove)
					jBody.slideDown();
				else
					jBody.show();					
					
				jTrigger.html(opts['hidetxt']).removeClass(opts['showclass']).addClass(opts['hideclass']);;
				
				bOpened=true;
				
				$.cookie("collapsible-"+opts['name'],"1", { expires: 2});		
			}
			
			
			function hide(bMove)
			{
				var bMove=bMove==true;
				
				if(bMove)
					jBody.slideUp();
				else
					jBody.hide();	
					
					
				jTrigger.html(opts['showtxt']).removeClass(opts['hideclass']).addClass(opts['showclass']);
				
				bOpened=false;
				
				$.cookie("collapsible-"+opts['name'],"0", { expires: 2});
			}
			
			
			COLLAPSIBLE.collapsibleHide = function(bMove){
				hide(bMove);
			}
			
			
			COLLAPSIBLE.collapsibleShow = function(bMove){
				show(bMove);
			}
		});
	};
	
		
	
	//
	// plugin defaults
	//
	$.fn.collapsible.defaults = {
		showtxt : 'otvoriť',
		hidetxt : 'zatvoriť',
		showclass : 'collapsible-down',
		hideclass : 'collapsible-up',
		name : 'cream'
	};
	
	
//
// end of closure
//
})(jQuery);
