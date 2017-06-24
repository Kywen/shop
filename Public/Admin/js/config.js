(function() {
    // 配置
    var envir = 'online';
    var configMap = {
        test: {
            appkey: '7d2b0281a7969701ae6ea2e812edddb1',
            url:'https://app.netease.im/index#/app/3281062'
        },
        pre:{
    		appkey: '7d2b0281a7969701ae6ea2e812edddb1',
    		url:'http://preapp.netease.im:8184'
        },
        online: {
           appkey: '7d2b0281a7969701ae6ea2e812edddb1',
           url:'https://app.netease.im'
        }
    };
    window.CONFIG = configMap[envir];
}())