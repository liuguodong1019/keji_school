<?php $this->load->view("home/block/my/b_course_nav");?>

<?php if($this->uri->segment(3) == 'count'  ){ ?>
<ul class="nav nav-pills" style="margin:-10px 0 20px;">
    <li class="<?php if($this->uri->segment(3)=="count"){echo 'active';}?>">
        <a href="<?php echo site_url("my/my_course/count?course_id={$mc['id']}");?>" class="btn btn-primary">课程统计</a>
    </li>
    <li class="<?php if($this->uri->segment(3)=="lessoncount"){echo 'active';}?>">
        <a href="<?php echo site_url("my/my_course/lessoncount?course_id={$mc['id']}");?>" class="btn btn-primary">课时统计</a>
    </li>
</ul>
<?php }?>
<style>.remark_time{font-size:12px;color:#ccc;}</style>
	<div class="panel-body tj_study">
        <h5 class="tj_study_title teacher_pj"><i></i>教师评价<span></span></h5>
        <?php if(!empty($remark)){ ?>
            <?php foreach($remark as $key=>$v){ ?>
                <div class="teacher_pj_conts">
                    <div class="pj_grade">
                        <span class="letter"><?= $v['level'];?></span>
                        <span class="hz_char"><?= $v['des'];?></span>
                    </div>
                    <div class="pj_content">
                        <h5><a href="<?php echo site_url("user/{$v['teacher']}");?>" target="_blank"><?= $v['t_name']; ?></a> 评语：</h5>
                        <span class="remark_time"><?= date('Y-m-d H:i:s',$v['create_time']);?></span>
                        <div class="conts">
                            <?= $v['content'];?>
                        </div>
                    </div>
                </div><br />
            <?php } ?>
        <?php }else{ ?>
        <div class="">
            暂无评价<br /><br /><br />
        </div>
        <?php } ?>
        <?php $this->load->view("home/block/my/my_course/b_count_chart");?>
	</div>
