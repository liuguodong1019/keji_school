<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>邮箱验证成功页</title>
</head>
<body>
	<div class="header">
		康邦在线教育平台
	</div>
	<div class="e_end_img">
	    <img src="<?php echo base_url()?>/public/home/static/email02.png" alt="">
	</div>
	<h3 class="e_end_title">恭喜你，邮箱验证成功</h3>
	<div style="text-align:center;">
		<a href="<?php echo site_url();?>" class="btn btn-primary">返回首页</a>
	</div>
</body>
</html>
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
	.e_end_title{
		text-align: center;
		color: #666;
		font-weight:bold;
		font-size: 24px;
		margin-top: 30px;
		margin-bottom: 50px;
		font-family: "microsoft yahei";
	}
	.btn.btn-primary {
		text-decoration: none;
	    color: #fff;
	    background: #00bc9c;
	    border: #none;
	    border-radius: 4px;
	    padding: 14px 52px;
	    font-size: 24px;
	    line-height: 12px;
	}
	.btn.btn-primary:hover {
	    color: #fff;
	    background: #02816b;
	    border-color: #02816b;
	}
</style>