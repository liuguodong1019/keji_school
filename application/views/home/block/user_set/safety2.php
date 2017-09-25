<!-- 安全设置/登录密码修改 -->
<div class="panel panel-default logoin-password-change">
	<div class="panel-heading">
		安全设置
	</div>
	<div class="panel-body">
		<ol class="breadcrumb">
			<li><a href="#">安全设置</a></li>
			<li class="active">登录密码修改</li>
		</ol>
		<!-- 密码修改 -->
		<form action="<?php echo site_url("user_set/xiugai");?>" method="post"  id="mm" class="form-horizontal">
			<?php echo $box;?>
			<!-- 当前密码 -->
			<div class="form-group">
				<label for="inputText15" class="col-md-2 control-label">当前密码</label>
				<div class="col-md-7">
					<input type="text" class="form-control" onblur="o(this);" name="old" id="inputText15">
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
								$(".c").html("密码不正确")
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
				<div class="col-md-7">
					<input type="text" class="form-control" id="inputText16">
					<div class="help-block" style="display:none;">
						<span class="text-danger">请输入新密码</span>
					</div>
					<div class="help-block" style="display:none;">
						<span class="text-danger">新密码的长度必须大于或等于5</span>
					</div>
				</div>
				<script>
				$('#inputText16').focusout(function() {
					if ($(this).val() == 0) {
						focunsout(this);
					} else if ($(this).val() != 0) {
						if ($(this).val().length < 5) {
							console.log("密码长度小于5");
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
				<div class="col-md-7">
					<input type="text" class="form-control" name="new" id="inputText17">
					<div class="help-block" style="display:none;">
						<span class="text-danger">请输入确认密码</span>
					</div>
					<div class="help-block" style="display:none;">
						<span class="text-danger">两次输入的确认密码不一致，请重新输入</span>
					</div>
				</div>
				
			</div>
			
		</form>
		<div class="col-md-7 col-md-offset-2">
				<button class="btn btn-primary" id="l">提交</button>
		</div>
		<script>
				$('#l').click(function() {
					if ($('#inputText17').val() == 0) {
						focunsout($('#inputText17'));
					} else if ($('#inputText17').val() != 0) {
						var prevtext = $('#inputText17').parents('.form-group').prev().find("input[type='text']").val();
						if ($('#inputText17').val() != prevtext) {
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
	</div>

</div>