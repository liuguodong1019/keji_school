<!-- 课时列表 -->
	<?php 
		$lesson=array(); //后期加载html没法接着循环存sessionk值 接着 循环
		if($courses_lesson){$lesson = $courses_lesson[$_SESSION['room_lesson_key']]['lessons'];
							$course[0]['id'] = $courses_lesson[$_SESSION['room_lesson_key']]['c_id'];
		}
		if($lessons){$lesson = $lessons;}
	?>
	
	<?php if($lesson): ?>
			<ul class="panel-keshi-body">
				<li class="section"></li>	
				<?php $i=1;foreach($lesson as $key=>$le): ?>
				<li class="keshi-list-item <?= ($l_id == $le['id'])?'active':'';?>">	<!-- 当前课时是 为li 添加类名 active	 -->		
					<a href="<?php echo site_url("course/lesson/{$course[0]['id']}/{$le['id']}");?>" title="<?=$le['title']?>">
						课时<?= $i;?>：
						<i class="keshi-icon-doing keshi-icon"></i>
						<span class="keshi-type type-video"></span>
						<span class="title"><?=$le['title']?></span>
						<!-- 课时类型图标 -->
						<?php if($le['resource_type']=="video"):?>
						<span class="keshi-type type-video"></span>
						<?php elseif($le['resource_type']=="text" || $le['resource_type']=="document"):?>
						<span class="keshi-type type-txt"></span>
						<?php elseif($le['resource_type']=="ppt"):?>
						 <span class="keshi-type type-ppt"></span>
						<?php elseif($le['resource_type']=="audio"):?>
						<span class="keshi-type type-audio"></span>
						<?php elseif($le['resource_type']=="pic"):?>
						<span class="keshi-type type-pic"></span>
						<?php elseif($le['resource_type']=="testpaper"):?>
						<span class="keshi-type type-test"></span>
						<?php endif;?>
					</a>
				</li>
			<?php $i++; endforeach; ?>				
			</ul>
	<?php endif; ?>