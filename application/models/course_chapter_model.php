<?php

class Course_chapter_model extends CB_Model {
	protected $table = 'course_chapter';
	public function add_item($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
	public function find_one($id){
		$this->db->select("id,title,seq,type,parent_id")->from($this->table)->where('id',$id); 
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}			
	}
	
	/*
	** 第几章
 	*/
	public function chapter_seq($cid,$id){
		
		$chap = $this->find_one($id);
		$chapter = $chap['title'];		
		
		$course_chapter = $this->get_chapter($cid);
		$arr = array();
		if(!empty($course_chapter)){			
			foreach($course_chapter as $key=>$val){
				$arr[$key+1] =$val['id']; 
			}
		}
		if(!empty($arr)){
			$s = array_search($id,$arr);
			return '第'.$s.'章'.' '.$chapter;
		}	
	}
	
	/*
	** 第几节
	*/
	public function unit_seq($pid,$id,$title){
		$course_chapter = $this->findunitdata($pid);
		$arr = array();
		if(!empty($course_chapter)){
			foreach($course_chapter as $key=>$val){
				$arr[$key+1] =$val['id']; 
			}
		}
		if(!empty($arr)){
			$s = array_search($id,$arr);
			return '第'.$s.'节'.' '.$title;
		}
	}
	/*
	** 查询课程下的所有章节
	*/
	public function findchapterdata($cid){
		$this->db->select("id,course_id,title")->from($this->table)
			 ->where('course_id',$cid)->where('type','chapter')
			 ->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}

	/*
	** 取出课程下的第一章
	*/

	public function findchapterfirst($cid){
		$this->db->select("id,course_id,title")->from($this->table)
			 ->where('course_id',$cid)->where('type','chapter')
			 ->order_by('seq','asc')
			 ->limit(1);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}		
	}
	
	/*
	** 取出课程下的最后一章
	*/

	public function findchapterlast($cid){
		$this->db->select("id,course_id,title")->from($this->table)
			 ->where('course_id',$cid)
			 ->order_by('seq','desc')
			 ->limit(1);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array()['title'];
		}
		return '';
	}
	/*
	** 查询课程下的所有章节
	*/
	public function firstchapterdata($cid){
		$chapter = $this->findchapterfirst($cid);
		$data = $this->findunitdata($chapter['id']);
		return $data;
	}	

	/*
	** 根据ID查询出所有章下的节
	*/
	public function findunitdata($chapterid){
		$this->db->select("id,course_id,title")->from($this->table)
			 ->where('parent_id',$chapterid)->where('type','unit')
			 ->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}		
	}
	
	public function get_chapter($c_id){
		$this->db->select('title,seq,id')->from('course_chapter')->where(array('course_id'=>$c_id,'type'=>'chapter'))->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}

	/*
	** 根据ID查询出所有章下的节
	*/
	public function findalltdata($chapterid){
		$this->db->select("id,course_id,title")->from($this->table)
			 ->where('parent_id',$chapterid)->or_where('id',$chapterid)
			 ->order_by('seq','asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$res = $query->result_array();
			$arr = array();
			foreach($res as $key=>$value){
				$arr[] = $value['id'];
			}
			return $arr;
		}		
	}
	
	
}