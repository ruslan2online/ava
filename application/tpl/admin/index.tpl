<html>
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
<body data-module="{$data.module}">
<div class="loading"><div></div></div>
{include file="admin/include_mainmenu.tpl"}
{include file="admin/include_modal.tpl"}
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
</html>