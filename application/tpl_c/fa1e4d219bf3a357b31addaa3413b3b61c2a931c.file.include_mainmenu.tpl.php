<?php /* Smarty version Smarty-3.1.18, created on 2016-07-12 11:49:41
         compiled from "application\tpl\admin\include_mainmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:151245784a1152b2ff6-71464911%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa1e4d219bf3a357b31addaa3413b3b61c2a931c' => 
    array (
      0 => 'application\\tpl\\admin\\include_mainmenu.tpl',
      1 => 1459942167,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151245784a1152b2ff6-71464911',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5784a1152df819_09308356',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5784a1152df819_09308356')) {function content_5784a1152df819_09308356($_smarty_tpl) {?><nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="http://www.avalab.ru" target="_blank">AVA CMS</a>
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
				<li><a href="/admin/logout">Выйти</a></li>
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
