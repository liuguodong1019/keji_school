<?php $this->load->view('home/public/base_link');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>密码重设连接邮件发送成功</title>
</head>
<body>
	<div class="header">
		北京科技高级技术学院
	</div>
	<div class="e_end_img">
	    <img src="<?php echo site_url("public/home/images/email02.png");?>" alt="">
	</div>
	<h3 class="e_after_title">密码重设连接邮件发送成功</h3>
	<div class="e_after_mail">
        已发送邮件至
        <span><?= $user['email'];?></span>
		<input type="hidden" name="userid" value="<?= $user['id'];?>" id="userid">
		<input type="hidden" name="email" value="<?= $user['email'];?>" id="email">
    </div>
    <div class="e_after_info col_888">没有收到？再次<a href="javascript:void(0);" onclick="sendto();">发送验证邮件</a></div>
</body>
</html>
<script>
function sendto(){
	var uid = $('#userid').val();
	var email = $('#email').val();
	$.post("<?php echo site_url();?>home/sendagain",{'uid':uid,'email':email},function(data){
	})	

}
</script>
<style>
	body{margin:0;padding:0;font-family: "microsoft yahei";}
	.header{
		color: #00bc9c;
		font-size: 36px;
		text-align: center;
		line-height: 150px;
		background: #f2f5f7;
	}
	.e_end_img{
		text-align: center;
		margin-top: 90px;
	}
	.e_after_title{
		text-align: center;
		color: #666;
		font-size: 24px;
		margin-top: 30px;
		margin-bottom: 25px;
		font-weight: normal;
		font-family: "microsoft yahei";
	}
	.e_after_mail{
		text-align: center;
		font-size: 18px;
		font-family: "microsoft yahei";
		color: #aaa;
	}
	.e_after_mail span{
		color: #00bc9c;
	}
	.e_after_info{
		font-family: "microsoft yahei";
		color: #aaa;
		font-size: 14px;
		text-align: center;
		margin-top: 20px;
	}
	.e_after_info.col_888{
		color: #888;
	}
	.e_after_info a{
		text-decoration: none;
		color: #00bc9c;
	}
</style>