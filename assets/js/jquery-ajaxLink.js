/*
 * jQuery Ajax Link Plugin
 * @requires jQuery v1.2.2 or later
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
;(function($){
	$.fn.ajaxLink = function(options){
		
		var defaults = {
			target		: "#divLoadView",
			dataType	: "html",
			method		: "post",
			cache		: false,
			async		: true,
			beforeSend	: false,
			complete	: false,
			error		: false
			
		};
		
		var options = $.extend(defaults, options);
		
		return this.each(function(){
			$(this).click(function(){
				$.ajax({
					type		: options.method,
					url			: $(this).attr('href'),
					dataType 	: options.dataType,
					cache		: options.cache,
					async		: options.async,
					data		: $(this).attr('data'),
					beforeSend	: function(){ 
									if(options.beforeSend) options.beforeSend(); 
					},
					complete	: function(XMLHttpReq, textStatus){
									if(options.complete) options.complete(XMLHttpReq, textStatus);
					},
					success		: function(data){
									$(options.target).html(data); 
					},
					error		: function (event, request, settings){ 
									if (options.error) options.error(event, request, settings); 
					}
				});
				return false;
			});
		});
	};
})(jQuery);