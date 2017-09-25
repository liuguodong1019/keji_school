	//验证添加 章/节 时 内容是否为空
	function addcontkong(obj){
		if($(obj).parents('.modal-dialog').find('input[type="text"]').val()==""){
			$(obj).parents('.modal-dialog').addClass('has-error');
			$(obj).parents('.modal-dialog').find('.help-block').css('display','block');
		}
	}   
    //试卷管理
    function SelectAll(ee){
        //即勾上全选框
        if($(ee).prop('checked')==true){
            $(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked','checked')
        }else{
            $(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked',false)
        }
    }
    function SelectItem(ee){
        var num = 0;
        //勾选 列表中 的每一项时
        if($(ee).prop('checked')==true){
            //console.log(111);
            var ntr=$(ee).parents('tbody').find('tr').length;
            var objectcurr=$(ee).parents('tbody').find('tr');
            //console.log(ntr)
            for (var i=0;i<ntr;i++){
                //console.log("i",i)
                if($(ee).parents('tbody').find('tr').eq(i).find('input[type="checkbox"]').is(':checked')){
                    num++;
                }
                //console.log("num:",num)
            }
            if(num==ntr){
                $(ee).parents('table').next().find('input[type="checkbox"]').prop('checked',true)
            }           
        }else{
            $(ee).parents('table').next().find('input[type="checkbox"]').prop('checked',false)
        }
    }


    //单击 标签 框 时的效果
    var allwith=0;
    $('.select2-choices').click(function(event) {
        dropdownlist($(this).find('.select2-input'));
        var n =$(this).find('.select2-search-choice').length;
        var $obj=$(this).find('.select2-search-choice');
        for(var i=0;i<n;i++){
            allwith += parseInt($obj.eq(i).css('width'));
            console.log("i",i,"allwith",allwith)
        }
        var dyna_width=parseInt($(this).css('width'))-allwith-13
        $(this).find('.select2-input').css('width',dyna_width).focus();
        //return false;
        event.stopPropagation();  
    })
    //单击 页面其他位置时 关闭 下拉列表框
    $(document).click(function(e){
        $('.select2-container').removeClass('select2-container-active');
        $('.select2-drop').css('display','none');
    })
    //下拉列表项hover时效果
    $('.select2-results li').hover(function(){
        $(this).addClass('select2-highlighted')
    },function(){
        $(this).removeClass('select2-highlighted')
    })
    //单击 下拉列表 中 “项” 时 效果
    $('.select2-results li').on('click',function(){
        var con_text=$(this).find('div').text();
        var char_licont=""
            char_licont += '<li class="select2-search-choice">' 
            char_licont += '    <div>'+ con_text +'</div>'
            char_licont += '    <span class="close">×</span>'
            char_licont += '</li>';
        console.log(con_text,char_licont)
        $('.select2-choices .select2-search-choice').last().after(char_licont)
        $('.select2-input').focus().css('width',20);
        $('.select2-drop').css('display','none');
        $(this).remove(); //将 此项 从列表中清除
    })
    // 单击 标签 内容 的 X 时
    $('.select2-choices .close').click(function(){
        $(this).parent().remove();
    })

    function dropdownlist(obj) {//计算 下拉列表框 位置 宽、高
        $(obj).parents('.select2-container').addClass('select2-container-active')
        var topdistance = $(obj).parents('.select2-choices').offset().top;
        var leftdistance = $(obj).parents('.select2-choices').offset().left;
        var elementheight = parseInt($(obj).parents('.select2-choices').css('height'))
        var elementwidth = parseInt($(obj).parents('.select2-choices').css('width'))
        var topnum=elementheight+topdistance;
        console.log(topdistance, elementheight, leftdistance, elementwidth)
        $('.select2-drop').css({'width':elementwidth,'top':topnum,'left':leftdistance,'display':'block'})
    }
    
    ////////试卷题目管理开始
    //c_test2  单击不同体型按钮时显示相应的题目列表
	var lx_type=$('.nav-pills li:first').data('t');//
	var hanzi_type="";
    $('.test-ques-manage .nav li').click(function(){
        lx_type=$(this).data('t');
		hanzi_type=$(this).find('a').text();
        $('.test-ques-manage .nav li').removeClass('active');
        $(this).addClass('active');
		$('.test-ques-manage table tbody').addClass('hide')
		$('.test-ques-manage table').find('tbody[data-type="'+lx_type+'"]').removeClass('hide');
		get_score(lx_type,hanzi_type);
    })
	//试卷总分 试题分数
	var get_score =function(t,tt){
		var sum=0
		var sums = 0;
		var f = $('.nav-pills li:first').data('t');
		t = t || f;
		var obj  = $('tbody[data-type='+t+'] tr.sum_count td input[name="s_score"]')
		var c =obj.length;
		for(var i=0;i<c;i++){
			sum += (obj.eq(i).val())*1;
		}
		var objs  = $('tr.sum_count td input[name="s_score"]')
		var cs =objs.length;
		for(var is=0;is<cs;is++){
			sums += (objs.eq(is).val())*1;
		}
		$('.test_s').html(sums);
		$('.test_t').html(cs);
		$('.test-infos-type').html(tt);
		$('.test-infos-num').html(i);
		$('.test-infos-scroe').html(sum);
	}
	get_score();
	$('td input[type="text"]').on('blur',function(){
		get_score(lx_type);		
	})
	
	function question_select_id(){
		var qid='';
		var t = lx_type;
		var f = $('.nav-pills li:first').data('t');
		t = t || f;
		var obj  = $('tbody[data-type='+t+'] tr td input[type="checkbox"]');
		var c =obj.length;
		for(var i=0;i<c;i++){
			qid+=obj.eq(i).val()+',';
		}	
		return qid;
	}
	//批量选择题目
	function Choiceall(obj){
		if(lx_type == 'material'){
			m_Choiceall(obj);
		}else{
			a_Choiceall(obj);
		}
	}
	
	function m_Choiceall(obj){
		var str ='';
		var tihuan_str='';
        for(var i=0;i<$('.getque:checked').length;i++){
		var qid = $('.getque:checked:eq('+i+')').parent('span').parent('td').attr('q_id');
		$.get(base_url+"course_set/findsub",{'qid':qid},function(data){

		if(!is_tihuan){
			$('tbody[data-type="'+lx_type+'"]').prepend(data);
		}else{			
			re = new RegExp('</?tr>','g');
			tihuan_str = data.replace(re,' ');
			obj_tihuan.parent().html(tihuan_str);
		}
		$('#myModal_01').modal('hide');			
			
		})
		
        }
	}
	
	function a_Choiceall(obj){
		var str ='';
		var tihuan_str='';
		var arr = new Array();
        for(var i=0;i<$('.getque:checked').length;i++){
        trr = $('.getque:checked:eq('+i+')').parent('span').parent('td').parent('tr');//console.log(trr)
        k = $('.getque:checked:eq('+i+')').val();
        arr['q_id'] = $('.getque:checked:eq('+i+')').parent('span').parent('td').attr('q_id');
		arr['score'] = trr.children('td:nth-child(4)').children('span').text();
        arr['stem'] = trr.children('td:nth-child(2)').children('a').text();
        arr['cong'] = trr.children('td:nth-child(2)').children('small').text();
		arr['types'] = trr.children('td:nth-child(3)').text();
        if(k==1){
			arr['difficulty'] = '简单';
		}else if(k==2){
			arr['difficulty'] = '一般';
		}else{
			arr['difficulty'] = '困难';
		}
        str = str_questions(arr);
		
		
       if(!is_tihuan){
			$('tbody[data-type="'+lx_type+'"]').prepend(str);
		}else{
			re = new RegExp('</?tr>','g');
			tihuan_str = str.replace(re,' ');
			obj_tihuan.parent().parent().parent().html(tihuan_str);
            $('h_tihuan:checked').parent().parent().parent().remove();
		}
		$('#myModal_01').modal('hide');
 
        }	
	}
	
	//替换试题
	var is_tihuan = 0;
	var obj_tihuan = {};
	
	function tihuan(obj){
		obj_tihuan = $(obj).parent().parent().parent();
		is_tihuan = 1;
		get_question_list(is_tihuan)

	}	
	
    //单击 新增试题 时效果
    $('.xin_add').click(function(){
		is_tihuan =0;
		get_question_list(is_tihuan)
    })
	function get_question_list(is_tihuan){
		var parent = $('select[name="parent"]').val();
		var keyword = $('input[name="keyword"]').val();
		//获取当前选择的试题ID
		var s_qid = question_select_id();
		$.post(base_url+"course_set/add_question/"+cc_id,{'s_qid':s_qid,'lx_type':lx_type,'is_tihuan':is_tihuan,'parent':parent,'keyword':keyword},function(data){
			var da = data.split('[`&`]');
			if(da){
				$('select[name="parent"]').html(da[0]);
				$('.search_list').removeClass('hide');
				$('.search_list').html(da[1])
				search_list_style();
			}
		})
	}
		//搜索试题
		var parent = '';
		var key = '';
		var p ='';
		var nav = $('ul[class="pagination"] li');
		$('.search_question_list').click(function(){
			get_search_item();
			var s_qid = question_select_id();
			$.get(base_url+"course_set/search_question_list/"+cc_id,{'s_qid':s_qid,'lx_type':lx_type,'key':key,'parent':parent},function(data){
				$('.search_list').html(data);
				search_list_style();
			})
		})
		//xx页
		$("#myModal_01").on('click','ul[class="pagination"] li',function(){
			
			var obj={}
			obj =$(this);
			d =  new RegExp('\\d+','g');
			lt = new RegExp('<<','g')
			var is_d = d.exec(obj.children('a').text());
			var is_lt = lt.exec(obj.children('a').text());
			var a_li = $('ul[class="pagination"] li[class="active"]').children('a').text();
			if(is_d){
				p = obj.children('a').text();
			}else if(!is_lt){
				var n_p =a_li
				p = n_p*1+1;
			}else{
				if(a_li>=2){
					var n_p = a_li
					p = n_p*1-1;
				}else{
					return;
				}
			}
			$('ul[class="pagination"] li').removeClass('active');
			get_search_item();
			var s_qid = question_select_id();
			$.get(base_url+"course_set/xx_p/"+cc_id,{'s_qid':s_qid,'lx_type':lx_type,'p':p,'key':key,'parent':parent},function(d){
				$('.search_list').html(d);
				$('ul[class="pagination"] li').removeClass('active');
				var c = $('ul[class="pagination"] li').length;
				for(var i = 0;i<c;i++){
					var ps = $('ul[class="pagination"] li').eq(i).children('a').text();
					if(p==ps){
						$('ul[class="pagination"] li').eq(i).addClass('active');
						break;
					}
				}
			})
		})
		function search_list_style(){
			$('.search_list').removeClass('hide');
			$('ul[class="pagination"] li').removeClass('active');
			$('ul[class="pagination"] li:nth-child(2)').addClass('active');
		}
		function get_search_item(){
			p_c = nav.length;
			for(var i=0;i<p_c;i++){
				if(nav.eq(i).hasClass('active')){
					p = i+1;
				}
			}
			parent = $('select[name="parent"]').val();
			key = $('input[type="text"][name="key"]').val();
		}
    //单击预览 
   $("#myModal_01").on('click','.yulan',function(){
		new_win($(this))
    })
	$(".yulan_l").click(function(){
		new_win($(this))
	})
	$('.q_list_yulan').click(function(){
       var q_id = $(this).data('id');
       window.open(base_url+'course_set/yulan/'+q_id,'newwindow','height=700,width=740,top=50,left=60,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')
		//new_win($(this))
	})
	function new_win(obj){
		var q_id = obj.parent().attr('q_id');
		 window.open(base_url+'course_set/yulan/'+q_id,'newwindow','height=700,width=740,top=50,left=60,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')
	}
	//选择此题添加或者替换
	function select_t(obj){
		str = get_test_question(obj);
		if(!is_tihuan){
			$('tbody[data-type="'+lx_type+'"]').prepend(str);
		}else{
			re = new RegExp('</?tr>','g');
			tihuan_str = str.replace(re,' ');
			obj_tihuan.html(tihuan_str);
		}
		$('#myModal_01').modal('hide');
	}
	function get_test_question(obj){
		var str ='';
		var tihuan_str='';
		var arr = new Array();
		p_obj = $(obj).parent('td').parent('tr');
		arr['q_id'] = $(obj).parent('td').attr('q_id');
		if($(obj).parent('td').attr('q_id')==1){
			arr['difficulty'] = '简单';
		}else if($(obj).parent('td').attr('q_id')==2){
			arr['difficulty'] = '一般';
		}else{
			arr['difficulty'] = '困难';
		}
		arr['stem'] = p_obj.children('td:nth-child(2)').children('a').text();
		arr['cong'] = p_obj.children('td:nth-child(2)').children('small').text();
		arr['types'] = p_obj.children('td:nth-child(3)').text();
		arr['score'] = p_obj.children('td:nth-child(4)').children('span').text();

		if( lx_type == 'material'){
			str = str_questions_m(arr);
		}else{
			str = str_questions(arr);
		}
		
		return str;
	}
	
	//读取材料题
	function str_questions_m(a){
		var qid = a['q_id'];
		$.get(base_url+"course_set/findsub",{'qid':qid},function(data){

		if(!is_tihuan){
			$('tbody[data-type="'+lx_type+'"]').prepend(data);
		}else{
			//re = new RegExp('</?tr>','g');
			//var tr = $("#ques_"+qid);
			//console.log(tr);
			//console.log(data);
			
			re = new RegExp('</?tr>','g');
			tihuan_str = data.replace(re,' ');
			obj_tihuan.parent().html(tihuan_str);
		}
		$('#myModal_01').modal('hide');			
			
		})
	}	
	
	function str_questions(a){
		var str ='';
		str +='<tr>'
		str +='		<td class="move_aniu"><span class="glyphicon glyphicon-resize-vertical"></span></td>'
		str +='		<td class="chk_box">'
		str +='			<span class="n_action n_open">'
		str +='				<input type="checkbox" name="question_item" value="'+a['q_id']+'" onchange="SelectItem(this);">'
		str +='				<label for=""></label>'
		str +='			</span>'
		str +='		</td>'
		str +='		<td>'+a['q_id']+'</td>'
		str +='		<td>'
		str +='			<a href="#" class="ti_gan">'+a['stem']+'</a>'
		str +='			<small class="text-muted"><span>'+a['cong']+'</span></small>'
		str +='		</td>'
		str +='		<td>'+a['types']+'</td>'
		str +='		<td>'+a['difficulty']+'</td>'
		str +='		<td>'
		str +='			<input type="text" value="'+a['score']+'" name="s_score" class="input-sm zy_scroe"> 分'
		str +='		</td>'
		str +='		<td>'
		str +='			<input type="text" value="0.0" class="input-sm zy_scroe"> 分'
		str +='		</td>'		
		str +='		<td>'
		str +='			<div q_id="'+a['q_id']+'" class="btn-group anniuzu" role="group"  style="margin-top:-3px;">'
		str +='				<a href="javascript:void(0);" class="yulan_l" data-toggle="modal">预览</button>'
		str +='				<a href="javascript:void(0);" class="tihuan" data-toggle="modal" data-target="#myModal_01" onclick="tihuan(this)">替换</button>'
		str +='				<a href="javascript:void(0);" class="" onclick="del_q2(this);">删除</button>'
		str +='			</div>'
		str +='		</td>'
		str +='	</tr>';
		return str;
	}
	//删除试题
	function del_q2(obj){
		var i = confirm('确定要删除此题吗?');
		if(i){
			//$(obj).parent().parent().parent().remove();        
            var tr = $(obj).parent().parent().parent();
            tr.parents('tbody').find('[data-parent-id=' + tr.attr("id") + ']').remove();
            tr.remove();			
		}
	}
	//点击保存生成试卷
	var  save_testpaper =function(obj){
		arr = get_sum_score();
		var str =  test_sum_score(arr.d,arr.i);
		$('#sum_score').removeClass('hide');
		$('#sum_score').html(str);
		return arr;
	}
	function get_sum_score(){
		var tbodys = $('#q_item tbody');
		var tbody_type_c = tbodys.length;
		var arr = {};
		var key= '';
		var cc=0;
		for(var i=0;i<tbody_type_c;i++){
			cc=0;
			key = tbodys.eq(i).data('type');
			var c_tr = tbodys.eq(i).children('tr').length;
			for(var k =0;k<c_tr;k++){
				 cc += tbodys.eq(i).children('tr').eq(k).children('td:nth-child(7)').children('input').val()*1;
			}
			arr[i] = {'score':cc,'ty':$('li[data-t="'+key+'"]').children().text(),'sum': tbodys.eq(i).children("tr[class='sum_count']").length};
		
		}
		var data={'d':arr,'i':i};
		return data;
	}
	function test_sum_score(a,ii){
		var str='';
		for(var i=0;i<ii;i++){
			str +='<tr><td>'+a[i].ty+'</td><td>'+a[i].sum+'</td><td>'+a[i].score+'</td></tr>';
		}
	  return str;
	}
	//点击确定
	function last_test(){

		var arr = [];
		var c = $('input[name="question_item"]').length;
		var o =  $('input[name="question_item"]');
			
		//var c = $('input[name="s_score"]').length;
		
		var score = 0;
		var sum_score = 0;
		var parentid = 0;
		var pid = $("#pid").val();
		var miss_arr = [];
		for(var i =0;i<c;i++){
			score = o.eq(i).parent().parent().parent().children('td:nth-child(7)').children('input').val();
			parentid = o.eq(i).parent().parent().parent().attr("data-parent-id");
			arr[i] = o.eq(i).val()+'_'+score+'_'+parentid;
			sum_score +=score*1;
			miss_score= o.eq(i).parent().parent().parent().children('td:nth-child(8)').children('input').val();
			miss_arr[o.eq(i).val()] = miss_score;	
			
		}
		var pathurl = 'course_set/new_test';
		if(pid != ""){
			pathurl = 'course_set/reset_test';
		}
		$.post(base_url+pathurl,{'pid':pid,'data':arr,'c_id':cc_id,'sum_score':sum_score,'miss_arr':miss_arr,'c':c},function(da){
			if(da){
				window.location=base_url+"course_set/shijuan/"+cc_id;
			}
		})		
	}


    ////////试卷题目管理结束

    //教师设置 已添加教师列表中 单击 × 删除时
    $('.del-teacher').click(function() {
        if ($(this).parents('.teacher-list').length == 1) {
            //console.log("只有一个")
            $('.del-tankuang').slideDown('fast', function() {
                setTimeout(function(){
                    $('.del-tankuang').slideUp('fast');
                    console.log($(this))
                }, 5000)
            })
        } else {
            //console.log("多个")
        }
    })

    //课时管理 工具提示
    $('.operation-btns button').tooltip({
    	trigger:"hover"
    });
    var strcont='';
	var zhtitle='章标题'
	    jietitle='节标题'
	    addzh='添加章'
	    addjie='添加节'
	    editzh='编辑章'
	    editjie='编辑节';
  function charstr(f,y,aa,bb,cc){
    	var char01 ='';
    		char01 += '<div class="modal-dialog modal-dialog-500">';
    		char01 += '    <div class="modal-content">';
    		char01 += '        <div class="modal-header">';
    		char01 += '            <button type="button" class="close close-lg" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>';
    		
    		char01 += '        </div>';
    		char01 += '        <div class="modal-body">';
    		char01 += '            <h4 class="modal-title">'+aa+'</h4>';
    		char01 += '            <form class="form-horizontal">';
    		char01 += '                <div class="form-group">';
    		char01 += '                    <label for="" class="col-sm-2 control-label">'+bb+'</label>';
    		char01 += '                    <div class="col-sm-10">';
    		char01 += '                        <input type="text" class="form-control" id="" value="'+cc+'">';
    		char01 += '                        <span class="help-block text-danger" style="display:none;">请输入标题</span>';
    		char01 += '                    </div>';
    		char01 += '                </div>';
    		char01 += '            </form>';
    		char01 += '        </div>';
    		char01 += '        <div class="modal-footer">';
    		/*char01 += '            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>';*/
    		char01 += '            <button type="button" class="btn btn-primary"  data-fid="'+f+'" data-type="'+y+'" onclick="save_item(this);">添加</button>';
    		char01 += '        </div>';
    		char01 += '    </div>';
    		char01 += '</div>';
    		return char01;
    }
	   //点击单选项后面的删除按钮时的效果
    function del_q(obj){ 
			var len = $(".qe_choice:checked").length;
			for(var i=0;i<len;i++){
				var val = $('.qe_choice:checked:eq('+i+')').val();
				console.log(val);
				$("#ques_"+val).hide();
			}
    }
	//单击 添加 节 时 弹出 设置节标题框
   /* $('.addsection').click(function(){
    	var ddd=charstr(jietitle,addjie,strcont);
        $('#myModal0').html(ddd);
    })
    $('.addchapter').click(function(){
    	var ddd=charstr(zhtitle,addzh,strcont);
        $('#myModal0').html(ddd);
    })
    $('.editchapter').click(function(){
    	var ddd=charstr(editzh,zhtitle,"章的原标题");
        $('#myModal0').html(ddd);
    })
    //单击 编辑 节 时 弹出 设置节标题框
    $('.editsection').click(function(){
    	var ddd=charstr(editjie,jietitle,"节的原标题");
        $('#myModal0').html(ddd);
    })*/
    //课时管理 中 文本框 focusin 时
    $('.modal-dialog .form-control').on("focusin", function(){
    	//console.log(9999999)
    	$(this).parents('.form-group').removeClass('has-error');
    	$(this).next('.help-block').css('display', 'none');
    })
    
    
    /*单选框失去焦点时提示*/
    $(".qe_choice .x_danxuan .field>input").on("focusout", function() {
        if ($(this).val() == "") { //失去焦点且内容为空时
            $(this).parents('.x_danxuan').addClass('has-error');
            $(this).parents('.x_danxuan').find('.help-block').css('display', 'block')
        }
    })
    $(".qe_choice .x_danxuan .field>input").on("focusin", function() {
        $(this).parents('.x_danxuan').removeClass('has-error');
        $(this).parents('.x_danxuan').find('.help-block').css('display', 'none')
    })

    $(".qe_choice .x_danxuan .field .answer-checkbox").on("focusin", function() {
        $(this).parents('.x_danxuan').removeClass('has-error')
    })

    var selArr = ["选项A", "选项B", "选项C", "选项D", "选项E", "选项F", "选项G", "选项H", "选项I"]
        //点击单选项后面的删除按钮时的效果
    $('.qe_choice .x_edit button').on("click", function() {
        if ($('.qe_choice .x_danxuan').length > 2) {
            $(this).parents('.x_danxuan').remove();
            console.log(selArr.length)
            for (var i = 0; i <= selArr.length; i++) {
                //更新选项名称
                $('.qe_choice .x_danxuan').find('.xxx').eq(i).text(selArr[i])
            }
            //更新答案处value值
            for (var i = 0; i <= $('.qe_choice .x_danxuan').length; i++) {
                $('.qe_choice .x_danxuan').eq(i).find('input[type="checkbox"]').attr('value', i)
            }
        } else {
            alert("选项至少有俩个！");
        }
    })

     //点击新添选项时效果
    var xqindex = 3;
    $('.qe_choice .x_addsel .field').click(function() {
        if ($('.qe_choice .x_danxuan').length < 6) {
            xqindex++;
			var new_file_name = $('.qe_choice .x_danxuan').length;
            var xinstring  = '<div class="form-group x_danxuan">'
            	xinstring +='	 <label for="" class="col-xs-2 control-label xxx">选项A</label>'
       			xinstring +='	 <div class="col-xs-6">'
	       		xinstring +='		<div class="field input-group">'
	        	xinstring +='			<input class="input form-control item-input" id="danxuan' + xqindex + '" name="metas[]" type="text" value="" data-display="选项内容" data-widget-cid="widget-4" data-explain="">'
	        	xinstring +='			<span class="input-group-addon choice-answer" style="border-left:0;">'
	        	xinstring +='				<input type="checkbox" name="answer[]" value="' + xqindex + '" class="answer-checkbox"><label for=""></label> 正确答案'
	        	xinstring +='			</span>'
	        	xinstring +='			<div class="x_edit">'
		        xinstring +='				<a href="javascript:;" class="btn bg-blue btn-small upload" style="cursor:pointer;">'
		        xinstring +='					<div class="wenzikuang"><span class="glyphicon glyphicon-picture"></span>上传缩略图</div>'
		        xinstring +='					<div class="filekuang">'
		        xinstring +='						<input type="file" name="cimage'+new_file_name+'" class="filek-invisible fdd" id="fdd' + xqindex + '" onchange="xx(this)">'
		        xinstring +='						<label style="opacity: 0; width: 100%; height: 100%; display: block;  background: rgb(255, 255, 255);" onclick="fdd' + xqindex + '.click()"></label>'
		        xinstring +='					</div>'
		        xinstring +='				</a>'
		        xinstring +='				<button class="btn bg" onclick="del_q(this);" type="reset" style="cursor:pointer;">'
		        xinstring +='					<span class=" icon-trash"></span> 删除'
		        xinstring +='				</button>'
	        	xinstring +='			</div>'
	        	xinstring +='		</div>'
            	xinstring +='		<div class="help-block text-danger" style="display:none;">请输入选项内容</div>'
            	xinstring +='	</div>'
            	xinstring +='	</div>';

            $('.qe_choice .x_addsel').before(xinstring)
            for (var i = 0; i <= selArr.length; i++) {
                $('.qe_choice .x_danxuan').find('.xxx').eq(i).text(selArr[i])
            }
        } else {
            alert("选项最多六个！")
        }
    })

    function xx(obj) {
        var vala = "[img]" + $(obj).val() + "[img]";
        $(obj).parents('.field').find('.form-control').attr({
                'value': vala,
                'readonly': 'readonly'
            })
            //$("#danxuan"+xqindex).attr({'value':vala,'readonly':'readonly'})
    }

    //单击 显示/隐藏 高级选项…  时效果
    $('.more-info-link').click(function() {
        if ($(this).parents('.form-group').next('#more-info-cont').css('display') == "none") {
            $(this).parents('.form-group').next('#more-info-cont').slideDown();
        } else {
            $(this).parents('.form-group').next('#more-info-cont').slideUp();
        }

    })

    // 题干处 框 focusin 时效果
    $('.tigan').focusin(function() {
        $(this).parents('.form-group').removeClass('has-error');
        $(this).next('.help-block').css('display', 'none');
    })
    //选择题 题干 处框 foucusin 时
    $('.qe_fillblanks .tigan').focusin(function(){
    	$(this).next().next().css('display','block')
    })

var c_check1 = false
c_check2 = false
c_check3 = false;

function IsComplete(obj) { //判断题目 选择题 是否完成了
    ISneirong(obj);
    IStigan(obj);
    ISanswer(obj);
    //以上三点都满足时，提交表单
    if (c_check1 && c_check2 && c_check3) {
         $(".choice_from").submit();
         $.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
         	if(data==1){
         		window.location = base_url+"course_set/question_choice/"+cc_id;
         	}
         	if(data==2){
         		window.location = base_url+"course_set/question_choice/"+cc_id+"?m_pid="+m_pid;
         	}
         })
    }
}


function choice_save(obj) { //判断题目 选择题 是否完成了
    ISneirong(obj);
    IStigan(obj);
    ISanswer(obj);
    //以上三点都满足时，提交表单
    if (c_check1 && c_check2 && c_check3) {
         $(".choice_from").submit();
        $.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
            if(data==1){
            	window.location = base_url+"course_set/test/"+cc_id;
            }
            if(data==2){
            	window.location = base_url+"course_set/material_list/"+cc_id+"/"+m_pid;
            }
			
		})
    }
}

function IStigan(obj) {
    //题干是否为空
    var tigan = $(obj).parents('form').find('.tigan').val();
    if (tigan == "") {
        $(obj).parents('form').find('.tigan').parents('.form-group').addClass('has-error');
        $(obj).parents('form').find('.tigan').next('.help-block').css('display', 'block');
        c_check1 = false;
        console.log("题干为空")
    } else {
        c_check1 = true;
        console.log("题干不为空")
    }
}

function ISneirong(obj) {
    //选项内容是否为空
    $(obj).parents('form').find('.x_danxuan').each(function() {
        var curcont = $(this).find('input[type="text"]').val();
        if (curcont == "") {
            $(this).addClass('has-error');
            $(this).find('.help-block').css('display', 'block');
            c_check2 = false;
            alert("选项为空！")
           // console.log("选项为空")
        } else {
            c_check2 = true;
            console.log("选项不为空")
        }
    })
}

function ISanswer(obj) {
    // 选择题 必须设置 正确答案
    if ($(obj).parents('form').find('input[type="checkbox"]:checked').length > 0) {
        c_check3 = true;
        console.log("答案已设置")
    } else {
        c_check3 = false;
        alert("答案未设置")
        //console.log("答案未设置")
        ISneirong(obj);
        IStigan(obj);
        if (c_check2 && c_check1) {
            console.log("eeeeeee")
            $('.del-tankuang .content').text("请选择正确答案！")
            $('.del-tankuang').slideDown('fast', function() {
                setTimeout(function() {
                    $('.del-tankuang').slideUp('fast');
                    console.log($(this))
                }, 5000)
            })
        }
    }
}
//判断题 //保存并继续添加
function JudgmentQue(obj) {
    //题干是否为空
    IStigan(obj);
    //答案是否已设置
    if ($(obj).parents('form').find('.pd-answers').find('input[type="radio"]:checked').length > 0) {
        if (c_check1 == true) {
            $(".judge_from").submit();
            $.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
            	if(data==1){
            		window.location = base_url+"course_set/question_judge/"+cc_id;
            	}
            	if(data==2){
            		window.location = base_url+"course_set/question_judge/"+cc_id+"?m_pid="+m_pid;
            	}
            })
        }
    } else {
        if (c_check1 == true) {
            $(obj).parents('form').find('.pd-answers').find('input[type="radio"]:last-child').focus();
			
        }
    }
}

//判断题 //保存
function judge_save(obj) {
    //题干是否为空
    IStigan(obj);
    //答案是否已设置
    if ($(obj).parents('form').find('.pd-answers').find('input[type="radio"]:checked').length > 0) {
        if (c_check1 == true) {
            $(".judge_from").submit();
          $.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
            if(data==1){
            	window.location = base_url+"course_set/test/"+cc_id;
            }
            if(data==2){
            	window.location = base_url+"course_set/material_list/"+cc_id+"/"+m_pid;
            }
			
		})
            
        }
    } else {
        if (c_check1 == true) {
            $(obj).parents('form').find('.pd-answers').find('input[type="radio"]:last-child').focus();
			
        }
    }
}

//填空题 函数定义//保存并继续添加
function fillblanks(ans){
	if( UE.getEditor('Editor01').getContent()==""){
		$(ans).parents('form').find('textarea.tigan').parents('.form-group').addClass('has-error');
		$(ans).parents('form').find('textarea.tigan').next('.help-block').css('display','block');
		$(ans).parents('form').find('textarea').parents('.form-group').find('.t_remarks').css('display','none');
		
	}else{
		$(".fill_from").submit();
		$.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
			if(data==1){
				window.location = base_url+"course_set/question_fill/"+cc_id;
			}
			if(data==2){
				window.location = base_url+"course_set/question_fill/"+cc_id+"?m_pid="+m_pid;
			}
		})
		
	}
}


//填空题 函数定义 保存
function fill_save(ans){
	if( UE.getEditor('Editor01').getContent()==""){
		$(ans).parents('form').find('textarea.tigan').parents('.form-group').addClass('has-error');
		$(ans).parents('form').find('textarea.tigan').next('.help-block').css('display','block');
		$(ans).parents('form').find('textarea').parents('.form-group').find('.t_remarks').css('display','none');
		
	}else{
		
		$(".fill_from").submit();
		$.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
            if(data==1){
            	window.location = base_url+"course_set/test/"+cc_id;
            }
            if(data==2){
            	window.location = base_url+"course_set/material_list/"+cc_id+"/"+m_pid;
            }
			
		})
		
		
	}
}
//问答题 函数定义//保存并继续添加
function wendablanks(ans){
	$("input[type='hidden'][name='answer']").val(UE.getEditor('Editor03').getContentTxt());
	if( UE.getEditor('Editor03').getContent()==""){
		$(ans).parents('form').find('textarea.tigan').parents('.form-group').addClass('has-error');
		$(ans).parents('form').find('textarea.tigan').next('.help-block').css('display','block');
		$(ans).parents('form').find('textarea').parents('.form-group').find('.t_remarks').css('display','none');
		
	}else{
		$(".wenda_from").submit();
		$.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
			if(data==1){
				window.location = base_url+"course_set/question_wenda/"+cc_id;
			}
			if(data==2){
				window.location = base_url+"course_set/question_wenda/"+cc_id+"?m_pid="+m_pid;
			}
		})

		
	}
}

//问答题 函数定义//保存
function wenda_save(ans){
	$("input[type='hidden'][name='answer']").val(UE.getEditor('Editor03').getContentTxt());
	if( UE.getEditor('Editor03').getContent()==""){
		$(ans).parents('form').find('textarea.tigan').parents('.form-group').addClass('has-error');
		$(ans).parents('form').find('textarea.tigan').next('.help-block').css('display','block');
		$(ans).parents('form').find('textarea').parents('.form-group').find('.t_remarks').css('display','none');
		
	}else{
		$(".wenda_from").submit();
	     $.post(base_url+"course_set/style",{'m_pid':m_pid},function(data){
            if(data==1){
            	window.location = base_url+"course_set/test/"+cc_id;
            }
            if(data==2){
            	window.location = base_url+"course_set/material_list/"+cc_id+"/"+m_pid;
            }
			
		
		});
	
	}
}
//问答题 函数定义//保存并继续添加
function materialblanks(ans){
	if( UE.getEditor('Editor01').getContent()==""){
		$(ans).parents('form').find('textarea.tigan').parents('.form-group').addClass('has-error');
		$(ans).parents('form').find('textarea.tigan').next('.help-block').css('display','block');
		$(ans).parents('form').find('textarea').parents('.form-group').find('.t_remarks').css('display','none');
		
	}else{
		$(".material_from").submit();
		
	}
}

/////
function del_question(obj){
	var id = $(obj).parent('div').attr('q_id');
	var i = confirm("确定要删除此题吗？");
	if(i){
		$.post(base_url+"course_set/del_question",{'id':id},function(data){
			if(data==1){
				$(obj).parents("tr").remove();
			}
		})
	}
}
$("input[type='radio'][name='mode']").change(function(){
	var v = $(this).val();
	if(v=='diffculty'){
		$('.test_degree').css('display','block')
	}else{
		$('.test_degree').css('display','none')
	}
})

///////试卷难度设置开始
$(".but_a").mousedown(function(e){
		var obj = $(this);
		var b_l_offset = $('.but_b').offset().left;
		var n = get_c(obj.css('left'));
		var x = e.pageX ; 
		var page_new_x = 0;
		var div_l_width = get_c($(".div_l").css('width'));
		$(document).bind("mousemove",function(ev){
			var b_left = get_c($(".but_b").css('left'));
			var a_l_offset = $('.but_a').offset().left;
			var nl = get_c(obj.css('left'));	
			var _x = ev.pageX - x;
			//var e_b = ev.pageX >
			var is_move_left = true;
			var is_move_right = true;
			if(ev.pageX-page_new_x>=0){
				is_move_right = true;
				is_move_left = false;
			}else{
				is_move_right = false;
				is_move_left = true;
			}
			//a移动事件
			if(nl>-2 && nl <=b_left){console.log(1)
				obj.animate({left:n+_x},0); 
			}
			if(nl<=-2){console.log(2)
				if(is_move_right && ((ev.pageX*1-25)>a_l_offset)){
					obj.animate({left:n+_x},0); 
				}
			}
			if(nl>b_left-5){
				if(is_move_left && ((ev.pageX*1-25)<b_l_offset)){ //不仅向左移动，鼠标还要在div_l内才可以向左移动
					obj.animate({left:n+_x},0); 
				}
			}
			if(nl>=b_left*1-50){
				$('.but_a').css('z-index','9999')
				$('.but_b').css('z-index','999')
			}
			var easy_ = Math.round(nl/div_l_width*100) ;
			var general_ = Math.round((b_left)/div_l_width*100) ;
			s_data(easy_,general_)
			console.log()
			page_new_x = ev.pageX;
		})
		
	});
	$(".but_b").mousedown(function(e){
		var obj = $(this);
		var a_l_offset = $('.but_a').offset().left;
		var n = get_c(obj.css('left'));
		var x = e.pageX ; 
		var page_new_x = 0;
		var div_l_width = get_c($(".div_l").css('width'));
		$(document).bind("mousemove",function(ev){
			var b_l_offset = $('.but_b').offset().left;
			var _x = ev.pageX - x;
			var nl = get_c(obj.css('left'));	
			var a_left = get_c($(".but_a").css('left'));
			var is_move_left = true;
			var is_move_right = true;
			if(ev.pageX-page_new_x>=0){
				is_move_right = true;
				is_move_left = false;
			}else{
				is_move_right = false;
				is_move_left = true;
			}
			var d = div_l_width-11;
			if(nl>a_left && nl<=d){
				obj.animate({left:n+_x},0); 
			}
			if(nl<=a_left){
				if(is_move_right && ((ev.pageX*1-25)>a_l_offset)){
					obj.animate({left:n+_x},0); 
				}
			}
			if(nl>d){
				if(is_move_left && ((ev.pageX*1-25)<b_l_offset)){
					obj.animate({left:n+_x},0); 
				}
			}
			if(nl>=a_left*1+50){
				$('.but_a').css('z-index','999')
				$('.but_b').css('z-index','9999')
			}
			var general_ = Math.round(nl/div_l_width*100);
			var easy_ = Math.round(a_left/div_l_width*100) ;
			s_data(easy_,general_);
			console.log((ev.pageX*1-25)+"==="+b_l_offset)
			page_new_x = ev.pageX;
		})
		
	});
	
	function is_5(c){
		var yu = c%5;
		var z = parseInt(c/5);
		var s = parseInt(c/10);
		if(yu==0){
			return c;
		}
		if(c>=10){
			if(yu<3){
				if(z%2==0){
					return s+'0';
				}else{
					return s+'5';
				}
			}else{
				if(z%2==0){
					return s+'5';
				}else{
					return s+1+'0';
				}
			}
		}else{
			if(yu<1){
				return '0';
			}else{
				return '5';
			}
		}
	}
	function s_data(a,b){
		$(".easy_").html(is_5(a)+'%');
		$(".general_").html(is_5(b)*1-is_5(a)*1+'%');
		$(".diffculty_").html(100-is_5(b)*1+'%');
		$(".easy_i").val(is_5(a));
		$(".general_i").val(is_5(b)*1-is_5(a)*1);
		$(".diffculty_i").val(100-is_5(b)*1);
	}
	function get_c(v){
		var re = new RegExp('px','g');
		var v = v.replace(re,'');
		return v*1;
	}
	$(document).mouseup(function(){ 
           $(document).unbind("mousemove");  
	})
/////结束



//按课时范围
$("input[type='radio'][name='range']").change(function(){
	if($(this).val()=='lesson'){
		$('#testpaper-range-selects').css('display','block')
		$.post(base_url+"course_set/test_get_lesson",{'c_id':cc_id},function(data){
			$('.rang_select').html(data);
		})
	}else{
		$('#testpaper-range-selects').css('display','none')
	}
})
$('.forem_select_option').click(function(){
	$(this).parent().attr('seq',$(this).attr('seq'));
})
$("#rang_select_from").change(function(){console.log($(this).val())
	$.post(base_url+"course_set/select_to_get_lesson",{'lesson_id':$(this).val(),'c_id':cc_id},function(data){
		$('#rang_select_to').html(data);
	})
})






//
//提交
function save_test(){
	var title = $("input[type='text'][name='title']").val();
	var about = UE.getEditor('Editor01').getContent();
	var time_limit = $("#testpaper-limitedTime-field").val();
	var mode = $("input[type='radio'][name='mode']:checked").val();
	var range = $("input[type='radio'][name='range']:checked").val();
	var pid  = $("#pid").val();
	var jifen = $("input[type='text'][name='jifen']").val();
	var easy_i = $("input[type='hidden'][name='easy_i']").val();
	var general_i = $("input[type='hidden'][name='general_i']").val();
	var diffculty_i = $("input[type='hidden'][name='diffculty_i']").val();
	var from_lesson = $("select[name='from_lesson']").val();
	var to_lesson = $("select[name='to_lesson']").val();
	//yan(title,about);
	var arr1 = [];
	for(var i=0;i<7;i++){
		arr1[i] =[] ;
		arr1[i][0] = $("#tests tr").eq(i).find('td').eq(2).children('input').val();//num(
		arr1[i][1] = $("#tests tr").eq(i).find('td').eq(3).children('input').val();//sorce
		arr1[i][2] = $("#tests tr").eq(i).data('t');//type
		arr1[i][3] = $("#tests tr").eq(i).find('td').eq(4).children('input').val();//miss_sorce
	}
	//console.log(title,time_limit,mode,range,pid,easy_i,general_i,diffculty_i,from_lesson,to_lesson)
	$.post(base_url+"course_set/create_test",{'pid':pid,'title':title,'about':about,'jifen':jifen,'limit_time':time_limit,'mode':mode,'range':range,'easy_i':easy_i,'general_i':general_i,'diffculty_i':diffculty_i,'from_lesson':from_lesson,'to_lesson':to_lesson,'questions':arr1,'c_id':cc_id},function(data){
			if(data.length==1){
				window.location=base_url+"course_set/c_test2/"+cc_id;
			}else{
				alert(data)
			}
		})

	
}

//重新提交生成问题
function reset_test(){
	var title = '';
	var about = '';
	var time_limit = '';
	var jifen = '';	
	var pid = $("input[type='hidden'][name='pid']").val();
	var mode = $("input[type='radio'][name='mode']:checked").val();
	var range = $("input[type='radio'][name='range']:checked").val();	
	var easy_i = $("input[type='hidden'][name='easy_i']").val();
	var general_i = $("input[type='hidden'][name='general_i']").val();
	var diffculty_i = $("input[type='hidden'][name='diffculty_i']").val();
	var from_lesson = $("select[name='from_lesson']").val();
	var to_lesson = $("select[name='to_lesson']").val();
	var arr1 = [];
	for(var i=0;i<7;i++){
		arr1[i] =[] ;
		arr1[i][0] = $("#tests tr").eq(i).find('td').eq(2).children('input').val();//num(
		arr1[i][1] = $("#tests tr").eq(i).find('td').eq(3).children('input').val();//sorce
		arr1[i][2] = $("#tests tr").eq(i).data('t');//type
		arr1[i][3] = $("#tests tr").eq(i).find('td').eq(4).children('input').val();//miss_sorce
	}
	$.post(base_url+"course_set/create_test",{'pid':pid,'title':title,'about':about,'jifen':jifen,'limit_time':time_limit,'mode':mode,'range':range,'easy_i':easy_i,'general_i':general_i,'diffculty_i':diffculty_i,'from_lesson':from_lesson,'to_lesson':to_lesson,'questions':arr1,'c_id':cc_id},function(data){
				if(data.length==1){
					window.location=base_url+"course_set/c_test2/"+cc_id;
				}else{
					alert(data)
				}
		})	
}


function yan(title,about){
	if(title ==''){
		$("input[type='text'][name='title']").parent().parent().addClass('has-error');
		$("input[type='text'][name='title']").next().css('dispaly','block');
		location.hash = 'title_';
	}
	
	if(about==''){
		$("textarea").parent().parent().addClass('has-error');
		return;
	}
}
$(".form-control").focus(function(){
	$(this).parent().parent().removeClass("has-error");
})


  //批量删除
    function del_quest(obj){
		var t = confirm('确定要删除此题吗?');
		for(i=0;i<$('.d_que:checked').length;i++){
		  var id = $('.d_que:checked:eq('+i+')').val();
		   $.post(base_url+"course_set/delete_question",{'id':id},function(data){
			  $('.d_que:checked').parent('span').parent('td').parent('tr').remove();
			  location.reload();
		})
		}

	}