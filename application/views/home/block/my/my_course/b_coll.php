	<!-- 收藏 -->
			<?php if($my_cour_coll):foreach($my_cour_coll as $mo):?>
			<div class="course_item clearfix col<?php echo $mo['c_id'];?>">
				<a href="<?php echo site_url("course/{$mo['c_id']}");?>" class="course_item_img">
					<img src="<?=site_url("public/home/images/course/{$mo['pic']}");?>" alt="">
				</a>
				<div class="course_item_things">
					<h5>
					<a href="<?php echo site_url("course/{$mo['c_id']}");?>"><?=$mo['title']?></a>
					<span><?php if($mo['open'] == '1'){echo '（内部班级课程）';}else if($mo['is_join'] == 'no'){echo '（非公开）';}?></span>
					</h5>
					<p class="things_update">更新至：<?= !empty($mo['update_to'])?$mo['update_to']:'暂无章节';?></p>
					<div class="things_others">

					<div class="star">
						评分：
						<?php
						for($i=0;$i<5;$i++){
							$image = 'star-off.png';
							if($i < $mo['score']){
							$image = 'star-on.png';
							}
						?>
						<img src="<?php echo base_url()?>public/home/static/<?= $image;?>" alt="">
						<?php } ?>
						<span>（<?= $mo['score'];?>分）</span>
					</div>			
					<div class="things_cour_info" style="margin-top:10px;">
						授课教师：
						<span class="belongs_to">
						<?php if(!empty($mo['teachers'])){ foreach($mo['teachers'] as $key=>$value){ ?>
						<a href="<?php echo site_url("user/{$value['id']}/learning_course");?>" style="color:#00bc9c;"><?= $value['nickname'];?></a>
						<?php } }else{echo '暂无设置';}?>
						</span>		
					</div>
                        <div class="user-nums">人数：<span class="nums_icon "></span>&nbsp;&nbsp;<?=$mo['student_num']?>人</div>
                        <a href="javascript:void(0);"  class="btn btn-primary pull-right" data-toggle="modal" data-target="#Modal_qxshcang" onclick="getshc_id(<?= $mo['c_id'];?>)">取消收藏</a>
					</div>
					
				</div>
				
			</div>
			<?php endforeach;?>
			<?php else:?>
				<p style="padding:10px;">暂无数据</p>				
			<?php endif;?>
			<?php echo $this->pagination->create_links();?>			
<script type="text/javascript">
	//取消收藏
function ncollect_note(obj){
	var course_id = $(obj).next().val();
	$('#Modal_qxshcang').modal('hide')
	$.post("<?php echo site_url("my/del_course_coll");?>",{'course_id':course_id},function(data){
		$(".col"+course_id+"").hide();
	})	
}

function getshc_id(id){
  $("#fuzhu_id").val(id);
}
</script>
<!-- 询问是否删除该条数据 提示框 -->
<div class="modal fade alert_sucess" id="Modal_qxshcang">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-lg" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<h4 class="modal-title">确定要取消收藏该条数据吗？</h4>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button" onclick="ncollect_note(this);">确定</button>
				<input type="hidden" id="fuzhu_id" value="">
				<button class="btn btn-primary" type="button" data-dismiss="modal">取消</button>
			</div>
		</div>
	</div>
</div>
<style>
	@media (min-width: 768px){
		.modal-dialog {
		  width: 400px;
		  margin: 30px auto;
		  margin-top: 20%;
		}
	}
	.alert_sucess .modal-header{
	  border:none;
	}
	.alert_sucess .close:focus{
		outline: none;
	}
	.alert_sucess .modal-header span {
	  color: #00bc9c;
	  text-shadow: none;
	}
	.alert_sucess .modal-body {
	  padding:10px 50px 30px;
	}
	.alert_sucess .modal-body h4 {
	  font-size: 16px;
	  color: #888;
	  font-weight: normal;
	}
	.alert_sucess .modal-footer{
	  padding:0px 50px 30px;
	  border:none;
	}
	.alert_sucess .modal-footer .btn.btn-primary{
	  padding:5px 17px;
	  color: #fff;
	  background: #00bc9c;
	  border: #none;
	  border-radius: 4px;
	  font-size: 12px;
	  line-height: 12px;
	}
	.alert_sucess .modal-footer .btn.btn-primary:hover{
	  background: #02816b;
	  border-color: #02816b;
	}
</style>		