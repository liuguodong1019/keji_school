<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CB_Controller {
	function __construct(){
		parent::__construct();
		//跳转登录
		if(!isset($_SESSION['user']['id']) && empty($_SESSION['user']['id'])){
			redirect(site_url('admin/login'));
		}		
		$this->load->model("category_model");
		$this->load->helper("upload_img");
		$this->load->model('user_model');	

	}

	//网站分类
	public function classify($flip="",$page="1"){	
		$config['per_page'] = 10;
		$config['base_url'] = site_url()."admin/system/classify/flip";
		$config['total_rows'] = $this->category_model->get_all_data_count('system');
		$start = $this->my_page($config,$page);
		$data['data_list'] = $this->category_model->get_all_data(intval($config['per_page']),intval($start),'system');		
		$this->load->view('admin/system/classify',$data);
	}
	
	//添加类别信息
	public function add_classify(){
		$data['title'] = $this->input->post('c_title');
		$data['type'] = 'course';
		$data['num'] = $this->input->post('c_num');
		$data['icon'] = $this->mt_rand(6);
		$data['description'] = $this->input->post('c_desc');
		$data['create_time'] = time();
		$this->db->insert('category',$data);
		echo '1';
	}
	
	//随机数字
	function mt_rand($length){
		$pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
		for($i=0;$i<$length;$i++){
			$key .= $pattern{mt_rand(0,35)};
		}
		return $key;		
	}

	//获取类别信息
	public function get_classify(){
		$id = $this->input->get('id');
		$data = $this->category_model->get_one($id);
		echo json_encode($data);			
	}
	
	//保存修改后的类别
	public function save_classify(){
		$id = $this->input->post('id');
		$data['title'] = $this->input->post('c_title');
		$data['num'] = $this->input->post('c_num');
		$data['description'] = $this->input->post('c_desc');
		$this->db->where("id",$id)->update('category',$data);
		echo '1';

	}
	
	//删除类别
	public function del_classify(){
		$id = $this->input->post('id');
		$this->db->where("id",$id)->delete('category');
		echo 1;	
	}		
	
	//批量删除类别
	public function del_classifys(){
		$id = $this->input->get('id');
		if(!empty($id)){
			foreach($id as $key){
				$this->db->where("id",$key)->delete('category');			
			}
		}
		echo 1;
	}	

}
