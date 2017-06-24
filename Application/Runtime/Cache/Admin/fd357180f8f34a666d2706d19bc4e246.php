<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>商品列表</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="/shop/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/shop/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
	<link href="/shop/Public/Admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/animate.min.css" rel="stylesheet">
    <link href="/shop/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
	<!-- 3 -table-->
	<div class="row-sx-8">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo ($good_name["good_name"]); ?>--创客分享情况</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="">
                        <a href="../../goods_list" class="btn btn-primary ">返回商品列表</a>
                    </div>

                    <table class="table table-striped table-bordered table-hover dataTables-example " >
                        <thead>
                            <tr> 
                                <th>编号</th>
                                <th>创客名称</th>
                                <th>个人小店名</th>
                                <th>小店图标</th>
                                <th>销售量</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($show_data)): $i = 0; $__LIST__ = $show_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	                            	<td><?php echo ($vo["num"]); ?></td>
	                            	<td><?php echo ($vo["username"]); ?></td>
	                            	<td><?php echo ($vo["store_name"]); ?></td>
	                            	<td>
										<img src="<?php echo ($vo["icon"]); ?>" style="width: 50px;height: 50px">
	                            	</td>
	                            	<td><?php echo ($vo["sales_volume"]); ?></td>
	                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>编号</th>
                                <th>创客名称</th>
                                <th>个人小店名</th>
                                <th>小店图标</th>
                                <th>销售量</th>
                            </tr>
                        </tfoot>
                    </table>
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