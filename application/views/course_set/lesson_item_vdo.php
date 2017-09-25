<script src="<?php echo site_url("public/expand/uploadify");?>/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("public/expand/uploadify");?>/uploadify.css">
<div class="form-horizontal">
<div class="form-group 01 clearfix">
	<label for="" class="col-sm-2 control-label">视频</label>
	<div class="col-sm-10 item_novideo" style="display:block;">
		<ul class="nav nav-pills" role="tablist">
			<li class="active">
				<a href="#aa" class="btn btn-default fff" data-toggle="tab">上传视频</a>
			</li>
			<li>
				<a href="#ss" class="btn btn-default" onclick="upliad_file_list();" data-toggle="tab">从课时文件中选择</a>
			</li>
			<li class="link_v_b">
				<a href="#dd" class="btn btn-default" data-toggle="tab">导入网络视频</a>
			</li>
		</ul>
		<div class="tab-content" style="margin-top:5px;">
			<div role="tabpanel" class="tab-pane fade active in" id="aa">
				<div class="file-chooseer-frame">
					<p>选择你要上传的视频文件：</p>
					<form>
						<div id="queue"></div>
						<input id="file_upload" name="file_upload" type="file" multiple="true">
						<input type="hidden" value=""  class="lesson_m"><!--上传之后视频文件id和名字的字符串-->
					</form>
					<style>
						.uploadify-queue .uploadify-queue-item:not(:first-child){display: none;}
					</style>
					<ul id="url">
					</ul>
					 <span class="help-block text-danger" style="display:none;">请选择视频</span>
					<!-- <div class="alert alert-info in active" role="alert"> -->
						<ul class="type_zhichi">
							<li><i></i>支持mp4、avi格式的视频文件上传，文件大小不能超过500.0MB 。</li>
							<li><i></i>支持swf格式的视频文件上传，文件大小不能超过500.0MB 。</li>
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
					<span  class="input-group-addon">
						<button class="btn btn-default" onclick="link_v(this);" id="daoru">导入</button>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-8 item_video" style="display:none;" >
		<span data-role="placeholder" style=""></span>
		<button class="btn btn-link btn-sm" type="button" onclick="choice_video();" data-role="trigger">
			<i class="glyphicon glyphicon-edit"></i> 编辑
		</button>
	</div>
</div>
<!-- <div class="form-group opens">
    <label for="" class="col-sm-2 control-label">下载</label>
    <div class="col-sm-8">
        <label class="radio-inline">
            <input type="radio" name="download" id="download" value="0" ><span class="choice-img"></span> 是
        </label>
        <label class="radio-inline">
            <input type="radio" name="download" id="download" value="1" checked=""><span class="choice-img" ></span> 否
        </label>
    </div>
</div> -->
<!-- 视频时长 -->
<!-- <div class="form-group video-time 02 clearfix">
	<label for="" class="col-sm-2 control-label">视频时长</label>
	<div class="col-sm-8" style="font-size:12px;color:#aaa;">
		<input type="text" value="<?php //echo $_SESSION['fen'];?>" class="form-control fen"> 分
		<input type="text" value="<?php //echo $_SESSION['miao'];?>" class="form-control miao"> 秒
		<span class="help-block">时长必须为整数</span>
	</div>
</div> -->

</div>
<?php $this->load->view("course_set/lesson_item_video_js");?>