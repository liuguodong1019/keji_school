$(document).ready(function () {
	//课时列表底部边线判断
	$('ul.panel-keshi-body').each(function(){
		if($(this).find('li.chapter').size()==0){
			$(this).css('border','none')
		}
	})
	//单击章节标题时折叠展开
	$('ul.panel-keshi-body>li.chapter').click(function(){
        if(this.className=="chapter"){
            $(this).nextUntil().slideUp('600');
            $(this).find('.flo-l').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-right');
            $(this).addClass('zhankai');
        }else if(this.className=="chapter zhankai"){
            $(this).nextUntil().slideDown('600');
            $(this).find('.flo-l').removeClass('glyphicon-triangle-right').addClass('glyphicon-triangle-bottom');
            $(this).removeClass('zhankai');
        }
    })
	//单击扫一扫
	$('.saosao').click(function(){
		$(this).toggleClass('open');
	})
	//单击右侧工具条项目时效果
	$('.toolbar>ul>li.toolbar-item').click(function(){
		var n=$(this).index();
		console.log(n)
		if(this.className=="toolbar-item"){
			//展开内容栏
			$(this).parents('.toolbar-frame').addClass('toolbar-frame-open');
			$(this).parents('.course-lesson-frame').addClass('right-column-open');
			//选项变换
			$('.toolbar>ul>li.toolbar-item').removeClass('active').eq(n).addClass('active');
			$('.toolitem-cont-frame .toolitem-content').css('display','none').eq(n).css('display','block')
		}else if(this.className=="toolbar-item active"){
			//收起内容栏
			$(this).parents('.toolbar-frame').removeClass('toolbar-frame-open');
			$(this).parents('.course-lesson-frame').removeClass('right-column-open');
			//恢复默认值
			$('.toolbar>ul>li.toolbar-item').removeClass('active');
			$('.toolitem-cont-frame .toolitem-content').css('display','none');
		}
	})

	//单击">"按钮收起内容栏效果
	$('.hide-cont-btn').click(function(){
		$('.toolbar-frame').removeClass('toolbar-frame-open');
		$('.course-lesson-frame').removeClass('right-column-open');
		//恢复默认值
		$('.toolbar>ul>li.toolbar-item').removeClass('active');
		$('.toolitem-cont-frame .toolitem-content').css('display','none');
	})
})



document.onselectstart=new Function("event.returnValue=false;"); //禁止选择,也就是无法复制
