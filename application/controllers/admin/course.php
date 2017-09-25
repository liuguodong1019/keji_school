<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CB_Controller {

	function __construct(){
		parent::__construct();
		//跳转登录
		if(!isset($_SESSION['user']['id']) && empty($_SESSION['user']['id'])){
			redirect(site_url('admin/login'));
		}
		$this->load->model('course_model');
		$this->load->model('category_model');
		$this->load->helper('asd');
		$this->load->model('user_model');
		$this->load->model('course_lesson_model');
		$this->load->helper('lang_array');
		$this->load->helper("upload_img");		
	}
	
	/*
	**课程管理
	*/	
	//课程管理
	public function manage($flip="",$page="1"){

		if(empty($flip)){
			$this->session->set_userdata(array('category'=>''));
			$this->session->set_userdata(array('course_name'=>''));
		}
		if(isset($_POST['sub']) && !empty($_POST)){
			if(isset($_POST['category'])){
				$category = $_POST['category'];
				$this->session->set_userdata(array('category'=>$category));		
			}
			if(isset($_POST['course_name'])){
				$course_name = $_POST['course_name'];
				$this->session->set_userdata(array('course_name'=>$_POST['course_name']));		
			}					
		}
		$category = $this->session->userdata('category');
		$course_name = $this->session->userdata('course_name');
		$config['per_page'] = 10;
		$config['base_url'] = site_url()."admin/course/manage/flip";
		$config['total_rows'] = $this->course_model->sys_course_count('manage',$category,$course_name);
		
		$start = $this->my_page($config,$page);
		$data['data_list'] = $this->course_model->sys_course_list('manage',intval($config['per_page']),intval($start),$category,$course_name);	

		$data['categorydata'] = $this->category_model->get_list('course');
		
		$data['category'] = $category;
		$data['course_name'] = $course_name;

		$this->load->view('admin/course/manage',$data);
	}
	
	//删除课程
	public function course_del(){
		$id = $this->input->get('id');
		$this->db->where("id",$id)->delete('course');
		$this->db->where("course_id",$id)->delete('course_lesson');
		echo '1';
	}	
	
	//课程管理
	public function update($id){
		$data['course'] = $this->course($id);
		$this->load->model("category_model");
		if($_POST){
			//基本信息
			$da['title'] = $this->input->post('title');
			$da['category_id'] = $this->input->post('category_id');
			$da['about'] = $this->input->post('editorValue');
			$this->course_model->update_($da,$id);
		}
		$data['msg'] = $this->course_model->msg($id);
		$data['id'] = $id;
		$data['category'] = $this->category_model->get_list('course');
		$this->load->view("admin/course/base",$data);
	}

	
	public function pic($id){
		$data['course'] = $this->course($id);		
		$this->load->view("admin/course/pic",$data);
	}	
	
	//课时管理
	public function lesson($id=""){
		
		$data['course'] = $this->course($id);
		$data['lessons'] = $this->course_lesson_model->get_chapter_lesson($id);
		$data['star_lesson'] = $this->course_lesson_model->get_lesson_question($id);
		$this->load->view("admin/course/lesson",$data);
	}	
	
	private function course($id){
		return $this->course_model->get_course2($id);
	}	
	
	
	//创建课程
	public function create_course(){
		//$c_title = $this->setting_model->get_one("course_img");
		$data['title'] = $this->input->post('title');
		$data['category_id'] = $this->input->post('category_id');
		$data['about'] = $this->input->post('about');
		$data['create_time'] = time();
		$data['create_id'] = $_SESSION['user']['id'];
		$data['pic'] = '1.jpg';
		$data['status'] = '1';
		$result= $this->course_model->add($data);
	    echo $result;
	}	
	
	
	//上传课程图片
	public function upload_course_img($t=''){
		$info = $this->upload_img();
		if(is_array($info)){
			$xx = xx_img($info['file_path'],$info['file_name'],$_POST['x1'],$_POST['y1'],$_POST['w'],$_POST['h']);
			if($xx){
				
				$result = $this->course_model->update_pic(intval($_POST['g_id']),$info['file_name']);
				if(!$result){
					unlink("./public/home/images/{$info['file_name']}");
				}else{
					echo "yes";
				}
			}
		}else{
			echo $info;
		}
	}	
	//上传图片
	public function upload_img(){
		$config['upload_path'] = "./public/home/images/course";
		$config['allowed_types'] = "jpg|png|jpeg|gif|ai";
		$config['max_size']="6600";
		$config['max_width']="4000";
		$config['max_height'] = "4000";
		$config['encrypt_name'] = true;
		$this->load->library("upload",$config);
		if(!$this->upload->do_upload('fileUpload')){
			$info = $this->upload->display_errors();
		}else{
			$info = $this->upload->data();
			//$data['alert_box'] = $this->alert_box("操作成功");
		}
		return $info;
	}	
	
}