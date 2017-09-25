<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CB_Controller {

	function __construct(){
		parent::__construct();
		//跳转登录
		if(!isset($_SESSION['user']['id']) && empty($_SESSION['user']['id'])){
			redirect(site_url('admin/login'));
		}		
		$this->load->model('user_model');
		$this->load->helper('asd');
	}

  //用户管理
	public function username($flip="",$page="1"){
		if(empty($flip)){
			$this->session->set_userdata(array('search'=>''));
		}
		if(isset($_POST['sub']) && !empty($_POST)){
			if(isset($_POST['search'])){
				$this->session->set_userdata(array('search'=>$_POST['search']));		
			}
		}
		$search = $this->session->userdata('search');

		$config['per_page'] = 10;
	    $config['base_url'] = site_url()."admin/user/username/flip";
		$config['total_rows'] = $this->user_model->get_user_count($search);

		$start = $this->my_page($config,$page);
		$data['user_list'] = $this->user_model->get_user_list(intval($config['per_page']),intval($start),$search);	
		$data['search'] = $search;	
		$this->load->view('admin/user/username',$data);
		
	}

	//获取用户信息
	public function up_stu_msg(){
		$id = $this->input->post("u_id");
		$user = $this->user_model->get_user_message($id);
		// print_r($user);die;
		echo json_encode($user);	
	}
	
    //删除用户
	public function del_user($u_id){
	  $result = $this->user_model->del_user($u_id);
	  echo 1;
	}
    
     //批量删除用户
	public function del_users(){

	  $id_arr = $this->input->post("id_arr");
	  if(!empty($id_arr)){
	  	foreach($id_arr as $u_id){
	  	 $result = $this->user_model->del_user($u_id);
	  	}
	  }
	  echo 1;

	}
	public function is_in(){
	$this->load->model("user_model");
	$name = $this->input->post("nickname");
    $this->db->select('id')->from('user')->where('nickname',$name);
	$query = $this->db->get()->row_array();
	if($query>0){
		echo '1';//用户名已存在
	}
	

	}
	
    //添加用户
	public function add_user(){
		$this->load->model("user_model");
		$data['nickname'] = $this->input->post("nickname");	
		$data['email'] = $this->input->post("email");	
		$data['password'] = md5($this->input->post("pas"));
		$data['moblie'] = $this->input->post("moblie");	
		$data['id_card'] = $this->input->post("id_card");
		$data['sex'] = md5($this->input->post("sex"));
		$data['birth_date'] = $this->input->post("birth_date");	
		$data['roles'] = $this->input->post("roles");	
		//判断用户是否存在
		$checkuser = $this->user_model->check_user_isset($data['email']);
		if(empty($checkuser)){
			if(!empty($data['nickname']) && !empty($data['email'])){
				$id = $this->user_model->add_user($data);
				echo '1';
			}
		}else{
			echo '2';
		}
	}	


	//编辑用户信息
	 public function update_user_msg(){
		$u_id = $this->input->post("u_id");
		$data['nickname'] = $this->input->post('nickname');
		$data['email'] = $this->input->post("email");
		$data['id_card'] = $this->input->post('id_card');
		$data['moblie'] = $this->input->post("moblie");
		$data['birth_date'] = $this->input->post('birth_date');
		// print_r($data['birth_date']);die;
		$result = $this->user_model->update_user($u_id,$data);
		echo '1';
	 }

	 //封禁用户
	 public function lock_user($u_id){
		$this->load->model("user_model");
		$result = $this->user_model->lock_user($u_id);	
		echo 1;
	 }
	//获取用户密码信息
	 public function editor_password(){
	  $this->load->model("user_model");
	  $u_id = $this->input->post("u_id");
	  $r = $this->user_model->get_stu($u_id);
	  echo json_encode($r);
	  
	 }
	//修改密码
	 public function save_editor_pass(){
		$u_id = $this->input->post("u_id");
		$data['password'] = md5($this->input->post("pass"));
		if(!empty($this->input->post("pass"))){
			$result = $this->user_model->update_user($u_id,$data);
		}
		echo 1;	

	 }
	 
	 //批量导入用户
	public function import(){
		$config['upload_path'] = "./upload/home/student_excel";
		$config['allowed_types'] = "*";
		$config['max_size']="35000";
		$config['encrypt_name'] = true;
		$this->load->library("upload",$config);
		if(!$this->upload->do_upload('Filedata')){
			$info = $this->upload->display_errors();
		}else{
			$info = $this->upload->data();
		}

		if(is_array($info)){
			$r = $this->import_excel($info['file_name']);
			if(is_array($r)){
				unlink("./upload/home/student_excel/{$info['file_name']}");
				$this->load->model("user_model");
				$result = $this->user_model->excel_add_user($r);
				echo "<p style='color:green;'>数据导入完成</p>";
			}else{
				unlink("./upload/home/student_excel/{$info['file_name']}");
				echo $r;
			}
		}else{
			echo $info;
		}
	
	}
	
	//导入
	function import_excel($name){
		require_once "./public/expand/php_excel/PHPExcel.php";
		$ext = explode(".",$name);
		if($ext['1'] == 'xls'){
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
		}else{
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		}
		$objPHPExcel = $objReader->load("./upload/home/student_excel/{$name}"); 
		$sheet = $objPHPExcel->getSheet(0); 
		$highestColumn = $sheet->getHighestColumn();

		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

		if($highestColumn =='D' && $highestColumnIndex==4){
			$highestRow = $sheet->getHighestRow();
			$objWorksheet = $objPHPExcel->getActiveSheet();	
			$data = array();
			$index = array("nickname","email","sex","moblie");
			for($r = 2;$r<$highestRow+1;$r++){
				for($i = 0;$i<4;$i++){
						$data[$r]["{$index[$i]}"] =$this->security->xss_clean($objWorksheet->getCellByColumnAndRow($i,$r)->getValue());
				}
			}
			return $data;
		}else{
			//unlink("./upload/home/student_excel/{$name}");
			return "<font color='red'>文件格式错误或上传文件与模板不一致，请下载最新模板！</font>";
		}

	}	

}