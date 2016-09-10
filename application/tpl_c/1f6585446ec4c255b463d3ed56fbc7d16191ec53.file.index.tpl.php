<?php /* Smarty version Smarty-3.1.18, created on 2016-02-26 02:54:53
         compiled from "application/tpl/admin/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2130362819564f21aa60a1d4-41588558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f6585446ec4c255b463d3ed56fbc7d16191ec53' => 
    array (
      0 => 'application/tpl/admin/index.tpl',
      1 => 1456443854,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2130362819564f21aa60a1d4-41588558',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_564f21aa6fd5c8_47607462',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_564f21aa6fd5c8_47607462')) {function content_564f21aa6fd5c8_47607462($_smarty_tpl) {?><html>
<head>
<title>AVACMS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/design/css/admin.css">
<link rel="stylesheet" href="/design/css/jquery.fileupload.css">

<!-- Optional theme -->
<!-- <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css"> -->

<!-- Latest compiled and minified JavaScript -->
<script src="/design/js/jquery.js"></script>
<script src="/design/js/jquery.ui.widget.js"></script>


<script src="/design/js/jquery.iframe-transport.js"></script>
<script src="/design/js/jquery.fileupload.js"></script>
<!-- <script src="/design/js/jquery.fileupload-image.js"></script>
<script src="/design/js/jquery.fileupload-process.js"></script> -->



<script src="/design/js/admin.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body data-module="<?php echo $_smarty_tpl->tpl_vars['data']->value['module'];?>
">
<div class="loading"><div></div></div>
<?php echo $_smarty_tpl->getSubTemplate ("admin/include_testupload.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("admin/include_mainmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("admin/include_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="container">
	<div class="row">
		<div class="col-md-10"><h3></h3></div>		
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="well ava_box">			
				<div class="resultTable"></div>
			</div>
			<span class="btn btn-default jsbtn_record_new">Добавить</span>
		</div>
		<div class="col-md-4"></div>		
	</div>
</div>
<style>
.ava_box{
	padding: 5px;
}
.ava_box .panel{
	margin-bottom: 2px;
}
.ava_box .panel .panel-body{
	padding: 5px;
}	
</style>
</body>
</html><?php }} ?>
