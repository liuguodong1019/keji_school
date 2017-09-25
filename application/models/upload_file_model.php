<?php
class Upload_file_model extends CB_Model {
	protected $table = 'upload_file';
	public function add($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function get_list($id,$p,$s,$target){
		$this->db->select("f.id,f.filename,f.type,f.size,f.create_time,f.usedCount,f.ext,u.nickname")->from($this->table." f")
				 ->join("cb_user u",'u.id= f.create_id')
				 ->where('f.is_public',1)
				 ->where('f.target_id',$id)
				 ->where('f.target',$target)
				 ->limit($p,$s);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}
	public function get_list_count($id,$target){
		$this->db->select("count(id) as c")->from($this->table)
				 ->where('is_public',1)
				 ->where('target_id',$id)
				 ->where('target',$target);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array()['c'];
		}
	}
	public function get_c_f($id,$type,$target){
		$this->db->select("id,filename,size,create_time")->from($this->table)->where_in('ext',$type)
		->where('target_id',$id)->where('target',$target);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}
	
	public function get_message($id){
		$this->db->select("id,target_id,target,filename,hashname,ext,type,size,create_time")->from($this->table)->where(array('id'=>$id)); 
		$query = $this->db->get();		
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}
	
	public function download($filemessage){
		$filepah = "./public/home/file/".$filemessage[0]['hashname'];
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filemessage[0]['filename'].'');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filepah));
		readfile($filepah);		
	}
	
	/*
	** 更新资料的使用状态
	*/
	public function updatestatus($id,$action){
		if($action == "plus"){
		$sql = "update cb_upload_file set usedCount=usedCount+1 where id ={$id}";		
		}else{
		$sql = "update cb_upload_file set usedCount=usedCount-1 where id ={$id}";	
		}
		$this->db->query($sql);
		return;
	}
}