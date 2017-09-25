<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Learn extends CB_Controller {

	function __construct(){
		parent::__construct();
		//跳转登录
		if(!isset($_SESSION['user']['id']) && empty($_SESSION['user']['id'])){
			// redirect(site_url('admin/login'));
			redirect(site_url('course/course_list'));
		}
	}

	//学习中心
	public function my_course ($action="learning",$page='1')
	{
		
		$this->load->model('course_learn_model');
		$config['per_page'] = 10;
		$config['base_url'] = site_url()."learn/my_course/".$action;

		if($action=="" or $action=="learning"){
			//学习中课程
			$finish_course = $this->course_learn_model->learnedid($_SESSION['user']['id'],1);
			
			$config['total_rows'] = count($finish_course);
			$start = $this->my_page($config,$page);
			$data['my_le_course'] = $this->course_learn_model->learnedid($_SESSION['user']['id'],1,$config['per_page'],$start);
			
			$data['action'] = "learning";
		}else if($action=="finished"){
			//己学完课程
			$finish_course = $this->course_learn_model->learnedid($_SESSION['user']['id'],2);	
			if(!empty($finish_course)){
				$config['total_rows'] = count($finish_course);
				$start = $this->my_page($config,$page);
				$data['my_le_course'] = $finish_course;
				
			}else{
				$data['my_le_course'] = array();
			}			
			$data['action'] = "finished";
		}
		$this->load->view('learn/index',$data);
	}
	
}