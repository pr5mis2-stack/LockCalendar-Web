jQuery.fn.vertSlider = function(options) {

	var ie7_flag = false;
	ie7_flag = (window.navigator.userAgent.indexOf("MSIE 7") != -1);
	
	$('#main-container').css('overflow', 'hidden');
	$('#side-nav').css('visibility', 'visible');
	
	return this.each(function() {

    
        $(this).click(function() {
            var index = $('#side-nav a').index(this);
            var checkAll = "#side-nav li";
            $(checkAll).each(function(){
            	$(this).removeClass("on");
            });
            $("#menu"+index).addClass("on");
            if (ie7_flag)
            {
                $("#main-container-background div").each(function(){
                	$(this).hide();
                });
            	
            	$(".s"+index).show();
            }
            else
            	$("#main-container-background").animate({ top: index * -695 }, 'slow');
        });
    });
};	
	
