// 获取html中对应的echarts显示的id
var s2=echarts.init(document.getElementById("echarts-provider-pie"));
var s3=echarts.init(document.getElementById("echarts-chuangke-pie"));
// 供应商扇形图配置
var provider_option = {
    title : { //图表名
        text: '供应商订单统计',
        subtext: '有无订单',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    //图表分布颜色
    color:['rgb(244, 208, 0)', 'rgb(138, 151, 123)'],
    legend: {
        orient: 'vertical',
        x: 'left',
        data: ['有订单供应商数','无订单供应商数']
    },
    series : [
        {
            name: '供应商订单统计',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            //显示数据
            data:[
                {value:pie_data.provider_ordered, name:'有订单供应商数'},
                {value:pie_data.provider_unordered, name:'无订单供应商数'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)',                    
                }
            }
        }
    ]
};

// 创客扇形图配置
var chuangke_option = {
    title : { //图表名
        text: '创客订单统计',
        subtext: '有无订单',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    color:['rgb(244, 208, 0)','rgb(29, 131, 8)'],
    legend: {
        orient: 'vertical',
        x: 'left',
        data: ['有订单创客数','无订单创客数']
    },
    series : [
        {
            name: '创客订单统计',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            //显示数据
            data:[
                {value:pie_data.chuangke_ordered, name:'有订单供创客数'},
                {value:pie_data.chuangke_unordered, name:'无订单创客数'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)',                   
                    
                }

            }
        }
    ]
};
// 实例化扇形图
s2.setOption(provider_option),$(window).resize(s2.resize);
s3.setOption(chuangke_option),$(window).resize(s3.resize);
