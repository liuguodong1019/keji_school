<!-- 如果 类型 为 图文时：包含(标题、摘要、内容) -->
<!-- 内容 -->
<script>
function add_lesson(){
	var title = $("#l_title").val();
	var points = 0;
	var l_content = UE.getEditor('Editor01').getContent(); 
	var chapter_id = $(".lesson_chapter_id").val();
	var resource_type = $("input[type='radio']:checked").val();
	$.post("<?php echo site_url("course_set/add_text_lesson/{$course['c_id']}");?>",{'chapter_id':chapter_id,'points':points,'resource_type':resource_type,'title':title,'l_content':l_content},function(data){
		if(append_lesson_html(chapter_id,data)){
			//$('#myModal3').modal('hide');
			seq();
			sx();
			location.reload();
		}
		
	})
}
function update_lesson_but(obj){
	var title = $("#up_l_title").val();
	var points =  0;
	var l_id = $(obj).attr('l_id');
	var l_content = UE.getEditor('Editor001').getContent();
	$.post("<?php echo site_url("course_set/update_text_lesson");?>",{'l_id':l_id,'points':points,'title':title,'l_content':l_content},function(data){
			//$('#myModal4').modal('hide');
			location.reload();
	})
}
</script>