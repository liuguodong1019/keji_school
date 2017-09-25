<?php $this->load->view('home/public/base_link');?>
<!-- <?php //$this->load->view('home/course_list');?> -->
<?php $this->load->view('home/public/header');?> 

	<!-- 找回密码 start -->
	<div class="wj_password_frame min-height">
		<div class="wj_frame">
			<h4>忘记密码<small><a href="<?php echo site_url('course/course_list');?>">返回</a>，<a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLogin">立即登录</a></small></h4>	
			<div style="font-size:12px;color:red;padding-bottom:12px;" class="p_error"></div>
			<div class="form-group first_bottom">
				<input type="text" placeholder="请输入注册时的邮箱地址" name="p_email" value="" class="form-control" id="p_email">
			</div>
			<div class="form-group second-bottom clearfix" style="margin-bottom:25px;">
				<input type="text" placeholder="请输入验证码" name="p_code" value="" class="form-control" id="p_code">
				<div id="captcha-image" class="reload" style="cursor:pointer;"></div>
				<a href="javascript:void(0)" class="icon-refresh reload" onclick="changeCode();"></a><br /><br />
			</div>	
			<input type="hidden" name="codeval" id="codeval" value="">			
			<button class="btn btn-primary login_btn_tk" onclick="post_data()" style="height: 40px">提交</button>	
		</div>
	</div>
	<!---找回密码 end-->	

<script type="text/javascript">
//提交数据
function post_data(){
	//判断邮箱
		var p_email = $("input[name='p_email']").val();		
		if(p_email==''){ $('.p_error').html("请输入注册时的邮箱"); return; }
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 		
		if(!reg.test(p_email)){ $('.p_error').html("请填写正确的邮箱格式"); return; }	
	//判断验证码
		var p_code = $("input[name='p_code']").val();		
		if(p_code==''){ $('.p_error').html("请输入验证码"); return; }
		var code = $("#codeval").val();
		if(code != p_code){ $('.p_error').html("验证码输入错误"); return; }
	//数据正确 提交
		//提交数据
		$.post("<?php echo site_url();?>admin/login/forget_password",{'p_email':p_email,'p_code':p_code},function(data){
			if(data == "2"){
				$('.p_error').html("该邮箱不存在"); return;
			}else{
				window.location.href="<?php echo site_url("admin/login/resetpass");?>?email="+data+"";
			}
		})	
}
function get_captcha() {
    $.get("<?php echo site_url('admin/login/get_captcha');?>", function(data){
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
</script>

<!-- <?php //$this->load->view('home/public/footer');?> -->
<style>
	.min-height{min-height: 620px;}
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
		margin-bottom: 35px;
		position: relative;
    	font-family: "microsoft yahei";
	}
	.wj_frame h4 small{
		color: #888;
		font-size: 12px;
		line-height: 22px;
		font-weight: normal;
		position: absolute;
		right: 0;
	}
	.wj_frame h4 small a{
		color: #1963e9;
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
		margin-bottom: 20px;
	}
	.wj_frame .second-bottom{
		margin-bottom: 55px;
	}
	.wj_frame .second-bottom input{
		width: 160px;
		display: inline-block;
		float: left;
	}
	.wj_frame .second-bottom img{
		width: 75px;
		height: 45px;
		float: left;
		margin-left: 15px;
	}
	.wj_frame .second-bottom .icon-refresh{
		color: #ccc;
    	font-size: 20px;
    	display: inline-block;
    	margin: 12px 0 0 10px;
    	-webkit-transition: 0.4s linear;
    	transition: 0.4s ease-in;
    	float: left;
	}
	.wj_frame .second-bottom .icon-refresh:hover {
	    color: #787d82;
	    transform: rotate(360deg);
	    -webkit-transform: rotate(360deg);
	    -moz-transform: rotate(360deg);
	    -o-transform: rotate(360deg);
	    -ms-transform: rotate(360deg);
	}
	.wj_frame .btn.btn-primary{
		border:none;
		background: #1976e9;
		padding:0;
		line-height: 45px;
		color: #fff;
		font-weight: normal;
		width: 100%;
		margin-bottom: 60px;
	}
	.wj_frame .btn.btn-primary:hover{
		background: #1963e9;
	}
</style>