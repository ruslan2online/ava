<?php /* Smarty version Smarty-3.1.18, created on 2016-07-12 11:44:58
         compiled from "application\tpl\admin\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1760457849ffa41d127-31827714%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '028628a556e82534de3ffebb414597dd36e7016e' => 
    array (
      0 => 'application\\tpl\\admin\\login.tpl',
      1 => 1459894340,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1760457849ffa41d127-31827714',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_57849ffa4424f4_10036846',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57849ffa4424f4_10036846')) {function content_57849ffa4424f4_10036846($_smarty_tpl) {?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="/bootstrap/css/bootstrap.flat.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="/design/js/jquery.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="well" style="margin-top:40%;">
				<form class="form-signin" role="form" method="POST">
					<h3 class="form-signin-heading text-center">Авторизация</h3>
					<input type="text" name="identity" class="form-control" placeholder="логин" required autofocus>
					<br>
					<input type="password" name="password" class="form-control" placeholder="пароль" required>
					<!-- <label class="checkbox">
						<input type="checkbox"  value="remember-me"> запомнить
					</label> -->
					<button class="btn btn-sm btn-primary btn-block"  style="margin-top:20px;" type="submit">войти</button>
				</form>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
</body>
</html><?php }} ?>
