<?php $this->load->view("admin/course/base_nav");?>
<!-- 基本信息 -->
<div class="manage">
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo site_url("admin/course/update/{$course['c_id']}");?>" method="post" >
			<!-- 标题 -->
			<div class="form-group">
				<label for="course-name" class="col-md-2 control-label">课程标题</label>
				<div class="col-md-8">
					<input type="text" name="title" class="form-control" id="course-name" value="<?php echo $msg['title'];?>">
				</div>
			</div>
			<!-- 所属学科 -->
			<div class="form-group">
				<label for="" class="col-md-2 control-label">所属学科</label>
				<div class="col-md-8">
					<select class="form-control" name="category_id" style="padding:7px 12px;background-position: 97% 50%;">
						<?php if($category): foreach($category as $a): ?>
						<option value="<?=$a['id']?>" <?php if($a['id']==$msg['category_id']){echo "selected";}?> ><?=$a['title'];?></option>
						<?php endforeach;endif; ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">课程简介</label>
				<div class="col-sm-8 _riframe">
					<div id="Editor01"  STYLE="height:150px;"></div>
					<div class="help-block " style="display:none;">
						
					</div>
					<!-- 配置文件 -->
					<script type="text/javascript" src="<?php echo site_url();?>public/expand/editor/ueditor.config.js"></script>
					<!-- 编辑器源码文件 -->
					<script type="text/javascript" src="<?php echo site_url();?>public/expand/editor/ueditor.all.min.js"></script>
					<!-- 实例化编辑器 -->
					<script type="text/javascript">
						var ue = UE.getEditor('Editor01',{
							toolbars: [
								['bold','italic','underline','forecolor', '|' , 'removeformat','pasteplain','|','insertorderedlist','insertunorderedlist','|', 'link', 'unlink', 'simpleupload', '|','source']
							],
							elementPathEnabled : false,//关闭元素路径
							wordCount:false      //关闭字数统计          
						}); 
                       	$(function(){
					        var content1= "<?php echo $msg['about'];?>";
					        //判断ueditor 编辑器是否创建成功
					        ue.addListener("ready", function () {
					        // editor准备好之后才可以使用
					        ue.setContent(content1);
					 
					        });
					    });						
					</script>
				</div>
			</div> 
			<div class="form-group">
				<label for="" class="col-md-2"></label>
				<div class="col-md-8">
					<button class="btn btn-primary" name="sub">保存</button>
				</div>
			</div>			
		</form>
	</div>
</div>	

</div>	
</div>	
<?php $this->load->view("admin/public/footer");?>
<script>
	function but(){
		var title = '';
		var category = '';
		var about = '';
		$.post("<?php echo site_url("course_set/ajax_add_tag")?>",{'arr':arr,'c_id':<?php echo $course['c_id'];?>},function(data){
			if(data==1){
				$(".form-horizontal").submit();
			}
		})
	}
</script>