<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>个人设置 <?= $message['name'];?> - <?= $message['slogan'];?></title>			
	<?php $this->load->view('home/public/base_link');?>
	<link rel="stylesheet" href="<?php echo base_url()?>/public/home/css/geren-personal.css">
    <script src="<?php echo base_url()?>/public/home/js/ID-authentication.js"></script>
	 <script>
    //表单项“获取焦点”和“失去焦点”时效果
    function focunsin(eee) {
        $(eee).parents('.form-group').removeClass('has-error');
        $(eee).nextAll('.help-block').css('display', 'none');
    }

    function focunsout(eee) {
        $(eee).next('.help-block').css('display', 'block');
        $(eee).parents('.form-group').addClass('has-error');
    }
    </script>
	<?php if($this->uri->segment(2)=="headpic"):?> 
	<script>
		var g_id = '<?php echo $_SESSION['user']['id'];?>';
	</script>
	<link href="<?php echo base_url()?>/public/expand/xx_img/css/jquery.Jcrop.min.css" rel="stylesheet" />
	<script src="<?php echo base_url()?>/public/expand/xx_img/js/jquery.Jcrop.min.js"></script>  
    <script src="<?php echo base_url()?>/public/expand/xx_img/js/upImgJcrop.js"></script>
	<?php endif; ?>
</head>

<body>
    <div class="cb-wrap">
		<!--头部-->
		<?php $this->load->view('home/public/header');?>
		<!--主题内容-->
		<div class="min-height container">
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="nav-list">
                                <!-- 标题 -->
                                <div class="nav-title">个人设置</div>
                                <div class="list-group">
                                    <a href="<?php echo site_url("user_set/index");?>" class="list-group-item <?php if($page=="index"){echo "active";}?>"><i></i>个人资料</a>
                                    <a href="<?php echo site_url("user_set/headpic");?>" class="list-group-item <?php if($page=="headpic"){echo "active";}?>"><i></i>头像设置</a>
                                    <a href="<?php echo site_url("user_set/safety");?>" class="list-group-item <?php if($page=="safety"){echo "active";}?>"><i></i>修改密码</a>
                                    <!-- <a href="<?php //echo site_url("user_set/email");?>" class="list-group-item  <?php //if($page=="email" || $page=="emailverifed"){echo "active";}?>"><i></i>邮箱验证</a> -->
                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <?php if($page=="index"){$this->load->view("home/block/user_set/base_msg");}
							if($page=="headpic"){$this->load->view("home/block/user_set/headpic");}
							if($page=="safety"){$this->load->view("home/block/user_set/safety");}
							if($page=="safety2"){$this->load->view("home/block/user_set/safety2");}
                            if($page=="email"){$this->load->view("home/block/user_set/email");}
                           /* if($page=="number"){$this->load->view("home/block/user_set/number");}*/
					?>
                </div>
            </div>
        </div>
		<!--底部-->
		<!-- <?php $this->load->view('home/public/footer');?> -->
	</div>
</body>
</html>