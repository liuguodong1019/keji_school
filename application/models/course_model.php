<?php

class Course_model extends CB_Model {
	protected $table = 'course';
	
	public function get_course($id){
		//$this->load->model("course_chapter_model");
		$this->db
			->select("id,title,about,pic,student_num")
			->from("course")
			->where("id",$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}	
	
	public function get_lst($page="",$start="",$tage="") {

		$this->load->model("course_lesson_model");
		$this->load->model("category_model");
		if(!empty($tage)){
			$tage = $this->category_model->get_categoryid($tage);
		}
		$this->db
			 ->select("c.id,c.title,c.pic,c.student_num,c.about")
			 ->from("course c")
			 ->where('c.status','1')->where('c.student_num >','0');
		if(!empty($tage)){
			$this->db->where('c.category_id',$tage);
		}
		$this->db->limit($page,$start);
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach ($query->result_array() as &$v) {
			   $v['lid'] = $this->course_lesson_model->course_lesson_first($v['id']);//获取第一课时
			}

			return $query->result_array();
		}
	}	
	
	public function get_lst_count($tage){
		$this->load->model("category_model");
		if(!empty($tage)){
			$tage = $this->category_model->get_categoryid($tage);
		}
		$this->db
			 ->select("c.id")
			 ->from("course c")
			 ->where('c.status','1')->where('c.student_num >','0');
		if(!empty($tage)){
			$this->db->where('c.category_id',$tage);
		}

		return  $this->db->count_all_results();

	}
	public function course_title($id){
		$this->db->select('title')->from($this->table)->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array()['title'];
		}
		return $id;
	}  
	
	public function add($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();	
	}
	
    public function get_list() {
		$this->db
			 ->select("id,title,pic,student_num,about,mubiao")
			 ->from("course")
			 ->where('status','1')
			 ->order_by('update_time','desc')
			 ->limit(9);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}

	public function get_course_info($c_id){
		$this->db->select("about,outline,lianzai")->from($this->table)->where('id',$c_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$data[0]=$query->row_array();
			
		}
		return $data;

	}
 
	public function get_course_cat($id){
			$this->db
			->select("t.title")
			->from("course c")
			->join("category t","t.id=c.category_id")
			->where("c.id",$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}

	function get_course2($id){
		$this->db->select("c.id as c_id,c.pic,c.title,c.status")->from($this->table." c")
				 ->where("c.id",$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}		 
	}
	//
	public function msg($id){
		$this->db->select("id,title,about,pic,category_id,student_num")->from($this->table)
			     ->where("id",$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}		
	}
	public function update_($data,$id){
		$this->db->where("id",$id)->update($this->table,$data);
	}
	//
	public function up_tag($d,$id){
		return $this->db->where('id',$id)->update($this->table,array('tag_id'=>$d));
	}
	public function get_tag($id){
		$this->db->select("tag_id")->from($this->table)->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $this->tag(json_decode($query->row_array()['tag_id']));
			
		}
	}

	public function tag($a){
		$this->db->select("id,title")->from("tag")->where_in('id',$a);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}
	public function update_pic($id,$n){
		$this->db->select('pic')->from($this->table)->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows>0){
			if($query->row_array()['pic']!=='course.jpg'){
				unlink("./public/home/images/{$n}");
			}
		}
		return $this->up_pic($id,$n);
	}
	function up_pic($id,$n){
		return $this->db->where('id',$id)->update($this->table,array('pic'=>$n));
	}

	/////////
	public function course_data($id){
		//$this->db->select("c.learner_num,")
	}
    
	//我的课程
	public function my_course(){
		$this->db->select();
	}
	//课程介绍
	public function get_info($c_id){
		$this->db->select('*')->from($this->table)->where('id',$c_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}
	}

	public function sys_course_count($type,$category,$course_name,$recommended=""){
		$this->db->select('c.id')->from($this->table." c")
				 ->join("user u","u.id = c.create_id");
		if(!empty($category)){		 
			$this->db->where('c.category_id',$category);		
		}	
		if(!empty($course_name)){		 
			$this->db->like('c.title', $course_name,'both');			
		}	
		if(!empty($recommended)){
			$this->db->where('c.recommended	',$recommended);	
		}			
		$data = $this->db->count_all_results();
		return $data;	
	}	

	//我在学的课程
	public function sys_course_list($type,$page,$start,$category,$course_name,$recommended=""){

		$this->load->model('category_model');
		$this->load->model('course_lesson_model');
		$this->db->select('c.id,c.title,c.about,c.status,c.create_id,c.create_time,c.category_id,c.student_num,u.nickname,c.recommended')->from($this->table." c")
				 ->join("user u","u.id = c.create_id");

		if(!empty($category)){		 
			$this->db->where('c.category_id',$category);		
		}	
		if(!empty($course_name)){
			$this->db->like('c.title', $course_name,'both');			
		}	
		if(!empty($recommended)){
			$this->db->where('c.recommended	',$recommended);	
		}

		$this->db->order_by('id','desc')->limit($page,$start);
		$query = $this->db->get();

		if($query->num_rows()>0){
			foreach($query->result_array() as &$q){
				$q['category'] = $this->category_model->get_category($q['category_id']);
				$q['lid'] = $this->course_lesson_model->course_lesson_first($q['id']);//获取第一课时
				//$q['lesson'] = $this->course_lesson_model->course_lesson($q['id']);//课程下的课时数
			}
			return $query->result_array();
		}
	}	
	
}