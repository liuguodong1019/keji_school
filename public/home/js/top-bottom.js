$(document).ready(function  () {
		var removeNavMobile = function() {
		    $(".nav-mobile,.html-mask").removeClass("active");
		    $("html,.cb-wrap").removeClass("nav-active");
		}

		$(".more-btn").click(function(e) {
		    var $nav = $(".nav-mobile");

		    if ($nav.hasClass("active")) {
		        removeNavMobile();

		    } else {
		        var height = $(window).height();
		        $nav.addClass("active").css("height", height);

		        $(".html-mask").addClass("active");
		        $("html,.cb-wrap").addClass("nav-active");
		    }
		});

	    //菜单hover时显示下拉菜单
	    $('nav.collapse ul li.nav-hover').hover(function(){
	        $(this).addClass('open');
	    },function(){
	        $(this).removeClass('open');
	    })

	    //调用bootstrap工具提示 函数
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
		
})
function alert_true_msg(msg,time){
	if(msg==null){msg='保存成功'}
	if(time==null){time=4000}
	$(".alert_msg").prepend('<div id="alert">'+msg+'</div><br>')
	setTimeout(function(){
		$("#alert").css('display','none')
	},time)
}
function alert_false_msg(msg,time){
	if(msg==null){msg='保存失败'}
	if(time==null){time=4000}
	$(".alert_msg").prepend('<div id="alert" style="background:pink">'+msg+'</div><br>')
	setTimeout(function(){
		$("#alert").css('display','none')
	},time)
}
