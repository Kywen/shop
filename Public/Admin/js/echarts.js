var s1=echarts.init(document.getElementById("echarts-map-chart"));

var local_option = {
    title: {
        text: '供应商-创客地域分布图',
        subtext: '地域管理',
        left: 'center'
    },
    tooltip: {
        trigger: 'item'
    },
    legend: {
        orient: 'vertical',
        left: 'left',
        data:['供应商','创客']
    },
    dataRange: {
        min: 0,
        max: 2500,
        left: 'left',
        top: 'bottom',
        text: ['高','低'],           // 文本，默认为数值文本
        calculable: true
    },
    toolbox: {

        show: true,
        orient: 'vertical',
        left: 'right',
        top: 'center',
        feature: {
            mark:{show:!0},
            dataView:{show:!0,readOnly:!1},
            restore:{show:!0},
            saveAsImage:{show:!0}
            // dataView: {readOnly: false},
            // restore: {},
            // saveAsImage: {}
        }
    },
    roamController:{
        show:!0,
        x:"right",
        mapTypeControl:{china:!0}
    },

    series: [
        {
            name: '供应商',
            type: 'map',
            mapType: 'china',
            roam: false,
            itemStyle: {
                normal: {
                    label:{show:!0}
                },
                emphasis: {
                    label:{show:!0}
                }
            },
            data:[
                {name: '北京',value: provider_data[0].provider_count },
                {name: '天津',value: provider_data[1].provider_count },
                {name: '河北',value: provider_data[2].provider_count },
                {name: '山西',value: provider_data[3].provider_count },
                {name: '内蒙古',value: provider_data[4].provider_count },
                {name: '辽宁',value: provider_data[5].provider_count },
                {name: '吉林',value: provider_data[6].provider_count },
                {name: '黑龙江',value: provider_data[7].provider_count },
                {name: '上海',value: provider_data[8].provider_count },
                {name: '江苏',value: provider_data[9].provider_count },
                {name: '浙江',value: provider_data[10].provider_count },
                {name: '安徽',value: provider_data[11].provider_count },
                {name: '福建',value: provider_data[12].provider_count },
                {name: '江西',value: provider_data[13].provider_count },
                {name: '山东',value: provider_data[14].provider_count },
                {name: '河南',value: provider_data[15].provider_count },
                {name: '湖北',value:provider_data[16].provider_count },
                {name: '湖南',value:provider_data[17].provider_count },
                {name: '广东',value:provider_data[18].provider_count },
                {name: '广西',value:provider_data[19].provider_count },
                {name: '海南',value:provider_data[20].provider_count },
                {name: '重庆',value: provider_data[21].provider_count },
                {name: '四川',value: provider_data[22].provider_count },
                {name: '贵州',value: provider_data[23].provider_count },
                {name: '云南',value: provider_data[24].provider_count },
                {name: '西藏',value: provider_data[25].provider_count },
                {name: '陕西',value: provider_data[26].provider_count },
                {name: '甘肃',value: provider_data[27].provider_count },
                {name: '青海',value: provider_data[28].provider_count },
                {name: '宁夏',value: provider_data[29].provider_count },
                {name: '新疆',value: provider_data[30].provider_count },
                {name: '台湾',value: provider_data[31].provider_count },
                {name: '香港',value: provider_data[32].provider_count },
                {name: '澳门',value: provider_data[33].provider_count }
            ]
        },
        {
            name: '创客',
            type: 'map',
            mapType: 'china',
            itemStyle: {
                normal: {
                    show: true
                },
                emphasis: {
                    show: true
                }
            },
            data:[
                {name: '北京',value: chuangke_data[0].chuangke_count },
                {name: '天津',value: chuangke_data[1].chuangke_count },
                {name: '河北',value: chuangke_data[2].chuangke_count },
                {name: '山西',value: chuangke_data[3].chuangke_count },
                {name: '内蒙古',value: chuangke_data[4].chuangke_count },
                {name: '辽宁',value: chuangke_data[5].chuangke_count },
                {name: '吉林',value: chuangke_data[6].chuangke_count },
                {name: '黑龙江',value: chuangke_data[7].chuangke_count },
                {name: '上海',value: chuangke_data[8].chuangke_count },
                {name: '江苏',value: chuangke_data[9].chuangke_count },
                {name: '浙江',value: chuangke_data[10].chuangke_count },
                {name: '安徽',value: chuangke_data[11].chuangke_count },
                {name: '福建',value: chuangke_data[12].chuangke_count },
                {name: '江西',value: chuangke_data[13].chuangke_count },
                {name: '山东',value: chuangke_data[14].chuangke_count },
                {name: '河南',value: chuangke_data[15].chuangke_count },
                {name: '湖北',value: chuangke_data[16].chuangke_count },
                {name: '湖南',value: chuangke_data[17].chuangke_count },
                {name: '广东',value: chuangke_data[18].chuangke_count },
                {name: '广西',value: chuangke_data[19].chuangke_count },
                {name: '海南',value: chuangke_data[20].chuangke_count },
                {name: '重庆',value: chuangke_data[21].chuangke_count },
                {name: '四川',value: chuangke_data[22].chuangke_count },
                {name: '贵州',value: chuangke_data[23].chuangke_count },
                {name: '云南',value: chuangke_data[24].chuangke_count },
                {name: '西藏',value: chuangke_data[25].chuangke_count },
                {name: '陕西',value: chuangke_data[26].chuangke_count },
                {name: '甘肃',value: chuangke_data[27].chuangke_count },
                {name: '青海',value: chuangke_data[28].chuangke_count },
                {name: '宁夏',value: chuangke_data[29].chuangke_count },
                {name: '新疆',value: chuangke_data[30].chuangke_count },
                {name: '台湾',value: chuangke_data[31].chuangke_count },
                {name: '香港',value: chuangke_data[32].chuangke_count },
                {name: '澳门',value: chuangke_data[33].chuangke_count }
            ]
        }
    ]
};

s1.setOption(local_option),$(window).resize(s1.resize);



