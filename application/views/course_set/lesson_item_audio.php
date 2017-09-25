<script src="<?php echo site_url("public/expand/uploadify");?>/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("public/expand/uploadify");?>/uploadify.css">
<div class="form-group 11">
	<label for="" class="col-sm-2 control-label">音频</label>
	<div class="col-sm-10 item_novideo" style="display:block;">
		<ul class="nav nav-pills" role="tablist">
			<li class="active">
				<a href="#aa" class="btn btn-default fff" data-toggle="tab">上传音频</a>
			</li>
			<li>
				<a href="#ss" class="btn btn-default" onclick="upliad_file_list();" data-toggle="tab">从课程文件中选择</a>
			</li>
			<li class="link_v_b">
				<a href="#dd" class="btn btn-default" data-toggle="tab">导入网络视频</a>
			</li>
		</ul>
		<div class="tab-content" style="margin-top:5px;">
			<div role="tabpanel" class="tab-pane fade active in" id="aa">
				<div class="file-chooseer-frame">
					<p>选择你要上传的音频文件：</p>
					<form>
						<div id="queue"></div>
						<input id="file_upload" name="file_upload" type="file" multiple="true">
						<input type="hidden" value=""  class="lesson_m"><!--上传之后视频文件id和名字的字符串-->
						
					</form>
					<ul id="url">
					</ul>
					 <span class="help-block text-danger" style="display:none;">请选择音频频</span>
					<!-- <div class="alert alert-info in active" role="alert"> -->
						<ul class="type_zhichi">
							<li><i></i>支持mp3格式的音频文件上传，文件大小不能超过1G 。</li>
						</ul>
					<!-- </div> -->
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="ss">
				<div class="file-chooseer-list">
					<ul class="upliad_file_list">
						
					</ul>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="dd">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="支持优酷、土豆、网易公开课的视频页面地址导入">
					<span  class="input-group-addon btn btn-default" onclick="link_v(this);" id="daoru">
						导入
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-8 item_video" style="display:none;">
		<span data-role="placeholder"></span>
		<button class="btn btn-link btn-sm"  type="button" onclick="choice_video();" data-role="trigger"><i class="glyphicon glyphicon-edit"></i> 编辑</button>
	</div>
</div>
<?php $this->load->view("course_set/lesson_item_video_js");?>