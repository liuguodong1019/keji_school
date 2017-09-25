<!-- 头像设置 -->
<div class="panel panel-default head-setting right_frame">
	<div class="panel-heading">
		<ol class="breadcrumb">
		  <li><a href="#">个人设置</a></li>
		  <li class="active">头像设置</li>
		</ol>
	</div>
	<div class="panel-body">
		<!-- 图标设置 -->
	<script>  
        $(function () {  
        	var g_id = "<?php echo $_SESSION['user']['id'];?>";
            var btn = $("#Button1");  
			var img_url = '<?php echo site_url("user_set/up");?>';
			var new_img_url = '<?php echo site_url("public/home/images/headpic");?>';
            btn.cropperUpload({  
                url: img_url,  
                fileSuffixs: ["jpg", "png", "gif"],  
                errorText: "{0}",  
                onComplete: function (msg) {  //上传之后的回调函数
                 //$("#image").attr('src',new_img_url+'/'+msg); 
					if(msg=="yes"){
						//$("#xx").html("新头像已经生效");
						document.location.reload();
					}else if(msg.indexOf("larger")>=0){
						$("#xx").html('<span class="text-danger">您试图上载的文件比允许的大小更大。</span>');
					}else if(msg.indexOf("filetype")>=0){
						$("#xx").html('<span class="text-danger">您要上传的文件类型是不允许的。</span>');
					}else{
						$("#xx").html(msg);
					}
                },  
                cropperParam: {//Jcrop参数设置，除onChange和onSelect不要使用，其他属性都可用  
				   aspectRatio:180/180,
                    bgColor: "black",  
                    bgOpacity: 0.4,  
                    allowSelect: true, 
					setSelect: [ 60, 70, 200, 330 ],
                    animationDelay:80, 
                    boxWidth:180,
                },  
                perviewImageElementId: "fileList", //设置预览图片的元素id    
                perviewImgStyle: { width: '100%'}//设置预览图片的样式    
            });  
  
            var upload = btn.data("uploadFileData");  
  
            $("#files").click(function () {  
                upload.submitUpload();  
            }); 			
        });  
    </script> 
	<div class="set-icon">
		<div class="form-group clearfix">
			<label for="curr-icon" class="col-md-2 control-label">当前头像</label>
			<div class="col-md-8">
				<img id="image" style="width:200px;" src="<?php echo site_url("public/home/images/headpic/{$info}");?>" alt="">
			</div>
		</div>
		<div class="form-group clearfix">
			<label for="" class="col-md-2 control-label"></label>
			<div class="col-md-8" style="font-size:12px;color:#aaa;">
				<p>你可以上传JPG、GIF或PNG格式的文件，文件大小不能超过2M。推荐大小（180*180）</p><br>
				<span id="xx"></span>
			</div>
			
		</div>
	</div>
	<div class="clearfix">
		<div class="col-xs-5 col-sm-5 col-md-offset-2 col-sm-offset-0">
			 <button id="Button1" class="btn btn-primary btn-md">选择要上传的头像</button>   
			<button  id="files" class="btn btn-primary btn-md">上传</button>
		</div>
	</div>
		<div style="width: 100%; min-height: 30px; float:left">    
            <div id="fileList" style="margin-top: 10px; padding-top:10px; font-size: 13px; width:100%">          
            </div>    
		</div>   
		<div id="testdiv" style="padding-top: 200px">  
			<img alt="" src="" id="testimg"/> 
			
		</div> 
	</div>

</div>
