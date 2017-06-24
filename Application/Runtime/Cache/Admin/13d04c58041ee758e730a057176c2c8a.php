<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>会员管理</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/shop/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/shop/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
	<link href="/shop/Public/Admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/animate.min.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
		<!-- 1-title -->
		<div class="row-md-1 ibox-content border-bottom">
			<h2>平台-会员管理</h2>		
		</div>
		<br>
		<!-- 2-提示信息 -->
		<div class="row-md-2">
			<div class="panel panel-success">
                <div class="panel-heading">会员列表</div>
                <div class="panel-body">
                <ul>
                	<li>该页面展示了所有商城的会员。</li>
                	<li>会员主要有4个等级：
                	普通会员<img src="http://139.199.198.151:8000/shop_img/images/putong.png" style="width: 20px;height: 20px">、
                	黄金会员<img src="http://139.199.198.151:8000/shop_img/images/huangjin.png" style="width: 20px;height: 20px">、
                	白金会员<img src="http://139.199.198.151:8000/shop_img/images/baijin.png" style="width: 20px;height: 20px">、
                	钻石会员<img src="http://139.199.198.151:8000/shop_img/images/zuanshi.png" style="width: 20px;height: 20px">。</li>
                	<li> 
                	在本平台消费金额0--300元：普通会员、
                	在本平台消费金额300--1000元：黄金会员、
                	在本平台消费金额1000--3000元：白金会员、
                	在本平台消费金额3000以上：钻石会员。
                	</li>
                </ul>
                </div> 
            </div>
		</div>
		<!-- 3 -表格-->
		<div class="row-md-6">
	        <div class="col-md-12">
	            <div class="ibox float-e-margins">
	            	<!-- 表格名 -->
	                <div class="ibox-title">
	                    <h5>会员列表</h5>
	                    <!-- 表格头工具栏 -->
	                    <div class="ibox-tools">
	                        <a class="collapse-link">
	                            <i class="fa fa-chevron-up"></i>
	                        </a>
	                        <a class="dropdown-toggle" data-toggle="dropdown" href="providers_list.html#">
	                            <i class="fa fa-wrench"></i>
	                        </a>
	                        <a class="close-link">
	                            <i class="fa fa-times"></i>
	                        </a>
	                    </div>
	                </div>
	                <!-- 表格内容 -->
	                <div class="ibox-content">
	                    <table class="table table-striped table-bordered table-hover dataTables-example" >
	                        <thead>
	                            <tr>
	                            	<th>编号</th>
	                                <th>用户名</th>
	                                <th>性别</th>
	                                <th>注册时间</th>
	                                <th>消费金额</th>
	                                <th>会员等级</th>
	                                <th>会员标志</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <?php if(is_array($show_data)): $i = 0; $__LIST__ = $show_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		                            	<td><?php echo ($vo["customer_id"]); ?></td>
		                            	<td><?php echo ($vo["uk_username"]); ?></td>
		                            	<td><?php echo ($vo["gender"]); ?></td>      
		                            	<td><?php echo ($vo["register_date"]); ?></td>
		                            	<td><?php echo ($vo["cost_money"]); ?></td> 
		                            	<td><?php echo ($vo["rank"]); ?></td>  
		                            	<td><img src="<?php echo ($vo["mark"]); ?>" style="width: 20px;height: 20px"></td>     
		                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	                        </tbody>
	                        <tfoot>
	                            <tr>
	                            	<th>编号</th>
	                                <th>用户名</th>
	                                <th>性别</th>
	                                <th>注册时间</th>
	                                <th>消费金额</th>
	                                <th>会员等级</th>
	                                <th>会员标志</th>
	                            </tr>
	                        </tfoot>
	                    </table>
	                </div>
	            </div>
	        </div>
		</div>
		
		<div class="row-md-3">
            <div id="echarts-customer-pie" class="row-md-12 col-md-12" style="width:800px;height: 400px"></div>
        </div>

	<script src="/shop/Public/Admin/js/jquery.min.js"></script>
    <script src="/shop/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/shop/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/shop/Public/Admin/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/shop/Public/Admin/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/shop/Public/Admin/js/content.min.js?v=1.0.0"></script>
    <script>
        $(document).ready(function(){
        	$(".dataTables-example").dataTable();
			
	    });
    </script>
    <script type="text/javascript">
    	var pie_data;
	        $.ajax({
	            url:"/shop/index.php/Admin/Platform/customer_mark_get",//这里指向的就不再是页面了，而是一个方法。
	            data:{},
	            type:"POST",
	            dataType:"JSON",
	            async : false,          
	            success: function(data){
	                pie_data = data;
	                // console.log(pie_data);
	            }
	        })
    </script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
    <script type="text/javascript" src="/shop/Public/Admin/js/plugins/echarts/echarts.min.js"></script>
	<script type="text/javascript" src="/shop/Public/Admin/js/echarts_customer.js"></script></body>
</html>