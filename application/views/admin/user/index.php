<?php $this->load->view("admin/public/header_meta");?>
<!-- 用户管理 -->
<div class="u_cont_Frame b_right_Frame">
	<div class="u_frame_title">
    <a class="btn btn-primary b_middle pull-right" data-toggle="modal" data-target="#export_users" onclick="exportdata();">批量导入</a>
        <a class="btn btn-primary b_middle pull-right" data-toggle="modal" data-target="#add_users" style="margin-right:10px;">添加用户</a>
        <ol class="breadcrumb ">
            <li><a href="#">用户</a></li>
            <li class="active">用户管理</li>
        </ol>
	</div>
	<div class="u_frame_conts course_manage">
		<!--
		<ul class="nav nav-pills">
            <li class="<?php if($this->uri->segment(3)=="username" || $this->uri->segment(3)==""){echo "active";}?>">
                <a href="<?php echo site_url();?>admin/user/username" >用户管理</a>
            </li>	
		</ul>
		-->