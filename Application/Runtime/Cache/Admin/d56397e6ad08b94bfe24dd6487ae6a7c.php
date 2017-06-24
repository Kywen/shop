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
	<form method="post" action="">
		<!-- 1-title -->
		<div class="row-sx-2  ibox-content border-bottom">
			<h2>商品-商品列表</h2>
			<span>您可以在这里对商品进行查看</span>	
		</div>
		<br>

		<!-- 2-小提示 -->
		<div class="row-sx-2">
			<div class="panel panel-success">
	            <div class="panel-heading">小提示</div>
	            <div class="panel-body">
	            <ul>
	            	<li>您可以在此处对供应商提交的商品进行审核，审核成功后的商品将显示在商城首页，审核不成功的商品信息将会返回至供应商。</li>
	            	<li>利润比例：您可以自行设置利润比例，默认为30%。范围（0%--150%）</li>
	            	<li>利润计算样例：若该商品供应商提供成本价为100元，则平台以其30%的利润售出，即为100*130% = 130元。</li>
	            </ul>
	            </div>
	        </div>
		</div>
		
		<!-- 3 -table-->
		<div class="row-sx-8">
	        <div class="col-sm-12">
	            <div class="ibox float-e-margins">
	                <div class="ibox-title">
	                    <h5>商品列表</h5>
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
	                    <table class="table table-striped table-bordered table-hover dataTables-example " >
	                        <thead>
	                            <tr> 
		                            <th>选择</th>
	                                <th>编号</th>
	                                <th>商品名称</th>
	                                <th>商家名称</th>
	                                <th>原产地</th>
	                                <th>创客分享情况</th>
	                                <th>货号</th>
	                                <th>成本</th>
	                                <th>利润比例%</th>
	                                <th>平台售价</th>
	                                <th>上架</th>
	                                <th>库存</th>
	                                <th>销量</th>
	                                <th>操作</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <?php if(is_array($show_data)): $i = 0; $__LIST__ = $show_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			                            <td><input type="checkbox" name="chkItem" value="<?php echo ($vo["id"]); ?>"></td>
		                            	<td class="modelID"><?php echo ($vo["id"]); ?></td>
		                             	<td><?php echo ($vo["commodity_name"]); ?></td>
		                            	<td><?php echo ($vo["provider"]); ?></td>
		                            	<td><?php echo ($vo["province"]); ?></td>
		                            	<td>
		                            		<a href="/shop/index.php/Admin/mall/share_detail/id/<?php echo ($vo["id"]); ?>">查看详情</a>
		                            	</td>
		                            	<td><?php echo ($vo["id"]); ?></td>
		                            	<td class="prime_cost"><?php echo ($vo["prime_cost"]); ?></td>
		                            	<td class="modelname"><?php echo ($vo["profit_ratio"]); ?></td>
		                            	<td class="unitprice"><?php echo ($vo["unitprice"]); ?></td>
		                            	<td><?php echo ($vo["state"]); ?></td>
		                            	<td><?php echo ($vo["amount"]); ?></td>
		                            	<td><?php echo ($vo["sales_volume"]); ?></td>
		                            	<td>
											<a href="/shop/index.php/Admin/mall/good_exam_ok/id/<?php echo ($vo["id"]); ?>">
												<i class="fa fa-check"></i>
												审核通过
											</a>
											<a href="/shop/index.php/Admin/mall/good_exam_no/id/<?php echo ($vo["id"]); ?>">
												<i class="fa fa-remove"></i>
												审核不通过
											</a>
		                            	</td>
		                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	                        </tbody>
	                        <tfoot>
	                            <tr>
		                            <th>选择</th>
	                                <th>编号</th>
	                                <th>商品名称</th>
	                                <th>商家名称</th>
	                                <th>原产地</th>
	                                <th>创客分享情况</th>
	                                <th>货号</th>
	                                <th>成本</th>
	                                <th>利润比例%</th>
	                                <th>平台售价</th>
	                                <th>上架</th>
	                                <th>库存</th>
	                                <th>销量</th>
	                                <th>操作</th>
	                            </tr>
	                        </tfoot>
	                    </table>
	                    <input type="checkbox" id="all">
						<input type="button" value="全选" class="btn btn-primary" id="selectAll">  
						<input type="button" value="全不选" class="btn btn-primary" id="unSelect">  
						<input type="button" value="反选" class="btn btn-primary" id="reverse">  
						<input type="button" value="一键审核通过" class="btn btn-primary" id="deal_all_ok">
						<input type="button" value="一键审核不通过" class="btn btn-primary" id="deal_all_no">

	                </div>
	            </div>
	        </div>
		</div>
	</form>



	<script src="/shop/Public/Admin/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(function () {  
		    $(".modelname").click(function() {
		    //给页面中的modelname的标签加上click事件  
		        var objTD = $(this);  
		        //点击后，内容变成文本框  
		        var oldText = $(this).text();  //保存原来的文本  
		        var input =$( "<input type='text'  value='" + oldText + "'/>");//文本框的html代码  
		        objTD.html(input);  //td变为文本  
		        //设置文本框的点击事件失效  
		        input.click(function () {  
		            return false;  
		        });  
		        //设置文本框的样式  
		        input.css("border-width", 0);  //边框为0  
		        input.css("margin", 0);  
		        input.css("padding", 0);  
		        input.css("color","black");
		        
		        //input.height(objTD.height);//文本框的高度为当前td的高度  
		        //input.width(objTD.width);  
		        input.trigger("focus").trigger("select");//全选  
		        //文本框失去焦点的时候变为文本  
		        input.blur(function () {  
		            var newText = $(this).val();  
		            var input_blur = $(this);  
		            //objTD.html(newText);  
		            //当原来的名称与修改后的名称不同时才进行数据库提交操作  
		            if (oldText != newText) {  
		  
		                //获取该模块名称对应的ID  
		                // var modelID = $.trim(objTD.prev().text());
			            var modelID = $.trim(objTD.siblings(".modelID").text());
			            var prime_cost = $.trim(objTD.siblings(".prime_cost").text());
			            var unitprice = $.trim(objTD.siblings(".unitprice").text())*(parseFloat(100)+parseFloat(newText))*0.01;
		                // AJAX异步更改数据库  
		                var url = "/shop/index.php/Admin/Mall/changeProfit?modelname="+encodeURI(encodeURI(newText)) +"&modelID=" + modelID+"&unitprice=" + unitprice;
		                // var url = "../handler/changeModelName.ashx?modelname=" + encodeURI(encodeURI(newText)) + "&modelID=" + modelID + "&t=" + new Date();  
		                $.get(url, function (data) {  
		                    if (data == "false") {  
		                    	alert("error");
		                        // $("#test").text("模块名称修改失败，请检查是否重复");  
		                        // input_blur.trigger("focus").trigger("select");  //文本框全选  
		                    }  
		                    else {  
		                        // $("#test").text(""); 
		                        objTD.siblings(".unitprice").html(unitprice);  
		                        objTD.html(newText);  
		                    }  
		                });  
		            }  
		            else {  
		                //前后文本一样，将文本宽变成标签
		                objTD.siblings(".unitprice").html(unitprice);    
		                objTD.html(newText);  
		            }  
		        });  
		        //在文本框中按下键盘某建  
		        input.keydown(function () {  
		            var jianzhi = event.keyCode;  
		            var input_keydown = $(this);  
		            switch (jianzhi) {  
		                case 13:   //按下回车，保存修改  
		                    var newText = input_keydown.val();//修改后的名称  
		                    //当原来的名称与修改后的名称不同时才进行数据库提交操作  
		                    if (oldText != newText) {  
		                        //获取该模块名称对应的ID  
		                        var modelID = $.trim(objTD.siblings(".modelID").text());
		                        var prime_cost = $.trim(objTD.siblings(".prime_cost").text());
					            var unitprice = $.trim(objTD.siblings(".prime_cost").text())*(parseFloat(100)+parseFloat(newText))*0.01;
				                // AJAX异步更改数据库  
				                var url = "/shop/index.php/Admin/Mall/changeProfit?modelname="+encodeURI(encodeURI(newText)) +"&modelID=" + modelID+"&unitprice=" + unitprice;
				                // var url = "../handler/changeModelName.ashx?modelname=" + encodeURI(encodeURI(newText)) + "&modelID=" + modelID + "&t=" + new Date();  
				                $.get(url, function (data) {  
				                    if (data == "false") {  
				                    	alert("error");
				                        // $("#test").text("模块名称修改失败，请检查是否重复");  
				                        // input_blur.trigger("focus").trigger("select");  //文本框全选  
				                    }  
				                    else {  
				                        // $("#test").text(""); 
				                        objTD.siblings(".unitprice").html(unitprice);  
				                        objTD.html(newText);  
				                    }  
				                });    
		                    }  
		                    else {  
		                        //前后文本一样，将文本宽变成标签
		                        objTD.siblings(".unitprice").html(unitprice);    
		                        objTD.html(newText);  
		                    }  
		                    break;  
		                case 27:    //按下Esc，取消修改，吧文本框变成文本  
		                    // $("#test").text("");
		                    objTD.siblings(".unitprice").html(unitprice);   
		                    objTD.html(oldText);  
		                    break;  
		            }  
		        });  
		    });  		     
		}); 
		//屏蔽Enter按键  
		$(document).keydown(function (event) {  
		    switch (event.keyCode) {  
		        case 13: return false;  
		    }  
		}); 
	</script>
	<script type="text/javascript">
		//全选或全不选。
		$("#all").click(function(){   
		    if(this.checked){   
		        $("[name = chkItem]:checkbox").prop("checked", true);  
		    }else{   
			$("[name = chkItem]:checkbox").prop("checked", false);
		    }   
		});
		//全选。
		$("#selectAll").click(function () {
		   $("[name = chkItem]:checkbox,#all").prop("checked", true);  
		});

		$("#unSelect").click(function () {  
		   $("[name = chkItem]:checkbox,#all").prop("checked", false);  
		});

		$("#reverse").click(function () { 
		    $("[name = chkItem]:checkbox").each(function () {  
	        $(this).prop("checked", !$(this).prop("checked"));  
		    });
			allchk();
		});
		//设置全选复选框
		$("[name = chkItem]:checkbox").click(function(){
			allchk();
		});
		//一键审核通过
		$("#deal_all_ok").click(function(){
			var valArr = new Array;
		    $("input[name = 'chkItem']:checked").each(function(i){
				valArr[i] = $(this).val();
		    });
		    // console.log(valArr);
		    if (valArr.length != 0) {
		    	window.location.href="deal_all_ok?ids="+valArr;
		    }else{
		    	alert("未选择任何数据");
		    }
		});
		//一键审核不通过
		$("#deal_all_no").click(function(){
			var valArr = new Array;
		    $("input[name = 'chkItem']:checked").each(function(i){
				valArr[i] = $(this).val();
		    });
		    // console.log(valArr);
		    if (valArr.length != 0) {
		    	window.location.href="deal_all_no?ids="+valArr;
		    }else{
		    	alert("未选择任何数据");
		    }
		});
		function allchk(){
			var chknum = $("[name = chkItem]:checkbox").size();
			//选项总个数
			var chk = 0;
			$("[name = chkItem]:checkbox").each(function () {  
		        if($(this).prop("checked")==true){
					chk++;
				}
		    });
			if(chknum==chk){
				//全选
				$("#all").prop("checked",true);
			}else{
				//不全选
				$("#all").prop("checked",false);
			}
		}
	</script>
    <script src="/shop/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/shop/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/shop/Public/Admin/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/shop/Public/Admin/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/shop/Public/Admin/js/content.min.js?v=1.0.0"></script>
    <script>
        $(document).ready(function(){$(".dataTables-example").dataTable();});
    </script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
</body>
</html>