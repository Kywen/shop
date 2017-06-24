<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>注册页面</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- 编码格式 -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- bootstrap样式 -->
	<link href="/shop/Public/Home/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="/shop/Public/Admin/css/base.css"/>
	<!-- 动画样式 -->
	<link rel="stylesheet" href="/shop/Public/Admin/css/animate.css"/>
	<!-- 基本样式 -->
	<link rel="stylesheet" href="/shop/Public/Admin/css/index.css?v=1"/>
	<!-- 设置页面顶部浏览器上显示的icon图标 -->
	<link rel="icon" href="/shop/Public/Admin/images/icon.ico" type="image/x-icon"/>
</head>
<body>
<!-- main -->
	<div class="wrapper radius10px" ng-controller="myController">
		<form action="/shop/index.php/Admin/Index/registe" name="myForm" ng-submit="submitForm(myForm.$valid)" method="post" class="m-register" novalidate>
			<div class="row tc form-group  has-feedback">
				<span class="type">*帐号：</span>
				<input type="text" class="radius5px box-sizing space" ng-model="username" name="username" autofocus="autofocus" autocomplete="on" placeholder="限20位字母或者数字"  maxlength="20" required />
				<span class="glyphicon glyphicon-ok form-control-feedback"	ng-show="myForm.username.$dirty && myForm.username.$valid"></span>
			</div>
			<div class="row tc form-group  has-feedback">
				<span class="type">*昵称：</span>
				<input type="text" class="radius5px box-sizing space" ng-model="nickname" name="nickname" autofocus="autofocus" autocomplete="on" placeholder="限10位汉字、字母或者数字" maxlength="10" required/>
				<span class="glyphicon glyphicon-ok form-control-feedback"	ng-show="myForm.nickname.$dirty && myForm.nickname.$valid"></span>
			</div>
			<div class="row tc form-group has-feedback">
				<span class="type">*密码：</span>
				<input type="password" class="radius5px box-sizing space" ng-model="password" name="password" placeholder="6~20位字母或者数字"  maxlength="20" required ng-minlength="6"/>
				<span class="glyphicon glyphicon-ok form-control-feedback"	ng-show="myForm.password.$dirty && myForm.password.$valid"></span>
			</div>
			<div class="row tc form-group has-feedback">
				<span class="type">*确认密码：</span>     
				<input type="password" class="radius5px box-sizing " ng-model="passwordAgain " name="passwordAgain" placeholder="6~20位字母或者数字"  maxlength="20" required ng-minlength="6"/>				
				<span class="glyphicon glyphicon-ok form-control-feedback"	ng-show="myForm.passwordAgain.$dirty && myForm.passwordAgain.$valid && passwordAgain==password">					
				</span>
			</div>
			<div class="row tc">
				<button type="submit" class="btn btn-login" name="registBtn" ng-model="registBtn" id="submit" ng-disabled="myForm.$invalid">注册</button>				
			</div>
			<div class="u-redirect row tc "><a href="./login.html">已有帐号？直接登录</a></div>
		</form> 
	</div>
	<div class="footer tc">
		<p class="hide">为了更好地体验采供商城管理平台，建议您使用IE10、Chrome、FireFox、Safari、360等主流浏览器。</p>
		<p>&copy;采供商城管理平台</p>
	</div>

	
	<script src="/shop/Public/Admin/3rd/jquery-1.11.3.min.js"></script>
	<script src="/shop/Public/Admin/js/config.js"></script>
	<!-- md5加密 -->
	<script src="/shop/Public/Admin/js/md5.js"></script>
	<script src="/shop/Public/Home/js/bootstrap.js"></script>
	<script type="text/javascript" src="/shop/Public/Admin/3rd/angular/angular.min.js"></script>
	<!-- 使用angularjs实现双向数据绑定 -->
	<script type="text/javascript">
	    angular.module('myapp', [])
	        .controller('myController', function($scope) {
	            $scope.submitForm = function(isValid) {
	                if (!isValid) {
	                    alert('验证失败');
	                }
	            };
	        }
	    );
	</script>
</body>
</html>