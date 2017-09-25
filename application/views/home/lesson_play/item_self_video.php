<div class="video-content">
	<?php
	if(empty($lesson[1]['hashname'])){
		echo '<font color="red">文件格式不正确或己被删除！</font>';
	}else{
	?>

	<video width="100%" height="100%" controls="controls" id="video">
		<source src="<?php echo site_url("public/home/file/{$lesson[1]['hashname']}");?>" type="video/mp4"></source>
		您的浏览器不支持video标签
	</video>

	<?php
	}
	?>
</div>
<script>
var myVideo = document.getElementById('video');
//设置播放点
function playBySeconds(num){ 
    myVideo.currentTime = num;
}
var current_time = "<?php echo $lesson[0]['last_view_time']?>";
if(current_time > 0){
	playBySeconds(current_time);
}
</script>
<script type="text/javascript">
var vid = document.getElementById("video");
var current_time = "<?php echo $lesson[0]['last_view_time']?>";
vid.currentTime = current_time;
vid.onended = function() {
	var course_id = "<?php echo $lesson[0]['course_id'];?>";
	var lesson_id = "<?php echo $lesson[0]['l_id'];?>";
	var totalTime = vid.duration;
	$.post("<?php echo site_url("course/learned");?>",{'course_id':course_id,'lesson_id':lesson_id,'totalTime':totalTime},function(da){
		$('#learn_btn').find('i').removeClass('glyphicon-unchecked').addClass('glyphicon-check');              
	})	
};


// var myVideo = document.getElementById('video');
//播放时间点更新时
// myVideo.addEventListener("timeupdate", function(){
//     var currentTime = myVideo.currentTime;//获取当前播放时间
//     var totalTime = myVideo.duration; 
//     console.log(totalTime) 
//     console.log(currentTime) 
	
// });

 //设置播放点
// function playBySeconds(num){
//     vid.currentTime = num;
// }
// var current_time = "<?php //echo $lesson[0]['last_view_time']?>//";
// if(current_time > 0){
// 	playBySeconds(current_time);
// }



</script>

<script type="text/javascript">
var myVideo = document.getElementById('video');
  window.onunload = function(){
  var currentTime = myVideo.currentTime;
  var totalTime = myVideo.duration;
  var course_id = "<?php echo $lesson[0]['course_id'];?>";
  var lesson_id = "<?php echo $lesson[0]['l_id'];?>";	
	$.post("<?php echo site_url("course/timeupdate");?>",{'course_id':course_id,'lesson_id':lesson_id,'currentTime':currentTime,'totalTime':totalTime},function(da){
		console.log(da);
	})
  // return "您确定要退出页面吗？";
  }
</script>