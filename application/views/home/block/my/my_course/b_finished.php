
<?php if($my_le_course):foreach($my_le_course as $k=>$mc):?>
	<div class="course_item clearfix">
		<a href="<?php echo site_url("course/{$mc['id']}");?>"  target="_blank" class="course_item_img">
			<img src="<?=site_url("public/home/images/course/{$mc['pic']}");?>" alt="">
		</a>
		<div class="course_item_things">
			<h5><a href="<?php echo site_url("course/lesson/{$mc['id']}");?>"  target="_blank"><?php echo $mc['title'];?></a>
			
			</h5>
			<p class="things_update">更新完毕</p>
			<p class="things_time">最后学习时间：<?php echo date("Y-m-d H:i",$mc['last_view_time']);?></p>
			<div class="things_jindu">
				学习进度：
				<div class="progress">
				    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
				    	<span class="sr-only">100% Complete</span>
				    </div>
				</div>
				<span class="progress_per_val">
					100%
				</span>
				完成课时：<?=$mc['finish_num']?>
				<a href="<?php echo site_url("course/lesson/{$mc['id']}/{$mc['last_learn_lesson_id']}");?>"  class="btn btn-primary">查看课程</a>
			</div>
			
		</div>
	</div>
<!-- 每一天内学习的课程，放到一个oneday-learn里面去 -->
<!-- <div class="oneday-learn">
	<span class="time">
       <?php echo date('Y-m-d',$k);?>
    </span>  
	<div class="oneday-list">
		<?php foreach($mcc as $mc){?> 
		
		 	<?php }?> 
		</div>
	</div>	 -->

		<?php endforeach;?>
		<?php echo $this->pagination->create_links();?>	
		<?php else:?>
			<p style="padding:10px;">暂无数据</p>			
		<?php endif;?>	