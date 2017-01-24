(function($) {

var exe = (function() {

	return {
    
		opts: {
            crtClass: 'crnt',
            btnID: '.top_btn',
            all: 'html, body',
            animEnd: 'webkitAnimationEnd MSAnimationEnd oanimationend animationend', //mozAnimationEnd
            transitEnd: 'webkitTransitionEnd MSTransitionEnd otransitionend transitionend', //mozTransitionEnd 
        },
        
        scrollFunc: function() {
            var t = this,
                tb = $(t.opts.btnID);
            
            tb.css('display','none').on('click', function() {
                $(t.opts.all).animate({ scrollTop:0 }, 1200, 'easeOutExpo');
            });

            $(document).scroll(function(){

                if($(this).scrollTop() < 200)
                    tb.fadeOut(200);
                else 
                    tb.fadeIn(300);
            });
            
        },
        
        
        isAgent: function(user) {
            if( navigator.userAgent.indexOf(user) > 0 ) return true;
        },
        
        isLocal: function() {
        	if( location.port == 8006 ) return true;
        },
        
        isSpTab: function(arg) {

        	var spArr = ['iPhone','iPod','Mobile ','Mobile;','Windows Phone','IEMobile'];
            var tabArr = ['iPad','Kindle','Sony Tablet','Nexus 7','Android Tablet'];
            var arr = [];
            
            if(arg == 'sp')
            	arr = spArr;
            
            else if(arg == 'tab')
            	arr = tabArr;
            
            else
            	arr = spArr.concat(tabArr);
            
        	
            var th = this;
            var bool = false;
            
            arr.forEach(function(e, i, a) {
            	if(th.isAgent(e)) {
                	bool = true;
                    return; //Exit
                }
            });
            
            return bool;
        },
        
        
        put: function(tag, argText) {
            $(tag).text(argText);
            console.log("CheckText is『 %s 』" , argText);
        },
        
        autoComplete: function() {
           
            var data = [];
           
            $('.tag-control').each(function(){
            	var group = $(this).attr('id');
                var tagList = $(this).next('span').text();
                //$('.panel-heading').text(tagList);
                
                data[group] = tagList.split(',');
                
                $('#' + group).autocomplete({
                    source: data[group],
                    autoFocus: true,
                    delay: 400,
                    minLength: 1,
                    
                    select: function(e, ui){
                    	$(e.target).siblings('.tag-area').append('<span style="border: 2px solid orange;">' + ui.item.value + '</span>');
                        ui.item.value = '';
                        //$('input').val('aaa');
                    },
                    close: function(e, ui){
                    	//$('.ui-front').css({display:'block', height:'auto'});
//                        $('#ui-id-1').css({display:'block', height:'200px', width:'100px'}).append('<li class="ui-menu-item" role="presentation"><a class="ui-corner-all"></a></li>');
                    },
                    search: function(e, ui){
                    	//if(ui.item.label == '')
//                        $('.panel-heading').text('abcde');
//                        $('.ui-front').css({display:'block', height:'auto'});
						
                    },
                    response: function(e, ui){
                    	if($('.c-ul').is(':hidden')) {
                    		$(e.target).siblings('.c-ul').css({display:'block', height:'auto', width:'100px', border:'1px solid red'});
                        }
						
//                    	//$('.panel-heading').text(ui.content.data['label']);
                    	if(ui.content == '') {
                        	//$('#ui-id-1').css({display:'block', height:'100px', width:'100px', left:'50%', top:'50%'});
                        	//$('.panel-heading').text($(e.target).attr('id'));
                            //$('.ui-autocomplete').css({display:'block', height:'200px'});
                            //$('.ui-autocomplete').append('<li>');
                            
                            $(e.target).on('keyup', function(event){
								var text = $(this).val();
                            	$('.panel-heading').text(text);
                            	$('.c-ul li a').text(text);
                            
                            });
                            
                            //$(this).autocomplete('widget').find('li').text('bbb');
                        }
                    	
                    },
                    
            	});

                
                $('#' + group).siblings('.c-ul').find('li a').on('click keydown', function(event){
                	console.log(event.which);
                	if (event.which == 1 || event.which == 13) {
                        var texts = $(this).text();
                        $('#' + group).siblings('.tag-area').append('<span style="border: 2px solid orange;">' + texts + '</span>');
                        $('#' + group).val('');
                        $('.c-ul').css({display:'none'});
                    }
                });
                
                $('#' + group).on('keydown', function(event){ //keypress
                	console.log(event.which);
                    
                	if(event.which == 13)
                    	event.preventDefault();
                    
//                    if(event.which == 40 && $('.c-ul').is(':visible'))
//                    	$('.c-ul li a').focus();
                    	
                });
                
                
//                $('#' + group).on('keyup', function(e){
//                	//if (e.which == 13) {
//                    
//                	var text = $(this).val();
//                    $('.ui-front').css({display:'block', height:'auto'});
//                    $(this).autocomplete( "search", text );
//                    //$(this).autocomplete('widget').find('li').text(text);
//                    //$('.tag-area').append('<span style="border: 2px solid orange;">' + text + '</span>');
//                    //}
//                });
            
            });
           
           
//            $('.tag').each(function(){
//            	var group = $(this).attr('id');
//            	$('.panel-heading').text(group);
//                
//                $('#' + group).autocomplete({
//                    source: function(req, resp){
//                        $.ajax({
//                            url: '/script/autocomplete.php',
//                            type: "POST",
//                            cache: false,
//                            dataType: "json",
//                            data: {
//                              param1: req.term,
//                              group: group,
//                            },
//                            success: function(resData){
//                                resp(resData);
//                                $('.panel-body').html(resData);
//                            },
//                            error: function(xhr, ts, err){
//                                resp(['']);
//                            }
//                          });
//
//                    },
//                    autoFocus: true,
//                    delay: 500,
//                    minLength: 2
//            	});
//            
//            });
           
//            $('.tag').autocomplete({
//                //source: data,
//                //source: '/script/autocomplete.php',
//                source: function(req, resp){
//                	
//                    $('.panel-heading').text($(this).attr('id'));
//                
//                    $.ajax({
//                        url: '/script/autocomplete.php',
//                        type: "POST",
//                        cache: false,
//                        dataType: "json",
//                        data: {
//                          param1: req.term,
//                          group: 'keyword',
//                        },
//                        success: function(resData){
//                            resp(resData);
//                            //$('.panel-body').html(resData);
//                        },
//                        error: function(xhr, ts, err){
//                            resp(['']);
//                        }
//                      });
//
//                },
//                autoFocus: true,
//                delay: 500,
//                minLength: 2
//            });
        },
        
        
    } //return

})();


$(function(e){ //ready
    
    exe.autoComplete();
    
    exe.scrollFunc();
    
});



})(jQuery);
