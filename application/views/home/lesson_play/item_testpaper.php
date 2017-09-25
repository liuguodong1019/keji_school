<div style="padding:20px;width:80%;margin:0 auto;background:white;margin-top:20px;">	
<?php
if(!empty($testpaper_r)){
	if($testpaper_r['state'] == "unpublish"){
	?>
		<div id="page-message-container" class="page-message-container" data-goto="" data-duration="0">
		  <div class="page-message-panel">			
			<div class="page-message-heading">
			  <h2 class="page-message-title">提示信息</h2>
			</div>
			<div class="page-message-body">该试卷已关闭，如有疑问请联系老师！</div>
		  </div>
		</div>	
	<?php
	}else if($testpaper_r['passed_status'] == "doing" && $testpaper_r['active'] == 1){
?>
	试卷未完全做完。
		<a href="<?php echo site_url("test/index").'/'.$this->uri->segment(3);?>/<?= $lesson[0]['media_id'];?>" class="btn btn-primary btn-sm">继续考试</a>	
	<?php }else if ($testpaper_r['passed_status'] == "fished" && $testpaper_r['status'] != "finished"){ ?>
	试卷正在批阅。
		<a href="<?php echo site_url("test/result");?>/<?= $lesson[0]['media_id'];?>" class="btn btn-primary btn-sm" target="_blank">查看试卷</a>	
	<?php }else if($testpaper_r['passed_status'] == "fished" && $testpaper_r['status'] == "finished"){?>			
	试卷已批阅。
		<a href="<?php echo site_url("test/result");?>/<?= $lesson[0]['media_id'];?>" class="btn btn-primary btn-sm"  target="_blank">查看结果</a>					
	<?php }else{
	?>
欢迎参加考试，请点击「开始考试」按钮。
	<a href="<?php echo site_url("test/index").'/'.$this->uri->segment(3);?>/<?= $lesson[0]['media_id'];?>/<?= $lesson[0]['l_id'];?>" class="btn btn-primary btn-sm">开始考试</a>	
	<?php
	}
	?>	
<?php }else{ ?>
欢迎参加考试，请点击「开始考试」按钮。
	<a href="<?php echo site_url("test/index").'/'.$this->uri->segment(3);?>/<?= $lesson[0]['media_id'];?>/<?= $lesson[0]['l_id'];?>" class="btn btn-primary btn-sm">开始考试</a>
<?php } ?>
</div>	