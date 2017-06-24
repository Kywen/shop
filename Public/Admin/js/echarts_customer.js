var s=echarts.init(document.getElementById("echarts-customer-pie"));
var customer_option = {
    title : {
        text: '会员分布统计',
        subtext: '会员等级',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    color:['rgb(244, 208, 0)', 'rgb(138, 151, 123)','rgb(220, 87, 18)','rgb(29, 131, 8)'],
    legend: {
        orient: 'vertical',
        x: 'left',
        data: ['普通会员','黄金会员',"白金会员","钻石会员"]
    },
    series : [
        {
            name: '会员分布统计',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[
                {value:pie_data.pt, name:'普通会员'},
                {value:pie_data.hj, name:'黄金会员'},
                {value:pie_data.bj, name:'白金会员'},
                {value:pie_data.zs, name:'钻石会员'}

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
s.setOption(customer_option),$(window).resize(s.resize);
