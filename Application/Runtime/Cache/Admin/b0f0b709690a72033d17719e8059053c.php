<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>采供商城管理平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="/shop/Public/Admin/css/base.css"/>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/shop/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/shop/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/shop/Public/Admin/css/animate.min.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <!-- 云信通讯 -->
    <link rel="stylesheet" href="/shop/Public/Admin/css/base.css"/>
    <link rel="stylesheet" href="/shop/Public/Admin/css/jquery-ui.css"/>
    <link rel="stylesheet" href="/shop/Public/Admin/css/contextMenu/jquery.contextMenu.css"/>
    <link rel="stylesheet" href="/shop/Public/Admin/css/main.css"/>
    <link rel="stylesheet" href="/shop/Public/Admin/css/uiKit.css"/>
    <link rel="stylesheet" href="/shop/Public/Admin/css/CEmojiEngine.css"/>
    <link rel="icon" href="/shop/Public/Admin/images/icon.ico" type="image/x-icon"/>
</head> 
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div class="bad-network hide tc radius5px" id="errorNetwork">已与服务器断开，请检查网络连接</div>
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i></div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <!-- 左侧导航栏上方 -->
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <!-- icon图标 -->
                            <span><img alt="image" class="img-circle" src="/shop/Public/Admin/images/a_logo.png" style="width: 85px;height: 85px;" /></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                <!-- 显示管理员名 -->
                               <span class="block m-t-xs"><strong class="font-bold" name="employee_name" id="uid"><?php echo ($main_data["employee_name"]); ?></strong></span>
                               <span class="block m-t-xs"><strong class="font-bold" name="employee_name" id="sdktoken" style="display: none;"><?php echo ($main_data["employee_sdktoken"]); ?></strong></span>
                                <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                </span>
                            </a>
                            <!-- 退出按钮 -->
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="login.html">安全退出</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- 左侧导航栏下方开始 -->
                    <!-- 首页模块 -->
                    <li>
                        <a href="#">
                            <i class="fa fa-home"></i>
                            <span class="nav-label">首页</span>                    
                        </a>
                    </li>
                    <!-- 平台模块 -->
                    <li>
                    <!-- 一级导航 -->
                        <a  href="#">
                            <i class="fa fa-desktop"></i>
                            <span class="nav-label">平台</span>
                            <span class="fa arrow"></span>
                        </a>
                        <!-- 二级导航 -->
                        <ul class="nav nav-second-level">
<!--                             <li>
                                <a class="J_menuItem" href="../Ad/carousel_list.html">轮播图管理</a>
                            </li> -->
                            <li>
                                <a href="../Platform/customers_list.html"  class="J_menuItem" >会员管理</a>
                            </li>                            
<!--                             <li>
                                <a href="../Platform/redis.html"  class="J_menuItem" >缓存管理</a>
                            </li> -->
                            <li>
                                <a href="#">统计<span class="fa arrow"></span></a>
                                <!-- 三级导航 -->
                                <ul class="nav nav-third-level">
                                    <li><a class="J_menuItem" href="../Platform/providers_chuangkes_count.html">供应商/创客统计</a>
                                    </li>    
                                    <li><a class="J_menuItem" href="../Platform/provider_chuangke.html">供应商-创客地域管理</a>
                                    </li>
                                    <li><a class="J_menuItem" href="../Platform/orders_count">订单统计</a>
                                    </li>  
                                    </li>
                                    <li><a class="J_menuItem" href="../Platform/sale_rank.html">销售排行</a>
                                    </li>                                 
                                </ul>
                            </li>
                            <li>
                                <a href="#">权限<span class="fa arrow"></span></a>
                                <!-- 三级导航 -->
                                <ul class="nav nav-third-level">
                                    <li><a class="J_menuItem" href="../Platform/admins_list.html">管理员列表</a>
                                    </li>
                                    <li><a class="J_menuItem" href="../Mall/providers_list.html">供货商列表</a>
                                    </li>  
                                    <li><a class="J_menuItem" href="../Mall/chuangkes_list.html">创客列表</a>
                                    </li>  
                                </ul>
                            </li>                            
                        </ul>
                    </li>
                    <!-- 商城模块 -->
                    <li>
                        <a href="#">
                            <i class="fa fa-cart-arrow-down"></i>
                            <span class="nav-label">商城</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">商品<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a class="J_menuItem" href="../Mall/goods_list">商品列表</a>
                                    </li>
                                    <li><a class="J_menuItem" href="../Mall/goods_sort.html">商品分类</a>
                                    </li>
                                </ul>
                            </li>                                         
                        </ul>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="../Mall/orders_list.html" data-index="0">订单列表</a>
                            </li>                                         
                        </ul>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#" data-index="0">商家入驻<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a class="J_menuItem" href="../Mall/providers_list.html">入驻商家列表</a>
                                    </li>
                                </ul>
                            </li>                                         
                        </ul>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#" data-index="0">创客<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a class="J_menuItem" href="../Mall/chuangkes_list.html">创客列表</a>
                                    </li>
                                </ul>
                            </li>                                         
                        </ul>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../Mall/order_commission.html" class="J_menuItem"  data-index="0">订单佣金结算</a>
                            </li>                                         
                        </ul>
                    </li>
                    <!-- 直播间模块 -->
                    <li>
                        <a href="#"><i class="fa fa-tv"></i> <span class="nav-label">直播间 </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a class="J_menuItem" href="../Live/createLive.html">创建直播间</a>
                            </li>
                            <li><a class="J_menuItem" href="../Live/livelist.html">直播间管理</a>
                            </li>
                        </ul>
                    </li>
                    <!-- 客户圈模块 -->
                    <li>
                        <a href="communication.html" class="J_menuItem"> 
                            <i class="fa fa-qq"></i>
                            <span class="nav-label">客户圈</span>
                        </a>                        
                    </li>
                    <!-- 日历模块 -->
                    <li>
                        <a href="../Calendar/calendar.html" class="J_menuItem">
                            <i class="fa fa-calendar"></i>
                            <span class="nav-label">日历</span>
                        </a>
                    </li>               
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->

        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <!-- 顶部  左侧菜单栏 -->
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <!-- 百度搜索引擎 -->
                        <form class="navbar-form-custom" action="http://www.baidu.com/baidu" target="_blank">
                            <div align="form-group"> 
                                <input name="tn" type="hidden" value="baidu">                        
                                <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="word">
                            </div>
                        </form>
                    </div>
                    <!-- 顶部  右侧菜单栏 -->
                    <ul class="nav navbar-top-links navbar-right">
                        <li class="hidden-xs">
                            <a href="javascript:location.reload(true)"></i> 刷新</a>
                        </li>
                        <li class="dropdown hidden-xs">
                            <a class="right-sidebar-toggle" aria-expanded="false">
                                <i class="fa fa-magic"></i> 主题
                            </a>
                        </li>
                        <li class="hidden-xs">
                            <a href="help.html" class="J_menuItem" data-index="0"><i class="fa fa-question"></i> 帮助</a>
                        </li>
                        <li class="hidden-xs">
                            <div id="tp-weather-widget"></div>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- 弹出框 -->
            <div class="modal inmodal row-sx-12" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-cart-plus modal-icon"></i>
                            <h4 class="modal-title">关于e直供采供商城</h4>
                            <small>一款原生态农产品原产地分享平台</small>
                        </div>
                        <div class="modal-body" style="height: 100px">
                            <div class="col-sm-6 col-md-offset-3">
                                <div>
                                    <span>e直供是一款基于B2B模式的原产地采供分享平台。在这里，每一个用户都能成为商家，并通过分享利润的模式，扩大消费集群的同时，也能给每个用户带来一定的利润，达到顾客亦是商家，分享即能创业的目的。 此外，通过原产地供应商直接供货的形式，去除了中间商环节，降低成本，提升产品价格竞争力，创业者（创客）也免除了资金及库存的忧虑。</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tab菜单项 -->
            <div class="row content-tabs">
                <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                </button>
                <nav class="page-tabs J_menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="active J_menuTab" data-id="homepage.html">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                </button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>
                    </button>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li class="J_tabShowActive"><a>定位当前选项卡</a>
                        </li>
                        <li class="divider"></li>
                        <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                        </li>
                        <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                        </li>
                    </ul>
                </div>
                <a href="login.html" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
            </div>
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="homepage.html" frameborder="0" data-id="homepage.html"  seamless></iframe>
            </div>
            <div class="footer">
                <div class="pull-right">&copy; 采购商城管理平台 </a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->
        
        <!--右侧边栏开始-->
            <!-- 修改主题功能 -->
        <div id="right-sidebar">
            <div class="sidebar-container">
                <ul class="nav nav-tabs navs-3">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1">
                            <i class="fa fa-gear"></i> 主题
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> 主题设置</h3>
                            <small><i class="fa fa-tim"></i>您可以从这里选择和预览主题的布局和样式，这些设置会被保存在本地，下次打开的时候会直接应用这些设置。</small>
                        </div>
                        <div class="skin-setttings">
                            <div class="title">主题设置</div>
                            <div class="setings-item">
                                <span>收起左侧菜单</span>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                        <label class="onoffswitch-label" for="collapsemenu">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>固定顶部</span>

                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                        <label class="onoffswitch-label" for="fixednavbar">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="setings-item">
                                <span>固定宽度</span>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                        <label class="onoffswitch-label" for="boxedlayout">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="title">皮肤选择</div>
                            <div class="setings-item default-skin nb">
                                <span class="skin-name ">
                                     <a href="#" class="s-skin-0">
                                         默认皮肤
                                     </a>
                                </span>
                            </div>
                            <div class="setings-item blue-skin nb">
                                <span class="skin-name ">
                                    <a href="#" class="s-skin-1">
                                        蓝色主题
                                    </a>
                                </span>
                            </div>
                            <div class="setings-item yellow-skin nb">
                                <span class="skin-name ">
                                    <a href="#" class="s-skin-3">
                                        黄色/紫色主题
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <!--右侧边栏结束-->       
    </div>

    
    <!-- 云信js -->
    <script src="/shop/Public/Admin/3rd/NIM_Web_SDK_v3.5.0.js"></script>
    <script src="/shop/Public/Admin/3rd/jquery-1.11.3.min.js"></script>
    <script src="/shop/Public/Admin/js/3rd/jquery-ui.min.js"></script>
    <!-- 右键菜单-->
    <script src="/shop/Public/Admin/js/3rd/contextMenu/jquery.ui.position.js"></script>
    <script src="/shop/Public/Admin/js/3rd/contextMenu/jquery.contextMenu.js"></script>

    <script src="/shop/Public/Admin/js/config.js"></script>
    <script src="/shop/Public/Admin/js/emoji.js"></script>
    <script src="/shop/Public/Admin/js/util.js?v=2"></script>
    <script src="/shop/Public/Admin/js/cache.js?v=2"></script>
    <script src="/shop/Public/Admin/js/link.js"></script>
    <script src="/shop/Public/Admin/js/ui.js?v=2"></script>
    <script src="/shop/Public/Admin/js/widget/uiKit.js?v=2"></script>
    <script src="/shop/Public/Admin/js/module/base.js"></script>
    <script src="/shop/Public/Admin/js/module/message.js"></script>
    <script src="/shop/Public/Admin/js/module/sysMsg.js"></script>
    <script src="/shop/Public/Admin/js/module/personCard.js"></script>
    <script src="/shop/Public/Admin/js/module/session.js"></script>
    <script src="/shop/Public/Admin/js/module/friend.js"></script>
    <script src="/shop/Public/Admin/js/module/team.js"></script>
    <script src="/shop/Public/Admin/js/module/cloudMsg.js"></script>
    <script src="/shop/Public/Admin/js/module/notification.js"></script>
    <script>
        $uid = $('#uid').text();
        $sdktoken = $('#sdktoken').text();
        setCookie('uid',$uid);
        setCookie('sdktoken',$sdktoken);    
    </script>
    <script src="/shop/Public/Admin/js/main.js?v=2"></script>

    <!-- 主页js -->
    <script src="/shop/Public/Admin/js/jquery.min.js"></script>
    <script src="/shop/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
    <script>tpwidget("init", {
        "flavor": "slim",
        "location": "WTMKQ069CCJ7",
        "geolocation": "enabled",
        "language": "zh-chs",
        "unit": "c",
        "theme": "chameleon",
        "container": "tp-weather-widget",
        "bubble": "enabled",
        "alarmType": "badge",
        "color": "#2E93D9",
        "uid": "UA59EBD856",
        "hash": "9829a1f7d9f882740642335d6a3aa14b"
    });
    tpwidget("show");</script>
    <script src="/shop/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/shop/Public/Admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/shop/Public/Admin/js/plugins/layer/layer.min.js"></script>
    <script src="/shop/Public/Admin/js/hplus.min.js?v=4.1.0"></script>
    <script type="text/javascript" src="/shop/Public/Admin/js/contabs.min.js"></script>
    <script src="/shop/Public/Admin/js/plugins/pace/pace.min.js"></script>
</body>
</html>