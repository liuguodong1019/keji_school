<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CB_Controller {
	function __construct() {
        parent::__construct();
		$this->load->model("user_model");
    }
	
	//首页
	public function index()
	{		
		$this->load->view('admin/login/index',$data);
	}
	
	//退出系统 
	public function logout(){
		$this->session->unset_tempdata('usermes');
		$this->session->sess_destroy();
		redirect(site_url('admin/login/index'));
	}
	
	//登录验证
	public function check_login(){
  		$info = $this->input->post("email");
		$pas = md5($this->input->post("password"));
		$is_remember = $this->input->post("is_remember");
		$result = $this->user_model->check_logins($info,$pas);

		if($result){
			 if($result['is_lock'] == '1'){
				echo '3'; //用户被锁定
			 }else{

			 	if($is_remember == "yes"){
						$this->input->set_cookie("username",$this->input->post("email"),3600*24*30); 
						$this->input->set_cookie("password",$this->input->post("password"),3600*24*30);  
					}else{
						$this->load->helper('cookie');
						delete_cookie("username");
						delete_cookie("password");    
				}
				 $this->session->set_tempdata('user',$result,3600*4); //存储时间为4小时
				 $user['login_ip'] = $_SERVER["REMOTE_ADDR"];
				 $user['login_time'] = time();
				 $this->user_model->update_user($result['id'],$user);
				 echo 1;
			}			 
		}else{
			echo 2;//用户不存在
		}			
	}


	//找回密码
	public function forget_password(){
		$this->load->model('email_model');
		$p_email = $this->input->post("p_email");
		if(!empty($p_email)){
			//判断该用户的邮箱是否注册过 
			$data = $this->user_model->check_user_isset($p_email);
			if(!empty($data)){
				$email = base64_encode($data['email']);
				echo $email;
				//发送邮件
				// $message = $this->sedmessage($data['id'],$data['email']);
				// print_r($message);die;
				// $bol = $this->email_model->sendemail($message['name'].'密码重置',$message['str'],$data['email']);
				// if ($bol) {
				// 	echo $message['code'];
				// }				
				
			}else{
				echo '2';
			}
		}else{
		$this->load->view('home/resetpass/forget_password');
		}
	}

	//生成随机码
	public function sedmessage($uid = '',$email = ''){
		$this->load->model('email_model');
		$code = $this->email_model->encrypt("{$email}",'E','combanc'); //加密
		$code = urlencode($code);
		$time = $this->email_model->encrypt(time(),'E','combanc'); //加密
		$time = urlencode($time);

		//更新用户	
		$arr = array();
		$message = $this->user_model->email_message($email);
		$name = $message['nickname']; //平台名称
		$url = site_url().'admin/login/resetpass/user?code='.$code.'&time='.$time;
		$str= '<p>尊敬的'.$name.'用户，您好！</p>';
		$str.= '<p>您在访问'.$name.'时点击了“忘记密码”链接，这是一封密码重置确认邮件。</p>';
		$str.= '<p>您可以通过点击以下链接重置账户密码：</p>';
		$str.= '<p><a href="'.$url.'">'.$url.'</a></p>';
		$str.= '<p>为保障您的账号安全，请在24小时内点击该链接，您也可以将链接复制到浏览器地址栏访问。若如果您并未尝试修改密码，请忽略本邮件，由此给您带来的不便请谅解。</p>';
		$str.= '<p>本邮件由系统自动发出，请勿直接回复！</p>';
		$arr['name'] = $name;
		$arr['code'] = $code;
		$arr['str'] = $str;
		return $arr;
	}

	//重置密码
	public function resetpass()
	{
		$email = base64_decode($_GET['email']);
		$data['user'] = $this->user_model->check_user_isset($email);
		// print_r($data['user']);die;
		$this->load->view('home/resetpass/resetpass',$data);				
		
	}


	//重置
	public function resetdata(){
		$uid = $this->input->post("uid");
		$data['password'] = md5($this->input->post("newPass"));
		//更新用户
		$this->user_model->update_user_password($uid,$data);
		echo '1';	
	}	


	//重置成功
	public function success(){
		$this->load->view('home/resetpass/success',$data);		
	}	


	public function fasong () 
	{
		$this->load->library('email');
		$config['protocol'] = 'smtp';        //邮件发送协议
		$config['smtp_host'] = 'smtp.163.com';    //SMTP 服务器地址
	    $config['smtp_user'] = '15110274504@163.com';    //SMTP 用户名
		$config['smtp_pass'] = 'liu13720907372';        //邮箱密码
		$config['mailtype'] = 'html';
		$config['validate'] = TRUE;        //是否验证邮件地址
		$config['charset'] = 'utf-8';        //iso-8859-1
		// $config['wordwrap'] = TRUE;        //是否启用自动换行
		$config['smtp_port'] = 25;        //SMTP 端口
		// $config['crlf']  = "\r\n";

		$this->email->initialize($config);
		
        $this->email->from('15110274504@163.com', '北京科技高级技术学校');
        $this->email->to('331787444@qq.com');
        $this->email->subject('北京科技高级技术学校');
        $this->email->message('还是没有内容');
        $this->email->send();
        // $this->email->attach('application/controllers/11.jpg');
	}

	//邮件发送成功
	public function sendemail(){
		$this->load->model('email_model');
		$code = $_GET['code'];

		$email = $this->email_model->encrypt($code,'D','combanc'); //解密

		$user = $this->user_model->check_user_isset($email);	
		// print_r($user);die;
		if(!empty($code) && !empty($user)){
			//查询出用户信息
			$data['user'] = $user;
			$this->load->view('home/resetpass/sendemail',$data);
		}else{
			redirect(site_url());
		}
	}


	//验证码
	public function get_captcha()
    {
            $this->load->helper('captcha');
            $vals = array(
                'img_path' => './public/captcha/',
                'img_url' => base_url().'public/captcha',
				'img_width' => '75',
				'img_height' => '45',
				'word_length' => 4,
				'font_size' => '30',
				'pool'		=> '0123456789',
				'colors' => array(
				'background' => array(255, 255, 255),
				'border' => array(255, 255, 255),
				'text' => array(0, 0, 0),
				'grid' => array(255, 40, 40)
				)				
            );
            $cap = create_captcha($vals);
            $data = array(
                'captcha_time' => $cap['time'],
                'ip_address' => $this->input->ip_address(),
                'word' => $cap['word']
            );
			echo json_encode($cap);
    }


	/**
	 * [sign_in description]
	 * 注册
	 */
	public function sign_in ()
	{
		$data = $_POST;
		unset($data['pass']);
		// print_r($data);die;
		$result = $this->user_model->sign($data);
		if ($result !== false) {
			echo 1;
		}
	}

	public function inspect ()
	{
		$this->load->model('user_model');
		$email = $this->input->post("email");
		$str = $this->user_model->inspe($email);
		echo $str;
	}
	public function inspect1 ()
	{
		$this->load->model('user_model');
		$id_card = $this->input->post("id_card");
		$str = $this->user_model->inspe1($id_card);
		echo $str;
	}
}
