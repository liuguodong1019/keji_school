//添加用户
 function add_user(obj){
    var nickname = $('#nickname').val();
    var email = $('#email').val();
    var pas = $('#pas').val();
    var repas = $('#repas').val();
    var sex = $('#sex').val();
    var moblie = $('#moblie').val();
    var id_card = $('#id_card').val();
    var roles = $('#roles').val();
    var birth_date = $('#birth_date').val();

	if(email.trim() == ""){
		$('.err_email').html('账号不能为空');$('.err_email').show();
	}else if(nickname.trim() == ""){
		$('.err_nickname').html('姓名不能为空!');$('.err_nickname').show();
		$('.err_email').html('');
		return false;
	}else if(moblie.trim() == ""){
    $('.err_moblie').html('联系方式不能为空!');$('.err_moblie').show();
    return false;
  }else if (id_card.trim() == "") {
    $('.err_id_card').html('证件号不能为空!');$('.err_id_card').show();
    return false;
  }else if(pas.trim() == ""){
		$('.err_pas').html('密码不能为空!');$('.err_pas').show();
		$('.err_email').html('');$('.err_nickname').html('');
		return false;	
	}else if(pas.length < 6){
		$('.err_pas').html('密码最少六位数!');$('.err_pas').show();
		$('.err_email').html('');$('.err_nickname').html('');
		return false;		
	}else if(repas.trim() == ""){
		$('.err_repas').html('确认密码不能为空!');$('.err_repas').show();
		$('.err_email').html('');$('.err_nickname').html('');$('.err_pas').html('');
		$('.err_ickname').html('姓名不能为空!');
	}else if( pas.trim() != repas.trim()){
		$('.err_repas').html('两次密码输入不一致!');
		$('.err_repas').show();
		$('.err_email').html('');$('.err_nickname').html('');$('.err_pas').html('');
	}else{
		$('.err_email').html('');$('.err_nickname').html('');$('.err_pas').html('');$('.err_repas').html('');	
		$.post(base_url+"admin/user/add_user",{'nickname':nickname,'email':email,'pas':pas,'sex':sex,'moblie':moblie,'id_card':id_card,'birth_date':birth_date},function(data){

			if(data==1){
				window.location.reload();
			}else if(data == 2){
				$('.err_email').html('该账号己存在');
				$('.err_email').show();
			}
		})
	}
} 

 function student_msg(id){
        var u_id = id;
        $.post(base_url+"admin/user/get_student_msg",{'u_id':u_id},function(data){
            $("#xx").html(data)
        })
    }
//修改用户信息
function update_stu_msg(id){
     var u_id = id;
     $.post(base_url+"admin/user/up_stu_msg",{'u_id':u_id},function(data){
        var jsondata = eval('('+data+')'); 
		var nickname = $('#up_nickname').val(jsondata['nickname']);
		var email = $('#up_email').val(jsondata['email']);		
		var id = $('#up_uid').val(u_id);	
    var id_card = $('#id_card').val(jsondata['id_card']);	
    var moblie = $('#moblie').val(jsondata['moblie']);
    var id_card = $('#birth_date').val(jsondata['birth_date']);
     })
}

//保存用户信息
function save_msg(){

   var u_id = $('#up_uid').val();
   var email = $('#up_email').val();
   var nickname = $('#up_nickname').val();
   var id_card = $('#id_card').val();  
   var moblie = $('#moblie').val();
   var birth_date = $('#birth_date').val();
   $.post(base_url+"admin/user/update_user_msg",{'email':email,'u_id':u_id,'nickname':nickname,'id_card':id_card,'moblie':moblie,'birth_date':birth_date},function(data){
     if(data==1){
       window.location.reload();
     }else{
      alert(data)
     }
    
   })
}

//封禁用户
function lock_user(obj){
    var u_id = $(obj).data("id");
    $.get(base_url+"admin/user/lock_user/"+u_id,function(data){
       if(data==1){
         window.location.reload();
       }else{
        alert(data)
       }
      
    })

}
//单删
 function del_u(obj){
	if(confirm("您确定要删除吗？")){
        var u_id = $(obj).data("id");
        $.get(base_url+"admin/user/del_user/"+u_id,function(data){
		  if(data.trim() == 1){
			$("#deluser_"+u_id+"").hide();
           } else{
            alert(data)
           } 
        })
	}	
}
//批删
function del_user(obj){
        confirm("您确定要删除吗？");
        var id_arr=[];
        for(var i=0;i<$('.deluser:checked').length;i++){
          var u_id = $('.deluser:checked:eq('+i+')').val();
          id_arr[i]=u_id;
        }
          $.post(base_url+"admin/user/del_users",{'id_arr':id_arr},function(data){
           if(data==1){
            window.location.reload();
           }else{
            alert(data)
           }
          })
        
  }

function editor_password(id){
   var u_id = id;
   $.post(base_url+"admin/user/editor_password",{'u_id':u_id},function(data){
     var da=eval("("+data+")");
     var str="";
     str += '<h4 class="modal-title">修改用户密码</h4>'
     str += '           <form action="" class="form-horizontal">'
     str += '        <div class="form-group">'
     str += '                   <label for="" class="col-sm-2 control-label">账号</label>'
     str += '                   <div class="col-sm-7">'
     str += '                       <input type="text" class="form-control u_text" id="" readOnly="true" value='+da.email+' >'
     str += '                   </div>'
     str += '              </div>'
     str += '               <div class="form-group">'
     str += '                   <label for="" class="col-sm-2 control-label">姓名</label>'
     str += '                   <div class="col-sm-7">'
     str += '                      <input type="text" class="form-control u_text" id="" readOnly="true" value='+da.nickname+' >'
     str += '  <input type="hidden" value='+u_id+' name="uid">'
     str += '                   </div>'
     str += '               </div>'
     str += '               <div class="form-group">'
     str += '                   <label for="" class="col-sm-2 control-label">输入新密码</label>'
     str += '                   <div class="col-sm-7">'
     str += '                       <input type="password" class="form-control" id="pass" value="">'
     str += '                       <span class="help-block pass">输入新密码</span>'
     str += '                   </div>'
     str += '               </div>'
     str += '               <div class="form-group">'
     str += '                   <label for="" class="col-sm-2 control-label">确认密码</label>'
     str += '                   <div class="col-sm-7">'
     str += '                       <input type="password" class="form-control" id="repass" value="">'
     str += '                       <span class="help-block repass">再输一次密码</span>'
     str += '                   </div>'
     str += '               </div>'
     str += '           </form>'
  $("#editor_pass").html(str)
    
 $(document).ready(function(){ 
  $("input#pass").focus(function(){ 
  $(".pass").html("6-20位英文、数字、符号、区分大小写");  
  });  
  $("input#pass").blur(function(){  
  var pass = $('#pass').val();
  if(pass.trim()==""){
    $(".pass").addClass("text-danger").html("密码不能为空");  
  }else if(pass.length<6 || pass.length>20){
    $(".pass").addClass("text-danger").html("密码不能小于6位或大于20位");
  }else{
    $(".pass").html("");  
   } 
  });  
    $("input#repass").focus(function(){  
    $(".repass").html("再输一次密码");  
  });  
  $("input#repass").blur(function(){
     var pass = $('#pass').val();
     var repass = $('#repass').val();
    if(repass.trim()==""){
    $(".repass").addClass("text-danger").html("密码不能为空");  
  }else if((repass != pass)){
    $(".repass").addClass("text-danger").html("两次密码不一致");
  }else if(pass==repass){
    $(".repass").html("");  
  }   
  });
});
})
}
function save_editor_pass(obj){
  var u_id = $('input[name="uid"]').val();
  var pass = $('#pass').val();
  $.post(base_url+"admin/user/save_editor_pass",{'u_id':u_id,'pass':pass},function(data){
   if(data==1){
      window.location.reload();
   }else{
    alert(data)
   }
  })
}
