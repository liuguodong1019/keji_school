
<?php $this->load->view("home/block/my/b_course_nav");?>

<?php if(  $this->uri->segment(3) == 'lessoncount'  ){ ?>
<ul class="nav nav-pills" style="margin:-10px 0 20px;">
    <li class="<?php if($this->uri->segment(3)=="count"){echo 'active';}?>">
        <a href="<?php echo site_url("my/my_course/count?course_id={$mc['id']}");?>" class="btn btn-primary">课程统计</a>
    </li>
    <li class="<?php if($this->uri->segment(3)=="lessoncount"){echo 'active';}?>">
        <a href="<?php echo site_url("my/my_course/lessoncount?course_id={$mc['id']}");?>" class="btn btn-primary">课时统计</a>
    </li>
</ul>

<?php }?>


<div class="course_datachartF keshi_datasF">
   <?php if($lessonCount){foreach($lessonCount as $l){?>
    <div class="chart_item">
        <span class="keshi_title" title="<?=$l['title_num']?>："><?=$l['title_num']?>：</span>
        <div class="shapesframe">
            <div class="color_block orange"style="width:<?=$l['percent']?>%;"></div>
        </div>
        <span class="color_num orange"><?=$l['percent']?>%</span>&nbsp;&nbsp;
        <?php if($l['resource_type']=="video" || $l['resource_type']=="audio"){?>
        <span class="words t_words">学习时长：<?php echo ($l['learn_time']!=0)?$l['new_learn_time']:'00:00'?></span>&nbsp;
        <?php }else{?>
        <span class="words t_words" >学习时长：00:00</span>&nbsp;
        <?php }?>
        <span class="words">完成练习：<?=$l['practice_num']?></span>&nbsp;
        <span class="words">完成作业：<?=$l['home_sum']?></span>&nbsp;
        <span class="words">笔记：<?=$l['note_num']?></span>&nbsp;
        <span class="words">问答：<?=$l['question_sum']?></span>
    </div>
    <?php }}?>
</div>