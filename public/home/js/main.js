$(document).ready(function() {
    //bootstrap popover.js 组件应用
    $('[data-toggle="popover"]').popover(
            {
                trigger:'manual', //触发方式
                placement:'top',
                html: true, // 为true的话，data-content里就能放html代码了
                content:'<div id="user-card-9" class="js-card-content" data-user-id="9"><div class="card-header media-middle"><div class="media"><div class="media-left"><a class=" " href="#" data-card-url="" data-user-id="9"><img class="card-img" src="images/dynamic01.jpg"></a></div><div class="media-body"><div class="title"><a class="link-light " href="/web/user/9">小明</a></div><div class="content">网络管理学生</div></div></div><div class="metas"><a class="btn btn-primary btn-high btn-xs follow-btn" href="javascript:;" data-url="/web/user/9/follow" data-loggedin="1">关注</a><a class="btn btn-default btn-high btn-xs unfollow-btn" href="javascript:;" data-url="/web/user/9/unfollow" style="display:none;">已关注</a><a class="btn btn-default btn-xs direct-message-btn" herf="javascript:;" data-toggle="modal" data-target="#modal" data-url="/web/message/create/9">私信</a></div></div><div class="card-body">勇敢超越一切</div><div class="card-footer clearfix"><span><a href="#">12<br>在学</a></span><span><a href="#">3<br>关注</a></span><span><a href="#">1<br>粉丝</a></span></div></div>'
            }
    ).on("mouseenter",function(){
        var _this = this;
        $(this).popover("show");

        $(this).siblings(".popover").on("mouseleave",function(){
            //console.log("这个")
            $(_this).popover("hide");
        });

        $(this).on("mouseleave",function(){
            //console.log("那个")
            var _this = this;
            setTimeout(function(){
                if(!$(".popover:hover").length){
                    $(_this).popover("hide");
                }
            },10)
        })
    })
    $('#g-dynamic .d-student .media-left>a').mouseenter(function(){
        $('.popover').addClass('top')
    })

    //已关注、关注按钮间的切换
    $('.attention').click(function(){
        $(this).css('display','none');
        $(this).next('.be-attention').css('display','inline-block')
    })
    $('.be-attention').click(function(){
        $(this).css('display','none');
        $(this).prev('.attention').css('display','inline-block')
    })
})








