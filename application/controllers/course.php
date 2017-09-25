	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CB_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model('user_model');
		$this->load->model('course_model');
		$this->load->model('category_model');
		$this->load->model('course_lesson_model');
		$this->load->helper('lang_array');
		$this->load->model('course_learn_model');
		$this->load->model('course_member_model');
    }
	
	public function course_list($tage="",$page='1'){
		$data['category']=$this->category_model->get_list('course'); //课程标签
		$config['per_page'] = 12;
		$config['base_url'] = site_url()."course/course_list/{$tage}";
		$config['total_rows'] = $this->course_model->get_lst_count($tage);
		$start = $this->my_page($config,$page);
		$data['course_list'] = $this->course_model->get_lst(intval($config['per_page']),intval($start),$tage);
		$data['tage'] = $tage;
		$data['user'] = $this->session->get_userdata('user');
	
		$this->load->view('home/course_list',$data);
	}	
	
	//课程课时主页面
	public function lesson($c_id,$l_id=""){
		// echo $_SERVER['PHP_SELF'];die;
		// if (empty($l_id)) {
		// 	$data['url'] = $_SERVER['HTTP_REFERER'];
		// 	// echo $data['url'];die;
		// }
		// print_r($url);die;
		$this->load->helper("word_pdf");
		$res = array();
		if (empty($_SESSION['user']['id'])) {
			$data['error_mes'] = '请登录后操作';
		}else {
			$res = $this->course_lesson_model->is_exist($c_id);
		}		
		if(empty($l_id) && empty($res)){
			$data['error_mes'] = '暂无视频资，请先去上传';
		}else{
			$lesson_id = $this->course_learn_model->is_exist($c_id,$res,$l_id);
			// print_r($lesson_id);die;
			$l_id = !empty($l_id) ? $l_id : $lesson_id;
			//课时列表
			$data['lessons'] = $this->course_lesson_model->get_chapter_lesson_byseq($c_id);
			
			//课程信息
			$data['lesson'] = $this->course_lesson_model->get_lesson($c_id,$l_id);
			// echo '<pre>';
			// print_r($data['lesson']);die;
			$data['course'] = $this->course_model->get_course($c_id);
			if($data['lesson'][1]['type']=='application'){
				$swf = explode('.',$data['lesson'][1]['hashname'])[0].".swf";
				
				if(!file_exists("./public/home/swf/".$swf)){
						
					pdf_ini($data['lesson'][1]['hashname']);
				}
			}
			$arr = $this->course_lesson_model->get_pre($c_id);
			
			$data['lesson_seq'] = $this->course_lesson_model->lessonseq($c_id,$l_id); //第几课时
			
			$data['last'] = $this->course_lesson_model->lesson_brother($c_id,$l_id,'last');
			$data['next'] = $this->course_lesson_model->lesson_brother($c_id,$l_id,'next');
			$data['l_id'] = $l_id;
		}
		$this->load->view('home/lesson',$data);
	}	
	

	//修改学习状态
   public function learned(){
    $this->load->model("course_lesson_model");
   	$c_id=$this->input->post('course_id');
   	$l_id=$this->input->post('lesson_id');
	$totalTime = floor($this->input->post('totalTime'));
   	$test = $this->course_member_model->is_exist($c_id);
    $result = $this->course_learn_model->up_learn_status($c_id,$l_id,$test,$totalTime);
    echo $result;
  }

  //记录学习时间
  public function timeupdate(){
     	$c_id = $this->input->post('course_id');
		$l_id = $this->input->post('lesson_id');
		$currentTime = floor($this->input->post('currentTime'))?floor($this->input->post('currentTime')):0;
//        echo $currentTime;die;
        $totalTime = floor($this->input->post('totalTime'));
        $this->course_member_model->par($c_id,$l_id,$currentTime,$totalTime);
		if (!empty($currentTime)) {
            $this->db->where(array('course_id'=>$c_id,'lesson_id'=>$l_id,'user_id'=>$_SESSION['user']['id']))->update('course_learn',array('last_view_time'=>$currentTime));
        }


	    $this->db->where(array('course_id'=>$c_id,'id'=>$l_id))->update('course_lesson',array('video_time'=>$totalTime));

        echo  1;	
  }

  //文档类型  开始学习时间
  public function document()
  {
  	$c_id = $this->input->post('course_id');
	$l_id = $this->input->post('lesson_id');
  	$time = $this->input->post('time');
  	$res = $this->course_learn_model->exp($c_id,$l_id);
  	
  	if (empty($res)) {
  		$req = $this->course_learn_model->add($c_id,$l_id,$time);
  	}else {
  		$req = $this->db->where(array('course_id'=>$c_id,'lesson_id'=>$l_id,'user_id'=>$_SESSION['user']['id']))->update('course_learn',array('start_time'=>$time,'status' => 'learning','finished_time' => 0));
  	}
  	   return $req;
  }

  //文档类型  记录结束时间  修改状态
  public function endTime ()
  {
  	$c_id = $this->input->post('course_id');
	$l_id = $this->input->post('lesson_id');
  	$time = $this->input->post('time');
  	$finished_time = time();
  	
  	$res = $this->course_learn_model->study_type($c_id,$l_id);
  	
  	if ($finished_time - $res['start_time'] > 60) {
  		$this->db->where(array('course_id'=>$c_id,'lesson_id'=>$l_id,'user_id'=>$_SESSION['user']['id']))->update('course_learn',array('last_view_time'=>$finished_time,'status'=> 'finished','finished_time' => $time));
  		$this->course_member_model->update($c_id,$l_id,$finished_time,1);
  		echo 1;
  	}else {
  		$this->db->where(array('course_id'=>$c_id,'lesson_id'=>$l_id,'user_id'=>$_SESSION['user']['id']))->update('course_learn',array('last_view_time'=>$time,'status'=> 'learning'));
  		$this->course_member_model->update($c_id,$l_id,$finished_time,2);
  		echo 1;
  	}
  }

	//退出系统 
	public function logout(){
		$this->user_model->delete_out($_SESSION['user']['id']);
		$this->session->sess_destroy();
		redirect(site_url());
	}
}

