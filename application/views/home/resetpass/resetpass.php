<?php $this->load->view('home/public/base_link');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>重设密码</title>
</head>
<body>
	<div class="header">
		北京科技高级技术学院
	</div>
	<div class="wj_password_frame min-height">
		<?php if(empty($errorMessage)){ ?>
		<div class="wj_frame">
			<h4>重设密码</h4>
			<p class="zhanghao">账号：<span><?= $user['email'];?></span></p>
			<div style="font-size:12px;color:red;padding-bottom:12px;" class="p_error"></div>
			<div class="form-group first_bottom">
				<input type="password" placeholder="请输入新密码" name="newPass" value="" class="form-control" id="newPass">
			</div>
			<div class="form-group second-bottom clearfix">
				<input type="password" placeholder="请确认新密码" name="c_newPass" value="" class="form-control" id="c_newPass">
				<input type="hidden" name="userId" value="<?= $user['id']; ?>">
			</div>
			<button class="btn btn-primary login_btn_tk" onclick="post_data()">提交</button>		
		</div>
		<?php } else{ ?>

		
		<div class="wj_frame">
			<div style="padding:40px;color:red;font-size:16px;text-align:center;"><?= $errorMessage;?></div>
			<div style="height:50px;"></div>
		</div>		
		
		
		<?php } ?>
		</div>
	</div>
</body>
</html>

<script>
//提交数据
function post_data(){
		var newPass = $("input[name='newPass']").val();		
		if(newPass==''){ $('.p_error').html("请输入新密码"); return; }
		if(newPass.length < 6){ $('.p_error').html("密码至少六位数"); return; }
		var c_newPass = $("input[name='c_newPass']").val();		
		if(c_newPass==''){ $('.p_error').html("请确认新密码"); return; }		
		if(newPass != c_newPass){ $('.p_error').html("两次密码输入不一致"); return; }
		var uid = $("input[name='userId']").val();		
		//提交数据
		$.post("<?php echo site_url();?>admin/login/resetdata",{'uid':uid,'newPass':newPass},function(data){
			window.location.href="<?php echo site_url("admin/login/success");?>";
		})	
}
</script>

<style>
	a,a:hover{
		text-decoration: none;
	}
	body{margin:0;padding:0;font-family: "microsoft yahei";}
	.header{
		color: #00bc9c;
		font-size: 36px;
		text-align: center;
		line-height: 150px;
		background: #fff;
	}
	.min-height{min-height: 500px;}
	.wj_password_frame{
		background: #f2f5f7;
		position: relative;
	}
	.wj_frame{
		width: 380px;
		height: auto;
		background: #fff;
		border-radius: 4px;
		position:absolute;
		left: 50%;
		margin:60px 0;
		margin-left: -190px;
		padding:50px 50px 0;

	}
	.wj_frame h4{
		font-size: 20px;
		color: #888;
		font-weight: normal;
		margin:0;
		margin-bottom: 15px;
		position: relative;
    	font-family: "microsoft yahei";
	}
	.wj_frame p.zhanghao{
		margin-bottom: 35px;
		color: #aaa;
	}
	.wj_frame .form-control{
		color: #bbb;
		font-size: 12px;
		height: 45px;
		padding-left: 16px;
		border-color: #e0e0e0;
		box-shadow: none;
	}
	.wj_frame .form-control::-webkit-input-placeholder{
		color: #bbb;
	}
	.wj_frame .form-control::-moz-placeholder{
		color: #bbb;
	}
	.wj_frame .form-control:-moz-placeholder{
		color: #bbb;
	}
	.wj_frame .form-control:-ms-input-placeholder{
		color: #bbb;
	}
	.wj_frame .form-control:focus{
		border-color: #00bc9c;
	}
	.wj_frame .first_bottom{
		margin-bottom: 30px;
	}
	.wj_frame .second-bottom{
		margin-bottom: 40px;
	}
	.wj_frame .second-bottom input{
		
	}
	
	.wj_frame .btn.btn-primary{
		border:none;
		background: #00bc9c;
		padding:0;
		line-height: 45px;
		color: #fff;
		font-weight: normal;
		width: 100%;
		margin-bottom: 60px;
	}
	.wj_frame .btn.btn-primary:hover{
		background: #02816b;
	}
</style>
<?php $this->load->view('home/public/base_link');?>