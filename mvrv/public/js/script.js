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
           
           	function addTagOnArea(target, text, groupId, val=0) {
           		var $tagArea = $(target).siblings('.tag-area');
           		var bool = true;
           
                $tagArea.find('.text-danger').remove();
           
                $tagArea.find('span').each(function(){
                	var preTag = $(this).text();

                	if(text == preTag) {
                    	bool = false;
                    }
                });
           
           		if(bool) {
                	//$tagArea.append('<span data-text="'+text+'" data-group="'+groupId+'" data-value="'+val+'"><em>' + text + '</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>');
                    $tagArea.append('<span><em>' + text + '</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>');
           			$tagArea.append('<input type="hidden" name="'+groupId+'[]" value="'+text+'">');
                }
                else {
           			$tagArea.prepend('<p class="text-danger"><i class="fa fa-exclamation" aria-hidden="true"></i> 既に追加されているタグです</p>');
                }
           
                return bool;
            }
           
            $(document).delegate('.del-tag', 'click', function(e){
                var $span = $(e.target).parent('span');
//                if($span.data('value'))
//                	data[$span.data('group')].splice($span.data('value'), 0, $span.data('text')); //or push
                
                $span.next('input').remove(); //先にinputをremove
                $span.fadeOut(150).remove();
            });
           
           
            $('.tag-control').each(function(){
            	var group = $(this).attr('id');
                var tagList = $(this).siblings('span').text();
                //$('.panel-heading').text(tagList);

                data[group] = tagList.split(',');
                var $tagInput = $('#' + group);
                
                $tagInput.autocomplete({
                    source: data[group],
                    autoFocus: true,
                    delay: 50,
                    minLength: 1,
                    
                    select: function(e, ui){
                    	var $num = data[group].indexOf(ui.item.value); //配列内の位置
                        var bool = addTagOnArea(e.target, ui.item.value, group, $num);
                        if(bool) {
//                        	if($num != -1)
//                            	data[group].splice($num, 1); //リストから削除
	                        
                            ui.item.value = '';
                        }
                    },
                    
                    response: function(e, ui){
                    	//$('.panel-heading').text(ui.content['label']);
                    	//if(ui.content == '') {
                        	$(e.target).siblings('.add-btn:hidden').fadeIn(50).css({display:'inline-block'});
                            //console.log('response');
                        //}
                        //else {
                        //	$(e.target).siblings('.add-btn').fadeOut(100);
                        //}
                        
                        //$(this).autocomplete('widget')
                    },
                    close: function(e, ui){
                    	/*
                    	if($(e.target).val().length > 1) {
                        	$(e.target).siblings('.add-btn').fadeIn(100).css({display:'inline-block'});
                        }
                        */
                    },
                    focus: function(e, ui){
//                    	if($(e.target).val().length > 1) {
//                        	$(e.target).siblings('.add-btn').fadeIn(100).css({display:'inline-block'});
//                        }
                    },
                    search: function(e, ui){
                    },
                    
            	}); //autocomplete

                
                $tagInput.next('.add-btn').on('click keydown', function(event){
                	//console.log(event.which);
                	if (event.which == 1 || event.which == 13) {
                        var texts = $('#' + group).val();
                        
                        var bool = addTagOnArea('#' + group, texts, group);
                        if(bool) {
                        	$tagInput.val('');
                        	$(this).fadeOut(100);
                        }
                    }
                });
                
                $tagInput.on('keydown keyup', function(event){ //or keypress
                	if(event.which == 13) {//40
                    	if(event.type=='keydown') { // && $('.ui-menu').is(':hidden')
                        	var texts = $(this).val();
                            if(texts != '') {
                        		if(addTagOnArea(this, texts, group))
                             		$(this).val('');
                             
                            	console.log(event.type);
                            }
                        }
                    	event.preventDefault();
                    }
                    
                    //if($(this).val().length < 2) { //event.which == 8 &&
                    if(event.type=='keyup' && $(this).val().length < 1) {
                		$(this).next('.add-btn').fadeOut(50);
                	}
                    
                    if(event.which != 13 && event.which != 8 && $(this).val().length > 0) {
                    	$(this).siblings('.add-btn:hidden').fadeIn(100).css({display:'inline-block'});
                    }
                });
            
            }); //each function
           
        },
        
        addClass: function() {
        	//$('.add-item').find('.item-panel').eq(0).addClass('first-panel');
            $('.item-panel').eq(0).css({border:'2px solid green'});
        },
        
        nl2br: function(str) {
            str = str.replace(/\r\n/g, "<br>");
            str = str.replace(/(\n|\r)/g, "<br>");
            return str;
        },
        
        
        addItem: function() {
        	var th = this;
           
            function addPanelAndNavi($thisPanel, $addSection, $thisTarget, targetClass) {
           		//ctrl-nav add
                var $ctrlPanel = $('.visible-none').find('.ctrl-nav').clone(true, true);
                $addSection.prepend($ctrlPanel);
           		$ctrlPanel.find('.edit-sec').data('target', targetClass);
           
                //panel next追加
                var $itemPanel = $('.visible-none').find('.item-panel').clone(true, true);
                $addSection.after($itemPanel);
                $itemPanel.find('.item-'+targetClass).fadeOut(100);
           
                //panel prev追加
                var $itemPanelPrev = $('.visible-none').find('.item-panel').clone(true, true);
                $addSection.before($itemPanelPrev);
                $itemPanelPrev.find('.item-'+targetClass).fadeOut(100);
                
                //clickした親メニューを閉じる
                //if(! $thisPanel.hasClass('first-panel')) {
                //$thisPanel.find('.item-btn').fadeToggle(100);
           		$('.item-btn').fadeOut(100);
                $thisTarget.parent('div').fadeOut(100);
            }
           
            //submit ---------------------
           
        	$('.subm-title').on('click', function(e) {
                e.preventDefault();
                
                var submType = $(this).parents('.item-form').data('type');
                console.log(submType);
                
                var text = $(this).prevAll('input[type="text"]').val();
                
                var option = $(this).prev('select').val();
                var addTag = option == 1 ? '<h1>'+text+'</h1>' : '<h2>'+text+'</h2>';

                //var $thisSection = $(this).parents('.item-panel').prev('section');
                
                if(submType == 'edit') { //編集時
                  var $thisSection = $(this).parents('section');
                  $thisSection.find('h1').remove();
                  $thisSection.find('h2').remove();
                  $thisSection.prepend(addTag);
                  $thisSection.find('.item-title').slideUp(100);
                }
                else { //新規追加時
                    //親のpanelを取得
                    var $thisPanel = $(this).parents('.item-panel');
                    //section追加
                    $thisPanel.after('<section></section>');
                    var $addSection = $thisPanel.next('section');

					//親panelを編集用にしてsectionに追加
                    $thisPanel.find('.add-nav').remove();
                    $thisPanel.find('.item-btn').remove();
                    $thisPanel.find('.item-form').data('type', 'edit').children('div').hide();
                    //$thisPanel.find('.item-form').children('.item-title').find('select').val(option);
                    $thisPanel.find('.item-form').children('.type-hidden').val('title');
                    
                    $addSection.append(addTag).append($thisPanel);
					
                    //inputの中身を消す
                	//$(this).prevAll('input[type="text"]').val('');
                    
                    addPanelAndNavi($thisPanel, $addSection, $(this), 'title');
                }
                            
            });
            
            $('.subm-text').on('click', function(e) {
                e.preventDefault();
                
                var submType = $(this).parents('.item-form').data('type');
                
                var text = $(this).prev('textarea').val();
                var addTag = '<p>'+ th.nl2br(text) +'</p>';
                
                if(submType == 'edit') { //編集時
                	var $thisSection = $(this).parents('section');
                    $thisSection.find('p').remove();
                    $thisSection.prepend(addTag);
                    $thisSection.find('.item-text').slideUp(100);
                }
                else { //新規追加時
                	//親のpanelを取得
                    var $thisPanel = $(this).parents('.item-panel');
                    //section追加
                    $thisPanel.after('<section></section>');
                    var $addSection = $thisPanel.next('section');
                    
                    //親panelを編集用にしてsectionに追加
                    $thisPanel.find('.add-nav').remove();
                    $thisPanel.find('.item-btn').remove();
                    $thisPanel.find('.item-form').data('type', 'edit').children('div').hide();
                    $thisPanel.find('.item-form').children('.type-hidden').val('text');
                    
                    //add
                    $addSection.append(addTag).append($thisPanel);
                    
                    addPanelAndNavi($thisPanel, $addSection, $(this), 'text');
                }

            });
           
            //Image Submit
            $('.subm-image').on('click', function(e) {
                e.preventDefault();
                
                var submType = $(this).parents('.item-form').data('type');
                
                var $parent = $(this).parent('.item-image');
                
                if($parent.find('input[type="file"]').val() == '') {
                	$(this).after('<span class="text-danger">画像を追加して下さい</span>');
                    return false;
                }
                
                var title = $parent.find('input[type="text"]').eq(0).val();
                var orgurl = $parent.find('input[type="text"]').eq(1).val();
                var comment = $parent.find('textarea').val();
                var addPreview = $parent.find('.preview');
                var fileVal = $parent.find('input[type="file"]').val();
                //addTag
                var addTitle = '<h4>'+title+'</h4>';
                var addOrgurl = '<p>引用元：'+orgurl+'</p>';
                var addComment = '<p>コメント：'+th.nl2br(comment)+'</p>';
                
                if(submType == 'edit') { //編集時
                	var $thisSection = $(this).parents('section');
                    $thisSection.find('h4').remove();
                    $thisSection.find('p').remove();
                    $thisSection.prepend(addTitle).prepend(addOrgurl).prepend(addComment);
                    $thisSection.find('.item-image').slideUp(100);
                }
                else { //新規追加時
                	//親panel取得
                    var $thisPanel = $(this).parents('.item-panel');
                    //section追加
                    $thisPanel.after('<section></section>');
                    var $addSection = $thisPanel.next('section');
                    
                    //親panelを編集用にしてsectionに追加
                    $thisPanel.find('.add-nav').remove();
                    $thisPanel.find('.item-btn').remove();
                    $thisPanel.find('.item-form').data('type', 'edit').children('div').hide();
                    $thisPanel.find('.item-form').children('.item-image').find('textarea').val(comment);
                    //$thisPanel.find('.item-form').children('.item-image').find('input[type="file"]').val(fileVal);
                    $thisPanel.find('.item-form').children('.type-hidden').val('image');
                    
                    $addSection.append(addPreview)
                                .append(addTitle)
                                .append(addOrgurl)
                                .append(addComment)
                                .append($thisPanel);
                    
                    //追加内容を削除
                    //$(this).prevAll('input[type="text"]').val('');
                    //$(this).prevAll('textarea').val('');
                    
                    addPanelAndNavi($thisPanel, $addSection, $(this), 'image');
                }
              
            });
           
           	//Link submit
            $('.subm-link').on('click', function(e) {
                e.preventDefault();
                
                var submType = $(this).parents('.item-form').data('type');
                
                var $frame = $(this).prev('.link-frame');
                var title = $frame.find('div').eq(0).text();
                var url = $frame.find('div').eq(1).text();
                //image url取得 後ほど-----
                var imgUrl = $frame.find('img:visible').attr('src'); //find(img:visible).attr(src)
                // imageUrlEND------
                var option = $(this).prevAll('select').val();
                console.log(imgUrl);
                
                var addTag = '<a href="'+url+'">'+title+'<br><img src="'+imgUrl+'"></a>';
                
                if(submType == 'edit') { //編集時
                	var $thisSection = $(this).parents('section');
                    $thisSection.find('.link-frame').remove();
                    $thisSection.find('.link-frame').find('a').remove();
                    $thisSection.prepend($frame).after(addTag);
                    $thisSection.find('.item-link').slideUp(100);
                }
                else { //新規追加時
					//panel取得
                    var $thisPanel = $(this).parents('.item-panel');
                    //section 追加
                    $thisPanel.after('<section></section>');
                    var $addSection = $thisPanel.next('section');
                    
                    //親panelを編集用にしてsectionに追加
                    $thisPanel.find('.add-nav').remove();
                    $thisPanel.find('.item-btn').remove();
                    $thisPanel.find('.item-form').data('type', 'edit').children('div').hide();
                    $thisPanel.find('.item-link').find('.link-title-hidden').val(title);
                    $thisPanel.find('.item-link').find('.link-imgurl-hidden').val(imgUrl);
                    
                    console.log($thisPanel.find('.item-link').find('.link-title-hidden').val());
                    
                    $thisPanel.find('.item-form').children('.type-hidden').val('link');
                    
                    
                    $addSection.append(addTag).append($thisPanel);

                    addPanelAndNavi($thisPanel, $addSection, $(this), 'link');
                    
                    //追加内容を削除
                    //$(this).prevAll('input[type="text"]').val('');
                    //$frame.text('');
                }
              
            });

        },
        
        eventItem: function() {
			
            //ここに追加 Btn
			$('.add-nav em').on('click', function() {
            	var $itemBtn = $(this).parent().siblings('.item-btn');
            	$itemBtn.nextAll('.item-form').children('div').fadeOut(100);
                $itemBtn.slideToggle(150);
                
            });
           
           	//add-item click
           	function eventItemBtn(name) {
                $('.i-'+name).on('click', function() {
                	//console.log($(this).parents('.item-btn').siblings('.item-form').find('.item-'+name));
                    
                    var $itemForm = $(this).parents('.item-btn').siblings('.item-form');
                    var $item = $itemForm.find('.item-'+name);
                    
                    $itemForm.children('div').not('.item-'+name).slideUp(100, 'linear', function() { //$this-> all div
                        $item.stop().slideToggle(100);
                        //$(this).queue([]).stop();
                    });
                });
            }
           
            eventItemBtn('title');
           	eventItemBtn('text');
            eventItemBtn('image');
           	eventItemBtn('link');
           
           
            //Link Check Btn
            $('.subm-check').on('click', function(e){
            	e.preventDefault();
                
            	var url = $(this).parent('div').find('.link-url').val(); //input type=text
                var $frame = $(this).parent('div').find('.link-frame');
                //console.log(url);
                
                $.ajax({
                    url: '/script/addLink.php',
                    type: "POST",
                    cache: false,
                    data: {
                      url: url,
                    },
                    //dataType: "json",
                    success: function(resData){
                    	//console.log(resData.image[0]);
                        $frame.html(resData).slideDown(100);
                    },
                    error: function(xhr, ts, err){
                        //resp(['']);
                    }
                });
            });
           
           	//Image File load Btn
            $('.img-file').on('click', function(){
            	var $th = $(this);
                $th.on('change', function(e){
                	var file = e.target.files[0],
                    reader = new FileReader(),
                    $preview = $(this).prevAll('.preview');
                    t = this;

                    // 画像ファイル以外の場合は何もしない
                    if(file.type.indexOf("image") < 0){
                      return false;
                    }

                    // ファイル読み込みが完了した際のイベント登録
                    reader.onload = (function(file) {
                      return function(e) {
                        //既存のプレビューを削除
                        $preview.empty();
                        // .prevewの領域の中にロードした画像を表示するimageタグを追加
                        $preview.append($('<img>').attr({
                                  src: e.target.result,
                                  width: "150px",
                                  class: "preview",
                                  title: file.name
                              }));
                        console.log(file.name);
                      };
                })(file);

                reader.readAsDataURL(file);
                });
            	
            });
           
           
            $('.edit-sec').on('click', function(e) {
            	var d = $(this).data('target');
                console.log(d);
                $(this).parents('section').find('.item-'+ d).slideToggle(100);
            
            });
           
            $('.del-sec').on('click', function() {
                var speed = 250;
                var $thisSec = $(this).parents('section');
                var itemId = $thisSec.find('.item-id-hidden').val();
                
				$thisSec.next('.item-panel').fadeOut(speed);
                $thisSec.fadeOut(speed, function(){
                	$(this).next('.item-panel').remove(); //追加用の空panelは必ずremoveする
                    
                	if(itemId > 0) //itemIdのあるもの（既存データ）はremoveせずdelete_keyをSetする。それ以外はremove
                    	$(this).find('.delete-hidden').val(1);
                    else
                    	$(this).remove();
                });
            });
           
            $('.up-sec').on('click', function(e) {
            	var speed = 250;
                var $thisSec = $(this).parents('section');
                var $underPanel = $thisSec.next('.item-panel');
                var $target = $thisSec.prev('.item-panel').prev('section'); //section
                
                if($target.is('section')) { //is target
                    $underPanel.fadeOut(speed);
                    $thisSec.fadeOut(speed, function(){
                        $underPanel.insertBefore($target);
                        $thisSec.insertBefore($underPanel);
                        
                        $underPanel.fadeIn(150);
                        $thisSec.fadeIn(150);
                        
                    });
                }
                else {
                	console.log('nullnull');
                }
            
            });
           
            $('.down-sec').on('click', function(e) {
            	var speed = 250;
                var $thisSec = $(this).parents('section');
                var $underPanel = $thisSec.next('.item-panel');
                var $target = $underPanel.next('section').next('.item-panel'); //item-panel
                //console.log($target);
                
                if($target.is('div')) { //is target
                    $underPanel.fadeOut(speed);
                    $thisSec.fadeOut(speed, function(){
                        $thisSec.insertAfter($target);
                        $underPanel.insertAfter($thisSec);
                        
                        $underPanel.fadeIn(150);
                        $thisSec.fadeIn(150);
                        
                    });
                }
                else {
                	console.log('nullnull');
                }
            
            });
           
            //$('.linksel-wrap').find('span').live('click', function(e){
            $(document).delegate('.linksel-wrap span', 'click', function() {
            	var $img = $(this).parent('div').prev('.linkimg-wrap').find('img:visible');
                var num;
                if($(this).is(':first-child')) {
                	if($img.prev().is('img')) {
                		$img.fadeOut(100);
                    	num = $img.prev('img').fadeIn(100).data('count');
                    }
                }
                else {
                	if($img.next().is('img')) {
                    	$img.fadeOut(100);
                		num = $img.next('img').fadeIn(100).data('count');
                    }
                }
                
                $(this).siblings('small').find('em').eq(0).text(num);
            });
           
        },
        
        
    } //return

})();


$(function(e){ //ready
    
    exe.autoComplete();
    
    exe.scrollFunc();
  
  	//exe.addClass();
  
    exe.addItem();
    exe.eventItem();
    
});



})(jQuery);
