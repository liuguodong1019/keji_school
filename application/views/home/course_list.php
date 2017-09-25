<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('home/public/base_link');?>
<!-- <link rel="stylesheet" href="<?php //echo base_url()?>/public/home/css/main.css">
<link rel="stylesheet" href="<?php //echo base_url()?>/public/home/css/login.css"> -->
<body>
<?php $this->load->view('home/public/header');?> 

	

	<div class="banner">
			<img src="<?php echo base_url()?>/public/home/static/keji_photo.jpg" alt="">
	</div>

	<!-- 课程内容区 -->
  <section id="course-content">
		<!-- 课程列表开始 -->
        <div id="course-list">
            <div class="container">
                <!-- 课程标签 -->
                <div class="course_label row">
					<ul>
						<li class="<?php if($tage ==""){echo "active";}?>">
                            <a href="<?php echo base_url()?>course/course_list">全部</a>
                        </li>
						<?php if(!empty($category)){ foreach($category as $key=>$value){ ?>
                        <li class="<?php if($tage == $value['icon']){echo "active";}?>">
                            <a href="<?php echo base_url()?>course/course_list/<?= $value['icon'];?>"><?= $value['title'];?></a>
                        </li>
						<?php } } ?>
					</ul>
                </div>
                
                <!-- 课程列表 start -->
				<div class="course-list">
					<div class="row">
						<?php if(!empty($course_list)){ ?>
							<?php foreach($course_list as $v){?>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
								<div class="course-item">
									<a href="<?php echo site_url();?>course/lesson/<?=$v['id']?>/<?= $v['lid']?>" class="course-img">
										<div class="course_pic_frame">
											<img src="<?php echo site_url()?>public/home/images/course/<?=$v['pic']?>" alt="" onclick = "gui()">
										</div>
									</a>
									<div class="course-info" style="width:100%;">
										<div class="title">
											<!-- 课程标题 -->
											<a href="<?php echo site_url();?>course/lesson/<?=$v['id']?>/<?= $v['lid']?>">
													<?=$v['title']?>
											</a><br>
											<?=$v['about']?>
										</div>
									</div>
								</div>
							</div>
							<?php }
						}else{echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"><div class="title">暂无数据</div><br /></div>';}?>
					</div>
				</div>
				<?php echo $this->pagination->create_links();?>		
                <!-- 课程列表 end -->					
			</div>
        </div>
	</section>
 <script>
  
// // 控制个人操作菜单的出现消失
// onload = function () {
// 	console.log($('#userMenu'))
// 	$('#userMenu').on('mouseenter', function () {
// 		$('.user-select-menu').show()
// 	})
// 	$('#userMenu').on('mouseleave', function () {
// 		$('.user-select-menu').hide()
// 	})
// }
</script>
