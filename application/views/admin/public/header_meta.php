<?php $this->load->view('admin/public/base_link');?>
<link rel="stylesheet" href="<?php echo base_url('public/admin')?>/css/background-users.css">
<body>
    <div class="cb-wrap">
        <!-- 头部信息 -->
         <?php $this->load->view('admin/public/header');?>
        <!-- 内容区开始 -->
        <div class="container" style="min-height:500px;">
            <div class="row user_page">
                <div class="col-md-3">
                    <div class="u_cont_Frame">
                        <div class="nav-list">
                            <!-- nav-list名字对下方的list-group-item进行样式设置 -->
                            <!-- 标题 -->
                            <div class="nav-title">管理中心</div>
                            <div class="list-group">
							   
							<a href="<?php echo site_url('admin/course/manage');?>" class="list-group-item <?php if($this->uri->segment(3)== "manage" or $this->uri->segment(3)== "update" or $this->uri->segment(3)== "pic" or $this->uri->segment(3)== "lesson"){echo "active";}?>"><i></i>课程管理</a>
							
							<a href="<?php echo site_url('admin/user/username');?>" class="list-group-item <?php if($this->uri->segment(3)== "username"){echo "active";}?>"><i></i>用户管理</a>		
							
							<a href="<?php echo site_url('admin/system/classify');?>" class="list-group-item <?php if($this->uri->segment(3)== "classify"){echo "active";}?>"><i></i>标签管理</a>		
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 distance20"> 
  <script type="text/javascript">
      //即勾上全选框 
    function SelectAll(ee){ 
        if($(ee).prop('checked')==true){
            $(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked','checked')
        }else{
            $(ee).parents('.select_father').prev().find('tbody').find('input[type="checkbox"]').prop('checked',false)
        }
    }
  </script>				