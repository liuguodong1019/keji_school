<?php $this->load->view('home/public/base_link');?>
<?php $this->load->view('home/public/header');?>

<div class="wj_password_frame min-height">
	<div class="wj_frame">
		<h4>忘记密码<small>返回，<a href="">立即登录</a></small></h4>
		<div class="form-group first_bottom">
			<input type="text" placeholder="请输入注册时的邮箱地址" name="email" value="" class="form-control" id="">
		</div>
		<div class="form-group second-bottom clearfix">
			<input type="text" placeholder="请输入验证码" name="" value="" class="form-control" id="">
			<img src="<?php echo base_url()?>/public/home/static/yanzhng_code01.jpg" alt="">
			<a href="javascript:void(0)" class="icon-refresh"></a>
		</div>
		<button class="btn btn-primary login_btn_tk">提交</button>		
	</div>
</div>
<?php $this->load->view('home/public/footer');?>
<style>
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
		color: #00bc9c;
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