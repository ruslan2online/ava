<?php /* Smarty version Smarty-3.1.18, created on 2016-09-05 17:19:37
         compiled from "application\tpl\admin\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:208395784a1151eea50-05170524%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa90a79e76bf831be60144a7756b2e1d38b0f5d8' => 
    array (
      0 => 'application\\tpl\\admin\\index.tpl',
      1 => 1473081573,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '208395784a1151eea50-05170524',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5784a115243f60_56332858',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5784a115243f60_56332858')) {function content_5784a115243f60_56332858($_smarty_tpl) {?><html>
<head>
<title>AVACMS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="/bootstrap/css/bootstrap.flat.min.css">
<link rel="stylesheet" href="/avafiles/css/admin.css">
<link rel="stylesheet" href="/avafiles/css/ui.fancytree.css">

<!-- Optional theme -->
<!-- <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css"> -->

<!-- Latest compiled and minified JavaScript -->
<script src="/avafiles/js/jquery/jquery.js"></script>
<script src="/avafiles/js/jquery/jquery.ui.js"></script>
<script src="/avafiles/js/jquery/jquery-ui.custom.js"></script>
<script src="/avafiles/js/jquery/jquery.cookie.js"></script>
<script src="/avafiles/js/jquery/jquery.fileupload.js"></script>

<script src="/avafiles/js/jquery/jquery.fancytree.js"></script>
<script src="/avafiles/js/jquery/jquery.fancytree.dnd.js"></script>
<script src="/avafiles/js/jquery/jquery.fancytree.edit.js"></script>
<script src="/avafiles/js/jquery/jquery.fancytree.glyph.js"></script>
<script src="/avafiles/js/jquery/jquery.fancytree.table.js"></script>
<script src="/avafiles/js/jquery/jquery.fancytree.persist.js"></script>

<script src="/avafiles/js/jquery/tinymce.min.js"></script>
<!-- <script src="/avafiles/js/jquery/plupload.min.js"></script>
<script src="/avafiles/js/jquery/jquery.ui.plupload.js"></script> -->
<!-- <script src="/avafiles/js/jquery/jquery.uploadify.min.js"></script> -->

<!-- <script src="/avafiles/js/jquery/FileAPI.min.js"></script>
<script src="/avafiles/js/jquery/FileAPI.exif.js"></script>
<script src="/avafiles/js/jquery/jquery.fileapi.min.js"></script> -->




<script src="/avafiles/js/admin.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body data-module="<?php echo $_smarty_tpl->tpl_vars['data']->value['module'];?>
">
<div class="loading"><div></div></div>
<?php echo $_smarty_tpl->getSubTemplate ("admin/include_mainmenu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("admin/include_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="container">
	<div class="row">
		<div class="col-md-10"><h3></h3></div>		
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="well1">
				<span class="btn btn-xs btn-primary jsbtn_record_new" data-parent="0"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> добавить запись</span>
			</div>
		</div>
		<div class="col-md-10">
			<div class="well1" >
				  	<table id="treetable" class="table table-condensed table-hover table-striped fancytree-fade-expander ">
					    <colgroup>
						<col width="20px"></col>
						<col width="10px"></col>
						<col width="*"></col>
						<col width="200px"></col>						
					    </colgroup>
					    <!-- <thead>
					      <tr> <th></th> <th></th> <th>Classification</th> <th>Folder</th> <th></th> <th></th> </tr>
					    </thead> -->
					    <tbody>
					      	<tr> 
						      	<td width="20px" style="color:#ddd;font-size:12px;"></td>
						      	<td width="10px"></td>
						      	<td></td>
						      	<td></td>
						    </tr>
					    </tbody>
				  </table>
			</div>
			<div class="remark" ><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> 
				Двойной клик по строке открывает окно редактирования. 
				<span class="jscontainer_remark_quickedit display_none">Shift+click включает режим быстрого редактирования.</span>
			</div>
		</div>				
	</div>
</div>
<footer class="footer">
  <div class="container">
    <p class="text-muted">&copy; AVALAb</p>
  </div>
</footer>

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
