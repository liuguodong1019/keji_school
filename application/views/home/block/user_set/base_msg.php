<!-- 个人资料 -->
<div class="panel panel-default basic-information right_frame">
	<div class="panel-heading">
		<ol class="breadcrumb">
		  <li><a href="#">个人设置</a></li>
		  <li class="active">个人资料</li>
		</ol>
	</div>
	<?php echo $box;?>

	<div class="panel-body">
		<form action="<?php echo site_url("user_set/index");?>" class="form-horizontal" method="post">
			<!-- 昵称 -->
			<!-- <div class="form-group">
				<label for="inputText1" class="col-md-2 control-label">昵称</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name='nickname' id="inputText1" value="<?php echo $nickname; ?>" <?= ($nickname_up == '0')?'disabled':'';?> >
				</div>
			</div> -->
			<!-- 姓名 -->
			<div class="form-group">
				<label for="inputText1"  class="col-md-2 control-label">姓名</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="nickname" id="inputText1" value="<?php echo $msg['nickname'];?>">
				</div>
			</div>
			<!-- 实名认证 -->
			<!--div class="real-name-authentication help-block">
				<label for="" class="col-md-2 control-label"></label>
				<p class="text-warning">您尚未实名认证，<strong><a href="#">点此认证</a></strong>。</p>
			</div-->
			<!-- 性别 -->
			<div class="form-group">
				<label for="" class="col-md-2 control-label">性别</label>
				<div class="col-md-7">
					<label class="radio-inline">
						<input type="radio" name="sex" id="optionsRadios1" value="1" <?php if($msg['sex']==1){echo "checked";}?> >男
					</label>
					<label class="radio-inline">
						<input type="radio" name="sex" id="optionsRadios2" value="2" <?php if($msg['sex']==2){echo "checked";}?> >女
					</label>
				</div>
			</div>

	<!-- 	学生信息 -->
	     <?php if($msg['roles']=="student"){?>
			<div class="form-group">
				<label for="inputText1"  class="col-md-2 control-label">级别</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="session" id="inputText1" value="<?php echo $msg['session'];?>">
				</div>
			</div>
			<!-- 学号 -->
			<!-- <div class="form-group">
				<label for="inputText5" class="col-md-2 control-label">学号</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="stu_num" id="inputText5" value="<?php echo $msg['stu_num'];?>" >
				</div>
			</div>
			 -->
			<div class="form-group">
				<label for="inputText5" class="col-md-2 control-label">年级</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="grade" id="inputText5" value="<?php echo $msg['grade'];?>" >
				</div>
			</div>
			<!-- 专业班级 -->
			<div class="form-group">
				<label for="inputText05" class="col-md-2 control-label">班级</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="banji" id="inputText05" value="<?=$msg['banji']?>" >
				</div>
			</div>
			<?php }elseif($msg['roles']=="teacher"){?>
         <!--   学生信息结束 -->
         <!-- laoshixinxi -->
         <div class="form-group">
         	<label for="inputText4" class="col-md-2 control-label">头衔</label>
         	<div class="col-md-7">
         		<input type="text" name="touxian" class="form-control" id="inputText14"value="<?php echo $msg['touxian'];?>">
         	</div>
         </div>
         <!-- 教师编号 -->
         <!-- <div class="form-group">
         	<label for="inputText4" class="col-md-2 control-label">编号</label>
         	<div class="col-md-7">
         		<input type="text" name="number" class="form-control" id="inputTextn" value="<?php echo $msg['number'];?>">
         	</div>
         </div>	 -->
         <div class="form-group">
         	<label for="inputText4" class="col-md-2 control-label">学历</label>
         	<div class="col-md-7">
         		<input type="text" name="edu" class="form-control" id="inputTextn"value="<?php echo $msg['edu'];?>">
         	</div>
         </div>	
         <?php }?>
       <!--   <laoshixinxijieshu>	 -->
            <div class="form-group">
            	<label for="inputText05" class="col-md-2 control-label">民族</label>
            	<div class="col-md-7">
            		<input type="text" class="form-control" name="nation" id="inputText05" value="<?=$msg['nation']?$msg['nation']:'汉族'?>" >
            	</div>
            </div>
			<div class="form-group">
				<label for="inputText5" class="col-md-2 control-label">出生日期</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="birth_date" id="inputText5" value="<?php echo $msg['birth_date'];?>" >
				</div>
			</div>
			
			<!-- 身份证号 -->
			<div class="form-group">
				<label for="inputText2" class="col-md-2 control-label">身份证号</label>
				<div class="col-md-7">
					<input type="text" class="form-control aaaa" name="id_card" id="inputText2" value="<?php echo $msg['id_card'];?>">
					<div class="help-block shen" style="display:none;">
						<span class="text-danger">身份证号格式不正确</span>
					</div>
					<script>
					$('#inputText2').focusout(function() {
						isIDCard1=/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/;    
						isIDCard2=/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/; 
						var id_card = $('#inputText2').val();
						if(id_card.length==15){
                            if(!preg_match(isIDCard1,id_card)){focunsout(this);}
						}else if(id_card.length==18){
							if(!preg_match(isIDCard2,id_card)){focunsout(this);}
						}else if(id_card.length==0){
							
						}else{
							focunsout(this);
						}
						
					})
					$('#inputText2').focusin(function() {
						focunsin(this);
					})
					</script>
				</div>
			</div>
			<!-- <div class="form-group">
				<label for="inputText05" class="col-md-2 control-label">政治面貌</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="political" id="inputText05" value="<?=$msg['political']?>" >
				</div>
			</div> -->
<!-- 			<div class="form-group">
				<label for="inputText05" class="col-md-2 control-label">电子邮箱</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="email" id="inputText05" value="<?=$msg['email']?>" >
				</div>
			</div> -->
			<!-- 手机号码 -->
			<div class="form-group">
				<label for="inputText3" class="col-md-2 control-label">联系方式</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="moblie" id="inputText3" value="<?php echo $msg['moblie'];?>">
					<div class="help-block" style="display:none;">
						<span class="text-danger">请输入正确的手机号码</span>
					</div>
				</div>
				<script>
				/*$('#inputText3').focusout(function() {
					if ($(this).val() != 0) {
						if (!$("#inputText3").val().match(/^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/)) {
							console.log("手机号码格式不正确！");
							focunsout(this);
						}
					}
				})
				$('#inputText3').focusin(function() {
					focunsin(this);
				})*/
				</script>
			</div>
			<!-- <div class="form-group">
				<label for="inputText4" class="col-md-2 control-label">家庭住址</label>
				<div class="col-md-7">
					<input type="text" name="address" class="form-control" id="inputText14" value="<?php echo $msg['address'];?>">
				</div>
			</div> -->
			
			<!-- 学校 -->
			<!-- <div class="form-group">
				<label for="inputText4" class="col-md-2 control-label">学校</label>
				<div class="col-md-7">
					<input type="text" name="school" class="form-control" id="inputText4"value="<?php echo $msg['school'];?>">
				</div>
			</div> -->
		
		
			<!-- 头衔 -->
			<!--div class="form-group">
				<label for="inputText6" class="col-md-2 control-label">头衔</label>
				<div class="col-md-7">
					<input type="text" class="form-control" id="inputText6" placeholder="高级教师">
				</div>
			</div-->
			<!-- 个人签名 -->
		<!-- 	<div class="form-group">
				<label for="inputText7" class="col-md-2 control-label">个人签名</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="signature" id="inputText7" value="<?php echo $msg['signature'];?>">
				</div>
			</div> -->
			<!-- 自我介绍 -->
			<!-- <div class="form-group">
				<label for="" class="col-md-2 control-label">自我介绍</label>
				<div class="col-md-7">
					<textarea class="form-control" name="about" rows="3"><?php echo $msg['about'];?></textarea>
				</div>
			</div> -->
			<!-- 个人主页 -->
			<!-- <div class="form-group">
				<label for="inputText8" class="col-md-2 control-label">个人网站</label>
				<div class="col-md-7">
					<input type="text" name="site" class="form-control" id="inputText8" value="<?php echo $msg['site'];?>" >
					<div class="help-block" style="display:none;">
						<span class="text-danger">个人网站地址不正确，须以http://开头。</span>
					</div>
				</div>
				<script>
				$('#inputText8').focusout(function() {
					if ($(this).val != 0 && $(this).val().indexOf("http://") != 0) {
						focunsout(this);
					}
				})
				$('#inputText8').focusin(function() {
					focunsin(this);
				})
				</script>
			</div> -->
			<!-- 微博 -->
			<!-- <div class="form-group">
				<label for="inputText9" class="col-md-2 control-label">微博</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="weibo" id="inputText9" value="<?php echo $msg['weibo'];?>" >
					<div class="help-block" style="display:none;">
						<span class="text-danger">微博地址不正确，须以http://开头。</span>
					</div>
				</div>
				<script>
				$('#inputText9').focusout(function() {
					if ($(this).val != 0 && $(this).val().indexOf("http://") != 0) {
						console.log("有内容且内容不以http://开头")
						focunsout(this);
					}
				})
				$('#inputText9').focusin(function() {
					focunsin(this);
				})
				</script>
			</div> -->
			<!-- 微信 -->
			<!-- <div class="form-group">
				<label for="inputText10" class="col-md-2 control-label">微信</label>
				<div class="col-md-7">
					<input type="text" name="weixin" class="form-control" id="inputText10" value="<?php echo $msg['weixin'];?>">
				</div>
			</div> -->
			<!-- QQ -->
			<!-- <div class="form-group">
				<label for="inputText11" class="col-md-2 control-label">QQ</label>
				<div class="col-md-7">
					<input type="text" name="qq" class="form-control" id="inputText11" value="<?php echo $msg['qq'];?>">
					<div class="help-block" style="display:none;">
						<span class="text-danger">QQ格式不正确</span>
					</div>
				</div>
			</div> -->
			<div class="col-md-7 col-md-offset-2" style="margin-top:30px;">
				<button class="btn btn-primary">保存</button>
			</div>
		</form>
	</div>
</div>
<script>
	if ($("#alert").html() == '保存成功') {
		setTimeout(function () {
			location = location; 
		},1000);
		
	}
</script>