(function($){
	
	
	$(function(){
		
		
		//deco selects
		 $("select.deco").each(function(){
            $(this).wrap('<div class="deco-sel"></div>');                   
        }).on("focus",function(){
        	$(this).parent(".deco-sel").addClass("focus")
        }).on("blur",function(){
        	$(this).parent(".deco-sel").removeClass("focus")
        });
        
        
        
		//MULTIPLE selects on grid
		
		function multiSelectize(sel) {
			
			//all selects or a specified one
			var select = sel !==undefined ? $(sel) : $(".multiSel") 
			
			var $mulS = select.multipleSelect({
				filter : true,
				width : '100%',
				onClick : function() {

				}
			});
			
			$mulS.each(function(k,v){
				var that = $(this)

				var ms = that.data("multipleSelect")
	
				ms.moveInput = function() {
					var inputDiv = ms.$drop.find(".ms-search").detach();
	
					ms.$choice.append(inputDiv)
					var input = ms.$choice.find("input").attr("placeholder", "Type...")
				}
	
				ms.moveInput()
	
				var _fnOpen = ms.open;
				var _fnClose = ms.close;
							
				ms.open = function() {
			        _fnOpen.call(ms);
			        ms.$parent.addClass("active");
			        
			        $(document).bind("click.multiSelect"+k,function(ev){
			        	var target = $(ev.target); 
			        	
			        	if (!ms.$parent.has(target).length) {
			        		ms.close();
			        		$(document).off("click.multiSelect"+k)
			        	}
			        	
			        })
			    }
	        
		        ms.close = function() {
		        	_fnClose.call(ms);
		        	ms.$parent.removeClass("active")        	   
	        	}
        	
        	})
			
		}

		if ($(".multiSel").length) {
			multiSelectize()	
		}
							
	})
})(jQuery)
