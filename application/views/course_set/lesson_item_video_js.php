<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script type="text/javascript">
var fileTypeExts='';
function init(){
	
	if(type_update_dingyi !==''){
		type = type_update_dingyi;
	}else{
		type = $("input[type='radio']:checked").val();
	}
	if(type=='video'){
		fileTypeExts = '*.mp4;*.swf';
		$('.link_v_b').css('display','block');
		$('.video-time').css('display','block');
	}else if(type=='audio'){
		fileTypeExts = '*.mp3';
		$('.link_v_b').css('display','none');
		$('.video-time').css('display','block');
	}else if(type=='ppt'||type=='document'){
		$('.link_v_b').css('display','block');
	}else{
		$('.link_v_b').css('display','none');
		$('.video-time').css('display','none');
	}
	
	if(type=='ppt'){
		fileTypeExts = '*.ppt;*.pptx';
	}
	if(type=='document'){
		fileTypeExts = '*.doc;*.excel;*.xlsx;*.xls;*.docx;*.pdf;';
	}
	if(has_choice_video_str!==''){
		has_choice_video(has_choice_video_str)
	}
}
init();
function link_v(obj){
	var video_link = $(obj).prev().val();
	$.post("<?php echo site_url("course_set/link_video/{$course['c_id']}");?>",{'video_link':video_link},function(data){
		if(data){
			var lesson_m = $(".lesson_m").val(data);
			$(".update_lesson_type").attr("lesson_m",data);
			has_choice_video(data.split("[media]")[1].split("_")[1]);
		}else{
			alert("请输入正确的视频地址")
		}
	})
}


$(function() {
	$('#file_upload').uploadify({
		'formData'     : {
			'timestamp' : '<?php $timestamp = time();?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'//声明令牌
		},
		'swf'      : '<?php echo site_url("public/expand/uploadify");?>/uploadify.swf',
		'uploader' : '<?php echo site_url("course_set/media/{$course['c_id']}");?>',
		'fileTypeExts'	: fileTypeExts,
		'fileSizeLimit'	: '2018MB',
		'onUploadSuccess' : function(file, data, response) {
			$(".lesson_m").val(data);
			$(".update_lesson_type").attr("lesson_m",data);
			if(has_v(data.split("[media]")[0])){
				has_choice_video(data.split("[media]")[1]);
			}
		},
		'onUploadError'   : function(file, data, response) {
			$('#url').append("<li>"+file.name+'<br/>'+data+"</li>");
		},
	});		
	
});
function has_choice_video(str){
	$(".item_video").find("span").text(str);
	$(".item_novideo").css("display",'none')
	$(".item_video").css("display",'block')
}
function choice_video(){
	$(".item_novideo").css("display",'block')
	$(".item_video").css("display",'none')
}
function has_v(str){
	var re = new RegExp("^\\d+$",'g');
	return re.test(str);
}
function choice_file(obj){
	has_choice_video($(obj).find(".filename").text());
	$(".lesson_m").val($(obj).data('fid')+"[media]"+$(obj).find(".filename").text());
	$(".update_lesson_type").attr("lesson_m",$(obj).data('fid')+"[media]"+$(obj).find(".filename").text());
}
function upliad_file_list(){
	var type = $("input[type='radio']:checked").val();
	$.get("<?php echo site_url("course_set/upliad_file_list/{$course['c_id']}");?>",{'type':type},function(data){
		$(".upliad_file_list").html(data);
	})
}
function add_lesson(){
	var lesson_m = $(".lesson_m").val();
	var media_source = 'self';
	var video_time = "00:00";
	if(lesson_m.split("[media]")[0] =='linkVideo'){ media_source= lesson_m.split("[media]")[1].split("_")[0]}
	var type = $("input[type='radio']:checked").val();
	var title = $("#l_title").val();
	var points = 0;
	//var l_abstract = $("#l_abstract").val();alert(l_abstract)
	var chapter_id = $(".lesson_chapter_id").val();

	if(title==''){ $("#l_title").parent().parent().addClass("has-error");return; } 

	//if(l_abstract==''){$("#l_abstract").parent().parent().addClass("has-error");return; }
	if(has_v(lesson_m.split("[media]")[0]) || lesson_m.split("[media]")[0] =='linkVideo'){true;}else{$(".lesson_m").parent().parent().find(".help-block").css('display','block');return; }
	
	$.post("<?php echo site_url("course_set/add_lesson/{$course['c_id']}");?>",{'video_time':video_time,'points':points,'media_source':media_source,'chapter_id':chapter_id,'type':type,'title':title,'lesson_m':lesson_m},function(data){//alert(data)
		append_lesson_html(chapter_id,data);
		//seq();
		//sx();
		//$('#myModal3').modal('hide');
		location.reload();
	})
}
function update_lesson(obj){
	$("#lesson_item").empty();
	var l_id = $(obj).parent().parent().data("id");
	var is_link ='';
	var is_linka='';
	$.post("<?php echo site_url("course_set/update_lesson_a")?>",{'l_id':l_id},function(data){
		var da = eval("("+data+")");
		$("input[type=radio][name=ks_type][value="+da[0].resource_type+"]").attr("checked",'checked');
		load_item($("#up_lesson_item"),$("#up_lesson_item_text"),da[0].resource_type);
		$(".update_lesson_type").attr("types",da[0].resource_type);
		$("#up_l_title").val(da[0].title);
		type_update_dingyi = da[0].resource_type;
		 UE.getEditor('Editor001').setContent(da[0].content);
		if(da[0].media_id==0){
			is_link = "linkVideo";
			is_linka = da[0].media_source+"_";
		}else{
			is_link =da[0].media_id;
		}
		$(".update_lesson_type").attr("lesson_m",is_link+"[media]"+is_linka+da[0].media_name);
		$(".update_lesson_type").attr("l_id",da[0].l_id);
		has_choice_video_str=da[0].media_name

	})
}
function update_lesson_but(obj){
	var lesson_m = $(obj).attr("lesson_m");
	var points = 0;
	var c_id = $(obj).attr('c_id');
	var media_source = 'self';
	var video_time = "00:00";
	var l_id = $(obj).attr('l_id');
	if(lesson_m.split("[media]")[0] =='linkVideo'){ media_source= lesson_m.split("[media]")[1].split("_")[0]}
	var types = $(".update_lesson_type").attr("types");
	var title = $("#up_l_title").val();
	var points =  parseInt($("#up_points").val());
	if(title==''){ $("#up_l_title").parent().parent().addClass("has-error");return; }
	if(has_v(lesson_m.split("[media]")[0]) || lesson_m.split("[media]")[0] =='linkVideo'){true;}else{$(".lesson_m").parent().parent().find(".help-block").css('display','block');return; }
	
	$.post("<?php echo site_url("course_set/update_lesson");?>",{'l_id':l_id,'points':points,'video_time':video_time,'media_source':media_source,'type':types,'title':title,'lesson_m':lesson_m},function(data){
		//$('#myModal4').modal('hide');	
		//window.location=base_url+"course_set/lesson/"+cc_id; 
		location.reload();
	})
}
</script>