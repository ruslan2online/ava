<?php /* Smarty version Smarty-3.1.18, created on 2016-02-26 02:34:26
         compiled from "application/tpl/admin/include_testupload.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9307386456720216c06115-68300197%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27ef8fdc286634fb2f274493aba17596adbae17d' => 
    array (
      0 => 'application/tpl/admin/include_testupload.tpl',
      1 => 1456443195,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9307386456720216c06115-68300197',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56720216c362a5_86202838',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56720216c362a5_86202838')) {function content_56720216c362a5_86202838($_smarty_tpl) {?><input class="fileupload" type="file" name="files" data-url="/admin/api_file_upload" multiple><div class="fileupload_c"></div>

<div id="progress">
    <div class="bar" style="width: 0%;"></div>
</div>
<script>
$(function () {
    $('.fileupload').fileupload({
        dataType: 'json',
      
        done: function (e, data) {
            console.log(data);
            $.each(data.result.files, function (index, file) {
                $('.fileupload_c').after('<div>'+file.name+'</div>');
            });
        },
        progressall: function (e, data) {
	        var progress = parseInt(data.loaded / data.total * 100, 10);
	        $('#progress .bar').css(
	            'width',
	            progress + '%'
	        );
    	}
    });
});
</script><?php }} ?>
