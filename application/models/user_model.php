<?php
class User_model extends CB_Model {
	protected $table = 'user';

	public function get_user_count($search){
		$this->db->select('count(a.id) as sum')->from($this->table.' a')->where('roles !=','admin');
		if(!empty($search)){		 
			$this->db->like('email', $search,'both');
			$this->db->or_like('nickname', $search,'both');				
		}		
		$data = $this->db->count_all_results();
		return $data;
	}
    
 
	public function get_user_list($p,$s,$search){
		$this->db->select('id,email,roles,nickname,is_lock,login_time,login_ip')->from($this->table.' a')->where('roles !=','admin');
		if(!empty($search)){		 
			$this->db->like('email', $search,'both');	
			$this->db->or_like('nickname', $search,'both');				
		}
		$this->db->order_by('id','desc');
		$this->db->limit($p,$s);		
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}
	//检查登录用户
    public function check_logins($info,$pas) {
		
		 $this->db->select()->from($this->table)->where('password',$pas)->where('email',$info)
		 ->or_where('nickname',$info);
		 $query = $this->db->get()->row_array();

         if($query){
			return $query;
         }else{	 
         	return false;
         }
    }	
	
	//获取用户信息
    public function get_user_message($u_id){
    	$this->db->select('id,nickname,email,password,roles,nation,birth_date,id_card,moblie,address,sex')
    	         ->from($this->table)->where('id',$u_id);
        $q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row_array();
		}
	}	


	//根据邮箱获取用户信息
    public function email_message($email){
    	$this->db->select('id,nickname')
    	         ->from($this->table)->where('email',$email);
        $q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row_array();
		}
	}	


	// 注册
    public function sign ($data)
    {
    	$data['login_time'] = time();
		$data['login_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['roles'] = 'student';
		$data['password'] = md5($data['password']);
		$data['headpic'] = site_url('public/home/images/morenphoto.jpg');
      if ($this->db->insert($this->table,$data)) {
      	return true;
      }
      return false;
    }

    /**
     * 检查邮箱或者身份证注册过没有
     */
    public function inspe ($res = '')
    {
    	$this->db->select('id')->from($this->table)->where('email',$res);
    	$query = $this->db->get();
    	if ($query->num_rows()>0) {
    		return true;
    	}
    	return false;
    }

    public function inspe1 ($card = '')
    {
    	$this->db->select('id')->from($this->table)->where('id_card',$card);
    	$query = $this->db->get();
    	if ($query->num_rows()>0) {
    		return true;
    	}
    	return false;
    }

   //更新登录ip和时间
	public function update_user($u_id,$data){
		return $this->db->where('id',$u_id)->update($this->table,$data);
	}	
	//更新密码
	public function update_user_password($id,$data){
		return $this->db->where('id',$id)->update($this->table,$data);
	}

	//判断邮箱是否注册过
	public function check_user_isset($email){
			$this->db->select("id,email,password,nickname")->from($this->table)->where("email",$email);
			$query = $this->db->get();
			if($query->num_rows()>0){
				return $query->row_array();
			}	
			return '';
	}
	
 	
	////////////////////////////////////////////////////////////////////////////////////
	

	

	public function check_name($nickname){
		 $this->db->select("id")->from($this->table)->where('nickname',$nickname);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array()['id'];
		}else{return 0;}
	}
	

	public function check_user($loginmes,$nickname){
		$this->db->select("u.id,u.nickname")->from($this->table." u")
				 ->join("user_msg m","m.user_id = u.id",'left')
				 ->where('u.email',$loginmes)
				 ->or_where('u.nickname',$loginmes)
				 ->or_where('m.moblie',$loginmes)
				 ->or_where('u.nickname',$nickname);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}		
	}

    public function get_stu($u_id){
    	$this->db->select('id,nickname,email,password')
    	         ->from($this->table)->where('id',$u_id);
        $q = $this->db->get();
		if($q->num_rows()>0){
			return $q->row_array();
		}
	}
	

    public function del_user($u_id){
    	return $this->db->where('id',$u_id)->delete($this->table);
    }

    //添加个人信息
    public function add_user($data){
           
        $this->db->insert($this->table,$data);
     
    	return $this->db->insert_id();	
    }

    // 修改个人信息
    public function up_user ($data)
    {
    	return $this->db->where('id',$_SESSION['user']['id'])->update($this->table,$data);
    }

    //获取当前头像
    public function get_headpic(){
		$this->db->select("headpic")->from($this->table)->where("id",$_SESSION['user']['id']);
		return $query = $this->db->get()->row_array()['headpic'];
	}

	//修改头像
	public function update_headpic($id,$n){
		
		return $this->db->where("id",$id)->update($this->table,array("headpic"=>$n));
	}


	//检验密码
	function check_($data){
		$this->db->select("id")->from($this->table)->where("id",$data['id'])->where("password",$data['mima']);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array()['id'];
		}
	}

	//修改密码
	function xiugai($data){
		$this->db->select("id")->from($this->table)->where("password",$data['old'])->where("id",$_SESSION['user']['id']);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $this->db->where("id",$_SESSION['user']['id'])->update($this->table,array("password"=>$data['new']));
		}
	}


	//删除退出用户信息
	public function delete_out($uid){
		$this->db->where("user_id",$uid)->delete('cb_user_onlinie');	
	}

	//禁止用户
	public function lock_user($u_id){
		$this->db->select('is_lock')->from($this->table)->where('id',$u_id);
		 $query = $this->db->get()->row_array()['is_lock'];
		 if($query==0){
		 	return $this->db->where('id',$u_id)->update($this->table,array('is_lock'=>'1'));
		 }else{
		 	return $this->db->where('id',$u_id)->update($this->table,array('is_lock'=>'0'));
		 }
		
	}

	public function up_ip($ip){
		return $this->db->where('id',$_SESSION['user']['id'])->update($this->table,array('login_ip'=>$ip,'login_time'=>time()));
	}

	public function get_list(){
	   $this->db->select('id,nickname,email,login_time,login_ip')->from($this->table);
	   $q = $this->db->get();
	   if($q->num_rows()>0){
	   	return $q->result_array();
	   }
	}



	/** 添加系统用户 **/
	public function excel_add_user($data){
 		
		$i = 1;
		foreach($data as $v){
			$res = $this->Check_validity($v);
			if(!empty($res)){
				$message = $res['message'];
			}else{
				   $time = time();
					
						$headpic = site_url('public/home/images/morenphoto.jpg');
						$ip = $_SERVER['REMOTE_ADDR'];
					
					$p = md5(123456);// 系统定义密码	
					$this->db->insert($this->table,array('nickname'=>$v['nickname'],'email'=>$v['email'],'password'=>$p,'roles'=>"student",'headpic' => $headpic,'create_time' => $time,'login_ip' => $ip,'moblie' => $v['moblie']));
								
					$message = "<font style='color:green;'>添加成功</font>";	
			}
			echo $i.'、'.$v['nickname'].'----'.$message.'<br />';
		$i++;	
		}
		
	}		
	
	public function Check_validity($v){
		
		$array = array();
		if(empty($v['email'])){
				$array['message'] = "<font style='color:red;'>添加失败，邮箱不可为空，请检查</font>";
		}else if(empty($v['nickname'])){
				$array['message'] = "<font style='color:red;'>添加失败，匿称不可为空，请检查</font>";
		}else if(!empty($v['moblie']) && !preg_match("/^1[34578]{1}\d{9}$/",$v['moblie'])){
				$array['message'] = "<font style='color:red;'>添加失败，手机格式不正确，请检查</font>";
		}else if(!preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/",$v['email'])){
				$array['message'] = "<font style='color:red;'>添加失败，邮箱格式不正确，请检查</font>";
		}else{
				$check = $this->check_user_isset1($v['email']);
				$check2 = $this->check_name($v['nickname']);
				$check3 = $this->check_mobile($v['moblie']);
				if(!empty($check)){
					$array['message'] = "<font style='color:red;'>添加失败，该邮箱己注册，请检查</font>";
					$array['id'] = $check['id'];
				}else if(!empty($check2)){
					$array['message'] = "<font style='color:red;'>添加失败，昵称己存在，请检查</font>";
					$array['id'] = $check2;
				}else if(!empty($v['moblie']) && !empty($check3)){
					$array['message'] = "<font style='color:red;'>添加失败，该手机己注册，请检查</font>";
					$array['id'] = $check3;
				}	
		}
		return $array;
	}
	
 	public function check_user_isset1($email){
			$this->db->select("id,email,password,nickname")->from($this->table)->where("email",$email);
			$query = $this->db->get();
			
			if($query->num_rows()>0){
				return $query->row_array();
			}	
			return '';
	}
		

	public function check_mobile($moblie){
		 $this->db->select("id")->from($this->table)->where('moblie',$moblie);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array()['id'];
		}else{return 0;}
	} 	
}

