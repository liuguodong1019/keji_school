<?php

class Course_member_model extends CB_Model {
	protected $table = 'course_member';
	//我在学课程
	public function study_course(){
		$this->db->select("c.id,c.title,c.open,c.is_join")->from($this->table." m")
				 ->join("course c","c.id = m.course_id")
				 ->where('m.user_id',$_SESSION['user']['id'])
				 ->order_by("m.create_time",'desc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}		
	}

    //学习课程记录
	public function add ($c_id,$l_id,$time = '',$num = 0) 
	{
		$data = array(
				'course_id' => $c_id,
				'user_id' => $_SESSION['user']['id'],
				'last_learn_lesson_id' => $l_id,
				'last_learn_time' => $time,
				'is_lock' => $_SESSION['user']['is_lock'],
				'create_time' => time(),
				'percent' => $num
			);
		// print_r($data);die;
		return $this->db->insert($this->table,$data);
	}

	//更新课程文档类型学习记录
	public function update ($c_id,$l_id,$time,$num)
	{   
		$this->load->model('course_learn_model');
		$finish_num = $this->finish($c_id);
		$su = $this->course_learn_model->sum($c_id);
		$bf = floor(100/$su);
		$time = time();
		$test = $this->is_exist($c_id);
		$lid = $test['last_learn_lesson_id'];
		$par = $test['percent'];
		$cmid = $test['id'];
		if (empty($test)) {
		    if ($num == 1) {
                $this->add($c_id,$l_id,$time,$bf);
            }else {
                $this->add($c_id,$l_id,$time);
            }
		}else {
			$str = $this->all_par($c_id,$l_id,$test);
			if ($num == 1) {
				if ($str >= 100) {
					$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'last_learn_lesson_id' => $l_id,'percent' => $bf,'finish_num' => $finish_num));
				}else {
					$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'last_learn_lesson_id'=>$l_id,'percent' => $par+$bf,'finish_num' => $finish_num));
				}
			}else {
					$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'last_learn_lesson_id'=>$l_id,'finish_num' => $finish_num));
			}
		}
	}
    
    //记录音频视频百分比
	public function par ($c_id,$l_id,$currentTime,$totalTime)
	{	

		$this->load->model('course_learn_model');
		
		$su = $this->course_learn_model->sum($c_id);
		$bf = floor(100/$su);
		$time = time();
		$finish_num = $this->finish($c_id);

		$test = $this->is_exist($c_id);
		$lid = $test['last_learn_lesson_id'];
		$par = $test['percent'];
		$cmid = $test['id'];
		if (empty($test)) {

            $part = floor($currentTime/($totalTime/$bf));
			$this->add($c_id,$l_id,$time,$part);
		}else {
			$lat = $this->les($c_id,$l_id,$currentTime);
			$lat_time = $lat['last_view_time'];

			$num = floor($currentTime/(floor($totalTime/$bf)));
			if ($num<=0) {
				$num = 0;
			}
			$str = $this->all_par($c_id,$l_id,$test);
			if ($str >= 100) {
				$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'percent' => $num,'last_learn_lesson_id'=>$l_id));
			}else {

				if ($lat_time == $currentTime) {
					$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'last_learn_lesson_id'=>$l_id));
				}
				// if ($lat_time > $currentTime){
				// 	$old_time = $lat_time-$currentTime;
				// 	$num = floor($old_time/(floor($totalTime/$bf)));
				// 	$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'percent' => $par-$num,'last_learn_lesson_id'=>$l_id));
				// }else {
					if ($currentTime == $totalTime) {
						$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'last_learn_lesson_id'=>$l_id));
					}else {
					$new_par = $par-(floor($lat_time/floor($totalTime/$bf))) + $num;
					// echo $new_par;die;
						$this->db->where('id',$cmid)->update('course_member',array('last_learn_time'=>$time,'percent' => $new_par,'last_learn_lesson_id'=>$l_id));
					}
					
				// }
			}			
		}
		$this->course_member_model->rewit($cmid,$c_id);
	}

	//查询百分比状态
	public function all_par ($c_id,$l_id,$test = '') {
		$lid = $test['id'];
		$percent = $this->db->select('percent')->from($this->table)
		->where('id',$lid)
		->get()->row_array();
		return $percent['percent'];
	}
	
	//是否学习过此课程
	public function is_exist ($c_id)
	{
		$res = $this->db->select('id,last_learn_lesson_id,percent')->from($this->table)
		->where('course_id',$c_id)->where('user_id',$_SESSION['user']['id'])->get();
		if ($res->num_rows() > 0) {
			return $res->row_array();
		}
		return false;
	}

	//最后学习时间
	public function les ($c_id,$lid,$currentTime = '')
	{
		$lat_time = $this->db->select('id,last_view_time,status')->from('course_learn')
		->where('course_id',$c_id)->where('lesson_id',$lid)
		->where('user_id',$_SESSION['user']['id'])->get()->row_array();
		return $lat_time;
	}

	//学习完成课时
	public function finish ($c_id)
	{
		$this->load->model('course_learn_model');
		$finish_num = $this->course_learn_model->user_finish_count($c_id,$_SESSION['user']['id']);
		return $finish_num;
	}

	//课时学习完成数量
	public function rewit ($id,$cid)
	{
		$finish_num = $this->finish($cid);
		$this->db->where('id',$id)->update($this->table,array('finish_num' => $finish_num));
	}
}