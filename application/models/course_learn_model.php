<?php
class Course_learn_model extends CB_Model
{
	protected $table = 'course_learn';

	//学习中心学习中和已完成
	public function learnedid($uid,$type,$page='',$start = ''){		
		$this->db->select('a.course_id,a.user_id,a.percent,a.finish_num,a.last_learn_lesson_id,b.id,b.about,b.pic,b.category_id,b.title')->from('course_member a')
		->join('course b','b.id = a.course_id');
		$this->db->where('a.user_id',$_SESSION['user']['id']);
		
		if ($type == 1) {
			$this->db->where('percent !=',100);
			$this->db->order_by('last_learn_time',DESC)->limit($page,$start);
		
		}else {
			$this->db->where('percent',100);
			$this->db->order_by('last_learn_time',DESC)->limit($page,$start);
		}

		$query = $this->db->get();
		
		if ($query->num_rows()>0) {
			$array = $query->result_array();
			return $array;
		}
		return '';

	}

	//修改学习状态与学习所占百分比
	public function up_learn_status($c_id,$l_id,$test = '',$totalTime){
		$tim = time(); 
		$su = $this->course_learn_model->sum($c_id);
		$bf = floor(100/$su);
		$cmid = $test['id'];
		$par = $test['percent'];
		$this->load->model('course_member_model');
		$lat = $this->course_member_model->les($c_id,$l_id);
		$lat_time = $lat['last_view_time'];
		
		$this->db->select('status')
		         ->from('course_learn')
		         ->where('course_id',$c_id)
		         ->where('user_id',$_SESSION['user']['id'])
		         ->where('lesson_id',$l_id);
		$query = $this->db->get();
		$this->load->model('course_lesson_model');
		
		 if($query->num_rows()>0){
		 	$data = $query->row_array();
		 	if($data['status'] == "finished"){
				$new_par = $par-floor($lat_time/floor($totalTime/$bf));
				$finish_num = $this->course_member_model->finish($c_id);
				$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$tim,'percent' => $new_par,'finish_num' => $finish_num));

		 		$this->db->where(array('course_id'=>$c_id,'lesson_id'=>$l_id,'user_id'=>$_SESSION['user']['id']))->update($this->table,array('status'=>"learning",'finished_time'=>'','last_view_time' => $tim));
		 		return 2;
		 	}else{
		 		$new_par = ($par-floor($lat_time/floor($totalTime/$bf)))+$bf;
		 		$finish_num = $this->course_member_model->finish($c_id);
		 		$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$tim,'percent' => $new_par,'finish_num' => $finish_num));
				$this->up_status($c_id,$l_id);
				return 1;
			 }
		 }
	}
    
    public function study_type ($c_id,$l_id)
    {
    	$this->db->select('id,start_time,status')->from($this->table)->where('course_id',$c_id)->where('lesson_id',$l_id);
    	$this->db->where('user_id',$_SESSION['user']['id']);
    	$query = $this->db->get();
    	$res = $query->row_array();
    	return $res;
    }

	public function up_status($c_id,$l_id){		
		return $this->db->where(array('course_id'=>$c_id,'lesson_id'=>$l_id,'user_id'=>$_SESSION['user']['id']))->update($this->table,array('status'=>"finished",'finished_time'=>time(),'last_view_time'=>'0'));
	}
	
	//学习完成的数据
	public function user_finish_count($cid,$uid,$status="finished"){
		$this->db->select('id')
		         ->from('cb_course_learn')
		         ->where('user_id',$uid)
		         ->where('status',$status)
		         ->where('course_id',$cid);
		return $this->db->count_all_results();
	}

	//学习中的数据
	public function learning($cid,$uid,$status="learning"){
		$this->db->select('id')
		         ->from('cb_course_learn')
		         ->where('user_id',$uid)
		         ->where('status',$status)
		         ->where('course_id',$cid);
		return $this->db->count_all_results();
	}

	//查看课程下是否学习过课时
	public function is_exist($cid,$arr,$l_id = '') 
	{
		$this->load->model('course_lesson_model');
		if (!empty($l_id)) {
			
				$this->db->select('id,lesson_id')->from($this->table)->where_in('lesson_id',$arr);
				$this->db->where('user_id',$_SESSION['user']['id']);
				$this->db->where('course_id',$cid);
				$this->db->order_by('start_time', 'DESC');
				$query = $this->db->get();
				$learn_id = $query->row_array()['id'];
				$last_view_time = time();
				
				return $query->row_array()['lesson_id'];
		}else {
			return $arr[0];
		}
		
	}


	public function exp ($c_id,$l_id)
	{
		$this->db->select('id,lesson_id')->from($this->table)->where('lesson_id',$l_id);
		$this->db->where('course_id',$c_id);
		$this->db->where('user_id',$_SESSION['user']['id']);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return true;
		}
		return false;
	}


	public function add ($c_id,$l_id,$time)
	{
		$data = array(
			'user_id' 	=> $_SESSION['user']['id'],
			'course_id' => $c_id,
			'lesson_id' => $l_id,
			'status' 	=> 'learning',
			'start_time'=> $time
			);
		
		return $this->db->insert($this->table,$data);
	}

	public function sum ($cid)
	{
		$sum = $this->db->select('id')->from('course_lesson')
		->where('course_id',$cid)->count_all_results();
		return $sum;
	}
}