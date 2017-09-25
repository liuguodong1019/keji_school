<link href="<?php echo base_url('public/expand/datepicker')?>/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="<?php echo base_url('public/expand/datepicker')?>/jquery-1.7.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('public/expand/datepicker')?>/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('public/expand/datepicker')?>/datepicker-zh_cn.js"></script>

<div class="b_header">
    <header class="cb-header navbar">
        <div class="navbar-header">
            <!-- logo -->
            <a href="<?php echo site_url("admin/course/manage");?>" class="navbar-brand">
            北京科技高级技术学院
            </a>
        </div>
        <nav class="collapse navbar-collapse">
            <div class="navbar-user left">
                <!-- 登录后显示： -->
                <span class="user_name">
                    <span class="b_touxiang"></span>
                    <?= $_SESSION['user']['nickname'];?>
                </span>
                <!-- 首页 --> 
                <a href="<?php echo site_url("course/course_list");?>" target="_blank" >
                    <span class="glyphicon glyphicon-home"></span> 首页
                </a>
                <!-- 退出登录 -->
                <a href="<?php echo site_url('course/logout');?>">
                    <span class="glyphicon glyphicon-off"></span> 退出登录
                </a>
            </div>       
        </nav>
    </header>
</div>
 <style>
/* 分页*/
#page-number-area {
    text-align: center;
}

#page-number-area .pagination {
    margin-top: 20px;
    margin-bottom: 0;
}

#page-number-area li a {
    background: #eee;
    color: #888;
    border: none;
    margin-right: 10px;
    line-height: 25px;
    padding: 0 9px;
}

#page-number-area li.active a {
    background: #d52029;
    color: #fff;
}

/* 个人信息*/
#modal01 .modal-header{
  border:none;  
}
#modal01 .modal-header span{
  color: #d52029;
  text-shadow: none;
}
#modal01 .modal-header .close:focus,
#modal01 .modal-header .close:hover{
  outline: none;
  opacity: 0.8;
}
#modal01 .modal-body{
  padding:20px 50px;
}
#modal01 .modal-body h4{
  font-size: 16px;
  color: #888;
  font-weight: normal;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
  margin-bottom: 30px;
}
#modal01 .modal-footer{
  padding:0 50px 50px;
  border:none;
}
#modal01 .modal-footer .btn.btn-primary:hover{
  background: #02816b;
  border-color: #02816b;
}
#modal01 table{
    font-family: "microsoft yahei";
    font-size: 12px;
}
#modal01 table th{
    color: #888;
    font-weight: normal;
}
#modal01 table td{
    color: #aaa;
    vertical-align: middle;
    padding: 8px;
}
 </style>