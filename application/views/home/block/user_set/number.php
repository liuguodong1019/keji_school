<!-- 绑定账号 -->
<div class="panel panel-default num_bangding  right_frame">
	<div class="panel-heading">
		<ol class="breadcrumb">
		  <li><a href="#">个人设置</a></li>
		  <li class="active">绑定账号</li>
		</ol>
	</div>
	<div class="panel-body">
		<div class="form-group clearfix">
			<div class="col-md-9 col-md-offset-2" style="padding:0;">
				<p>绑定第三方帐号，可以直接登录，还可以将内容同步到以下平台，与更多好友分享。</p>
				<div class="clearfix">
					<div class="zhh_type">
						<span class="zhh_img weixin"></span>
						<span class="zh_text">未绑定账号</span>
						<a herf="<?php echo site_url("user_set/weixin");?>" class="btn btn-primary">立即绑定</a>
					</div>
					<div class="zhh_type">
						<span class="zhh_img blog"></span>
						<span class="zh_text">未绑定账号</span>
						<button class="btn btn-primary">立即绑定</button>
					</div>
					<div class="zhh_type on"><!-- 添加类名on表示已绑定时的样式 -->
						<span class="zhh_img qq"></span>
						<span class="zh_text">已绑定QQ账号</span>
						<button class="btn btn-default">解除绑定</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>

</div>