<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- 登录弹出框 lgd -->
 <div class="modal fade bs-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">登录</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <input type="text" class="form-control" id="nickname" placeholder="用户名">
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" id="message-text" placeholder="密码">
          </div>
        </form>
      </div>
      <div class="modal-footer">   
        <button type="button" class="btn btn-primary">登录</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bs-example-modal-sm" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">注册</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <input type="text" class="form-control" name="nickname" placeholder="用户名">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="identity_card" placeholder="身份证号">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="mobile" placeholder="手机号">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="邮箱账号">
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" id="message-text" placeholder="密码">
          </div>
          <div class="form-group">
            <input type="password" name="pass" class="form-control" id="message-text" placeholder="确认密码">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">头像:</label>
            <input type="file"  name="headpic" placeholder="邮箱账号">
          </div>
        </form>
      </div>
      <div class="modal-footer">   
        <button type="button" class="btn btn-primary">登录</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>