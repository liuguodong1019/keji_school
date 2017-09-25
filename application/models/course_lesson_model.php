<?php

class Course_lesson_model extends CB_Model {
	protected $table = 'course_lesson';
	
	//获取课程下的第一课时
	public function course_lesson_first($cid){
		$this->db->select('id')->from($this->table)->where("course_id",$cid)->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array()['id'];
		}
	}	
	
	
	//课程课时列表
	public function get_chapter_lesson_byseq($c_id){
		$this->db->select("id,title,type,status,seq,chapter_id,resource_type,video_time")->from($this->table)->where('course_id',$c_id)->order_by("seq",'asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}		
	

/*
	//课程课时列表
	public function get_chapter_lesson_byseq($id){

		$sql="select id,title,type,status,seq,chapter_id,resource_type,video_time from cb_course_lesson where course_id ={$id} union select id, title,type,number,seq,parent_id,course_id,create_time from cb_course_chapter where course_id ={$id}";

		$q = $this->db->query($sql);
		if($q->num_rows()>0){
			$data = $this->seq_sort($q->result_array());

			$c = count($data);
			$parent_id = 0;	
			$k = 0;
			for($i = $k;$i<$c;$i++){
				if($data[$i]['type']=="chapter"){
					$m =0;
					for($k = $i+1;$k<$c;$k++){
						if($data[$k]['type']=='chapter'){
							break;
						}
						if($data[$k]['type']=="unit"){
							$n=0;
							$data[$i]['units'][$m] = $data[$k];
							unset($data[$k]);
							for($l=$k+1;$l<$c;$l++){
								if($data[$l]['type']=='chapter'){
									break 2;
								}
								if($data[$l]['type']=="unit"){
									break;
								}
								if($data[$l]['type']=="lesson"){
									$data[$i]['units'][$m]['lessons'][] = $data[$l];
									unset($data[$l]);
								}
								$n++;
							}
							$m++;
						}
						if($data[$k]['type']=='lesson'){
							$data[$i]['lesson'][] = $data[$k];
							unset($data[$k]);
						}
					}
				}
			}

			return $data;
		}			 
	}	

*/
	
	public function seq_sort($arr,$seq='seq'){
		$c_arr = count($arr);
		$temp = array();
			for ($i = 0; $i < $c_arr; $i++) {
				for ($j = 0; $j < $c_arr - $i - 1; $j++) {
					if ($arr[$j][$seq] > $arr[$j + 1][$seq]) {
						$temp = $arr[$j];
						$arr[$j] = $arr[$j + 1];
						$arr[$j + 1] = $temp;
					}
				}
			}
		return $arr;
	}	
	////////////////////////////////////////////////////////////////////////////
/* 	public function add_lesson($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	 */
	//获取课程下的课时
	public function is_exist($cid) 
	{
		$ron = array();
		$this->db->select('id')->from($this->table)->where('course_id',$cid)->order_by('id','asc');
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			$array = $query->result_array();
			foreach ($array as $key => $value) {
				$ron[] = $value['id'];
			}
			return $ron;
		}
	}

	public function add_lesson($data){
		$this->db->insert($this->table,$data);
		//更新课程数
		$this->load->model('course_model');
		$course = $this->course_model->msg($data['course_id']);
		$course_data['student_num'] = $course['student_num']+1;
		$this->db->where("id",$data['course_id'])->update('course',$course_data);
		return $this->db->insert_id();
	}	
	
	
    
    public function points_sum($c_id){
      $this->db->select('sum(points) as points')->from($this->table)->where('course_id',$c_id);
      $query = $this->db->get();
      if($query->num_rows()>0){
      	return $query->row_array();
      }
    }
	public function get_lesson_chapter($id){
		$this->load->model("Course_chapter_model");
		$unit = $this->course_chapter_model->findunitdata($id);
		$arr = array();
		foreach($unit as $key=>$value){
			$arr[] = $value['id'];
		}
		$data = $this->chapter_lesson($arr);
		return $data;
	}
	
	public function get_les_info($l_id){
		$this->db->select('id,title')->from($this->table)->where('id',$l_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}
	}


	// 获取课时为第几课时
	public function lessonseq($cid,$lid){
		$arr = $this->lesson_sort_seq($cid);
		if(!empty($arr)){
			$s = array_search($lid,$arr);
			return $s;
		}	
	}
	
	//课时排序列表
	public function lesson_sort_seq($cid,$status=""){
		$lesson = $this->get_pre($cid,$status);
		$arr = array();
		if(!empty($lesson)){
			foreach($lesson as $key=>$val){
				$arr[$key+1] = $val['id'];
			}
		}

		return $arr;
	}
	
	//获取上一课时  下一课时
	public function lesson_brother($cid,$lid,$r){
		$arr = $this->lesson_sort_seq($cid,'');

		if(!empty($arr)){
			$now = array_search($lid,$arr);
			if($r == 'last'){
				$num = ($now-1)>=1?$now-1:'';
			}else{
				$num = ($now+1)<=$arr[count($arr)]?$now+1:'';	
			}
			return !empty($num)?$arr[$num]:'';
		}	
	}	


	//课程下的课时个数
	public function course_lesson($cid){
		$this->db->from($this->table)->where("course_id",$cid);
		$data = $this->db->count_all_results();
		return $data;
	}	
	

	/*
	** 取出章下的课时
	*/	
	public function chapter_lesson($id){
		$this->db->select('title,seq,id')->from($this->table)->where_in('chapter_id',$id)->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}	
	}	

	/*
	** 取出节下的课时
	*/	
	public function get_lesson_unit($id){
		$this->db->select('title,seq,id')->from($this->table)->where('chapter_id',$id)->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}	
	}		
	
	public function add_lesson_select($data){
		$this->db->insert('cb_course_lesson_testpaper',$data);
		return $this->db->insert_id();
	}		
	
	//修改课时发布状态
	public function up_status($l_id,$status){
		return $this->db->where('id',$l_id)->update('course_lesson',array('status'=>$status));
	}
	
	public function find_one($id){
		$this->db->select("course_id,status,title,media_id")->from("course_lesson")->where('id',$id); 
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}			
	}
	
	public function get_lesson($c_id,$l_id){
		$this->db->select("id as l_id,title,course_id,chapter_id,l_abstract,type,resource_type,media_source,content,video_time,media_id,media_name,media_url")
		->from($this->table)->where("id",$l_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$res = $this->db->select('last_view_time')->from('course_learn')->where('lesson_id',$l_id)->where('user_id',$_SESSION['user']['id'])->get()->row_array();
			
			$data[0] = $query->row_array();
			$data[0]['last_view_time'] = $res['last_view_time'];
			
			if($data[0]['media_source']){
				$this->db->select("filename,hashname,ext,type,size")->from("upload_file")->where('is_public',1)->where("id",$data[0]['media_id']);
				$query2 = $this->db->get();
				if($query2->num_rows()>0){
					$data[1] = $query2->row_array();
				}
			}
		}
		return $data;
	}



	function update_lesson($l_id,$data){
		return $this->db->where('id',$l_id)->update($this->table,$data);
	}

	//管理课时时获取章节
	public function get_chapter_lesson($id){
		$this->db->select("seq,id,type,course_id,title,chapter_id,resource_type,status,video_time,points")->from("course_lesson")->where('course_id',$id); 
		$query = $this->db->get();
		$lessons = $query->result_array();
		return $this->seq_sort($lessons,'seq');

	}
	public function chapter_seq($id,$s,$p){
		$this->db->where('id',$id)->update("course_chapter",array('parent_id'=>$p,'seq'=>$s));
	}
	public function lesson_seq($id,$s,$p){
		$this->db->where('id',$id)->update("course_lesson",array('chapter_id'=>$p,'seq'=>$s));
	}

	
	public function get_lesson_question($c_id){
		$this->db->select("id,title")->from($this->table)->where('course_id',$c_id)->order_by("seq");
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}

	
	function update_testpaper($l_id,$data){
		return $this->db->where('id',$l_id)->update($this->table,$data);
	}		
	
	function update_lesson_select($l_id,$data){
		return $this->db->where('id',$l_id)->update('cb_course_lesson_testpaper',$data);
	}	
	
	function get_one_testpaper($id){
		$this->db->select('id,lesson_id,chapter_id,unit_id')->from('cb_course_lesson_testpaper')->where(array('id'=>$id));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}	
	}

	public function get_pre($c_id,$status=""){
		$this->db->select('*')->from($this->table)->where('course_id',$c_id);
		if(!empty($status)){
			$this->db->where('status',$status);
		}
		$this->db->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}	
		
}