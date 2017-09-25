$(document).ready(function() {
    //单击收藏题目时效果
    $('.collection').click(function() {
		var obj = $(this);
		var t = obj.children('span:nth-child(1)').text()
		//console.log(t);
		//console.log(test_id);
		console.log($(this).parent().parent().parent().attr('q_id'));
		
		if(t=='收藏'){
			$.post(base_url+'test/question_like',{'test_id':test_id,'question_id':$(this).parent().parent().parent().attr('q_id')},function(da){
				if(da==1){
					obj.addClass('off');
					obj.children('span:nth-child(1)').text('取消收藏')
					obj.children('span:nth-child(1)').attr('class','qxsh')
				}
			})
		}
		if(t=='取消收藏'){
			$.post(base_url+'test/question_like_del',{'test_id':test_id,'question_id':$(this).parent().parent().parent().attr('q_id')},function(da){
				if(da==1){
					obj.removeClass('off');
					obj.children('span:nth-child(1)').text('收藏')
					obj.children('span:nth-child(1)').attr('class','sh')
				}
			})
		}
		//<span class="qxsh">取消收藏</span>
    })
    $(window).scroll(function() {
            //console.log($(document).scrollTop())
        })
    
	//页面元素“题型按钮”固定
	
    var top01 = $('.item-type-btns').offset().top;
    //console.log("top01:", top01)
    $('.item-type-btns').affix({
        offset: {
            top: top01
        }
    })
    /*$('.test-answer-card').affix({
        offset: {
            top: top01
        }
    })*/


    //单击答题卡片上的试题编号时跳转效果实现方法
    $('.question-indexs').on('click', '.btn-round', function() {
        var currpostion = $($(this).data('destination')).offset().top;
        $(document).scrollTop(currpostion - 55)
    })

    //自动更新导航插件，会根据滚动条的位置自动更新对应的导航目标。
    var $body = $(document.body);
    $body.scrollspy({
        target: '#item-type-btns',
        offset: 100
    });
	
    $(window).on('load', function() {
        $body.scrollspy('refresh');
    });

	//下次再做
    $('#suspend').on('click', function() {
		var results={};
		var obj = $('.test-question');//对象题
		var question_count = obj.length;
		var radio_count=0;
		var get_result=function(){
			for(var i=0;i<question_count;i++){
				this.obji = obj.eq(i); //对象eq(i)
				this.q_id = this.obji.attr('q_id');//试题id
				this.q_types = this.obji.attr('q_type');
				if(this.q_types=='choice' || this.q_types=='choices_n' || this.q_types=='choices'){
					this.radio_obj = this.obji.children('div:nth-child(2)');//选项对象
					radio_count = this.radio_obj.children().length;
					if(this.q_types=='choice'){
						this.answer_i = this.radio_obj.children().find('input[type="radio"]:checked').val();//获取每一个选项的值
						save_question();//alert(this.answer_i)
					}else{
						
						this.checkbox_count = this.radio_obj.children().find('input[type="checkbox"]:checked').length;
							this.answer_i = [];
							for(var checki=0;checki<this.checkbox_count;checki++){
								this.answer_i[checki] = this.radio_obj.children().find('input[type="checkbox"]:checked').eq(checki).val();
								
							}
						save_question();	
					}
				}
				
				if(this.q_types=='fill'){
					this.answer_i = [];
					var fill_length = this.obji.find('input[type="text"]').length;
					for(var filli=0;filli<fill_length;filli++){
					this.answer_i[filli] = this.obji.find('input[type="text"]').eq(filli).val();			
					}
					save_question();
				}				

				if(this.q_types=='judge'){
					this.answer_i = this.obji.find('input[type="radio"]:checked').val();
					save_question();
				}
				if(this.q_types=='wenda' || this.q_types=='material'){
					this.answer_i = this.obji.find('textarea').val();
					save_question();
				}
			};
			
			var u_id = $('.test-top-about').attr('u_id');
			var test_id = $('.test-top-about').attr('test_id');
			//console.log(results);

			$.post(base_url+'test/record_result',{result:results, usedTime:usedTime,'u_id':u_id,'test_id':test_id},function(data){
				window.location.href=""+base_url+"my/test/overdue"; 
			})

			function save_question(){
				results[i] = {'answer_i':answer_i,'q_id':this.q_id,'q_type':this.obji.attr('q_type')};
			}
		}
		get_result();

    });	
	
	
	//我要交卷
	$('body').on('click', '#finishPaper', function(){
		$('#testpaper-finished-dialog').modal('show');
	});
	
	//正在交卷
	$('#testpaper-finish-btn').on('click', function(){
		$finishBtn = $('#finishPaper');
		$('#testpaper-finish-btn').button('saving');
		$('#testpaper-finish-btn').attr('disabled', 'disabled');

		timer.stop();
		if (isAjaxing == 0) {
			$.post(base_url+'test/testover',{'test_id':test_id,'usedTime':usedTime},function(data){
				window.location.href = base_url+'test/result/'+test_id;
			})			
		} else {
			timerFinish = setInterval(function(){
				if (isAjaxing == 0) {
					clearInterval(timerFinish);
					$.post(base_url+'test/testover',{'test_id':test_id,'usedTime':usedTime},function(data){
						window.location.href = base_url+'test/result/'+test_id;
					})	
				}
			}, 1000);
		}
	});
	
	
    //如果当前题目 “已答” ，则在右侧卡片上做出标记  开始

    var changeAnswers = {};

    $('*[data-isempty]').each(function(index) {

        var name = $(this).data('i'); //name 为当前 题的 id 的 question 后面的数字 即可以标识“哪道题”
		
        $(this).on('change', function() {

            // var name = $(this).attr('name');
            //console.log("触发了")

            var values = [];
            //choice 选择题
            if ($(this).data('isempty') == 'radio-choice') {

                $('input[data-i=' + name + ']:checked').each(function() {
                    values.push($(this).val()); //$(this).val() 取出来的内容 选择题：为第几个选项 问答/填空：为具体输入的内容（总而言之：答案）
                    //console.log("values存储的答案内容：", values[0])
                });

            }
			 //choice 选择题
            if ($(this).data('isempty') == 'multiple-choice') {

                $('input[data-i=' + name + ']:checked').each(function() {
                    values.push($(this).val()); //$(this).val() 取出来的内容 选择题：为第几个选项 问答/填空：为具体输入的内容（总而言之：答案）
                    //console.log("values存储的答案内容：", values[0])
                });

            }
            //determine 判断题
            if ($(this).data('isempty') == 'judge-choice') {

                $('input[data-i=' + name + ']:checked').each(function() {
                    values.push($(this).val());
                });

            }
            //fill 填空题
            if ($(this).data('isempty') == 'fill-blacks') {

                $('input[data-i=' + name + ']').each(function() {
                    values.push($(this).val());
                });

            }
            //essay 问答题
            if ($(this).data('isempty') == 'area-textarea') {
                var $this = $(this);
                if ($this.val() !== "") {
                    values.push($this.val());
                }
            }
			//essay 材料题
            if ($(this).data('isempty') == 'material') {
                var $this = $(this);
                if (!$this.val() !== "") {
                    values.push($this.val());
                }
            }

            changeAnswers[name] = values; //存储 题  答案

            //console.log("当前题的 编号：", name) //changeAnswers存储的是当前题的 编号 + 对应内容
            //console.log(changeAnswers); //输出JSON对象内容

            if (values.length > 0 && !isEmpty(values)) {
                $('a[data-destination="#question' + name + '"]').addClass('active');
            } else {
                $('a[data-destination="#question' + name + '"]').removeClass('active');
            }


        });
    });

    function isEmpty(values) {
        for (key in values) {
            if (values[key] != '') {
                return false;
            }
        }
        return true;
    }
    //... 如果当前题目 “已答” ，则在右侧卡片上做出标记  结束

    ///////计时器开始
    // 做试卷
    var interval = 600;
	var changeAnswers = {};
    var isAjaxing = 0;
    var deadline = $('#time_show').data('time'); ////初始值为3000
    var usedTime = 0;
    var isLimit = true;
    var timerFinish = null;

    if (deadline == null) {
        isLimit = false;
        deadline = interval * 3;
    } else {
        isLimit = true;
    }

    var timeLastPost = deadline - interval; ////2400

    //计时器...

    if ($('#time_show').hasClass('preview')) {
        $('#time_show').text(formatTime(deadline));
    }

    if ($('#finishPaper').hasClass('do-test')) {

        var timer = timerShow(function() {
            deadline--; ////初始时间
            usedTime++; ////消耗的时间
            $('#time_show').text(formatTime(deadline));

            if (deadline <= 0) {

                timer.stop();

                if (isAjaxing == 0) {
						//更新时间
						var test_id = $('.test-top-about').attr('test_id');
						$.post(base_url+'test/testover',{'test_id':test_id,'usedTime':usedTime},function(data){
							post_testpaper();
							$('#timeout-dialog').show();
							timer.stop();
						})								

						
                } else {
                    timerFinish = setInterval(function() {
                        if (isAjaxing == 0) {
                            clearInterval(timerFinish);
                            $.post($('#finishPaper').data('url'), {
                                data: changeAnswers,
                                usedTime: usedTime
                            }, function() {
                                changeAnswers = {};
                                usedTime = 0;
                                $('#timeout-dialog').show();
                            }).error(function() {
                                $('#timeout-dialog').find('.empty').text('系统好像出了点小问题，请稍后再交卷');
                                $('#timeout-dialog').find('#show_testpaper_result').text('确定');
                                $('#timeout-dialog').show();
                            });
                        }
                    }, 1000);
                }

            }

        }, 1000, true);

        $('#pause').on('click', function() {
            timer.pause();
        });
        $('div#pauseModal').on('hidden.bs.modal', function() { //弹框关闭后继续
            timer.play();
        });

    }
    function timerShow(func, time, autostart) {
        /**/this.set = function(func, time, autostart) {
            this.init = true;
            if (typeof func == 'object') {
                var paramList = ['autostart', 'time'];
                for (var arg in paramList) {
                    if (func[paramList[arg]] != undefined) {
                        eval(paramList[arg] + " = func[paramList[arg]]");
                    }
                };
                func = func.action;
            }
            if (typeof func == 'function') {
                this.action = func;
            }
            if (!isNaN(time)) {
                this.intervalTime = time;
            }
            if (autostart && !this.isActive) {
                this.isActive = true;
                this.setTimer();
            }
            return this;
        };
        this.once = function(time) {
            var timer = this;
            if (isNaN(time)) {
                time = 0;
            }
            window.setTimeout(function() {
                timer.action();
            }, time);
            return this;
        };
        this.play = function(reset) {
            if (!this.isActive) {
                if (reset) {
                    this.setTimer();
                } else {
                    this.setTimer(this.remaining);
                }
                this.isActive = true;
            }
            return this;
        };
        this.pause = function() {
            if (this.isActive) {
                this.isActive = false;
                this.remaining -= new Date() - this.last;
                this.clearTimer();
            }
            return this;
        };
        this.stop = function() {
            this.isActive = false;
            this.remaining = this.intervalTime;
            this.clearTimer();
            return this;
        };
        this.toggle = function(reset) {
            if (this.isActive) {
                this.pause();
            } else if (reset) {
                this.play(true);
            } else {
                this.play();
            }
            return this;
        };
        this.reset = function() {
            this.isActive = false;
            this.play(true);
            return this;
        };
        this.clearTimer = function() {
            window.clearTimeout(this.timeoutObject);
        };
        this.setTimer = function(time) {
            var timer = this;
            if (typeof this.action != 'function') {
                return;
            }
            if (isNaN(time)) {
                time = this.intervalTime;
            }
            this.remaining = time;
            this.last = new Date();
            this.clearTimer();
            this.timeoutObject = window.setTimeout(function() {
                timer.go();
            }, time);
        };
        this.go = function() {
            if (this.isActive) {
                this.action();
                this.setTimer();
            }
        };

        if (this.init) {
            return new $.timer(func, time, autostart);
        } else {
            this.set(func, time, autostart);
            return this;
        }
    };
    function formatTime(time) { ////函数功能：将秒转为分：秒 58:45
        // time = time / 10;
        var min = parseInt(time / 60),
            sec = time - (min * 60);
        return (min > 0 ? pad(min, 2) : "00") + ":" + pad(sec, 2);
    };

    function pad(number, length) { ////保证“秒数”显示是两位数字
        var str = '' + number;
        while (str.length < length) {
            str = '0' + str;
        }
        return str;
    };
	
})
//获取所填答案
var post_testpaper=function(){
		this.results={};
		this.obj = $('.test-question');//对象题
		this.question_count = this.obj.length ;
		this.result = {};
		this.radio_count=0;
		this.get_result=function(){
			for(var i=0;i<question_count;i++){
				this.obji = this.obj.eq(i); //对象eq(i)
				this.q_id = this.obji.attr('q_id');//试题id
				this.q_types = this.obji.attr('q_type');
				if(this.q_types=='choice' || this.q_types=='choices_n' || this.q_types=='choices'){
					this.radio_obj = this.obji.children('div:nth-child(2)');//选项对象
					this.radio_count = this.radio_obj.children().length;
					if(this.q_types=='choice'){
						this.answer_i = this.radio_obj.children().find('input[type="radio"]:checked').val();//获取每一个选项的值
						save_question();
					}else{
						
						this.checkbox_count = this.radio_obj.children().find('input[type="checkbox"]:checked').length;
							this.answer_i = [];
							for(var checki=0;checki<this.checkbox_count;checki++){
								this.answer_i[checki] = this.radio_obj.children().find('input[type="checkbox"]:checked').eq(checki).val();
								
							}
						save_question();	
					}
				}
				
				if(this.q_types=='fill'){
					this.answer_i = [];
					var fill_length = this.obji.find('input[type="text"]').length;
					
					for(var filli=0;filli<fill_length;filli++){
					this.answer_i[filli] = this.obji.find('input[type="text"]').eq(filli).val();			
					}
					save_question();
				}
				
				if(this.q_types=='judge'){
					this.answer_i = this.obji.find('input[type="radio"]:checked').val();
					save_question();
				}
				if(this.q_types=='wenda' || this.q_types=='material'){
					this.answer_i = this.obji.find('textarea').val();
					save_question();
				}
			};

			testresu(results);

			function save_question(){
				results[i] = {'answer_i':answer_i,'q_id':this.q_id,'q_type':this.obji.attr('q_type')};
			}
		}
		this.get_result();
		
	}


	function testresu(a){
		var u_id = $('.test-top-about').attr('u_id');
		var test_id = $('.test-top-about').attr('test_id');console.log(a)
		
		$.post(base_url+'test/item_result',{'result':a,'u_id':u_id,'test_id':test_id},function(data){
			$('html').append(data)
		})
	}
	
	function f(){
		var c=$('input[type="radio"]:checked').length;
		for(var i=0;i<c;i++){
			console.log($('input[type="radio"]:checked').eq(i).val());
		}
	}
