<?php $this->load->view("admin/public/header_meta");?>
<!-- 用户管理 -->
<div class="u_cont_Frame b_right_Frame">
	<div class="u_frame_title">
		<?php if($this->uri->segment(3)=="manage"){?>
		<a class="btn btn-primary b_middle pull-right" data-toggle="modal" data-target="#creatclass">创建课程</a>
		<?php  } ?>
		<ol class="breadcrumb ">
			<li><a href="#">课程</a></li>
			<li class="active">课程管理</li>
		</ol>
	</div>
	<div class="u_frame_conts course_manage">
		<!--
		<ul class="nav nav-pills">
            <li class="<?php if($this->uri->segment(3)=="manage"){echo "active";}?>">
                <a href="<?php echo site_url();?>admin/course/manage" >课程管理</a>
            </li>	
		</ul>
		-->