<!-- 修改密码 -->
<div class="panel panel-default safety-setting right_frame">
	<div class="panel-heading">
		<ol class="breadcrumb">
		  <li><a href="#">个人设置</a></li>
		  <li class="active">修改密码</li>
		</ol>
	</div>
	<div class="panel-body">
		<form action="<?php echo site_url("user_set/xiugai");?>" method="post"  id="mm" class="form-horizontal">
			<div class="form-group clearfix">
				<label for="" class="col-md-2 control-label">安全等级</label>
				<div class="col-md-7">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
						</div>
					</div>
				</div>
				<span style="color:#e77367;font-size: 12px;display: inline-block;margin-top: 8px;">中</span>
			</div>
			<!-- 密码修改 -->
			<?php echo $box;?>
			<!-- 当前密码 -->
			<div class="form-group">
				<label for="inputText15" class="col-md-2 control-label">当前密码</label>
				<div class="col-md-6">
					<input type="password" class="form-control" onblur="o(this);" name="old" id="inputText15">
					<div class="help-block" style="display:none;">
						<span class="text-danger">请输入当前密码</span>
					</div>
					<span class="c" style="display:none;"></span>
				</div>
				<script>
				function o(obj){
					if ($(obj).val() == 0) {
						focunsout(obj);
					}else{
						var mima = $("#inputText15").val();
						$.post("<?php echo site_url('user_set/check_');?>",{'mima':mima},function(data){
							if(data==""){
								$(".c").css('display','block')
								$(".c").addClass("text-danger").html("密码不正确")
							}else{
								$(".c").css('display','none')
							}
						})
					}
				}
				$('#inputText15').focusin(function() {
					focunsin(this);
				})
				
				</script>
			</div>
			<!-- 新密码 -->
			<div class="form-group">
				<label for="inputText16" class="col-md-2 control-label">新密码</label>
				<div class="col-md-6">
					<input type="password" class="form-control" id="inputText16">
					<div class="help-block" style="display:none;">
						<span class="text-danger">请输入新密码</span>
					</div>
					<div class="help-block" style="display:none;">
						<span class="text-danger">新密码的长度必须大于或等于6</span>
					</div>
				</div>
				<script>
				$('#inputText16').focusout(function() {
					if ($(this).val() == 0) {
						focunsout(this);
					} else if ($(this).val() != 0) {
						if ($(this).val().length < 6) {
							console.log("密码长度小于6");
							$(this).next().next().css('display', 'block');
							$(this).parents('.form-group').addClass('has-error');
						}
					}
				})
				$('#inputText16').focusin(function() {
					focunsin(this);
				})
				</script>
			</div>
			<!-- 确认密码 -->
			<div class="form-group">
				<label for="inputText17" class="col-md-2 control-label">确认密码</label>
				<div class="col-md-6">
					<input type="password" class="form-control" name="new" id="inputText17">
					<div class="help-block q" style="display:none;">
						<span class="text-danger">请输入确认密码</span>
					</div>
					<div class="help-block re" style="display:none;">
						<span class="text-danger">两次输入的确认密码不一致，请重新输入</span>
					</div>
				</div>
				<script>
				$('#inputText17').focusout(function() {
					var pas = $('#inputText16').val();
					var repas = $('#inputText17').val();
					if(pas!=repas){
                        $(".re").css('display','block');
					}
				})
				
				</script>
			</div>
			
		</form>
		<div class="col-md-6 col-md-offset-2">
				<button class="btn btn-primary" id="l">保存</button>
		</div>
		<script>
				$('#l').click(function() {

					if ($('#inputText17').val() == 0) {
						 focunsout($('#inputText17'));
					}else if($('#inputText15').val() == 0){
                         focunsout($('#inputText15'));
					}else if($('#inputText16').val() == 0){
                         focunsout($('#inputText16'));
					} else if ($('#inputText17').val() != 0) {
						var pas = $('#inputText16').val();
						if ($('#inputText17').val() != pas) {
							$('#inputText17').next().next().css('display', 'block');
							$('#inputText17').parents('.form-group').addClass('has-error');
							
						}else{
							$("#mm").submit();
						}
					}
				})
				$('#inputText17').focusin(function() {
					focunsin(this);
				})

		</script>
		<!-- <div class="row">
			<div class="col-md-2 text-right text-success" style="font-size:20px;">
				<span class="glyphicon glyphicon-ok"></span>
			</div>
			<span class="col-md-3" style="margin-top:5px;">登录密码</span>
			<span class="col-md-4" style="margin-top:5px;">登录网校时需要输入的密码</span>
			<a href="<?php echo site_url("user_set/safety2");?>" class="col-md-offset-1 btn btn-primary" style="margin-top: -3px;">修改</a>
		</div> -->
	</div>
</div>