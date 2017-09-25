<?php $this->load->view('home/public/base_link');?>
<link rel="stylesheet" href="<?php echo base_url();?>public/home/css/lesson.css">
<script src="<?php echo base_url();?>public/home/js/lesson.js"></script>
<body>
    <div class="cb-wrap">
        <div class="course-lesson-frame">
            <!-- 若右边工具栏展开，则为它添加一类名“right-column-open” -->
            <?php if(!isset($error_mes) && empty($error_mes)){ ?>
			<div class="clearfix things">
               <font color="red"><?= $error_mes; ?></font>
            </div>		
			<div class="clearfix things">
                <a href="<?php echo site_url('course/course_list')?>"  class="btn btn-primary return-course-page">
                    <i class="glyphicon glyphicon-chevron-left"></i> &nbsp;&nbsp;&nbsp;返回课程
                </a>
                <div class="pull-left chapter-title">
                    <span class="keshi">课时<?= isset($lesson_seq)?$lesson_seq:'';?>：<span class="keshi-number"></span></span>
                    <span class="title" title="<?php echo $lesson[0]['title'];?>"><?php echo $lesson[0]['title'];?></span>
                </div>
            </div>			
            <div class="video-frame">
				<!--在线预览ppt，office等文档使用openoffice+swftool+FlexPaper方案如有更好方案欢迎交流q249602717-->
				<?php if($lesson[0]['resource_type']=='text'){$this->load->view("home/lesson_play/item_text");}?>
				<?php if($lesson[0]['resource_type']=='ppt'){$this->load->view("home/lesson_play/item_document");}?>
				<?php if($lesson[0]['resource_type']=='document'){
                    $this->load->view("home/lesson_play/item_document");}?>
				<?php if($lesson[0]['resource_type']=='video' && $lesson[0]['media_source']=='self'){$this->load->view("home/lesson_play/item_self_video");}?>
				<?php if($lesson[0]['resource_type']=='video' && $lesson[0]['media_source']=='youku'){$this->load->view("home/lesson_play/item_youku_video");}?>
				<?php if($lesson[0]['resource_type']=='testpaper'){
                    $this->load->view("home/lesson_play/item_testpaper");
                }?>
                <?php if($lesson[0]['resource_type']=='audio' && $lesson[0]['media_source']=='self'){$this->load->view("home/lesson_play/item_self_audio");}?>

			    <div class="have-learned" id="<?php echo $lesson[0]['course_id'];?>">
                    <?php if(!empty($last)){?>
					<a href="<?php echo site_url("course/lesson/{$lesson[0]['course_id']}/{$last}");?>" class="btn btn-primary prev_next_btn prev_btn">
                        上一课时
                    </a>
					<?php } ?>
					<?php if(!empty($next)){?>
                    <a href="<?php echo site_url("course/lesson/{$lesson[0]['course_id']}/{$next}");?>" class="btn btn-primary prev_next_btn next_btn">
                        下一课时
                    </a>
					<?php } ?>
                </div>
            </div>
			
            
			<!--目录 start -->
            <div class="toolbar-frame hidden-xs" style="<?= (count($lessons)>1)?'':'display:none';?>">
                <div class="toolbar">
                    <ul>
                        <li class="toolbar-item">
                            <a href="javascript:void(0);">
                                <i class="bar_icons bar_icons_01"></i>目录
                            </a>
                        </li>
                    </ul>					
                    <a href="#" class="hide-cont-btn">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </a>
                </div> 
                <!-- 功能项对应的内容区  -->
                <div class="toolitem-cont-frame">
                    <!-- 目录 -->
                    <div class="toolitem-content mulu-con">
                        <?php $this->load->view("home/block_lesson_list");?>
                    </div>

                </div>
            </div>
			<!--目录 end -->
			<?php }else{ ?>
			<div style="border:solid 1px red;width:350px;padding:40px;margin:0 auto;margin-top:200px;color:red;">暂无数据，请到课程下上传视频或资料。</div>
			<?php } ?>
        </div>
    </div>

</body>
</html>
<script>
window.onload = function () {
    var id = "<?php echo $_SESSION['user']['id'];?>";
    var is_lock = "<?php echo $_SESSION['user']['is_lock'];?>";
    if (id == "") {
        alert('请登录后操作');
        location.href = "<?php echo site_url('course/course_list');?>";
    }else if (is_lock == 1) {
        alert('您已被管理员封禁,暂不能进行此项操作');
        location.href = "<?php echo site_url('course/course_list');?>";
    }

    var course_id = "<?php echo $lesson[0]['course_id'];?>";
    var lesson_id = "<?php echo $lesson[0]['l_id'];?>";   
    var ts = new Date().getTime();
    var time = Math.round(ts/1000).toString();
    
    $.post("<?php echo site_url("course/document");?>",{'course_id':course_id,'lesson_id':lesson_id,'time':time},function(da){
                        console.log(da);
                    })    
}
</script>
<script>
   <?php if ($lesson[0]['resource_type']=='text' || $lesson[0]['resource_type']=='ppt' || $lesson[0]['resource_type']=='document') {?>
   
    window.onunload = function() {
        var ts = new Date().getTime();
        var time = Math.round(ts/1000).toString();
        var course_id = "<?php echo $lesson[0]['course_id'];?>";
        var lesson_id = "<?php echo $lesson[0]['l_id'];?>";   
        $.post("<?php echo site_url("course/endTime");?>",{'course_id':course_id,'lesson_id':lesson_id,'time':time},function(da){
            console.log(da);
        })
    }
    <?php }?>
</script>
