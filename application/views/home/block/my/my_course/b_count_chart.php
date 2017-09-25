    <h5 class="tj_study_title course-datas"><i></i>课程进度<span></span></h5>
    <div class="course_datachartF">
        <div class="chart_item">
            <span>课时进度：</span>
            <?php 
                $h_finish = isset($m_course[0]['is_learn'])?$m_course[0]['is_learn']:'0';
                $h_all = isset($sum_les)?$sum_les:'0';
                $h_percent = 0;
                if($h_finish >0){
                    $h_percent = floor(($h_finish/$h_all)*100);
                }
            ?>
            <div class="shapesframe">
                <div class="color_block orange"style="width:<?= $h_percent;?>%;"></div>
            </div>
            <span class="color_num orange"><?= $h_percent;?>%</span>&nbsp;&nbsp;
            <span class="words">完成课时：<?= $h_finish;?>/<?= $h_all;?></span>
        </div>
        <div class="chart_item">
            <span>练习进度：</span>          
            <?php 
                $p_finish = isset($m_practise['is_my'])?$m_practise['is_my']:'0';
                $p_all = isset($m_practise['sum'])?$m_practise['sum']:'0';
                $p_percent = 0;
                if($p_finish >0){
                    $p_percent = floor(($p_finish/$p_all)*100);
                }
            ?>                     
            <div class="shapesframe">
                <div class="color_block green"style="width:<?= $p_percent;?>%;"></div>
            </div>
            <span class="color_num green"><?= $p_percent;?>%</span>&nbsp;&nbsp;
            <span class="words">完成练习：<?= $p_finish; ?>/<?= $p_all;?></span>
        </div>
        <div class="chart_item">
            <span>作业进度：</span>
            <?php 
                $m_finish = isset($m_home[0]['is_my'])?$m_home[0]['is_my']:'0';
                $m_all = isset($m_home[0]['sum'])?$m_home[0]['sum']:'0';
                $m_percent = 0;
                if($m_finish >0){
                    $m_percent = floor(($m_finish/$m_all)*100);
                }
            ?>                  
            <div class="shapesframe">
                <div class="color_block blue"style="width:<?= $m_percent;?>%;"></div>
            </div>
            <span class="color_num blue"><?= $m_percent;?>%</span>&nbsp;&nbsp;
            <span class="words">完成作业：<?= $m_finish;?>/<?= $m_all;?></span>
        </div>
        <div class="chart_item">
            <span>考试进度：</span>              
            <?php 
                $t_finish = isset($m_test[0]['is_my'])?$m_test[0]['is_my']:'0';
                $t_all = isset($m_test[0]['sum'])?$m_test[0]['sum']:'0';
                $t_percent = 0;
                if($t_finish >0){
                    $t_percent = floor(($t_finish/$t_all)*100);
                }
            ?>                 
            <div class="shapesframe">
                <div class="color_block purple"style="width:<?= $t_percent; ?>%;"></div>
            </div>
            <span class="color_num purple"><?= $t_percent; ?>%</span>&nbsp;&nbsp;
            <span class="words">完成考试：<?= $t_finish; ?>/<?= $t_all; ?></span>
        </div>
    </div>
    <h5 class="tj_study_title test_tongji"><i></i>考试统计<span></span></h5>
    <?php if(!empty($test_count)) { ?>
    <div class="test_tjchart">
        <div id="test_chart" style="height:400px;width:75%;"></div>
        <script type="text/javascript">
            var colorArr77 = ['#a53adc','#3a97dc','#7cbd55']
            var myCharttest = echarts.init(document.getElementById('test_chart'));
            var title = "考试统计图表";
            option = {
                color:colorArr77,
                backgroundColor: '#fff',
                tooltip: {
                    trigger: 'item',
                    formatter: function(params){
                        var res="";
                        res = params.name+' <br/><span style="color:' +colorArr77[params.seriesIndex]+ ';">'+params.seriesName+' : '+params.data+'分</span>'
                        return res;
                    },
                    formatter: '{a} <br/>{b} : {c}'
                },
                legend: {
                    itemWidth:12,
                    itemHeight:12,
                    bottom:'0',
                    data:[ 
                    {
                        name: '我的考试得分',
                        icon: 'rect'
                    },
                    {
                        name: '试卷平均得分',
                        icon: 'rect'
                    },
                    {
                        name: '试卷总分',
                        icon: 'rect'
                    },                        
                ],
                },
                xAxis: {
                    type: 'category',
                    boundaryGap : false,
                    name: '',
                    splitLine: {
                        show: true,
                        lineStyle: {color: '#eee'}},
                    axisLine:{
                        lineStyle: {color: '#eee'}},
                    axisTick:{
                        lineStyle:{
                            color:'#fff'}},
                    axisLabel: {
                                interval: 0,
                                rotate: -65,
                                margin: 10,
                                textStyle: {
                                    color: "#666"}},
                    data: <?= isset($test_count['testname'])?$test_count['testname']:'';?>
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '20%',
                    borderColor:'#eee',
                    containLabel: true,
                    show:'true',
                },
                yAxis: {
                    type: 'value',
                    boundaryGap: [0, '100%'],
                    name: '分数',
                    splitLine: {
                        show: true,
                        lineStyle: {color: '#eee'}
                    },
                    nameTextStyle:
                        {
                           fontSize:'12',
                           color:'#666'
                        },
                    axisLine:{
                        lineStyle: {color: '#eee'}
                    },
                    axisLabel:{
                        textStyle:{
                            fontSize:'12',
                            color:'#666'
                        }
                    },
                    axisTick:{
                        lineStyle:{
                            color:'#fff'
                        }
                    },
                    data:5,
                    min:0,                 
                },
                series: [
                    {
                        name: '我的考试得分',
                        type: 'line',
                        data: <?= isset($test_count['mytest'])?$test_count['mytest']:'';?>
                    },
                    {
                        name: '试卷平均得分',
                        type: 'line',
                        data: <?= isset($test_count['average'])?$test_count['average']:'';?>
                    },
                    {
                        name: '试卷总分',
                        type: 'line',
                        data: <?= isset($test_count['fullmark'])?$test_count['fullmark']:'';?>
                    }                        
                ]
            };
            myCharttest.setOption(option);
        </script>
        <div class="test-datas">
            <p><span></span>最高分：<?= $test_count['max']; ?></p>
            <p><span></span>最低分：<?= $test_count['min']; ?></p>
            <p><span></span>平均分：<?= $test_count['myaverage']; ?></p>
        </div>
    </div>
    <?php }else{ ?>
        暂无考试<br /><br /><br />
    <?php } ?>    
    <h5 class="tj_study_title learning_dt"><i></i>学习动态<span></span></h5>
    <div class="learning_dtchart">
        <div id="learning_chart" style="height:350px;width:100%;"></div>
        <script type="text/javascript">
            var colorArr6 = ['#5d9cec','#b16be6','#0092bc','#f77cc2','#7cbd55'] ;
            var myChart06 = echarts.init(document.getElementById('learning_chart'));
                option = {
                color:colorArr6,
                backgroundColor: '#fff',
                tooltip: {
                    trigger: 'item',
                    textStyle:{
                            fontSize:'12',
                            color:'#aaa',
                            fontStyle: 'normal'
                        },
                    backgroundColor: 'rgba(255,255,255,0.9)',
                    borderColor: '#ccc',
                    borderWidth: 1,  
                    formatter: function(params){
                        var res="";
                        res = params.name+' <br/><span style="color:' +colorArr6[params.seriesIndex]+ ';">'+params.seriesName+' : '+params.data+'个</span>'
                        return res;
                    }
                    
                },
                legend: {
                    itemWidth:12,
                    itemHeight:12,
                    data:[ //更改图例中 小图形的形状
                        {
                            name: '完成的课时数',
                            icon: 'rect'
                        },
                        {
                            name: '完成的练习数',
                            icon: 'rect'
                        },
                        {
                            name: '完成的作业数',
                            icon: 'rect'
                        },
                        {
                            name: '笔记总数',
                            icon: 'rect'
                        },
                        {
                            name: '问答总数',
                            icon: 'rect'
                        },

                    ],
                    bottom:'0',
                    textStyle:{
                            fontSize:'12',
                            color:'#888'
                        }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap : false,
                    name: '',
                    splitLine: {  
                        show: false,
                        lineStyle: {color: '#eee'}},
                    axisLine:{
                        show: false,
                        lineStyle: {color: '#eee'}}, 
                    axisTick:{
                        lineStyle:{
                            color:'#fff'}},  
                    axisLabel:{
                        interval: 0,
                        rotate: 0,
                        margin: 10,
                        textStyle:{
                            fontSize:'12',
                            color:'#aaa'
                        }
                    },
                   data : <?= isset($result['times'])?$result['times']:'';?>             
                },                          
                grid: {
                    left: '4%',
                    right: '8%',
                    bottom: '15%',
                    borderColor:'#fff', 
                    containLabel: true,
                    show:'true',
                },
                yAxis: {
                    type: 'value',
                    boundaryGap: [0, '100%'],
                    name: '数量',
                    splitLine: {    
                        show: true,
                        lineStyle: {color: '#eee'}
                    },
                    nameTextStyle:
                        {
                           fontSize:'12',
                           color:'#888'
                        },
                    axisLine:{  
                        show: false,
                        lineStyle: {color: 'red'}
                    },
                    axisLabel:{
                        textStyle:{
                            fontSize:'12',
                            color:'#aaa'
                        }
                    },
                    axisTick:{  
                        lineStyle:{
                            color:'#fff'
                        }
                    },
                    data:6,
                    min:0,               
                },
                series: [
                    {
                        name: '完成的课时数',
                        type: 'line',
                        data: <?= isset($result['finishLesson'])?$result['finishLesson']:'';?>
                    },
                    {
                        name: '完成的练习数',
                        type: 'line',
                        data: <?= isset($result['practise'])?$result['practise']:'';?>
                    },
                    {
                        name: '完成的作业数',
                        type: 'line',
                        data: <?= isset($result['finishWork'])?$result['finishWork']:'';?>
                    },
                    {
                        name: '笔记总数',
                        type: 'line',
                        data: <?= isset($result['notesData'])?$result['notesData']:'';?>
                    },
                    {
                        name: '问答总数',
                        type: 'line',
                        data: <?= isset($result['thread'])?$result['thread']:'';?>
                    },
                ]                           
            };
            myChart06.setOption(option);
        </script>
    </div>