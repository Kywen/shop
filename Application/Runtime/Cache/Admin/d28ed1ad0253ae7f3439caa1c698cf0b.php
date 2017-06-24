<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>供应商/创客统计</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="/shop/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <!-- 图标库 -->
    <link href="/shop/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <!-- dataTables css样式 -->
	<link href="/shop/Public/Admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <!-- 动画库 -->
    <link href="/shop/Public/Admin/css/animate.min.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
	<!-- 1-title -->
	<div class="row-md-2  ibox-content border-bottom">
		<h2>统计-供应商/创客统计</h2>
		<span>您可以在这里对供应商和创客数量进行查看</span>	
	</div>
	<br>
	<!-- 2 -供应商统计-->
	<div class="row-md-5">
        <!-- 表格占5 -->
        <div class="col-md-5">
            <div class="ibox float-e-margins">
                <!-- 表格名 -->
                <div class="ibox-title">
                    <h5>供应商统计</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div> 
                <!-- 表格内容 -->
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example " >
                        <thead>
                            <tr>
                                <th>供应商总数</th>
                                <th>有订单供应商数</th>
                                <th>供应商订单总数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($show_data)): $i = 0; $__LIST__ = $show_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	                            	<td><?php echo ($vo["provider_count"]); ?></td>
	                            	<td><?php echo ($vo["provider_ordered"]); ?></td>
	                            	<td><?php echo ($vo["provider_order_count"]); ?></td>         	
	                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- 扇形图占7 -->
        <div class="col-md-7">
            <div id="echarts-provider-pie" class="row-md-12 col-md-12" style="height: 200px"></div>
        </div>
	</div>

    <!-- 3 -创客统计-->
    <div class="row-md-5">
        <div class="col-sm-5">
            <div class="ibox float-e-margins">
                <!-- 表格标题 -->
                <div class="ibox-title">
                    <h5>创客统计</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <!-- 表格内容 -->
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example " >
                        <thead>
                            <tr>
                                <th>创客总数</th>
                                <th>有订单创客数</th>
                                <th>创客订单总数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($show_data)): $i = 0; $__LIST__ = $show_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	                            	<td><?php echo ($vo["chuangke_count"]); ?></td>
	                            	<td><?php echo ($vo["chuangke_ordered"]); ?></td>
	                            	<td><?php echo ($vo["chuangke_order_count"]); ?></td>         	
	                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- 扇形图占7 -->
        <div class="col-md-7">
            <div id="echarts-chuangke-pie" class="row-md-12 col-md-12" style="width:600px;height: 200px"></div>
        </div>
	</div>
    

	<script src="/shop/Public/Admin/js/jquery.min.js"></script>
    <script src="/shop/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/shop/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!-- 表格相关js -->
    <script src="/shop/Public/Admin/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/shop/Public/Admin/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/shop/Public/Admin/js/content.min.js?v=1.0.0"></script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>

    <!-- 扇形图所需数据 -->
    <script type="text/javascript">
        var pie_data;
        $.ajax({
            url:"/shop/index.php/Admin/Platform/count_get",//这里指向的就不再是页面了，而是一个方法。
            data:{},
            type:"POST",
            dataType:"JSON",
            async : false,          
            success: function(data){
                pie_data = data;
                console.log(pie_data);
            }
        })
    </script>
    <!-- echarts相关js -->
    <script type="text/javascript" src="/shop/Public/Admin/js/plugins/echarts/echarts.min.js"></script>
    <script type="text/javascript" src="/shop/Public/Admin/js/echarts_p_c.js"></script>
</body>
</html>