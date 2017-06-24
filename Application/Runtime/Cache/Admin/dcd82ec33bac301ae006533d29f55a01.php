<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>订单列表</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/shop/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/shop/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
	<link href="/shop/Public/Admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/animate.min.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
	<!-- 1-title -->
	<div class="row-sx-2  ibox-content border-bottom">
		<h2>商品-订单列表</h2>
	</div>
	<br>
	<!-- 2-提示信息 -->
	<div class="row-sx-1">
		<div class="panel panel-success">
            <div class="panel-heading">操作提示</div>
            <div class="panel-body">
	            <ul>
	            	<li>商城所有的订单列表，包括入驻商家的订单和创客分享的订单。</li>
	            	<li>若该订单为创客分享的订单，则可通过点击查看详情进行查看。</li>
	            	<li>点击查看即可进入详情页面对订单进行操作。</li>
	            	<li>Tab切换不同状态下的订单，便于分类订单。</li>
	            </ul>
            </div>
        </div>
	</div>


	<!-- 3 -table-->
	<div class="row-sx-8">
        <div class="col-sm-12">
            <div class="tabs-container">
            	<!-- 分为三块tab -->
                <ul class="nav nav-tabs">
                	<!-- 全部订单tab -->
                    <li class="active"><a data-toggle="tab" href="#tab-all" aria-expanded="true"> 全部订单</a>
                    </li>
                    <!-- 未完成订单tab -->
                    <li><a data-toggle="tab" href="#tab-unconfirm" aria-expanded="false">未完成</a>
                    </li>
<!--                         <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">待付款</a>
                    </li> -->
<!--                         <li class=""><a data-toggle="tab" href="#tab-wait" aria-expanded="false">待发货</a>
                    </li> -->
                    <!-- 已完成订单tab -->
                    <li><a data-toggle="tab" href="#tab-finished" aria-expanded="false">已完成</a>
                    </li>
                </ul>
                <div class="tab-content">
                	<!-- 全部订单 -->
                    <div id="tab-all" class="tab-pane active">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover dataTables-example " >
		                        <thead>
		                            <tr>
		                                <th>订单号</th>
		                                <th>商家名称</th>
		                                <th>创客名称</th>
		                                <th>下单时间</th>
		                                <th>下单用户</th>
		                                <th>收货人</th>
		                                <th>金额</th>
		                                <th>订单状态</th>
		                                <th>操作</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        	<?php if(is_array($show_data_all)): $i = 0; $__LIST__ = $show_data_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		                        			<td><?php echo ($vo["order_num"]); ?></td>
		                        			<td><?php echo ($vo["provider_name"]); ?></td> 
											<td>
			                            		<a href="/shop/index.php/Admin/mall/order_share_detail/id/<?php echo ($vo["order_id"]); ?>">查看详情</a>
			                            	</td>
		                        			<td><?php echo ($vo["order_time"]); ?></td>
		                        			<td><?php echo ($vo["customer_name"]); ?></td>
		                        			<td><?php echo ($vo["mailname"]); ?></td>
		                        			<td>&yen;<?php echo ($vo["money"]); ?></td>
		                        			<td><?php echo ($vo["state"]); ?></td>
		                        			<td>
			                        			<a href="/shop/index.php/Admin/mall/invoice/id/<?php echo ($vo["order_id"]); ?>">
													<i class="fa fa-eye"></i>
													查看
												</a>
			                            	</td> 
		                        		</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
		                        </tbody>
		                        <tfoot>
		                            <tr>
		                                <th>订单号</th>
		                                <th>商家名称</th>
		                                <th>创客名称</th>
		                                <th>下单时间</th>
		                                <th>下单用户</th>
		                                <th>收货人</th>
		                                <th>金额</th>
		                                <th>订单状态</th>
		                                <th>操作</th>
		                            </tr>
		                        </tfoot>
		                    </table>
                        </div>
                    </div>
                    <!-- 全部订单结束 -->
                    <!-- 未完成订单开始 -->
                    <div id="tab-unconfirm" class="tab-pane">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover dataTables-example " >
		                        <thead>
		                            <tr>
		                                <th>订单号</th>
		                                <th>商家名称</th>
		                                <th>创客名称</th>
		                                <th>下单时间</th>
		                                <th>下单用户</th>
		                                <th>收货人</th>
		                                <th>金额</th>
		                                <th>订单状态</th>
		                                <th>操作</th>
		                            </tr>
		                        </thead>
		                        <tbody>
									<?php if(is_array($show_data_unfinished)): $i = 0; $__LIST__ = $show_data_unfinished;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		                        			<td><?php echo ($vo["order_num"]); ?></td>
		                        			<td><?php echo ($vo["provider_name"]); ?></td>
											<td>
			                            		<a href="/shop/index.php/Admin/mall/order_share_detail/id/<?php echo ($vo["order_id"]); ?>">查看详情</a>
			                            	</td>
		                        			<td><?php echo ($vo["order_time"]); ?></td>
		                        			<td><?php echo ($vo["customer_name"]); ?></td>
		                        			<td><?php echo ($vo["mailname"]); ?></td>
		                        			<td>&yen;<?php echo ($vo["money"]); ?></td>
		                        			<td><?php echo ($vo["state"]); ?></td>
		                        			<td>
			                        			<a href="/shop/index.php/Admin/mall/invoice/id/<?php echo ($vo["order_id"]); ?>">
													<i class="fa fa-eye"></i>
													查看
												</a>
			                            	</td> 
		                        		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		                        </tbody>
		                        <tfoot>
		                            <tr>
		                                <th>订单号</th>
		                                <th>商家名称</th>
		                                <th>创客名称</th>
		                                <th>下单时间</th>
		                                <th>下单用户</th>
		                                <th>收货人</th>
		                                <th>金额</th>
		                                <th>订单状态</th>
		                                <th>操作</th>
		                            </tr>
		                        </tfoot>
		                    </table>
                        </div>
                    </div>
                    <!-- 未完成订单结束 -->
                    <!-- 已完成订单开始 -->
					<div id="tab-finished" class="tab-pane">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover dataTables-example " >
		                        <thead>
		                            <tr>
		                                <th>订单号</th>
		                                <th>商家名称</th>
		                                <th>创客名称</th>
		                                <th>下单时间</th>
		                                <th>下单用户</th>
		                                <th>收货人</th>
		                                <th>金额</th>
		                                <th>订单状态</th>
		                                <th>操作</th>
		                            </tr>
		                        </thead>
		                        <tbody>
									<?php if(is_array($show_data_finished)): $i = 0; $__LIST__ = $show_data_finished;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		                        			<td><?php echo ($vo["order_num"]); ?></td>
		                        			<td><?php echo ($vo["provider_name"]); ?></td>
											<td>
			                            		<a href="/shop/index.php/Admin/mall/order_share_detail/id/<?php echo ($vo["order_id"]); ?>">查看详情</a>
			                            	</td>
		                        			<td><?php echo ($vo["order_time"]); ?></td>
		                        			<td><?php echo ($vo["customer_name"]); ?></td>
		                        			<td><?php echo ($vo["mailname"]); ?></td>
		                        			<td>&yen;<?php echo ($vo["money"]); ?></td>
		                        			<td><?php echo ($vo["state"]); ?></td>
		                        			<td>
			                        			<a href="/shop/index.php/Admin/mall/invoice/id/<?php echo ($vo["order_id"]); ?>">
													<i class="fa fa-eye"></i>
													查看
												</a>
			                            	</td> 
		                        		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		                        </tbody>
		                        <tfoot>
		                            <tr>
		                                <th>订单号</th>
		                                <th>商家名称</th>
		                                <th>创客名称</th>
		                                <th>下单时间</th>
		                                <th>下单用户</th>
		                                <th>收货人</th>
		                                <th>金额</th>
		                                <th>订单状态</th>
		                                <th>操作</th>
		                            </tr>
		                        </tfoot>
		                    </table>
                        </div>
                    </div>
					<!-- 已完成订单结束 -->
                </div>
            </div>
        </div>
	</div>

	<script src="/shop/Public/Admin/js/jquery.min.js"></script>
    <script src="/shop/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/shop/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/shop/Public/Admin/js/plugins/jeditable/jquery.jeditable.js"></script>
    <script src="/shop/Public/Admin/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/shop/Public/Admin/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/shop/Public/Admin/js/content.min.js?v=1.0.0"></script>
    <script>
        $(document).ready(function(){$(".dataTables-example").dataTable();});
    </script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
</body>
</html>