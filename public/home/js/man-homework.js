	
//作业总分 作业分数
	var get_home_score =function(t){
		var sum=0
		var sums = 0;
		var f = $('.nav-pills li:first').data('t');
		t = t || f;
		var obj  = $('tbody[data-type='+t+'] tr td input[type="text"]')
		var c =obj.length;
		for(var i=0;i<c;i++){
			sum += (obj.eq(i).val())*1;
		}
		
		var objs  = $('td input[type="text"]')
		var cs =objs.length;
		for(var is=0;is<cs;is++){
			sums += (objs.eq(is).val())*1;
		}
		$('.home_sum').html(sums);
		$('.home-infos-num').html(i/2);
		$('.home-infos-scroe').html(sum);
		
	}
		get_home_score();
	$('td input[type="text"]').on('blur',function(){
		get_home_score(lx_type);
	})
 //点击替换删除此题  
    function tihuan_que(obj){
        obj_tihuan=$(obj).parent().parent().parent();
        is_tihuan = 1;
        get_question(is_tihuan)
  
    }
    //单击 新增试题 时效果
    $('.new_add').click(function(){
        is_tihuan =0;
        get_question(is_tihuan)
    })
    function get_question(is_tihuan){
        var parent = $('select[name="parent"]').val();
        var keyword = $('input[name="keyword"]').val();
        var s_qid = question_sel_id();
        $.post(base_url+"course_set/new_add_question/"+cc_id,{'s_qid':s_qid,'lx_type':lx_type,'is_tihuan':is_tihuan,'parent':parent,'keyword':keyword},function(data){
            var da = data.split('[`&`]');
            if(da){
                $('select[name="parent"]').html(da[0]);
                $('.question_list').removeClass('hide');
                $('.question_list').html(da[1])
                search_list_style();
            }
        })
    }
    function search_list_style(){
            $('.question_list').removeClass('hide');
            $('ul[class="pagination"] li').removeClass('active');
            $('ul[class="pagination"] li:nth-child(2)').addClass('active');

      //即勾上全选框 
    function SelectAll(ee){ 
        if($(ee).prop('checked')==true){
            $(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked','checked')
        }else{
            $(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked',false)
        }
    }

        	//搜索试题
      
		var parent = '';
		var key = '';
		var p ='';
		var nav = $('ul[class="pagination"] li');
		$('.search_home_ques').click(function(){
			get_search_item();
			var s_qid = question_sel_id();
			$.get(base_url+"course_set/search_home_ques/"+cc_id,{'key':key,'s_qid':s_qid,'lx_type':lx_type,'parent':parent},function(data){
				$('.question_list').html(data);
				search_list_style();
			})
		})


		//xx页
		$("#zy_add_ques").on('click','ul[class="pagination"] li',function(){
			
			var obj={}
			obj =$(this);console.log(obj.html())
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
			var s_qid = question_sel_id();
			$.get(base_url+"course_set/home_page/"+cc_id,{'s_qid':s_qid,'lx_type':lx_type,'p':p,'key':key,'parent':parent},function(d){
				$('.question_list').html(d);
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

		        }
function question_sel_id(){
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
    //单击预览 
   $("#zy_add_ques").on('click','.yulan',function(){
		new_win($(this))
    })
	function yulan(obj){
		var q_id = $(obj).parent('div').attr('q_id');
		 window.open(base_url+'course_set/yulan/'+q_id,'newwindow','height=700,width=740,top=50,left=60,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')
	}
	function new_win(obj){
		var q_id = obj.parent().attr('q_id');
		 window.open(base_url+'course_set/yulan/'+q_id,'newwindow','height=700,width=740,top=50,left=60,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')
	}

//单击不同题型按钮时显示相应的题目列表
   var lx_type=$('.nav-pills li:first').data('t');
   var type = $('.nav-pills li:first').data('type');
    $('.ttj_zuoye .nav li').click(function(){
        lx_type=$(this).data('t');
         type = $(this).data('type');
        $('.ttj_zuoye .nav li').removeClass('active');
        $(this).addClass('active');
		$('.ttj_zuoye table tbody').addClass('hide')
		$('.ttj_zuoye table').find('tbody[data-type="'+lx_type+'"]').removeClass('hide');
		get_home_score(lx_type);
		$('.zuoye-infos-type').html(type);
    })

 
	//选择此题添加或者替换（一个题）
	function select_question(obj){
		str = get_question_item(obj);
		if(lx_type=='material'){
			m_str = get_mater_str(obj);
			data = str + m_str;
		}
		if(!is_tihuan){
			if(lx_type!='material'){
				$('tbody[data-type="'+lx_type+'"]').prepend(str);
			}else{
				$('tbody[data-type="'+lx_type+'"]').prepend(data);
			}	
		}else{
			re = new RegExp('</?tr>','g');	
			if(lx_type!='material'){
				tihuan_str = str.replace(re,'');
				obj_tihuan.html(tihuan_str);
			}else{
				tihuan_str = str.replace(re,'');
				var nn=$(obj_tihuan).next().data('id');
				$(obj_tihuan).parent().find('tr[data-id='+nn+']').remove();
                da= obj_tihuan.html(tihuan_str);
                da.after(m_str);
			}
			
		}
		$('#zy_add_ques').modal('hide');
	}
	function get_question_item(obj){
		var str ='';
		var tihuan_str='';
		var arr = new Array();
		p_obj = $(obj).parents('td').parent('tr');
		arr['q_id'] = $(obj).parent('div').attr('q_id');
		k = $(obj).parent('div').attr('difficulty');
		if(k==1){
			arr['difficulty'] = '简单';
		}else if(k==2){
			arr['difficulty'] = '一般';
		}else{
			arr['difficulty'] = '困难';
		}
		arr['score'] = p_obj.children('td:nth-child(3)').text();
		arr['stem'] = p_obj.children('td:nth-child(2)').children('a').text();
		arr['cong'] = p_obj.children('td:nth-child(2)').children('small').text();
		arr['types'] = p_obj.children('td:nth-child(4)').text();
		type = $(obj).parent('div').parent('td').attr('q_id');
		if(type!='material'){
			str = str_question(arr);
		}else{
            str = str_mater_question(arr);
       }
		return str;
	}

	function get_mater_str(obj){
		var str ='';
		var tihuan_str='';
		var qid ='';
		var arr = new Array();
	    qid = $(obj).parent('div').attr('q_id');
		for(var i=0;i<$(obj).parents('td').parent('tr').parent('tbody').find('[data-parent-id='+qid+']').length;i++){
		m = $(obj).parents('td').parent('tr').parent('tbody').find('[data-parent-id='+qid+']:eq('+i+')');
		arr['score_m'] = m.children('td:nth-child(3)').text();
		arr['stem_m'] = m.children('td:nth-child(2)').children('a').text();
		arr['cong_m'] = m.children('td:nth-child(2)').children('small').text();
		arr['types_m'] = m.children('td:nth-child(4)').text();//alert(arr['types_m'])
		arr['q_id'] = m.children('td:nth-child(5)').text();
		arr['material_pid'] = m.children('td:nth-child(6)').text();
		arr['miss_score'] = '0.0';
		d = m.children('td:nth-child(1)').find('.getmater').val();
        if(d==1){
			arr['difficulty_m'] = '简单';
		}else if(d==2){
			arr['difficulty_m'] = '一般';
		}else{
			arr['difficulty_m'] = '困难';
		}
		    str +=' <tr data-id="'+arr['material_pid']+'">'      
			str +='			<td class="move_aniu">'
			str +='<input type="checkbox" name="question_item" value="'+arr['q_id']+'"  class="delete_que" onchange="SelectItem(this);">'
			str +='</td>'			
			str +='<td class="move_aniu" style="padding-left:0;">'			
			str +='				<span class="glyphicon glyphicon-resize-vertical"></span>'
			str +='			</td>'
			str +='			<td>'+arr['q_id']+'</td>'
			str +='			<td>'
			str +='				<a href="#" class="ti_gan">'+arr['stem_m']+'</a>'
			str +='				<small class="text-muted">从属于 <span>'+arr['cong_m']+'</span></small>'
			str +='			</td>'
			str +='			<td>'+arr['types_m']+'</td>'
			str +='			<td>'+arr['difficulty_m']+'</td>'
			str +='			<td>'
			str +='				<input type="text"  value="'+arr['score_m']+'" name="s_score" class="input-sm zy_scroe"> 分'
			str +='			</td>'
			str +='         <td>'
			str +='				<input type="text"  name="sum_ques" value="'+arr['miss_score']+'" class="input-sm zy_scroe"> 分'
			str +='			</td>	'					
			str +='		</tr>';			
		}
		return str;
	}
    //批量选择试题
	function queding(obj){

	
		var str ='';
		var arr = new Array();
    for(var i=0;i<$('.getque:checked').length;i++){
        trr = $('.getque:checked:eq('+i+')').parent('span').parent('td').parent('tr');//console.log(trr)
        k = $('.getque:checked:eq('+i+')').val();
        arr['q_id'] = $('.getque:checked:eq('+i+')').parent('span').parent('td').attr('q_id');
        arr['score'] = trr.children('td:nth-child(3)').text();
        arr['stem'] = trr.children('td:nth-child(2)').children('a').text();
        arr['cong'] = trr.children('td:nth-child(2)').children('small').text();
		arr['types'] = trr.children('td:nth-child(4)').text();
        if(k==1){
			arr['difficulty'] = '简单';
		}else if(k==2){
			arr['difficulty'] = '一般';
		}else{
			arr['difficulty'] = '困难';
		}

		str = str_question(arr);
		if(!is_tihuan){
			if(lx_type!='material'){
				 $('tbody[data-type="'+lx_type+'"]').append(str);
			}
			if(lx_type=='material'){
			str = str_mater_question(arr);
			qid =  arr['q_id']
			str_m  = get_m_str(qid);
			str_mm =  str +str_m;
			$('tbody[data-type="'+lx_type+'"]').append(str_mm);
			}
		}else{ 
          re = new RegExp('</?tr>','g');	
			if(lx_type!='material'){
				tihuan_str = str.replace(re,' ');
				obj_tihuan.html(tihuan_str);
			}else{
				qid =  arr['q_id']
				str_m  = get_m_str(qid);
				tihuan_str = str.replace(re,'');
				var nn=$(obj_tihuan).next().data('id');console.log(nn)
				$(obj_tihuan).parent().find('tr[data-id='+nn+']').remove();
                da = obj_tihuan.html(tihuan_str);
                da.after(str_m);console.log(str_m)
			}
       }
   }
		$('#zy_add_ques').modal('hide');  
	}
	
   function get_m_str(qid){
   	    var str = '';
   	    var ar = new Array();
		for(var i=0;i<$('.getque:checked').parents('tbody').find('[data-parent-id='+qid+']').length;i++){
		m = $('.getque:checked').parents('tbody').find('[data-parent-id='+qid+']:eq('+i+')');console.log(m.html())
		ar['q_id'] =m.children('td:nth-child(1)').attr('q_id');
		ar['score_m'] = m.children('td:nth-child(3)').text();
		ar['stem_m'] = m.children('td:nth-child(2)').children('a').text();
		ar['cong_m'] = m.children('td:nth-child(2)').children('small').text();
		ar['types_m'] = m.children('td:nth-child(4)').text();
		ar['material_pid'] = m.children('td:nth-child(6)').text();
		ar['miss_score'] = '0.0';
		d = m.children('td:nth-child(1)').find('.getmater').val();
        if(d==1){
			ar['difficulty_m'] = '简单';
		}else if(d==2){
			ar['difficulty_m'] = '一般';
		}else{
			ar['difficulty_m'] = '困难';
		}
		   
		    str +=' <tr data-id="'+ar['material_pid']+'">'      
			str +='			<td class="move_aniu" >'
			str +='<input type="checkbox"  name="question_item" value="'+ar['q_id']+'" class="delete_que" onchange="SelectItem(this);">'
			str +='</td>'			
			str +='<td class="move_aniu" style="padding-left:0;">'			
			str +='				<span class="glyphicon glyphicon-resize-vertical"></span>'
			str +='			</td>'
			str +='			<td>'+ar['q_id']+'</td>'
			str +='			<td>'
			str +='				<a href="#" class="ti_gan">'+ar['stem_m']+'</a>'
			str +='				<small class="text-muted">从属于 <span>'+ar['cong_m']+'</span></small>'
			str +='			</td>'
			str +='			<td>'+ar['types_m']+'</td>'
			str +='			<td>'+ar['difficulty_m']+'</td>'
			str +='			<td>'
			str +='				<input type="text"  value="'+ar['score_m']+'" name="s_score" class="input-sm zy_scroe"> 分'
			str +='			</td>'
			str +='         <td>'
			str +='				<input type="text" name="sum_ques" value="'+ar['miss_score']+'" class="input-sm zy_scroe"> 分'
			str +='			</td>	'					
			str +='		</tr>';
			
	  }

	    return str;
   } 
function str_question(a){
		var str ='';
		str +='<tr>'
		str +='		<td class="move_aniu"><span class="glyphicon glyphicon-resize-vertical"></span></td>'
		str +='		<td class="chk_box">'
		str +='			<span class="n_action n_open">'
		str +='				<input type="checkbox" name="question_item" value="'+a['q_id']+'" name="question_item" class="delete_que" onchange="SelectItem(this);">'
		str +='				<label for=""></label>'
		str +='			</span>'
		str +='		</td>'
		str +='		<td>'+a['q_id']+'</td>'
		str +='		<td>'
		str +='			<a href="javascript:void(0);" class="ti_gan" data-id="'+a['q_id']+'" data-toggle="modal" data-target=".question_view" onclick="preview(this);">'+a['stem']+'</a>'
		str +='			<small class="text-muted"><span>'+a['cong']+'</span></small>'
		str +='		</td>'
		str +='		<td>'+a['types']+'</td>'
		str +='		<td>'+a['difficulty']+'</td>'
	    str +='		<td>'
		str +='			<input type="text" value="'+a['score']+'" name="s_score" class="input-sm zy_scroe"> 分'
		str +='		</td>'
		str +='		<td>'
		str +='			<input type="text" name="sum_ques" value="0.0" class="input-sm zy_scroe"> 分'
		str +='		</td>'		
		str +='		<td>'
		str +='			<div q_id="'+a['q_id']+'" class="btn-group anniuzu" role="group"  style="margin-top:-3px;">'
		str +='				<a href="javascript:void(0);" class="yulan" data-id="'+a['q_id']+'" data-toggle="modal" data-target=".question_view" onclick="preview(this);">预览</button>'
		str +='				<a href="javascript:void(0);" class="h_tihuan" id="h_tihuan" data-toggle="modal" onclick="tihuan_que(this);" data-target="#zy_add_ques">替换</button>'
		str +='				<a href="javascript:void(0);" class="" onclick="del_que(this);">删除</button>'
		str +='			</div>'
		str +='		</td>'
		str +='	</tr>';
		return str;
	}


      function str_mater_question(a){   	
		var str = '';
		str +='<tr>'
			str +='		<td class="move_aniu" data-parent-id="'+a['q_id']+'"><span class="glyphicon glyphicon-resize-vertical"></span></td>'
			str +='		<td class="chk_box">'
			str +='			<span class="n_action n_open">'
			str +='				<input type="checkbox" name="question_item" value="'+a['q_id']+'" class="delete_que" onchange="SelectItem(this);">'
			str +='				<label for=""></label>'
			str +='			</span>'
			str +='		</td>'
			str +='		<td></td>'
			str +='		<td>'
			str +='			<a href="javascript:void(0);" class="ti_gan" data-id="'+a['q_id']+'" data-toggle="modal" data-target=".question_view" onclick="preview(this);">'+a['stem']+'</a>'
			str +='			<small class="text-muted"><span>'+a['cong']+'</span></small>'
			str +='		</td>'
			str +='		<td>'+a['types']+'</td>'
			str +='		<td>'+a['difficulty']+'</td>'
			str +='		<td>'
			str +='			<input type="hidden"  value="" name="s_score" class="input-sm zy_scroe"> '
			str +='		</td>'
			str +='		<td >'
			str +='			<input type="hidden" value="" class="input-sm zy_scroe"> '
			str +='		</td>'		
			str +='		<td>'
			str +='			<div q_id="'+a['q_id']+'" class="btn-group anniuzu" role="group"  style="margin-top:-3px;">'
			str +='				<a href="javascript:void(0);" class="yulan" data-id="'+a['q_id']+'" data-toggle="modal" data-target=".question_view" onclick="preview(this);">预览</button>'
			str +='				<a href="javascript:void(0);" class="h_tihuan" id="h_tihuan" data-toggle="modal" onclick="tihuan_que(this);" data-target="#zy_add_ques" data-role=batch-item>替换</button>'
			str +='				<a href="javascript:void(0);" class="" onclick="del_mater(this);">删除</button>'
			str +='			</div>'
			str +='		</td>'
			str +='	</tr>';
            return str;
	}


	

      //删除材料题以及其子题
      function del_mater(obj){
        var q_id = $(obj).parent('div').attr('q_id');
        if(confirm("确认要删除吗？")){
        	$(obj).parents('tbody').find('[data-id='+q_id+']').remove();
        	$(obj).parents('tr').remove();
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
    //删除单个题
    function del_que(obj){
    		var i = confirm('确定要删除此题吗?');
		if(i){
			$(obj).parent().parent().parent().remove();
		}

    }
    //批量删除
    function del_questions(obj){
    	var i = confirm('确定要删除此题吗?');
		if(i){
		 $('.delete_que:checked').parents('tr').remove();
		 }		
	}


   
	//点击保存生成试卷
	var  save_homework =function(obj){
		arr = get_arr_sum_score();
		var str =  test_sum_score(arr.d,arr.i);
		$('#sum_score').removeClass('hide');
		$('#sum_score').html(str);
		return arr;
	}
	function get_arr_sum_score(){
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
			arr[i] = {'score':cc,'ty':$('li[data-t="'+key+'"]').children().text(),'sum': tbodys.eq(i).children('tr').length};
	
		}
		var data={'d':arr,'i':i};
		return data;
	}
	//点击确定
	function last_homework(){
		var arr = [];
		var c = $('input[name="question_item"]').length;
		var o =  $('input[name="question_item"]');
		var q =  $('input[name="sum_ques"]').length;
		var score = 0;
		var sum_score = 0;
		var miss_arr = [];
		for(var i =0;i<c;i++){
			score = o.eq(i).parents('tr').children('td:nth-child(7)').children('input').val();
			arr[i] = o.eq(i).val()+'_'+score;console.log(arr[i])
			sum_score +=score*1;
			miss_score= o.eq(i).parents('tr').children('td:nth-child(8)').children('input').val();
			miss_arr[o.eq(i).val()] = miss_score;	
		}
		$.post(base_url+"course_set/new_home",{'data':arr,'c_id':cc_id,'sum_score':sum_score,'q':q,'miss_arr':miss_arr},function(da){
			if(da){
				window.location=base_url+"course_set/lesson/"+cc_id;
			}
			
		})
	}
   //点击确定--作业
	function last_home2(){
		var arr = [];
		var c = $('input[name="question_item"]').length;
		var o =  $('input[name="question_item"]');
		var q =  $('input[name="sum_ques"]').length;
		
		var score = 0;
		var sum_score = 0;
		var miss_arr = [];
		for(var i =0;i<c;i++){
			score = o.eq(i).parents('tr').children('td:nth-child(7)').children('input').val();
			arr[i] = o.eq(i).val()+'_'+score;
			sum_score +=score*1;
			miss_score= o.eq(i).parents('tr').children('td:nth-child(8)').children('input').val();
			miss_arr[o.eq(i).val()] = miss_score;
		}
		$.post(base_url+"course_set/new_home",{'data':arr,'c_id':cc_id,'sum_score':sum_score,'q':q,'miss_arr':miss_arr},function(da){
			if(da){
				window.location=base_url+"course_set/homework/"+cc_id;
			}
			
		})
	}


	 //点击确定--练习
/*	function last_practice(){
        var lesson_id = $('select option:checked').val();

		var arr = [];
		var c = $('input[name="question_item"]').length;
		var o =  $('input[name="question_item"]');
		var q =  $('input[name="sum_ques"]').length;
		
		var score = 0;
		var sum_score = 0;
		var miss_arr = [];
		for(var i =0;i<c;i++){
			score = o.eq(i).parents('tr').children('td:nth-child(7)').children('input').val();
			arr[i] = o.eq(i).val()+'_'+score;
			sum_score +=score*1;
			miss_score= o.eq(i).parents('tr').children('td:nth-child(8)').children('input').val();
			miss_arr[o.eq(i).val()] = miss_score;
		}
		$.post(base_url+"course_set/new_practice",{'data':arr,'c_id':cc_id,'lesson_id':lesson_id,'sum_score':sum_score,'q':q,'miss_arr':miss_arr},function(da){
				//alert(da)
				//$('#myModal_05').modal('hide');
				window.location=base_url+"course_set/practice_list/"+cc_id;		
			
		})
	}*/