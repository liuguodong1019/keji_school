<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CB_Controller  extends CI_Controller{


	function __construct(){
		parent::__construct();
		//$this->load->model('role_model');
	}
	//个人资料保存成功提示
	function alert_box($msg){
		if(!$msg){$msg = "操作成功";}
		$str ="";
		$str .="<div id='alert'>{$msg}</div>";
		return  $str;
	}
	function my_page($config,$page){
		$this->load->library('pagination');
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<div style="clear:both;"><nav id="page-number-area"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav></div>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_link'] = '&lt;&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 6;
		$start = ($page-1)*$config['per_page'];
		$this->pagination->initialize($config);
		return $start;
	}

	public function has_pri(){
	    $this->load->model("privilege_model");
		$mod = $this->uri->segment(1);
		if($mod!="admin"){
           $mod="";
		}
		$con = $this->router->fetch_class();
	    $func = $this->router->fetch_method();
	    $u_id = $this->session->userdata('user')['id'];
	    if($u_id==1){
	    	return true;
	    }else{
	    	$info = $this->privilege_model->get_type($u_id,$mod,$con,$func);
	    	//return $info;
             if($info=="allow"){
	    	 	return "allow";
	    	 }elseif($info=="anniu"){
	    	 	return "anniu";
	    	 }elseif($info=="lianjie"){
	    	 	show_error('','500','对不起，您无权访问此页面');	
	    	 }
	    }
	    
		}
}