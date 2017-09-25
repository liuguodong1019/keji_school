<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>后台管理 登录</title>
       <?php $this->load->view('admin/public/base_link');?>
</head>
<body style="background:#f2f5f7;">
	<!--用户登录 start-->
	<div class="container log-in-frame">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3">
				<div class="login-content-frame">
					<div class="top">
						<h4>登录</h4>
					</div>				
						<div class="form-group">
							<p class="x" style="color:red;"></p>
							<label for="account-number">账号</label>
							<input type="text" placeholder="用户名" name="email" value="" class="form-control" id="account-number">
						</div>
						<div class="form-group">
							<label for="account-number">密码</label>
							<input type="password" placeholder="密码" name="password" value="" class="form-control" id="account-number">
						</div>
						<div class="form-group btns-relative">
							<button class="btn btn-primary">登录</button>
						</div>
				</div>
			</div>
		</div>
	</div>
	<!--用户登录 end -->
</body>
</html>
<script>
	$(".btn-primary").click(function(){
		var email = $("input[name='email']").val();
		var password =$("input[name='password']").val();
		if(email=='' || password=='' ){
			$('.x').html("账号或密码不能为空");
			return;
		}else{
			$.post("<?php echo site_url();?>admin/login/check_login",{'email':email,'password':password},function(data){
				if(data==2){
					$('.x').html("账号或密码错误");
				}else if(data==3){
					$('.x').html("您的账号己被禁用，请联系管理员");
				}else if(data==1){
					//history.go(-1)
					 window.location = "<?php echo site_url("admin/course/manage");?>"  
				}
			})
		}
	})
</script>