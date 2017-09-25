<?php $this->load->view("admin/course/base_nav");?>
	<!-- 课程图片 -->
	<script>
		var g_id = '<?php echo $course['c_id'];?>';
	</script>
	<link href="<?php echo base_url()?>/public/expand/xx_img/css/jquery.Jcrop.min.css" rel="stylesheet" />
	<script src="<?php echo base_url()?>/public/expand/xx_img/js/jquery.Jcrop.min.js"></script>  
    <script src="<?php echo base_url()?>/public/expand/xx_img/js/upImgJcrop.js"></script>
	<div class="manage">
		<div class="panel-body">

			<!-- 图标设置 -->
			<script>  
		        $(function () {  
					
		            var btn = $("#Button1");  
					var img_url = '<?php echo site_url("admin/course/upload_course_img");?>';
					var new_img_url = '<?php echo site_url("public/home/images/course");?>';
		            btn.cropperUpload({  
		                url: img_url,  
		                fileSuffixs: ["jpg", "png", "bmp"],  
		                errorText: "{0}",  
		                onComplete: function (msg) {  //上传之后的回调函数
		                 //$("#image").attr('src',new_img_url+'/'+msg); 
						if(msg=="yes"){
							document.location.reload();
						}else{
							$("#xx").html(msg);
						}
		                },  
		                cropperParam: {//Jcrop参数设置，除onChange和onSelect不要使用，其他属性都可用  
						    aspectRatio:270/153, //图片宽高比例
		                    bgColor: "black",  
		                    bgOpacity: 0.4,  
		                    allowSelect: true, 
		                    animationDelay:80,
							setSelect:[0,0,0,0],
							boxWidth:270,
							// minSize:[ 200, 0 ],
							// maxSize:[ 540, 0 ],
				
		                }, 
					
		                perviewImageElementId: "fileList", //设置预览图片的元素id    
		                perviewImgStyle: { width: '100%', border: '1px solid #ebebeb' }//设置图片预览框的样式    
		            });  

		            var upload = btn.data("uploadFileData");  
		  
		            $("#files").click(function () {  
		                upload.submitUpload();  
		            }); 			
		        });  
		    </script> 
			<div class="set-icon course_img_set">
				<div class="form-group clearfix">
					<label for="curr-icon" class="col-md-2 control-label" style="text-align:right;">课程图片</label>
					<div class="col-md-8">
						<img id="image" src="<?php echo site_url("public/home/images/course/{$course['pic']}");?>" alt="" width="270">
					</div>
				</div>
				<div class="form-group clearfix">
					<label for="" class="col-md-2 control-label"></label>
					<div class="col-md-8">
						<p>你可以上传JPG、GIF或PNG格式的文件，文件大小不能超过2M。推荐大小（270*153）</p>
						<span id="xx"></span>
					</div>
					
				</div>
			</div>
			<div class="clearfix">
				<div class="col-xs-5 col-sm-5 col-md-offset-2 col-sm-offset-0">
					 <button id="Button1" class="btn btn-primary btn-md">选择文件</button>   
					<button  id="files" class="btn btn-primary btn-md">上传新图标</button>
				</div>
			</div>
			<div style="width: 100%; min-height: 30px; float:left">    
		        <div id="fileList" style="margin-top: 10px; padding-top:10px; font-size: 13px; width:100%">          
		        </div>    
			</div>   
			<div id="testdiv" style="padding-top: 580px">  
				<img alt="" src="" id="testimg"/> 
			</div> 
		</div>
	</div>
	</div>
	</div>
	</div>
<?php $this->load->view("admin/public/footer");?>
