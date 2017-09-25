<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class User_set extends CB_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("user_model");
	}

	// 个人资料
	public function index ()
	{
		$data['page'] = 'index';
		$uid = $_SESSION['user']['id'];
		$data['msg'] = $this->user_model->get_user_message($uid);
		if ($_POST) {

			$_POST['create_time'] = time();
			$r = $this->user_model->up_user($_POST);
			if ($r) {
				$data['box'] = $this->alert_box("保存成功");
			}
		}
		$this->load->view('home/user_set',$data);
	}

	//头像设置
	public function headpic(){
		$data['page'] = "headpic";
		$data['info'] = $this->user_model->get_headpic();
		$this->load->view("home/user_set",$data);
	}

	//上传头像
	public function up(){
			$info = $this->upload_headpic();
			$this->load->helper("upload_img");
			if(is_array($info)){
				$xx = xx_img($info['file_path'],$info['file_name'],$_POST['x1'],$_POST['y1'],$_POST['w'],$_POST['h']);
				if($xx){
					
					$result = $this->user_model->update_headpic(intval($_POST['g_id']),$info['file_name']);
					echo "yes";
					/*
					if(!$result){
						//unlink("./public/home/images/headpic/{$info['file_name']}");
					}else{
						echo "yes";
					}
					*/
				}
			}else{
				echo $info;
			}
	}

	//上传头像设置
	public function upload_headpic(){
		$config['upload_path'] = "./public/home/images/headpic";
		$config['allowed_types'] = 'png|jpg|fig';
		$config['max_size']="2048";
		$config['max_width']="5000";
		$config['max_height'] = "5000";
		$config['encrypt_name'] = true;
		$this->load->library("upload",$config);
		if(!$this->upload->do_upload('fileUpload')){
			$info = $this->upload->display_errors();
		}else{
			$info = $this->upload->data();
		}
		return $info;
	}

	//修改密码
	public function safety(){
		$data['page'] = "safety";
		$this->load->view("home/user_set",$data);
	}

	//修改密码
	public function xiugai(){
		$data['old'] = md5($_POST['old']);
		$data['new'] = md5($_POST['new']);
		$r = $this->user_model->xiugai($data);
		if($r){
			$data['box'] = $this->alert_box("保存成功");
		}else{
			$data['box'] = $this->alert_box("修改失败");
		}
		$data['page'] = "safety2";
		$this->load->view("home/user_set",$data);
	}

	//效验密码
	public function check_(){
		$this->load->model("user_model");
		$data['id'] = $_SESSION['user']['id'];
		$data['mima'] = md5($_POST['mima']);
		$result = $this->user_model->check_($data);
		echo $result;
	}
	// public function safety2(){
	// 	$data['page'] = "safety2";
	// 	$this->load->view("home/user_set",$data);
	// }
}