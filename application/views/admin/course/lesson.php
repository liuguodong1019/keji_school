<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view("admin/course/base_nav");?>
<style>
	#jia_keshi{position: absolute;right:0;top:-60px;}
</style>	
<!-- 课时管理 -->
<div class="manage" style="position: relative;">
	<a class="btn btn-primary btn-sm" id="jia_keshi" data-id="0" onclick="add_lesson_seq(this);" data-toggle="modal" data-target="#myModal3">
		<i class="glyphicon glyphicon-plus"></i> 课时
	</a>	
	<div class="panel-body">
		<style>.sortable-ghost {opacity:.3;}#bar li{cursor:move;}</style>
			<ul id="bar" class="keshi-list">
				<?php if($lessons): foreach($lessons as $l):?>
				<li data-type="<?=$l['type'];?>" id="datalist<?=$l['id'];?>" data-id="<?=$l['id'];?>" <?php if($l['type']=='lesson'){echo 'class="keshi-list-item course-test clearfix"';}elseif($l['type']=='unit'){echo 'class="keshi-list-item section clearfix"';}else{echo 'class="keshi-list-item chapter clearfix"';}?> >
					<?php if($l['type']=='lesson'): ?>
						<i class="left-point left-point-2"></i>
						<!-- 课时类型：视频、考试… -->
						<?php if($l['resource_type']=='video'): ?>
							<span class="l_type l_type_video"></span><!-- 视频课时-->
						<?php elseif($l['resource_type']=='text'): ?>
							<span class="l_type l_type_text"></span><!-- 图文课时 -->
						<?php elseif($l['resource_type']=='ppt'): ?>
							<span class="l_type l_type_ppt"></span><!-- ppt课时 -->
						<?php elseif($l['resource_type']=='document'): ?>
							<span class="l_type l_type_document"></span><!-- document课时 -->
						<?php elseif($l['resource_type']=='audio'): ?>
							<span class="l_type l_type_audio"></span><!-- 音频课时 -->
						<?php endif;?>
					<?php endif; ?>

					<div class="ks-title">
						<?php if($l['type']=='lesson'): ?>
							课时<span class="number"></span>：<?=$l['title'];?>
						<?php endif; ?>
					</div>
					<div class="operation-btns">
							<a href="" class="btn-custom" onclick="update_lesson(this);" data-toggle="modal" data-target="#myModal4">
								<i class="glyphicon glyphicon-pencil"></i> 编辑
							</a>
						<a class="btn-custom" href="<?php echo site_url("course/lesson/{$course['c_id']}/{$l['id']}");?>">
							<i class="glyphicon glyphicon-eye-open"></i> 预览
						</a>
						<a class="btn-custom" href="javascript:void(0);" data-id="<?= $l['course_id']?>" onclick="del_lesson(this);"><i class="glyphicon glyphicon-trash"></i> 删除</a>
					</div>
				</li>
				<?php endforeach; endif;?>
			</ul>
	</div>
	
	<script>

		var type='';
		var type_update_dingyi = '';
		var has_choice_video_str = '';
		function add_lesson_seq(obj){
			type_update_dingyi='';
			has_choice_video_str = '';
			$("#up_lesson_item").empty(); 
			$("#lesson_item").load("<?php echo site_url("course_set/item_video");?>/<?php echo $course['c_id'];?>")
			$(".lesson_chapter_id").val($(obj).data('id'));	
		}
		function seq(){
			var c = $("#bar").children("li").length;
				var d = [];
				for(var i = 0;i<c;i++){
					if($("#bar").children("li").eq(i).data('type')=='lesson'){
						d[i] =$("#bar").children("li").eq(i).data('id')+'_lesson';
					}
				}
				$.post('<?php echo site_url("course_set/seq_lesson")?>',{'lesson':d},function(da){
					return da;
				})
		}
		(function (){
			var console = window.console;

			if( !console.log ){
				console.log = function (){
					alert([].join.apply(arguments, ' '));
				};
			}
			new Sortable(bar, {
				group: "words",
				onEnd: function(evt){ seq();sx();}
			});
		})();
	</script>
</div>
<script>


	//课时添加成功之后插入html位置，原理查找下一个同属性的上面添加
	function append_lesson_html(chapter_id,data){
		$('#bar').append(data)
		return true;
	}

	function sx(){//系统自定义章节序号排序
		var l_n = c_n = u_n = 0;
		var c =  $("#bar").children("li").length;
		for(var i =0;i<c;i++){
			if($("#bar").children("li").eq(i).hasClass('course-test')){
				l_n++;
				$("#bar").children("li").eq(i).find('.number').text(l_n);
			}
			if($("#bar").children("li").eq(i).hasClass('section')){
				u_n++;
				$("#bar").children("li").eq(i).find('.number').text(u_n);
			}
			if($("#bar").children("li").eq(i).hasClass('chapter')){
				u_n=0;
				c_n++
				$("#bar").children("li").eq(i).find('.number').text(c_n);
			}
		}
	}
	function del_lesson(obj){
		if(confirm("确定删除吗？")){
			var l_id = $(obj).parent().parent().data("id");
			$.post("<?php echo site_url("course_set/del_lesson");?>",{'l_id':l_id},function(data){
				if(data==1){
					$(obj).parent().parent().remove();
					seq();
					sx();
				}
			})

		}
	}

	sx();
</script>
	<!-- 编辑课时 -->
	<div class="modal fade" id="myModal4">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close-lg" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
				 	<h4 class="modal-title">编辑课时</h4>
				
					<form class="form-horizontal update_lesson_str">
					 <!-- 标题 -->
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">标题</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="up_l_title">
								<span class="help-block text-danger" style="display:none;">请输入标题</span>
							</div>
						</div>
						<div class="form-group " id="up_lesson_item_text" style="display:none;clear:both;">
								<label for="" class="col-sm-2 control-label">内容</label>
								<div class="col-sm-10">
									<div class="form-control" style="height: auto;border:none;padding:0;min-height:220px;">
									<div id="Editor001" style="min-height:220px;"></div>
									</div>
								</div>
							</div>
						<div id="up_lesson_item">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<!-- <button type="button" class="btn btn-default" data-dismiss="modal">取消</button> -->
					<button type="button" onclick="update_lesson_but(this);" types="" lesson_m="" l_id=""  c_id="<?=$course['c_id']?>" class="btn btn-primary update_lesson_type">保存</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 添加 课时 -->
    <div class="modal fade" id="myModal3">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-lg" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                </div>
                <div class="modal-body">
                	<h4 class="modal-title">添加课时</h4>
                    <form class="form-horizontal">
                        <!-- 类型 -->
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">类型</label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="ks_type" value="video" checked><span class="choice-img"></span> 视频
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="ks_type" value="audio"><span class="choice-img"></span> 音频
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="ks_type" value="text"><span class="choice-img"></span> 图文
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="ks_type" value="ppt"><span class="choice-img"></span> PPT
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="ks_type" value="document"><span class="choice-img"></span> 文档
                                </label>
                            </div>
							<input type="hidden" value="" class='lesson_chapter_id'><!--点击添加课时之后存储父id-->
                        </div>
                        <!-- 标题 -->
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="l_title">
                                <span class="help-block text-danger" style="display:none;">请输入标题</span>
                            </div>
                        </div>
						<div class="form-group " id="lesson_item_text" style="display:none;clear:both;">
							<label for="" class="col-sm-2 control-label">内容</label>
							<div class="col-sm-10">
								<div class="form-control" style="height: auto;border:none;padding:0;min-height:220px;">
								<div id="Editor01" style="min-height:220px;"></div>
								</div>
							</div>
						</div>
                        <!-- 视频 -->
						<div id="lesson_item" asd="456">
							<?php $this->load->view("course_set/lesson_item_video");?>
						</div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">取消</button> -->
                    <button type="button" onclick="add_lesson(this);"  class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </div>
	<script>
		//选中哪个课时类型则获取相应课时的添加逻辑html  js
		$("input[type='radio']").change(function(){
			var type = $(this).val();
			load_item($("#lesson_item"),$("#lesson_item_text"),type);
		})
		function load_item(obj,objt,type){
			if(type=='text'){
				obj.css('display','none');
				objt.css('display','block')
				obj.load("<?php echo site_url("course_set/item_");?>"+type+"/<?php echo $course['c_id'];?>")
			}else{
				obj.css('display','block');
				objt.css('display','none')
				obj.load("<?php echo site_url("course_set/item_");?>"+type+"/<?php echo $course['c_id'];?>")
			}
		}
	</script>
	<!-- 动态添加框 -->
    <div class="modal fade" id="myModal0">
    </div>


	<!-- 添加 作业 -->
    <div class="modal fade" id="myModal_hwork">
		<div class="modal-dialog modal-dialog-500">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close-lg" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
				 	<h4 class="modal-title">添加作业</h4>
					<form class="form-horizontal">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">所属课时</label>
							<div class="col-sm-10">
							<input type="hidden" id="po_home" data-id="" data-title="">
								<span class="belong_keshi"  id="title">计算机组成原理</span>
							</div>
						</div>
					 	<!-- 标题 -->
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">作业标题</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control">
								<span class="help-block text-danger" style="display:none;">请输入标题</span>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">作业积分</label>
							<div class="col-sm-10">
								<input type="text" name="jifen" class="form-control" readOnly="true" value="<?=$point?>  分 （学员交卷后即可获得全部积分）">	
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">作业说明</label>
							<div class="col-sm-10">
								<div class="form-control" style="height: auto;border:none;padding:0;min-height:120px;">
									<div id="Editor_hwork" style="min-height:100px;"></div>
								</div>
							</div>
						</div>
						
					</form>
				</div>
				<div class="modal-footer">
				<a href="javascript:void(0);" class="btn btn-primary" onclick="homework(this);">保存</a>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function dodel(id){
			$('#myModal_hwork').modal('show').on('shown',function(){
				alert('ssssssssss');
			})
		}
	</script>
	<script>

		function get_lesson(obj){
		    var l_title = $(obj).data("title");
			var lesson_id=$(obj).data("id");
			var id = $(obj).parents('.operation-btns').prev('.ks-title').find('.number').text();//alert(id)
		    $("#po_home").attr("data-id",lesson_id);
		    $("#po_home").attr("data-title",l_title);
		    var title_id = '课时'+id+'：'+l_title;
	        document.getElementById('title').innerHTML=title_id;
		
		}

	</script>


	<!--图文课时-->
	<script type="text/javascript" src="<?php echo site_url();?>public/expand/editor/ueditor.config.js"></script>
	<script type="text/javascript" src="<?php echo site_url();?>public/expand/editor/ueditor.all.min.js"></script>
	<script>
		var ue = UE.getEditor('Editor01',{
			toolbars: [
				['bold','italic','underline','forecolor', '|' , 'removeformat','pasteplain','|','insertorderedlist','insertunorderedlist','|', 'link', 'unlink', 'simpleupload', '|','source']
			],
			elementPathEnabled : false,//关闭元素路径
			wordCount:false      //关闭字数统计          
		}); 
		var ue = UE.getEditor('Editor001',{
			toolbars: [
				['bold','italic','underline','forecolor', '|' , 'removeformat','pasteplain','|','insertorderedlist','insertunorderedlist','|', 'link', 'unlink', 'simpleupload', '|','source']
			],
			elementPathEnabled : false,//关闭元素路径
			wordCount:false      //关闭字数统计          
		});
		var ue = UE.getEditor('Editor_hwork',{
			toolbars: [
				['bold','italic','underline','forecolor', '|' , 'removeformat','pasteplain','|','insertorderedlist','insertunorderedlist','|', 'link', 'unlink', 'simpleupload', '|','source']
			],
			elementPathEnabled : false,//关闭元素路径
			wordCount:false      //关闭字数统计          
		}); 


	</script>
</div>	
</div>	
<?php $this->load->view("admin/public/footer");?>

