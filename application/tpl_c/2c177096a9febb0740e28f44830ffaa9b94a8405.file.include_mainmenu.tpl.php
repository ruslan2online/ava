<?php /* Smarty version Smarty-3.1.18, created on 2016-02-26 02:54:53
         compiled from "application/tpl/admin/include_mainmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1293398093564f21aa735963-78901029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c177096a9febb0740e28f44830ffaa9b94a8405' => 
    array (
      0 => 'application/tpl/admin/include_mainmenu.tpl',
      1 => 1456443853,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1293398093564f21aa735963-78901029',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_564f21aa7835c1_06011578',
  'variables' => 
  array (
    'data' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_564f21aa7835c1_06011578')) {function content_564f21aa7835c1_06011578($_smarty_tpl) {?><nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">AVA CMS</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<?php  $_smarty_tpl->tpl_vars["v"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["v"]->_loop = false;
 $_smarty_tpl->tpl_vars["k"] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['conf']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["v"]->key => $_smarty_tpl->tpl_vars["v"]->value) {
$_smarty_tpl->tpl_vars["v"]->_loop = true;
 $_smarty_tpl->tpl_vars["k"]->value = $_smarty_tpl->tpl_vars["v"]->key;
?>
					<li <?php if (($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['data']->value['module'])) {?>class="active"<?php }?>><a href="/admin/module/<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
				<?php } ?>
				<!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>	 -->			
				<!-- <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">Separated link</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li> -->
			</ul>
			<!-- <form class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form> -->
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">Выйти</a></li>
				<!-- <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">Separated link</a></li>
					</ul>
				</li> -->
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav><?php }} ?>
