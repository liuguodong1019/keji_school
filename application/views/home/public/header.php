<!-- <header class="cb-header navbar">
	<div class="navbar-header"> -->
		<!-- logo -->
		<!-- <a href="<?php //echo site_url();?>" class="navbar-brand">康邦在线教育平台</a>
		<div class="navbar-user  left ">
			<ul class="nav user-nav" role="menu">
				<li>
					<a href="<?php //echo site_url("admin/course/manage");?>" class="register-user"><i class="es-icon es-icon-setting"></i>管理</a>
				</li>
			</ul>
		</div>
	</div>
</header> -->
<link rel="stylesheet" href="<?php echo base_url()?>/public/home/css/main.css">
<link rel="stylesheet" href="<?php echo base_url()?>/public/home/css/login.css">
<header class="cb-header navbar">
		<nav class="collapse navbar-collapse">
			<h1 class="navbar-name right">
				<a href="<?php echo site_url('course/course_list');?>">北京科技高级技术学校</a>
			</h1>
			<!-- <div class="from-group navbar-search center">
				<input class="form-control" type="text" placeholder="这是一个搜索框">
				<button class="button icon-search"></button>
			</div> -->
			<div class="navbar-user left">
				
				<ul class="nav user-nav" role="menu">
				<?php if (!$_SESSION['user']['id']) {?>
					<!-- 尚未登录时显示 -->
					<li>
						<a href="javascript:void(0);" class="login-user" data-toggle="modal" data-target="#myModalLogin">
							登录
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="login-user" data-toggle="modal" data-target="#myModalRegister">
							注册
						</a>
					</li>
				<?php }else{?>

					<!-- 登录成功后显示 -->
					<li id="userMenu">
						<img src="<?php echo base_url()?>/public/home/images/headpic/<?php echo $_SESSION['user']['headpic'];?>">
						<ul class="user-select-menu">
							<li>
								<?php echo $_SESSION['user']['nickname'];?>
							</li>
							<!-- <li>
								<a href="">
									<i class="head_xiala_icon study t_study"></i>
									教学中心
								</a>
							</li> -->
							<!-- <li>
								<a href="">
									<i class="head_xiala_icon geren"></i>个人主页
								</a>
							</li> -->
	            			<li>
								<a href="<?php echo site_url('learn/my_course')?>">
									<i class="head_xiala_icon study"></i>学习中心
								</a>
							</li>
							<li>
								<a href="<?php echo site_url('user_set/index');?>">
									<i class="head_xiala_icon shezhi"></i>个人设置
								</a>
							</li>
							<?php if ($_SESSION['user']['roles'] == 'admin') {?>
	            			<li>
								<a href="<?php echo site_url('admin/course/manage');?>">
									</i>后台管理
								</a>
							</li>
							<?php }?>
							<!-- <li class="hidden-lg">
								<a href="">
									<i class="head_xiala_icon tz_sx"></i>通知/私信
								</a>
							</li> -->
							<li>
								<a href="<?php echo site_url('course/logout');?>">
									<i class="head_xiala_icon signout"></i>退出登录
								</a>
							</li>
						</ul>
					</li>
					<?php }?>
				</ul>
			</div>
		</nav>
	</header>
	<script>

		// 控制个人操作菜单的出现消失
onload = function () {
	console.log($('#userMenu'))
	$('#userMenu').on('mouseenter', function () {
		$('.user-select-menu').show()
	})
	$('#userMenu').on('mouseleave', function () {
		$('.user-select-menu').hide()
	})
}
	</script>
	<!-- 登录弹框 -->
	<div class="modal fade" id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">登录</h4>
				</div>
				<div class="modal-body">
				<form id = "form">
					<input class="form-control" type="text" placeholder="用户名" name = "email"
					value="<?php if(!empty($this->input->cookie("username"))){echo $this->input->cookie("username");} ?>">
					<input class="form-control" type="password" placeholder="密码" name = "password" value="<?php if(!empty($this->input->cookie("password"))){echo $this->input->cookie("password");} ?>">
					<div class="optations_pas">
						<input type="checkbox" name = 'is_remember' value = "yes" <?php if(!empty($this->input->cookie("password"))){echo 'checked';} ?>>
						<!-- <label for=""></label> -->
						<span>记住密码</span>
						<a href="<?php echo site_url("admin/login/forget_password");?>">忘记密码</a>
					</div>
				</form>
				<span style="color: red" class="cue"></span>
				</div>
				<div class="modal-footer">
					<button type="button"  class="btn btn-default" onclick="but()">登录</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 注册弹框 -->
	<div class="modal fade" id="myModalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">注册</h4>
				</div>
				<div class="modal-body">
				<form id = "form1">
					<input class="form-control" type="text" placeholder="用户名" name = "nickname">
					<div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}">
					  <input type="text" class="am-form-field" placeholder="出生日期" readonly name = "birth_date">
					  <span class="am-input-group-btn am-datepicker-add-on">
					    <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span> </button>
					  </span>
					</div>
					<input class="form-control" type="text" placeholder="邮箱" name = "email" onblur="inspect()" id = "em">
					<input class="form-control" type="text" placeholder="身份证" name = "id_card" onblur="inspect1()" id = "em1">
					<input class="form-control" type="text" placeholder="联系方式" name="moblie">
					<input class="form-control" type="password" placeholder="密码" name ="password">
					<input class="form-control" type="password" placeholder="确认密码" name= "pass">
					<span style="color:gray">性别:</span>
					<div class="btn-group" data-toggle="buttons">
				        <label  class="btn btn-primary">
				            <input  type="radio" value="1"> 男
				        </label>
				        <label  class="btn btn-primary">
				            <input  type="radio" value="2"> 女
				        </label>
					</div>
					
				</form>
				<span style="color: red" class="cue1"></span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default"  onclick="sin()">注册</button>
				</div>
			</div>
		</div>
	</div>

</body>
</html>	

<script>
  function inspect () {
  	var email = $("#em").val();
  	$.post("<?php echo site_url('admin/login/inspect');?>",{'email':email},function (data){
  			if (data ==1) {$(".cue1").html('此邮箱已被注册');}else{$(".cue1").html('');}
  	});
  }
  function inspect1 () {
  	var id_card = $("#em1").val();
  	$.post("<?php echo site_url('admin/login/inspect1');?>",{'id_card':id_card},function (data){
  			if (data ==1) {$(".cue1").html('此身份证已被注册');}else{$(".cue1").html('');}
  	});
  }
function but () {
	var formData = new FormData($("#form")[0]);
	if (formData.get('email') == '') {
		$(".cue1").html('用户名不能为空');
	}else if(formData.get('password') == '') {
		$(".cue1").html('密码不能为空');
	}else {
		$.ajax({
			url: '<?php echo site_url('admin/login/check_login');?>',
			type:'POST',
			data:formData,
			async: false,  
			cache: false,  
			contentType: false,  
			processData: false,  
			success: function (data) {  
				if (data == 1) {
					window.location.reload();
				}else if (data == 2) {
					$(".cue").html('账号或密码错误');
				}else if (data == 3) {
					$(".cue").html('用户已被锁定');
				}
				
			}
		});
	}	
}

// 控制个人操作菜单的出现消失
onload = function () {
	console.log($('#userMenu'))
	$('#userMenu').on('mouseenter', function () {
		$('.user-select-menu').show()
	})
	$('#userMenu').on('mouseleave', function () {
		$('.user-select-menu').hide()
	})
}
</script>
<script>
	function sin () {
		var formData = new FormData($("#form1")[0]);
		var nickname = formData.get('nickname');
		var password = formData.get('password');
		var pass = formData.get('pass');
		var email = formData.get('email');
		var id_card = formData.get('id_card');
		var moblie = formData.get('moblie');
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		var reg2 = /^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
		if (nickname == '') {
			$(".cue1").html('用户名不能为空');
		}else if(password == '') {
			$(".cue1").html('密码不能为空');return;
		}else if(pass == '') {
			$(".cue1").html('密码不能为空');return;
		}else if(email == '') {
			$(".cue1").html('邮箱不能为空');
		}else if(id_card == '') {
			$(".cue1").html('证件编号不能为空');
		}else if(moblie == '') {
			$(".cue1").html('联系方式不能为空');
		}else if(password !== pass) {
			$(".cue1").html('两次密码不一致');
		}else {
			if(password.length < 6){ $('.cue1').html("密码至少六位数");}
			else if(password != pass){ $('.cue1').html("两次密码输入不一致"); return;}
			else if(!reg.test(email)){ $('.cue1').html("邮箱格式不正确"); return; }
			else if(!reg2.test(moblie)){ $('.cue1').html("手机格式不正确"); return; }
			else {
				$.ajax({
				url: '<?php echo site_url('admin/login/sign_in');?>',
				type:'POST',
				data:formData,
				async: false,  
				cache: false,  
				contentType: false,  
				processData: false,  
				success: function (data) {  
					if (data == 1) {
						alert('注册成功,请登录');
						window.location.reload();
					}else {
						alert('注册失败');
					}
				}	
				});
			}
			
		}

		

	}
</script>