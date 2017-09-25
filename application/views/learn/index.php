<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= $message['name'];?> - 学习中心 </title>		
	<?php $this->load->view('home/public/base_link');?>
	<link rel="stylesheet" href="<?php echo base_url()?>/public/home/css/personal.css">
	<link rel="stylesheet" href="<?php echo base_url()?>/public/home/css/group-zhuye.css">
	<link rel="stylesheet" href="<?php echo base_url()?>/public/home/css/group-list.css">
    <script src="<?php echo base_url()?>/public/home/js/echarts.min.js"></script>    
</head>

<body>
    <div class="cb-wrap">
	<?php $this->load->view('home/my_nav');?>
                </div>

            </div>
        </div>
  
    </div>
</body>
</html>