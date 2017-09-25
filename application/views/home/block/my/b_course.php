<!-- 我的课程 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<ol class="breadcrumb">
		  <li><a href="javascript:void">学习中心</a></li>
		  <li class="active">我的课程</li>
		</ol>
	</div>
	<div class="panel-body" style="padding-bottom:35px;">
		
		<ul class="nav nav-pills" >
			<li <?php if(!$action or $action=="learning"){echo "class='active'";}?>>
				<a href="<?php echo site_url("learn/my_course/learning");?>" class="btn btn-primary">学习中</a>
			</li>
			<li <?php if($action=="finished"){echo "class='active'";}?>>
				<a href="<?php echo site_url("learn/my_course/finished");?>" class="btn btn-primary">已学完</a>
			</li>
		</ul>
		
		<div class="course_list_frame">
        	<!-- 学习中 -->
			<?php if($this->uri->segment(3)=="" or $this->uri->segment(3)=="learning"){$this->load->view("home/block/my/my_course/b_learn");}?>
        	<!-- 已学完 -->
        	<?php if($this->uri->segment(3)=="finished"){$this->load->view("home/block/my/my_course/b_finished");}?>
		</div>
	</div>

	
</div>