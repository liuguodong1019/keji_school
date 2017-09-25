<?php
$file = explode('.',$lesson[1]['hashname'])[0];
if(empty($file)){
	echo '文件格式不正确或己被删除！';
}else{
?>

<div class="video-content">
	<script type="text/javascript" src="<?php echo site_url("public/expand/FlexPaper");?>/js/flexpaper.js"></script>
	<script type="text/javascript" src="<?php echo site_url("public/expand/FlexPaper");?>/js/flexpaper_handlers.js"></script>
		<div id="documentViewer" class="flexpaper_viewer" style="width:100%;height:100%">
		</div>
		<script type="text/javascript">
			var startDocument = "Paper";
			var f = '<?php echo explode('.',$lesson[1]['hashname'])[0];?>'+".swf";
			$('#documentViewer').FlexPaperViewer(
					{ config : {
						SWFFile : base_url+'public/home/swf/'+f,
						Scale : 0.6,
						ZoomTransition : 'easeOut',
						ZoomTime : 0.5,
						ZoomInterval : 0.2,
						FitPageOnLoad : true,
						FitWidthOnLoad : false,
						FullScreenAsMaxWindow : false,
						ProgressiveLoading : false,
						MinZoomSize : 0.2,
						MaxZoomSize : 5,
						SearchMatchAll : false,
						InitViewMode : 'Portrait',
						RenderingOrder : 'flash',
						StartAtPage : '',

						ViewModeToolsVisible : true,
						ZoomToolsVisible : true,
						NavToolsVisible : true,
						CursorToolsVisible : true,
						SearchToolsVisible : true,
						WMode : 'window',
						localeChain: 'en_US'
					}}
			);


		</script>
</div>
<?php
}
?>

<?php if($is_set['copy_enabled']==0):?>
<style type="text/css" media="screen">
 body {-moz-user-select: none;-webkit-user-select: none;}
</style>
<script type="text/javascript">
document.onselectstart = function(e) {
    return false;
}
document.oncontextmenu = function(e) {
    return false;
}
</script>
<?php endif;?>

<!-- <script type="text/javascript">
window.onload = function () {
	 setTimeout(fun,1000);
};
function fun(){
    var ss = 0;
    var time = ss+1;
}
window.onbeforeunload = function(){
  var time1 =  time;
  var course_id = "<?php //echo $lesson[0]['course_id'];?>";
  var lesson_id = "<?php //echo $lesson[0]['l_id'];?>";	
	$.post("<?php //echo site_url("course/timeupdate");?>",{'course_id':course_id,'lesson_id':lesson_id,'time1':time1},function(da){
		console.log(da);
	})
  return "您确定要退出页面吗？";
  }
</script> -->