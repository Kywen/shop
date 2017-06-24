var s=echarts.init(document.getElementById("echarts-orders"));
var option = {
    color: ['#3398DB'],
    title:{text:"最近七日的平台订单量"},
    tooltip : {
        trigger: 'axis',
        legend:{data:["订单量"]},
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    calculable:!0,
    xAxis : [
        {
            type : 'category',
            data : [show_data[6].dates, show_data[5].dates, show_data[4].dates, show_data[3].dates, show_data[2].dates, show_data[1].dates, show_data[0].dates],
            axisTick: {
                alignWithLabel: true
            }
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'订单量',
            type:'bar',
            barWidth: '40%',
            data:[show_data[6].count, show_data[5].count, show_data[4].count, show_data[3].count, show_data[2].count, show_data[1].count, show_data[0].count]
        }
    ]
};
s.setOption(option),$(window).resize(s.resize);