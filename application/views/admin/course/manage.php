<?php $this->load->view("admin/course/manage_nav");?>
<!-- 课程管理 -->
		<!-- 课程管理内容： -->
		<div class="manage">
			<form class="form-inline manage" method="post">
				<select class="cm_type" name="category">
					<option value="" selected="">课程分类</option>
					<?php
					if(!empty($categorydata)){
						foreach($categorydata as $key=>$value){
						$select = "";
						if($category == $value['id']){$select="selected";}
					?>
					<option value="<?= $value['id'];?>" <?= $select;?>><?= $value['title'];?></option>
					<?php
						}
					}
					?>					
				</select>
				<input type="text" class="form-control cm_name" placeholder="请输课程名称" name="course_name" value="<?= !empty($course_name)?$course_name:'';?>">
				<button type="submit" class="btn btn-primary b_middle" name="sub" >搜索</button>
			</form>
			<table class="table">
				<thead>
					<tr>
						<th width="8%">编号</th>
						<th width="20%">课程名称</th>
						<th width="15%">分类</th>
						<th width="10%">资料</th>
						<th width="">简介</th>
						<th width="20%">创建者</th>
						<th width="60">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if($data_list):foreach($data_list as $u):?> 
					<tr class="delcourse<?= $u['id'];?>">
						<td><?= $u['id'];?></td>
						<td class="cm_classname">
							<a href="<?php echo site_url('admin/course/update/'.$u['id'].'');?>" ><?= $u['title'];?></a>
						</td>
						<td><?= $u['category'];?></td>
						<td><a href="<?php echo site_url('admin/course/lesson/'.$u['id'].'');?>"><?= $u['student_num'];?></a></td>
						<td><?= $u['about'];?></td>
						<td class="cm_creator">
							<?= $u['nickname'];?>
							<span><?= date('Y-m-d H:i',$u['create_time']);?></span>
						</td>
						<td>
							<div class="btn-group" role="group" q_id="692">
								<a href="javascript:void(0);" class="dropdown-toggle gli_hover" data-toggle="dropdown" style="margin-bottom:0;">
									管理 <span class="xialabtn"></span>
								</a>
								<ul data-id="" class="dropdown-menu pull-right">									
									<li>									
										<a href="<?php echo site_url('course/lesson/'.$u['id'].'/'.$u['lid'].'');?>" target="_blank">查看课程</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/course/update/'.$u['id'].'');?>" >管理课程</a>
									</li>
									<li>
										<a href="javascript:void(0);" onclick="confirm_del('<?= $u['id'];?>')">删除课程</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<?php endforeach;endif;?>
				</tbody>
			</table>
		<?php echo $this->pagination->create_links();?>			
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php $this->load->view("admin/public/footer");?>
<div class="modal fade" id="creatclass">
    <div class="modal-dialog" role="document">
		<div class="modal-content">  
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>		
            <div class="modal-body">
                <h4 class="modal-title">创建课程</h4>
				<form class="form-horizontal" action="<?php echo site_url("my/create_course");?>" method="post" >
					<div class="form-group">
						<label for="input01" class="col-sm-2 control-label">课程标题</label>
						<div class="col-sm-9 _riframe">
						  <input type="text" name="title" class="form-control" id="input01">
						</div>
					</div>
					<div class="form-group">
					   <label for="select02" class="col-sm-2 control-label">所属学科</label>
						<div class="col-sm-9 _riframe" >
							<select  class="form-control" id="category_id" name="category_id" style="padding-right:0px;">
								<?php if($categorydata):foreach($categorydata as $c):?>
								<option  value="<?=$c['id']?>"><?=$c['title']?></option>
							<?php endforeach;endif;?>  
							</select>
						</div>
					</div> 
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">课程简介</label>
						<div class="col-sm-9 _riframe">
							<div id="Editor01"  STYLE="height:150px;"></div>
							<div class="help-block " style="display:none;">
								请输入内容
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
							</script>
						</div>
					</div>       
				</form>
				<div class="error_mes" style="color:red;font-size:12px;"></div>		
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-primary creat_btn"  onclick="add_course(this);">创建课程</button>
            </div>			
		</div>
    </div>
</div>

<script>
       //创建课程
		function add_course(obj){
		var title = $("input[type='text'][name='title']").val();
		var category_id= $('#category_id option:selected').val();;
		var about = UE.getEditor('Editor01').getContent();
		if(title == ""){
			$('.error_mes').html('课程名称不可为空，请填写！');
			return false;
		}else{
			$.post("<?php echo site_url("admin/course/create_course");?>",{'title':title,'category_id':category_id,'about':about},function(data){
			if(data != ""){
				window.location=base_url+"admin/course/update/"+data;  
			}
			})		
		}
	}
</script>

<script>
	function confirm_del(id){
		 if(confirm("确认要删除该课程吗？")){
			$.get("<?php echo site_url("admin/course/course_del");?>",{'id':id},function(data){
				if(data == "1"){
					$('.delcourse'+id+'').hide();
				}else{
					alert("无权操作")
				}
			}) 	
		 }	
	}		
</script>