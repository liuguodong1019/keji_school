<?php $this->load->view("admin/public/header_meta");?>
	<!-- 分类管理 -->
	<div class="u_cont_Frame b_right_Frame">
		<div class="u_frame_title has_line">
			<a class="btn btn-primary b_middle pull-right" data-toggle="modal" data-target="#add_fenlei" onclick="add_one()">添加分类</a>
			<ol class="breadcrumb ">
				<li><a href="#">系统</a></li>
				<li class="active">分类管理</li>
			</ol>
		</div>
		<div class="u_frame_conts fenlei_manage">
			<table class="table">
				<thead>
					<tr>
						<th class="chk_box">
							<span class="n_action n_open">
								<input type="checkbox">
								<label for=""></label>
							</span>
						</th>					
						<th>分类名称</th>
						<th width="14%">编码</th>
						<th width="15%">显示序号</th>
						<th width="15%">描述</th>
						<th width="66">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if($data_list):foreach($data_list as $u):?>
					<tr class="del<?= $u['id'];?>">
						<td class="chk_box">
							<span class="n_action n_open">
									<input type="checkbox" value="<?= $u['id']; ?>" onchange="SelectItem(this);" class="deluser m_checkbox">
									<label for=""></label>
							</span>
						</td>
						<td><?= $u['title'];?></td>
						<td><?= $u['icon'];?></td>
						<td><?= $u['num'];?></td>
						<td><?= $u['description'];?></td>
						<td class="u_caozuo" style="padding-right:15px;">
						   <div class="btn-group" role="group">
								<a href="javascript:void(0);" class="dropdown-toggle gli_hover" data-toggle="dropdown" style="margin-bottom:0;">
									管理 <span class="xialabtn"></span>
								</a>
								<ul data-id="" class="dropdown-menu pull-right">
									<li>
										<a href="javascript:void(0);" onclick="get_message('<?= $u['id'];?>')" data-toggle="modal" data-target="#add_fenlei">编辑</a>
									</li>
									<li>
										<a href="javascript:void(0);" onclick="del_data(<?= $u['id'];?>)">删除</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<?php endforeach;endif;?>
				</tbody>
			</table>
			<div class="select_father">
				<span class="n_action n_open">
					<input type="checkbox" class="is_select" id="selectall" value="option1" onchange="SelectAll(this);">
					<label for=""></label><span>全选</span>
				</span>
				<a href="javascript:void(0);" class="btn btn-primary" onclick="m_delete(this);">删除</a>
			</div>
			<?php echo $this->pagination->create_links();?>
		</div>

</div>	 
</div>	 
</div>	 
<?php $this->load->view("admin/public/footer");?>
<!-- 添加分类 -->
<div class="modal fade" id="add_fenlei">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title">添加分类</h4>
                <form action="" class="form-horizontal">
					<div class="form-group">
                        <label for="" class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="c_title" name="c_title">
                        </div>
                    </div>				
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">显示序号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="" name="c_num">
                            <span class="help-block">显示序号需为整数，分类按序号的顺序从大到小排序。（非必填）</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">分类描述</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="c_desc" id="c_desc" cols="" rows="5" style="line-height:17px;"></textarea>
                            <span class="help-block">（非必填）</span>
							<input type="hidden" name="aid" value="" id="a_e_id">
                        </div>
                    </div>
                        <div class="error_mes" style="color:red;font-size:12px;"></div>					
                </form>
            </div>
            <div class="modal-footer" id="add_a">
                <button type="button" class="btn btn-primary" onclick="add_category(this);">添加</button>
            </div>
            <div class="modal-footer" id="edit_a">
                <button type="button" class="btn btn-primary" onclick="save_category(this);">修改</button>
            </div>			
        </div>
    </div>
</div>
<script>
		//批量删除
		function m_delete(){
			if(confirm('您确定要删除选中数据吗？')){
				var i = 0;  
				var deleList = new Array();  
				var len = $(".m_checkbox:checked").length;
				for(var i=0;i<len;i++){
					var val = $('.m_checkbox:checked:eq('+i+')').val();
					deleList[i] = val;
				}
				
				$.get("<?php echo site_url("admin/system/del_classifys");?>",{'id':deleList},function(data){
					if(data == "1"){
						window.location.reload();		
					}else{
						alert(data)
					}
				}) 		
			}
		}	
		//即勾上全选框 
		function SelectAll(ee){ 
			if($(ee).prop('checked')==true){
				$(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked','checked')
			}else{
				$(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked',false)
			}
		}
		//删除
		function del_data(id){
			if(confirm("确定要删除该条数据吗？")){
					 $.post("<?php echo site_url("admin/system/del_classify");?>",{'id':id},function(data){
						if(data==1){
						$(".del"+id+"").hide();	
					}else{
						alert(data)
						}
					})	
					
			}
		}
       //保存标签
		function save_category(obj){
			var c_title= $("input[type='text'][name='c_title']").val();
			var c_num= $("input[type='text'][name='c_num']").val();
			var c_desc = $("#c_desc").val();
			var id = $('#a_e_id').val();
			if(c_title == ''){
				$('.error_mes').html('标签名称不可为空，请填写！');
				return false;
			}else{			
				$.post("<?php echo site_url("admin/system/save_classify");?>",{'id':id,'c_title':c_title,'c_num':c_num,'c_desc':c_desc},function(data){
					if(data==1){
						location.reload();  
					}else{
						alert(data)
					}
					
				})
			}
		}

		//获取标签信息
		function get_message(id){
				$('.error_mes').html('');
				$.get("<?php echo site_url("admin/system/get_classify");?>",{'id':id},function(data){
					if(data){
						var jsondata = eval('('+data+')'); 						
						var c_title= $("input[type='text'][name='c_title']").val(jsondata['title']);
						var c_num= $("input[type='text'][name='c_num']").val(jsondata['num']);
						var c_desc = $("#c_desc").val(jsondata['description']);						
						$('#a_e_id').val(id);
						$("#add_a").hide();
						$("#edit_a").show();
					}
				}) 		
		}

       //添加标签
		function add_category(obj){

			var c_title= $("input[type='text'][name='c_title']").val();
			var c_num= $("input[type='text'][name='c_num']").val();
			var c_desc = $("#c_desc").val();
			if(c_title == ''){
				$('.error_mes').html('标签名称不可为空，请填写！');
				return false;
			}else{
				$.post("<?php echo site_url("admin/system/add_classify");?>",{'c_title':c_title,'c_num':c_num,'c_desc':c_desc},function(data){
					if(data==1){
						location.reload(); 
					}else{
						alert(data)
					}			 
				})
			}	
		}
		//控制按钮
		function add_one(){
			$("#edit_a").hide();
			$("#add_a").show();			
			c_title= $("input[type='text'][name='c_title']").val('');
			c_num= $("input[type='text'][name='c_num']").val('');
			c_desc = $("#c_desc").val('');				
		}
</script>