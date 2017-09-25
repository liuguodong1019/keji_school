<?php $this->load->view("admin/user/index");?>
<script src="<?php echo base_url('public/home');?>/js/amazeui.js"></script>
<link rel="stylesheet" href="<?php echo base_url('public/home');?>/css/amazeui.css">
<script src="<?php echo base_url('public/home');?>/js/layui.all.js"></script>
<link rel="stylesheet" href="<?php echo base_url('public/home/');?>/css/layui.css">
    <!-- 用户管理内容： -->
        <form class="form-inline user_m_form" action="<?php echo site_url("admin/user/username");?>" method="post">
            <input type="text" class="form-control" name="search" value="<?= $search;?>" placeholder="请输入搜索账号或姓名关键字" style="width:250px;">
            <button type="submit" class="btn btn-primary b_middle" name="sub">搜索</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th class="chk_box">
                        <span class="n_action n_open">
                            <input type="checkbox">
                            <label for=""></label>
                        </span>
                    </th>
                    <th width="15%">账号</th>
                    <th width="15%">姓名</th>
                    <th width="">状态</th>
                    <th width="20%">最近登录时间</th>
                    <th width="20%">登录IP</th>
                    <th width="66">操作</th>
                </tr>
          
            </thead>
            <tbody>
                <?php if($user_list):foreach($user_list as $u):?>
                <tr id="deluser_<?= $u['id'];?>">
                   <td class="chk_box">
                     <span class="n_action n_open">
                            <input type="checkbox" value="<?=$u['id']?>" onchange="SelectItem(this);" class="deluser" >
                            <label for=""></label>
                        </span>
                    </td>
                    <td class="u_user_name">
                        <?=$u['email']?>
                    </td>					
                    <td class="u_user_name">
                        <?=$u['nickname']?>
                    </td>
                    <td class="u_user_name"><span><?= ($u['is_lock'] == '0')?'正常':'禁用';?></span></td>
                    <td class="u_user_time">
                        <?php echo !empty($u['login_time'])?date("Y-m-d H:i:s",$u['login_time']):'暂无记录';?>
                    </td>
                    <td class="u_user_time">
                        <?php echo !empty($u['login_ip'])?$u['login_ip']:'暂无记录';?>
                    </td>
                    <td>
                        <div class="btn-group" role="group" q_id="692">
                            <a href="javascript:void(0);" class="dropdown-toggle gli_hover" data-toggle="dropdown" style="margin-bottom:0;">
                                管理 <span class="xialabtn"></span>
                            </a>
                            <ul data-id="692" class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:void(0);" onclick="update_stu_msg(<?= $u['id'];?>)"  data-toggle="modal" data-target="#edit_user_infos">编辑用户信息</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-roles="<?=$u['roles']?>" onclick="editor_password(<?= $u['id'];?>)" data-toggle="modal" data-target="#edit_password">修改密码</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" onclick="lock_user(this);"  data-id="<?=$u['id']?>"><?= $u['is_lock']=='0'?'封禁用户':'解禁用户'?></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" onclick="del_u(this);" data-id="<?=$u['id']?>">删除用户</a>
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
            <a href="javascript:void(0);" class="btn btn-primary" onclick="del_user(this);">删除</a>
        </div>
   <?php echo $this->pagination->create_links();?>

<!-- 添加用户 -->
<div class="modal fade" id="add_users">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title">添加用户</h4>
                <form action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">账号</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="email" placeholder="登录账号">
							<span class="help-block text-danger err_email" style="display:none;">请输登录账号</span>
                        </div>
                    </div>				
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nickname" placeholder="用户名">
                            <span class="help-block text-danger err_nickname" style="display:none;">请输入用户名</span>
                        </div>
                    </div>
                    <div class="am-input-group am-datepicker-date" data-am-datepicker="{format: 'yyyy-mm-dd'}" style="width: 57%" id="gt">
                      <input type="text" class="am-form-field" placeholder="出生日期" readonly name = "birth_date">
                      <span class="am-input-group-btn am-datepicker-add-on">
                        <button class="am-btn am-btn-default" type="button"><span class="am-icon-calendar"></span> </button>
                      </span>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">身份证</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="id_card" placeholder="证件号">
                            <span class="help-block text-danger err_id_card" style="display:none;">请输入身份证</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">联系方式</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="moblie" placeholder="手机号">
                            <span class="help-block text-danger err_moblie" style="display:none;">请输入手机号</span>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="" class="col-sm-2 control-label">性别</label>
                             <div class="layui-input-block">
                              <input type="radio" id="sex" value="1" style="margin-left: 2%" checked>男
                              <input type="radio" id="sex" value="2"  style="margin-left: 2%">女
                            </div>
                            <span class="help-block text-danger err_sex" style="display:none;">请输入性别</span>
                     </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="pas" value="123456">
                            <span class="help-block pas">6-20位英文、数字、符号、区分大小写（默认密码123456）</span>
							<span class="help-block text-danger err_pas" style="display:none;">账号不能为空</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="repas"  value="123456">
							<span class="help-block text-danger err_repas" style="display:none;">账号不能为空</span>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="" class="col-sm-2 control-label">角色</label>
                             <div class="layui-input-block">
                              <input type="radio" id="roles" value="1" style="margin-left: 2%" >教师
                              <input type="radio" id="roles" value="2"  style="margin-left: 2%" checked>学生
                            </div>
                     </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="add_user(this);">添加</button>
            </div>
        </div>
    </div>
</div>

<!-- 编辑用户信息 -->
<div class="modal fade" id="edit_user_infos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title">编辑用户</h4>
                <form action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">账号</label>
						<input type="hidden" name="up_uid" value="" id="up_uid">
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="up_email">
                            <span class="help-block pas">4-20位英文字母或邮箱</span>
							<span class="help-block text-danger up_email" style="display:none;">请输登录账号</span>
                        </div>
                    </div>				
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="up_nickname">
                            <span class="help-block text-danger up_nickname" style="display:none;">请输入用户名</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">身份证</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="id_card">
                            <span class="help-block text-danger up_nickname" style="display:none;">请输入证件号</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">手机号</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="moblie">
                            <span class="help-block text-danger up_nickname" style="display:none;">请输入联系方式</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">出生日期</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="birth_date">
                            <span class="help-block text-danger up_nickname" style="display:none;">请输入出生年月</span>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                    <label for="" class="col-sm-2 control-label">性别</label>
                         <div class="am-form-group" style="margin-top: 5px">
                              <label class="am-radio-inline" style="margin-left: 15px " >
                                <input type="radio"  id="sex" > 男
                              </label>
                              <label class="am-radio-inline">
                                <input type="radio" id="sex2" value = '2'> 女
                              </label>
                         </div>
                     </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_msg()">修改</button>
            </div>
        </div>
    </div>
</div>

<!-- 修改用户密码 -->
<div class="modal fade" id="edit_password">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="editor_pass">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_editor_pass(this);">保存</button>
            </div>
        </div>
    </div>
</div>

<!-- 设置用户角色 -->
<div class="modal fade" id="set_user_role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title">设置角色</h4>
                <form action="" class="form-horizontal">
                    <div class="form-group">
                     <label for="" class="col-sm-2 control-label">用户角色</label>
                        <div class="col-sm-10" id="role_list">
                     
                        </div> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_roles(this);">保存</button>
            </div>
        </div>
    </div>
</div>

  </div>
</div>

<!--批量导入用户-->
<div class="modal fade" id="export_users">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refresh();"><span aria-hidden="true">×</span></button>
            </div>          
            <div class="modal-body" id="home_ques">
            <!-- 学员管理 -->
            <script src="<?php echo site_url("public/expand/uploadify");?>/jquery.uploadify.min.js" type="text/javascript"></script>
            <div class="panel  manage-student">
                            <h4 class="modal-title">批量导入用户</h4>
                <div class="panel-body">
                    <form action="" class="form-horizontal">
                        <div class="form-group" style="margin-bottom:15px;">
                            <label class="control-label col-sm-3">选择要导入的文件</label>
                            <div class="col-sm-6">
                                <div style="margin-top:8px;position:relative;">
                                    <a href="javascript:$('#file_upload').uploadify('upload','*')" id="uploadButton" class="btn btn-primary">开始导入数据</a>
                                    <input id="file_upload" name="file_upload" type="file" multiple="true" style="color: red">
                                </div>
                                <style>
                                input#file_upload{opacity: 0;}
                                #file_upload{
                                    border-radius: 4px;width: 80px !important;height: 24px !important;
                                }
                                #file_upload #file_upload-button{width:80px !important;height:24px !important;
                                    text-align: center;}
                                #file_upload-queue{font-size: 12px;color: #888;}
                                #file_upload-queue>div{position: relative;margin-top: 10px;padding-right: 20%;}
                                #file_upload-queue>div .cancel{position: absolute;right: 18%;font-size: 12px;}
                                #file_upload-queue>div .cancel a:hover{color: #02816b;}
                                #file_upload-queue>div .fileName{font-size: 12px;color: #888;}
                                #url{font-size: 12px;color: #888;line-height: 18px;padding-left: 15px;}
                                #url li+li{margin-top: 5px;}
                                #uploadButton{position: absolute;left: 100px;}
                                </style>
                                <div class="help-block" style="margin-top:15px;">从Excel文件导入（文件格式参照实例说明文件）</div>
                            </div>
                            <a href="<?php echo site_url("course_set/down");?>" class="col-sm-3" style="margin-top:13px;color:#00bc9c;">点击下载实例说明</a>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3"></label>
                            <div class="col-sm-9">  
                                <ul id="url" style="border:0px;"></ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        <?php $timestamp = time();?>
        $(function() {
            $('#file_upload').uploadify({
                //数据
                'formData'      : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                },
                'swf'           : '<?php echo site_url("public/expand/uploadify");?>/uploadify.swf',
                'uploader'      : '<?PHP echo site_url("admin/user/import")?>',         
                'auto'          : false,                    
                'buttonImage'   : '<?php echo site_url("public/home/static");?>/banji_guanli_btn01.png',
                'multi'         : false,                
                'fileTypeExts'  : '*.xls;*.xlsx',   
                'fileSizeLimit' : '1204MB',                 
                'successTimeout': 300,                  
                'onUploadSuccess' : function(file, data, response) {
                    $('#url').append("<li>"+data+"</li>");
                },
                'onUploadError'   : function(file, data, response) {
                    $('#url').append("<li>"+data+"</li>");
                }
            });
        });
        
        function refresh(){
              window.location.reload();
        }
    </script>
<script src="<?php echo base_url()?>public/admin/js/user.js"></script>
<style>
    #gt{
        margin-left:17%;
    }
</style>
<?php $this->load->view("admin/public/footer");?>

