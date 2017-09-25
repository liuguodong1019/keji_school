
<?php if($my_le_course):foreach($my_le_course as $k=>$mc):?>
	<div class="course_item clearfix courseid<?=$mc['id']?>">
		<a href="<?php echo site_url("course/lesson/{$mc['id']}");?>"  target="_blank" class="course_item_img">
			<img src="<?=site_url("public/home/images/course/{$mc['pic']}");?>" alt="">
		</a>
		<div class="course_item_things">
			<h5><a href="<?php echo site_url("course/lesson/{$mc['id']}");?>"  target="_blank"><?php echo $mc['title'];?></a>
			
			</h5>
			<div class="things_jindu">
				学习进度：
				<div class="progress">
				    <div class="progress-bar" role="progressbar" aria-valuenow="27%" aria-valuemin="0" aria-valuemax="100" style="width: <?= $mc['percent'];?>%;">
				    	<span class="sr-only">27% Complete</span>
				    </div>
				</div>
				<span class="progress_per_val">
					<?= $mc['percent'];?>%
				</span>
				<?= ($this->uri->segment(3) == 'learning')?'学习':'完成'; ?>课时：<?= ($mc['finish_num'] >0 )?$mc['finish_num']:'0';?>
				<a href="<?php echo site_url("course/lesson/{$mc['id']}/{$mc['last_learn_lesson_id']}");?>" class="btn btn-primary">继续学习</a>
			</div>
			
		</div>
	</div>


<?php endforeach;?>
<?php else:?>
	<p style="padding:10px;">暂无数据</p>
<?php endif;?>
<?php echo $this->pagination->create_links();?>