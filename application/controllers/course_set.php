<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_set extends CB_Controller {
	function __construct() {
        parent::__construct();
		if(!$_SESSION['user']){show_error("先登录去");}
		$this->load->model("course_model");
		$this->load->model('course_lesson_model');
		$this->load->helper('lang_array');
		$this->load->helper("upload_img");
		$this->load->model('course_chapter_model');		
		$this->load->model('user_model');
		//$this->load->modal('notification_model');			
    }
    public function set(){
		return $this->setting_model->get_one("classroom");
    }

	public function item_text($id){
		$data['course'] = $this->course($id);
		$this->load->view("course_set/lesson_item_text",$data);
	}
	
	public function add_text_lesson($id){	
		$data['title'] = $this->input->post("title");
		$data['points'] = $this->input->post("points");
		$data['content'] = $_POST["l_content"];
		$data['resource_type'] = $this->input->post("resource_type");
		$data['create_time'] = time();
		$data['course_id'] = $id;
		$data['type'] = 'lesson';
		$data['create_id'] = $_SESSION['user']['id'];
		$data['chapter_id'] = $this->input->post('chapter_id');
		$data['seq'] = $this->course_lesson_model->course_lesson($data['course_id']);
		$i_id = $this->course_lesson_model->add_lesson($data);
		echo $this->new_lesson_str($data,$i_id);
	}	
	
	function update_text_lesson(){	
		$data['title'] = $this->input->post("title");
		$data['points'] = $this->input->post("points");
		$data['content'] = $_POST["l_content"];
		$i_id = $this->course_lesson_model->update_lesson(intval($_POST['l_id']),$data);	
	}	
	public function item_ppt($id){
		$data['course'] = $this->course($id);
		$this->load->view("course_set/lesson_item_ppt",$data);
	}
	public function item_document($id){
		$data['course'] = $this->course($id);
		$this->load->view("course_set/lesson_item_document",$data);
	}
	public function item_video($id){
		$data['course'] = $this->course($id);
		$this->load->view("course_set/lesson_item_video",$data);
	}
	public function item_audio($id){
		$data['course'] = $this->course($id);
		$this->load->view("course_set/lesson_item_audio",$data);
	}
	

	


	
	public function upliad_file_list($id){
		$this->load->model("upload_file_model");
		$type = array();
		$t = $this->input->get("type");
		if($t=='video'){
			$type = array('mp4','swf');
		}
		if($t=='ppt'){
			$type = array('ppt','pptx');
		}
		if($t=='document'){
			$type = array('docx','doc','xls','xlsx','pdf');
		}

		if($t=='audio'){
			$type = array('mp3');
		}

		$u_files = $this->upload_file_model->get_c_f($id,$type,'course_lesson');
		$str = '';
		 if($u_files){
			foreach($u_files as $f){
		$str .='
				<li class="clearfix" data-fid="'.$f['id'].'" onclick="choice_file(this);">
					<span class="filename">'.$f['filename'].'</span><span class="filesize">'.round($f['size']/1024,2) .'MB</span><span class="filetime">'.date('Y-m-d',$f['create_time']).'</span>
				</li>';
			}
		}
		echo $str;
	}

	
	public function add_lesson($c_id){//添加课时
		
		$data['course_id'] = intval($c_id);
		$data['type'] = 'lesson';
		$data['video_time'] = $this->input->post('video_time');
		$data['title'] = $this->input->post('title');
		$data['resource_type'] = $this->input->post('type');
		$data['points'] = $this->input->post('points');
		$data['media_source'] = $this->input->post("media_source");
		if(explode("[media]",$this->input->post('lesson_m'))[0]=='linkVideo'){
			$data['media_name'] = explode("_",explode("[media]",$this->input->post('lesson_m'))[1])[1];
			$data['media_url'] = $this->play_code($data['media_source'],explode("_",explode("[media]",$this->input->post('lesson_m'))[1])[2]);
		}else{
			$data['media_id'] = explode("[media]",$this->input->post('lesson_m'))[0];
			$data['media_name'] = explode("[media]",$this->input->post('lesson_m'))[1];
		}
		$data['create_id'] = $_SESSION['user']['id'];
		$data['create_time'] = time();
		$data['chapter_id'] = $this->input->post("chapter_id"); 
		$data['seq'] = $this->course_lesson_model->course_lesson($data['course_id']); 
	    $id = $this->course_lesson_model->add_lesson($data);
		//更新资料使用状态
		$this->load->model("upload_file_model");
		$this->upload_file_model->updatestatus($data['media_id'],"plus");
		echo $this->new_lesson_str($data,$id);
		
	}
	
	public function update_lesson(){
		
		$data['video_time'] = $this->input->post('video_time');
		$data['title'] = $this->input->post('title');
		$data['resource_type'] = $this->input->post('type');
		$data['points'] = $this->input->post('points');
		$data['media_source'] = $this->input->post("media_source");
		if(explode("[media]",$this->input->post('lesson_m'))[0]=='linkVideo'){
			$data['media_id'] = 0;
			$data['media_name'] = explode("_",explode("[media]",$this->input->post('lesson_m'))[1])[1];
			$data['media_url'] = $this->play_code($data['media_source'],explode("_",explode("[media]",$this->input->post('lesson_m'))[1])[2]);
		}else{
			$data['media_id'] = explode("[media]",$this->input->post('lesson_m'))[0];
			$data['media_name'] = explode("[media]",$this->input->post('lesson_m'))[1];
		}
	    echo $r = $this->course_lesson_model->update_lesson(intval($_POST['l_id']),$data);
		//echo $this->new_lesson_str($data,$id);
	}
	public function del_lesson(){
		//更新资料使用状态
		$this->load->model("upload_file_model");
		$data = $this->course_lesson_model->find_one($_POST['l_id']);
		if(!empty($data)){
			$this->upload_file_model->updatestatus($data['media_id'],"less");	
			$sql = "update cb_course set student_num=student_num-1 where id ={$data['course_id']}";	
			$this->db->query($sql);
		}
		$this->db->get("course_lesson");		
		echo $this->db->where('id',intval($_POST['l_id']))->delete("course_lesson");
	}
	public function del_chapter(){
		$this->db->get("course_chapter");
		echo $this->db->where('id',intval($_POST['c_id']))->delete("course_chapter");
	}
	public function update_lesson_a(){
		
		$data = $this->course_lesson_model->get_lesson('',intval($_POST['l_id']));
		$_SESSION['fen'] = explode(":",$data[0]['video_time'])[0];
		$_SESSION['miao'] = explode(":",$data[0]['video_time'])[1];
		echo json_encode($data);
	}
    public function get_d_info(){
    	$this->load->model("course_model");
    	$c_id = $this->input->post('c_id');
    	$data = $this->course_model->get_course_info($c_id);//var_dump($data['a']);

    	//$this->load->view("course_set/detailsinfo",$data);
    	echo json_encode($data);
    }
	public function new_lesson_str($data,$id){ /*添加课时-上传的内容*/
		$str = '';
		$str = '
				<li data-type="'.$data['type'].'" id="datalist'.$id.'" data-id="'.$id.'"'; $str .=' class="keshi-list-item course-test clearfix" >';
					$str .='<i class="left-point left-point-2"></i>';
					if($data['resource_type']=='video'){
						$str .='<span class="l_type l_type_video"></span>';
					}elseif($data['resource_type']=='text'){
						$str .='<span class="l_type l_type_text"></span>';
					}elseif($data['resource_type']=='ppt'){
						$str .='<span class="l_type l_type_ppt"></span>';
					}elseif($data['resource_type']=='document'){
						$str .='<span class="l_type l_type_document"></span>';
					}elseif($data['resource_type']=='audio'){
						$str .='<span class="l_type l_type_audio"></span>';
					}
					$str .='<div class="ks-title">';
					$str .='课时<span class="number">1</span>：'.$data['title'];
					$str .='</div>';
				$str .='<div class="operation-btns">
					<a class="btn-custom" onclick="update_lesson(this);" data-toggle="modal" data-target="#myModal4">
						<i class="glyphicon glyphicon-pencil"></i> 编辑
					</a>
					<a class="btn-custom" href="'.site_url().'course/lesson/'.$data["course_id"].'/'.$id.'" target="_blank">
						<i class="glyphicon glyphicon-eye-open"></i> 预览
					</a>
					<a class="btn-custom" href="javascript:void(0);" onclick="del_lesson(this);"><i class="glyphicon glyphicon-trash"></i> 删除</a>
				</div>';
		return $str;
		
	}
	
	//上传视频文件不带上传课时信息
	public function media($id){
		$config['allowed_types'] = "*";
		$info = $this->upload_file('Filedata',$config);
		if(is_array($info)){
			$l['media_id'] = $this->add_file($info,$id,"course_lesson");
			$l['media_name'] = $info['client_name'];
			echo $l['media_id']."[media]".$info['client_name'];
		}else{
			echo $info;
		}
		
	}
	
	public function media_lesson($id){
		$config['allowed_types'] = "*";
		$info = $this->upload_file('Filedata',$config);
		if(is_array($info)){
			$l['media_id'] = $this->add_file($info,$id,"lesson");
			$l['media_name'] = $info['client_name'];
			echo $l['media_id']."[media]".$info['client_name'];
		}else{
			echo $info;
		}
		
	}	
	
	//导入视频
	public function link_video($id){
		print_r($this->link_video_msg($this->input->post('video_link')));
	}
	public function play_code($type,$code){
		$str ='';
		if($type=='youku'){
			$str ='<iframe height=800 width=100% src="http://player.youku.com/embed/'.$code.'" frameborder=0 allowfullscreen></iframe>';
		}
		return $str;
	}
	public function link_video_msg($url){
		header('Content-type:text/html;charset=utf-8');
		$ch = curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$url); 
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch); 
		curl_close($ch);
		$info['media_source'] = explode(".",explode("com/",$url)[0])[1];
		if($info['media_source']=='youku'){
			$re = '/<meta\sname="irTitle"\scontent="(.*)"\s\/>/';
			preg_match_all($re,$data,$arr);
			$onlyid_r = '/id_(.*)\.html/';
			preg_match_all($onlyid_r,$url,$onlyid_ar);	
		}
		if($data && $arr[1][0] && $onlyid_ar[1][0] ){ 1==1;}else{return false;}
		$info['filename'] = $arr[1][0];
		return "linkVideo[media]".$info['media_source']."_".$info['filename']."_".$onlyid_ar[1][0];
	}
	//上传图文课时
	public function add_lesson_text(){
		
	}
	public function seq_lesson(){
		
		$c = count($_POST['lesson']);
		//AkyhxA
		$lesson = $_POST['lesson'];
		for($i = 0;$i<$c;$i++){
			$seq = $i;
			$id = explode('_',$lesson[$i])[0];
			$type = explode('_',$lesson[$i])[1];
			if($type=="lesson"){
				for($k = $i;$k>=0;$k--){
					$parent_id = 0;
				}
				$this->course_lesson_model->lesson_seq($id,$seq,$parent_id);
			}
		}
		print_r($lesson);
	}
	

	public function up_file_all($id,$type){
		$config['allowed_types'] = "*";
		$info = $this->upload_file('fileList',$config);
		echo $this->add_file($info,$id,"{$type}");
	}	



	public function up_file($id){
		$config['allowed_types'] = "*";
		$info = $this->upload_file('fileList',$config);
		echo $this->add_file($info,$id,"course_lesson");
	}
	public function add_file($info,$id,$target){
		if(is_array($info)){
			$this->load->model("upload_file_model");
			$data['target_id'] = $id;
			$data['filename'] = $info['client_name'];
			$data['hashname'] = $info['file_name'];
			$data['ext'] = explode('.',$info['file_ext'])[1];
			$data['size'] = $info['file_size'];
			$data['type'] = explode('/',$info['file_type'])[0];
			$data['is_public'] = 1;
			$data['target'] = $target;
			$data['create_id'] = $_SESSION['user']['id'];
			$data['create_time'] = time();
			return $this->upload_file_model->add($data);
		}else{
			return $info;
		}
	}
	public function upload_file($t,$config){
		$config['upload_path'] = "./public/home/file";
		$config['max_size']="2097152";  //单位KB
		$config['encrypt_name'] = true;
		$this->load->library("upload",$config);
		if(!$this->upload->do_upload($t)){
			$info = $this->upload->display_errors();
		}else{
			$info = $this->upload->data();
		}
		return $info;
	}

	
	private function course($id){
		return $this->course_model->get_course2($id);
	}


	function down(){
		$this->load->helper("download");
		$filename = "student.xls";
		$data = file_get_contents("./public/home/static/{$filename}");
		if(!$data){show_404();}else{
			force_download($filename,$data);
		}
			
	}



}