<!-- 邮箱验证 -->
<div class="panel panel-default email_yanzheng  right_frame">
	<div class="panel-heading">
		<ol class="breadcrumb">
		  <li><a href="#">个人设置</a></li>
		  <li class="active">邮箱验证</li>
		</ol>
	</div>
	<div class="panel-body" style="padding-bottom:400px;">
		<!-- 邮箱未验证时 显示 -->
		<?php if($info[0]['emailverify']==0):?>
		<div class="form-group clearfix">
			<label for="" class="col-md-2 control-label">当前登录邮箱</label>
			<div class="col-md-7 yzh_frame">
				<p><?=$info[0]['email']?></p>
				<span style="display:block;margin-bottom:35px;">邮箱尚未验证</span>
				<a href="#" class="btn btn-primary" onclick="verify('<?=$info[0]['id']?>','<?=$info[0]['email']?>','<?=$info[0]['nickname']?>');">去验证</a>
			</div>
		</div>
		<!-- 邮箱已验证后 当前页显示 -->
		<?php elseif($info[0]['emailverify']==1):?>
		<div class="e_after_img">
			<img src="<?php echo base_url()?>/public/home/static/email01.png" alt="">
		</div>
		<h3 class="e_after_title">邮箱已绑定，并验证</h3>
		<div class="e_after_mail">
			<?=$info['email']?>
			<a href="javascript:void(0);" data-toggle="modal" data-target="#yanzhengshenfen">更改</a>
		</div>
		<div class="e_after_info">可用邮箱找回密码</div>
		<?php endif;?>	
	</div>
</div>

<!-- 验证身份 -->
<div class="modal fade" id="yanzhengshenfen">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4 class="modal-title">验证身份</h4>
				<div class="keybox"><i></i></div><!-- class="icon-key"  -->
				<p class="wenzi_part">请输入登录密码验证身份<br><?=$info[0]['email']?></p>
				<form action="" class="form-horizontal">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">密码：</label>
						<div class="col-sm-10">
							<input type="password" id="password" placeholder="请输入密码" name="password" class="form-control password">
						    <span class="text-danger null_error" style="display:none;margin-top:5px;">请输入密码</span>
						    <span class="text-danger pass_error" style="display:none;margin-top:5px;">密码错误</span>
						</div>
					</div>
					<div class="form-group ma clearfix" style="margin-bottom:25px;">
						<label for="" class="col-sm-2 control-label">验证码：</label>
						<div class="col-sm-10">
							<input type="text" placeholder="输入验证码" name="yanzhengcode" class="form-control">
							<div id="captcha-image" class="reload" style="cursor:pointer;">
								<!-- <img src="http://192.168.140.81:82/vv/public/captcha/1475129683.2521.jpg"> -->
							</div>
							<a href="javascript:void(0)" class="icon-refresh reload" onclick="changeCode();"></a>
							<input type="hidden" name="codeval" id="codeval" value="">	
							<span class="text-danger has_error" style="display:none;margin-top:5px;">请输入4位验证码</span>
							<span class="text-danger is_error" style="display:none;margin-top:5px;">验证码错误</span>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" id="sure_info" onclick="make_sure(this);">确定</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
//提交数据
function make_sure(obj){
	//判断邮箱
		var password = $("#password").val();	
		var u_id = "<?php echo $info[0]['id'];?>";
		if(password==''){
			$('.null_error').css('display','block');
            $('.pass_error').css('display','none');
			return;}
	//判断验证码
		var p_code = $("input[name='yanzhengcode']").val();	
		if(p_code==""){ 
			$('.has_error').css('display','block');
			$('.is_error').css('display','none');
			return; }
		var code = $("#codeval").val();
		if(code != p_code){
		 $('.is_error').css('display','block');
         $('.has_error').css('display','none');
		 return;}
	//数据正确 提交
		//提交数据
		$.post("<?php echo site_url();?>user_set/get_email",{'password':password,'u_id':u_id},function(data){
			if(data == "no"){
				$('.null_error').css('display','none');
				$('.pass_error').css('display','block');

			}else if(data == "yes"){
				//单击“验证身份”框中的确认按钮
				$('#yanzhengshenfen').modal('hide');
				$('#changemail').modal('show');
			}
		})	
}
function get_captcha() {
    $.get("<?php echo site_url('home/get_captcha');?>", function(data){
        var code =  eval('('+data+')');      
		$('#captcha-image').html(code['image']);
		$('#codeval').val(code['word']);
    });
};
$(function(){
    get_captcha();
    $('.reload').click(get_captcha);
})
function changeCode(){  
     document.getElementById('captcha_images').src ="<?php echo base_url()?>login/captcha_URL";  
} 

function email(obj){
    var email = $("#email").val();
    if(email==''){
     $('.email_error').css('display','none'); 
     $('.email_null').css('display','block'); return; }
    var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 		
    if(!reg.test(email)){ 
    	$('.email_null').css('display','none'); 
    	$('.email_error').css('display','block'); return; }	
    var u_id = "<?php echo $info[0]['id'];?>";
    $.post(base_url+"user_set/update_email",{'email':email,'u_id':u_id},function(data){
    	if(data==1){
    		$('#changemail').modal('hide');
    		$('#change_success').modal('show');
    	}
    	
    })
}
</script>
<!-- 修改邮箱 -->
<div class="modal fade" id="changemail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4 class="modal-title">修改邮箱</h4>
				<form action="" class="form-horizontal">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">邮箱：</label>
						<div class="col-sm-10">
							<input type="text" placeholder="请输入您的邮箱" name="mail" id="email" class="form-control">
							<span class="text-danger email_null" style="display:none;margin-top:7px;margin-right:15px;">请输入邮箱</span>
							<span class="text-danger email_error" style="display:none;margin-top:7px;margin-right:15px;">邮箱格式不正确</span>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" id="sure_change" onclick="email(this);">确定</button>
			</div>
		</div>
	</div>
</div>
<!-- 修改邮箱成功提示框 -->
<div class="modal fade" id="change_success">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="register_success_frame">
				<div class="e_end_img">
				    <img src="<?php echo base_url()?>/public/home/static/email02.png" alt="">
				</div>
				<h3 class="e_after_title">邮箱绑定成功，但尚未验证</h3>
				<div class="e_after_info col_888">你可以通过
					<a href="javascript:void(0);" onclick="sendmail();"></a>登录慕课平台</div>
				<div style="text-align:center;margin-top:50px;">
					<a href="<?php echo site_url("user_set/email");?>" target="_blank" class="btn btn-primary" id="e_check" >去邮箱验证</a>
					<a href="javascript:void(0);" class="btn btn-primary btn-default" onclick="guanbik()" >稍后验证</a>
				</div>
				<input type="hidden" name="reg_user_id"  id="reg_user_id" value="">
				<input type="hidden" name="reg_user_email"  id="reg_user_email" value="">
				<input type="hidden" name="reg_user_nickname"  id="reg_user_nickname" value="">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function verify(id,email,nickname){
		$.post(base_url+"user_set/emailverify",{'email':email,'id':id,'nickname':nickname},function(data){

			if(data==1){
				window.location=base_url+"user_set/emailverifed";
		
			}
			
		})
	}
	function guanbik () {
		$('#change_success').modal('hide');
	}
</script>