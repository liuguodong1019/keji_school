<?php

class Category_model extends CB_Model {
	protected $table = 'category';
	//首页面显示分类标签
	function get_list($type){
		$this->db->select("id,title,icon,description")->from($this->table)->where('type',$type)->or_where('type','alles')->order_by('num','desc')->limit(28);
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}
	//网站分类数据总数
	public function get_all_data_count(){
		$this->db->select('id')->from($this->table);					
		$data = $this->db->count_all_results();
		return $data;	
	}	
	//网站分类数据列表
	public function get_all_data($page,$start){
		$this->db->select('id,title,type,description,icon,num,create_time')->from($this->table);		
		$this->db->order_by('create_time','desc')
				 ->limit($page,$start);
		$query = $this->db->get();
		if($query->num_rows()>0){	
			return $query->result_array();
		}
	}		
	
	//获取分类名称
	function get_category($id){
		$this->db->select('title')->from($this->table)->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			 return $q->row_array()['title'];
		}
		return '';
	}

	//获取分类信息
	function get_one($id){
		$this->db->select('id,title,type,description,icon,num,create_time')->from($this->table)->where('id',$id);
		$q = $this->db->get();
		if($q->num_rows()>0){
			 return $q->row_array();
		}
	}	
	
	//获取分类ID
	function get_categoryid($icon){
		$this->db->select('id,title')->from($this->table)->where('icon',$icon);
		$q = $this->db->get();
		if($q->num_rows()>0){
			 return $q->row_array()['id'];
		}
		return '';
	}	
}