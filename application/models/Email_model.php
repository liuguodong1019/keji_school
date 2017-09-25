<?php

class Email_model extends CB_Model {

	protected $table = 'setting';
	
	public function send($email,$nickname,$type=""){
		$authdata = $this->setting_model->get_one('auth');
		$title = $authdata['email_activation_title'];
		$body = $authdata['email_activation_body'];
		
		$this->load->model('setting_model');
		$message = $this->setting_model->get_one('site');
		
		$title1 = str_replace("{{sitename}}","{$message['name']}",$title);
		$body = str_replace("{{sitename}}","{$message['name']}",$body);
		$body = str_replace("{{nickname}}",$nickname,$body);
		$code = $this->encrypt("{$email}",'E','combanc'); //解密
		$code = urlencode($code);

		$url = site_url()."home/activated?code={$code}";		
		if($type="register"){
			$body.="<p>点击下面链接验证邮箱</p>
			<p><a href='{$url}' target='_blank'>{$url}</a></p>
			";
		}

		$this->sendemail("{$title1}","{$body}","{$email}");
	}
	
	

	//发送邮件	
	public function sendemail($subject,$message,$to){
		// $this->load->model("setting_model");	
		$this->load->library('email');	
		// $data = $this->setting_model->get_one('mailer');
		// if(!empty($data['host']) && !empty($data['username']) && !empty($data['password'])){
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = "smtp.163.com";  //host
		$config['smtp_user'] = "15110274504@163.com"; //username
		$config['smtp_pass'] = "liu13720907372"; //password
		$config['mailtype'] = 'html';
		$config['validate'] = true;
		// $config['priority'] = 1;
		$config['crlf']  = "\r\n";
		$config['smtp_port'] = "25";  //port
		$config['charset'] = 'utf-8';
		// $config['wordwrap'] = TRUE;
		$this->email->initialize($config);  	
		//from发件邮箱   name 发件人名称
		$this->email->from('15110274504@163.com', '北京科技高级技术学校');//发件人
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();	
		// }
		return true;		
	} 	
	
	//查看邮箱
	public function showemail($email){
		$retval="";
		$pt=strrpos($email, "@");
		if ($pt) $retval=substr($email, $pt+1, strlen($email) - $pt);
		$string = explode('.',$retval)[0];	
            switch ($string)
            {
                case "163":   //网易163
                    $url = "http://mail.163.com/";
                    break;
                case "126":   //  网易126
                    $url = "http://mail.126.com/";
                    break;
                case "sina":  //  sina
                    $url = "http://mail.sina.com.cn/";
                    break;
                case "yahoo": //雅虎
                    $url = "http://mail.cn.yahoo.com/";
                    break;
                case "sohu":  //  搜狐
                    $url = "http://mail.sohu.com/";
                    break;
                case "yeah":  //网易yeah.net
                    $url = "http://www.yeah.net/";
                    break;
                case "gmail": //Gmail
                    $url ="http://gmail.google.com/";
                    break;
                case "hotmail":   //Hotmail
                    $url = "http://www.hotmail.com/";
                    break;
                case "live":      //Hotmail
                    $url = "http://www.hotmail.com/";
                    break;
                case "qq":        //QQ
                    $url = "https://mail.qq.com/";
                    break;
                case "139":       //139
                    $url = "http://mail.10086.cn/";
                    break;
				default:
					$url="https://www.baidu.com/s?wd=%E9%82%AE%E7%AE%B1&rsv_spt=1&rsv_iqid=0x9797571600011af1&issp=1&f=3&rsv_bp=0&rsv_idx=2&ie=utf-8&tn=baiduhome_pg&rsv_enter=1&rsv_sug3=1&rsv_sug1=1&rsv_sug7=001&rsv_sug2=0&rsp=0&rsv_sug9=es_2_1&inputT=464&rsv_sug4=2162&rsv_sug=9";
					break;
			}
		return $url;
		
	}
	
	//字符串加密
	public function encrypt($string,$operation,$key=''){
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++){
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++){
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++){
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D'){
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return substr($result,8);
            }else{
                return'';
            }
        }else{
            return str_replace('=','',base64_encode($result));
        }
    }	
}