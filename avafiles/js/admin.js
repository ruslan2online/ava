$(document).ready(function() {
	DataSet.module = $('body').attr('data-module');
	DataSet.getMainConf();
	//DataSet.fetchModuleData();		
	Tree.init();
	//HTML.loadingShow();	
			
}).on("submit", "form.jsform_module_form", function(){
	var id = $(this).find('input[name=id]').val();
	var form_data = $(this).serialize();
	//ниже костыль, поскольку serialize не включает в итоговую строку нечекнутые чекбоксы
	$(this).find("input[type=checkbox]:not(:checked)").each(function() {
        form_data += '&'+this.name+'=0';
    });
	DataSet.saveModuleData(form_data,id);
	return false;
//добавить новую запись	
}).on("click", ".jsbtn_record_new", function(){	
	var parent = $(this).attr('data-parent');
	HTML.openModalModuleForm(false,parent);
	return false;	 
}).on("click", ".jsbtn_record_edit", function(){		
	var id = $(this).attr('data-id');
	HTML.openModalModuleForm(id);
	return false;
}).on("dblclick", "#treetable tr", function(){
	var id = $(this).attr('data-id');
	HTML.openModalModuleForm(id);
	return false;	
}).on("click", ".jsbtn_record_del", function(){	
	var id = $(this).attr('data-id');
	if(confirm('Уверены, что хотите удалить?')){
		DataSet.deleteModuleData(id);
	}
	return false;
}).on("click", ".jsbtn_toggle_meta_block", function(){	
	var meta_block=$(this).parent().parent().find('.jscontainer_meta_block');
	if($(meta_block).attr('data-show')=='1'){
		$(meta_block).hide();
		$('.jsbtn_toggle_meta_block').html('<span  title="показать" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> показать');
		$(meta_block).attr('data-show','0');
	}
	else{
		$(meta_block).show();
		$('.jsbtn_toggle_meta_block').html('<span title="скрыть" class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> скрыть');
		$(meta_block).attr('data-show','1');
	}
	return false;		 
});

var DataSet = {
		
	url_base: "/admin/api/",
	url_upload_base: "/admin/api_upload/",  
	response:{},
	main_conf:{},//полностью конфиг
	current_conf:{},//конфиг текущего модуля
	module:'',
	GET: function(url,callback){		
			if(!url){
				console.log('no url!');
				return false;
			}
			HTML.loadingShow();
			$.ajax({
					url: DataSet.url_base+url,
					type: "GET"
			}).done(function(response){									
				data = $.parseJSON(response);
				DataSet.response=data.data;
				HTML.loadingHide();
				callback();				
			});
	},
	POST: function(url,postdata,callback){
			if(!url){
				console.log('no url!');
				return false;
			}
			HTML.loadingShow();			
			$.ajax({
					url: DataSet.url_base+url,
					type: "POST",
					data: postdata
			}).done(function(response){									
				data = $.parseJSON(response);
				DataSet.response=data.data;
				HTML.loadingHide();
				callback();
			});
	},
	GETupload: function(url,callback){		
			$.ajax({
					url: DataSet.url_upload_base+url,
					type: "GET"
			}).done(function(response){									
				data = $.parseJSON(response);				
				callback(data);				
			});
	},
	getMainConf: function(){
		DataSet.GET('get_main_conf',function(){
			DataSet.main_conf=DataSet.response;
			DataSet.current_conf=(DataSet.main_conf.modules[DataSet.module])?DataSet.main_conf.modules[DataSet.module]:{};
			//HTML.generateForm('',main_conf,module);
			HTML.init();
		});
	},
	fetchModuleData: function(){
		// if(!DataSet.module) return false;
		// DataSet.GET('get/'+DataSet.module,function(){
		// 	HTML.buildResultTable('.resultTable',DataSet.response);
		// });
		Tree.reload();
	},
	deleteModuleData: function(id){
		if(!DataSet.module) return false;
		DataSet.GET('del/'+DataSet.module+'/'+id,function(){
			DataSet.fetchModuleData(); //обновляем список записей
		});
	},
	fetchModuleDataOne: function(id,callback){
		if(!DataSet.module || !id) return false;
		DataSet.GET('get/'+DataSet.module+'/'+id,function(){
			//HTML.buildResultTable('.resultTable',DataSet.response);
			//console.log(DataSet.response);
			callback(DataSet.response);
		});
	},
	saveModuleData: function(form_data,id){
		if(!DataSet.module) return false;
		//console.log(form_data);
		if(!id){
			DataSet.POST('create/'+DataSet.module,form_data,function(){
				$('.jsmodal_module_form').modal('hide');
				DataSet.fetchModuleData(); //обновляем список записей
				return false;
			});	
		}
		else {
			DataSet.POST('update/'+DataSet.module+'/'+id,form_data,function(){
				$('.jsmodal_module_form').modal('hide');
				DataSet.fetchModuleData(); //обновляем список записей
				return false;
			});	
		}		
	}
}


var HTML ={
	init:function(){
		if(DataSet.current_conf.editonly){
			$('.jsbtn_record_new').hide();			
		}
		if(DataSet.current_conf.quickedit){
			$('.jscontainer_remark_quickedit').show();			
		}
	},
	loadingShow: function(){
		$('.loading').show();
	},
	loadingHide: function(){
		$('.loading').hide();
	},
	buildResultTable: function(ident,data){ //!deprecated
		var html_str='';
		//console.log(data);
		$.each(data,function(i,e){
			html_str+=	'<li data-id="'+e.id+'" >'
							+'<div class="panel panel-default">'
								//+'<span class="glyphicon glyphicon-th" aria-hidden="true"></span>'
								+'<div class="panel-body">'
									+'<div class="col-xs-1"><span class="glyphicon glyphicon-th" aria-hidden="true"></span></div>'
									+'<div class="col-xs-7 ignore-dragging"><span class="label label-default">#'+e.id+'</span> <a href="#" class="jsbtn_record_edit ignore-dragging" data-id="'+e.id+'">'+e.name+'</a></div>'
									+'<div class="col-xs-4 ignore-dragging"><div class="btn-group pull-right" role="group" aria-label="..."><button type="button" class="btn btn-default btn-xs jsbtn_record_edit ignore-dragging" data-id="'+e.id+'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ред.</button>'
										+' <button type="button" class="btn btn-default btn-xs jsbtn_record_del ignore-dragging" data-id="'+e.id+'"> <span class="glyphicon glyphicon-glyphicon glyphicon-remove" aria-hidden="true"></span> уд.</button></div>'
									+'</div>'
								+'</div>'
							+'</div>'
						+'</li>';
			// html_str+=	'<li data-id="'+e.id+'" class="dd-item"  style="margin:10px; padding:5px;height:50px;width:100%;">'
			// 				+'<div class="dd-handle glyphicon glyphicon-th" style="color:#aaa;left:0px;top:5px;font-size:12px;width:100px;height:20px;"></div>'
			// 				+'<div class="panel panel-default " style="left:20px;top:0;width:500px;height:50px;">'
			// 					+'<div class="col-xs-8"><span class="label label-default">#'+e.id+'</span> <a href="#" class="jsbtn_record_edit" data-id="'+e.id+'">'+e.name+'</a></div>'
			// 					+'<div class="col-xs-4"><div class="btn-group pull-right" role="group" aria-label="..."><button type="button" class="btn btn-default btn-xs jsbtn_record_edit" data-id="'+e.id+'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ред.</button>'
			// 					+' <button type="button" class="btn btn-default btn-xs jsbtn_record_del" data-id="'+e.id+'"> <span class="glyphicon glyphicon-glyphicon glyphicon-remove" aria-hidden="true"></span> уд.</button></div>'
			// 					+'</div>'
			// 				+'</div>'	
			// 			+'</li>';			
		});		
		$(ident).html(html_str?html_str:'<div class="alert alert-info" role="alert">Записей нет.</div>');		

	},
	openModalModuleForm:function(id,parent){
		$('.jscontainer_time_updated').hide();
		$('.jscontainer_time_created').hide();		

		if(id){//редактирование
			DataSet.fetchModuleDataOne(id,function(data){
				//console.log(data);
				HTML.generateModuleForm(data);
				$('.jscontainer_module_form_title').html('Редактирование записи');
				$('.jsmodal_module_form').modal('show');
				
				$('.jscontainer_time_created').show();
				$('.jscontainer_time_created span.datetime').html(data.time_created);
				if(data.time_updated){
					$('.jscontainer_time_updated').show();
					$('.jscontainer_time_updated span.datetime').html(data.time_updated);
				}				
			});	
		}
		else{//создание нового
			HTML.generateModuleForm(false,parent);
			if(parent && parseInt(parent)>0)	$('.jscontainer_module_form_title').html('Создание новой вложенной записи');
			else $('.jscontainer_module_form_title').html('Создание новой записи');
			$('.jsmodal_module_form').modal('show');
			
			UplFile.init();//хак, потому что первый раз не срабатывает 	
		}		
		$('.jsmodal_module_form').on('show.bs.modal', function (event) {
			UplFile.init();
		});		
	},
	generateModuleForm: function(data,parent){		
		try{
			var fields=DataSet.main_conf.modules[DataSet.module].fields;
		}catch(e){}
		var initWysiwyg=0;
		if(!DataSet.module || !DataSet.main_conf || !fields) return false;
		var str='';
		if(data){
			str+=HTML.generateElementText({
				'ident':'name',
				'title':'Название',
				'value':(data.name?data.name:'')
			});
			str+=HTML.generateElementHidden({
				'ident':'id',
				'value':data.id
			});
		}
		else {			
			str+=HTML.generateElementText({
				'ident':'name',
				'title':'Название',
				'value':''
			});
			str+=HTML.generateElementHidden({
				'ident':'parent',
				'value':parent
			});
		}

		
		$.each(fields,function(i,e){
			var element_title = e.title?e.title:i;
			var readonly = e.readonly?e.readonly:false;
			var value = data?data[i]:'';
			var id = data?data.id:'';
			
			switch(e.type){
				case 'text':
					str+=HTML.generateElementText({
						'ident':i,
						'title':element_title,
						'value':value,
						'readonly':readonly
					});
					break;
				case 'textarea':
					str+=HTML.generateElementTextarea({
						'ident':i,
						'title':element_title,
						'value':value,
						'readonly':readonly
					});
					break;	
				case 'img':
					str+=HTML.generateElementImg({
						'ident':i,
						'title':element_title,
						'value':value,
						'id':id
					});
					break;
				case 'wysiwyg':
					str+=HTML.generateElementWysiwyg({
						'ident':i,
						'title':element_title,
						'value':value,
						'id':id
					});
					initWysiwyg=1;
					break;	
				case 'check':
					str+=HTML.generateElementCheck({
						'ident':i,
						'title':element_title,
						'value':value						
					});
					break;			
				default:
					str+=HTML.generateElementText({
						'ident':i,
						'title':element_title,
						'value':value,
						'readonly':readonly
					});
					break;	
			}
			
		});

		//META
		if(!DataSet.current_conf.hide_meta){
			str+='<div class="panel panel-default"><div class="panel-heading">META Теги <span class="btn btn-default btn-xs pull-right jsbtn_toggle_meta_block"><span  title="показать" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> показать</span></div><div class="panel-body jscontainer_meta_block" data-show="0">';
			str+=HTML.generateElementText({
							'ident':'meta_t',
							'title':'Title',
							'value':(data.meta_t?data.meta_t:'')
						});
			str+=HTML.generateElementTextarea({
							'ident':'meta_d',
							'title':'Description',
							'value':(data.meta_d?data.meta_d:'')				
						});
			str+=HTML.generateElementText({
							'ident':'meta_k',
							'title':'Keywords',
							'value':(data.meta_k?data.meta_k:'')				
						});
			str+='</div></div>';
		}
		$('#jscontainer_module_form').html('<div class="form-group">'+str+'</div>');
		$('.jscontainer_meta_block').hide();
		if(initWysiwyg) tinymce.init({
			selector:'textarea.js_wysiwyg' ,
			menubar: false,
			height: 300,
			skin: 'lightgray' ,
			toolbar: [
			    'code | undo redo | bold italic | bullist numlist outdent indent | alignleft aligncenter alignright alignjustify | forecolor backcolor | link | table'			   
			],
			plugins: 'code textcolor link table'  // required by the code menu item
		});
	},
	generateElementText: function(p){
		var str='<div class="form-group">';
		str+='<label for="form_element_'+p.ident+'">'+p.title+'</label>';
		str+='<input type="text" '+(p.readonly?'readonly disabled':'')+' class="form-control" for="form_element_'+p.ident+'" value="'+p.value+'" name="'+p.ident+'" placeholder="'+p.title+'">';
		str+='</div>';
		return str;
	},
	generateElementHidden: function(p) {		
		str='<input type="hidden" value="'+p.value+'" name="'+p.ident+'">';		
		return str;
	},
	generateElementTextarea: function(p){
		var str='<div class="form-group">';
		str+='<label for="form_element_'+p.ident+'">'+p.title+'</label>';
		str+='<textarea '+(p.readonly?'readonly disabled':'')+' class="form-control" for="form_element_'+p.ident+'" name="'+p.ident+'" placeholder="'+p.title+'"  rows="5">'+p.value+'</textarea>';
		str+='</div>';
		return str;
	},
	generateElementWysiwyg: function(p){
		var str='<div class="form-group">';
		str+='<label for="form_element_'+p.ident+'">'+p.title+'</label>';
		str+='<textarea '+(p.readonly?'readonly disabled':'')+' class="form-control js_wysiwyg" for="form_element_'+p.ident+'" name="'+p.ident+'" placeholder="'+p.title+'"  rows="5">'+p.value+'</textarea>';
		str+='</div>';
		return str;
	},
	generateElementCheck: function(p){
		var str='<div class="form-group">';
		str+='<label>'+p.title+'</label>';
		str+='&nbsp;&nbsp;<input type="checkbox" '+((parseInt(p.value))?'checked':'')+' name="'+p.ident+'" >';
		str+='</div>';
		return str;
	},
	generateElementImg: function(p){		
		var str='<div class="form-group">'
					+'<label for="form_element_'+p.ident+'">'+p.title+'</label>'
					+'<div class="panel panel-default jscontainer_fileupload fileupload">'
						+'<div class="panel-body">'
							+'<input  class="fileinput-value" type="hidden" value="'+p.value+'" name="'+p.ident+'" >'
							+'<div class="fileinput-buttons btn-group" role="group">'
			                    +'<span class="btn btn-xs btn-default fileinput-button">'
			                        +'<i class="glyphicon glyphicon-plus"></i> '
			                        +'<span>Выбрать файл</span>'			                       
			                        +'<input class="js_fileupload" data-url="/admin/api_upload/upload/'+DataSet.module+'/'+p.ident+'/'+p.id+'" data-field="'+p.ident+'" type="file" name="userfiles">'
			                    +'</span>'
			                    +'<span class="btn btn-xs btn-default fileinput-del">'
			                    	+'<i class="glyphicon glyphicon-remove"></i> '
			                    	+'удалить'
			                    +'</span>'
			                +'</div>'
			                +'<div class="fileinput-img"><img src=""><span class="glyphicon glyphicon-ban-circle"></span></div>'
			                +'<div class="fileinput-name"></div>'
			                +'<div class="fileinput-size"></div>'
			                +'<div class="fileinput-progress progress">'
			                    +'<div class="progress-bar"></div>'
			                +'</div>'
						+'</div>'
					+'</div>'
				+'</div>';
		return str;
	}
}

var UplFile={
	init: function(url){		
		$('.js_fileupload').fileupload({
            //url: url+'upload/'+DataSet.module+'/'+$(this).attr('data-field')+'/'+$(this).parents('form').find('input[name=id]').val(),
            dataType: 'json',             
            create:function(){
            	var id=$(this).parents('.jscontainer_fileupload').find('.fileinput-value').val();
            	UplFile.refreshImg(id,$(this));

            	$(this).parents('.jscontainer_fileupload').find('.fileinput-del').bind('click',function(){
            		if (confirm("Вы уверены? Изображение будет удалено после сохранения записи.")) {
            			UplFile.refreshImg(false,$(this));
            		}            		
            	});
            },           
            done: function (e, data) {
               	//console.log(data);
               	var thiss=$(this);
                $.each(data.result.files, function (index, file) {                	
                	UplFile.attachImg(thiss,file);                  
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);               
                $(this).parents('.jscontainer_fileupload').find('.fileinput-progress .progress-bar').css('width',progress + '%');
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
	},
	refreshImg:function(id,obj){
		if(id){
			DataSet.GETupload('get_img/'+id,function(response){
				if(!response.error) UplFile.attachImg(obj,response.files[0]);
				else UplFile.noImg(obj);
			});
		}
		else{
			UplFile.noImg(obj);
		}
	},
	attachImg: function(obj,data){
		if(data.value) obj.parents('.jscontainer_fileupload').find('.fileinput-value').val(data.value);  
		obj.parents('.jscontainer_fileupload').find('.fileinput-progress').show();
		obj.parents('.jscontainer_fileupload').find('.fileinput-del').show();
		obj.parents('.jscontainer_fileupload').find('.fileinput-name').html(data.name+' <span class="label label-info">'+data.size+'kB</span>');        	
    	//obj.parents('.jscontainer_fileupload').find('.fileinput-size').html('<span class="label label-info">'+response.files[0].size+'kB</span>');
    	obj.parents('.jscontainer_fileupload').find('.fileinput-img span').hide();
    	obj.parents('.jscontainer_fileupload').find('.fileinput-img img').show().attr('src',data.thumb); 
	},
	noImg: function(obj){
		obj.parents('.jscontainer_fileupload').find('.fileinput-del').hide();
		obj.parents('.jscontainer_fileupload').find('.fileinput-progress').hide();
		obj.parents('.jscontainer_fileupload').find('.fileinput-name').html('<span class="grey">картинка отсутствует</span>');
		obj.parents('.jscontainer_fileupload').find('.fileinput-img img').hide();
		obj.parents('.jscontainer_fileupload').find('.fileinput-img span').show();
		obj.parents('.jscontainer_fileupload').find('.fileinput-value').val(''); 
	}

}

Tree={
	allow_update_active:true,	//разрешение на отправку на сервер активации/деактивации при клике на чекбокс
	glyph_opts:{
	    map: {
	      doc: "glyphicon glyphicon-file",
	      docOpen: "glyphicon glyphicon-file",
	      checkbox: "glyphicon glyphicon-unchecked",
	      checkboxSelected: "glyphicon glyphicon-check",
	      checkboxUnknown: "glyphicon glyphicon-share",
	      dragHelper: "glyphicon glyphicon-play",
	      dropMarker: "glyphicon glyphicon-arrow-right",
	      error: "glyphicon glyphicon-warning-sign",
	      expanderClosed: "glyphicon glyphicon-plus",
	      expanderLazy: "glyphicon glyphicon-menu-right",  // glyphicon-plus-sign
	      expanderOpen: "glyphicon glyphicon-minus",  // glyphicon-collapse-down
	      folder: "glyphicon glyphicon-folder-close",
	      folderOpen: "glyphicon glyphicon-folder-open",
	      loading: "glyphicon glyphicon-refresh glyphicon-spin"
	    }
  	},
  	init:function(){
		$("#treetable").fancytree({
			extensions: ["dnd", "edit", "glyph", "table", "persist"],
			checkbox: true,
			dnd: {
				focusOnClick: true,
				preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
    			preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
				dragStart: function(node, data) { return true; },
				dragEnter: function(node, data) { 
					console.log(DataSet.current_conf);
					if(DataSet.current_conf.tree)
						return true;
					else  
						return ["before","after"];
				},
				dragDrop: function(node, data) {
					data.otherNode.moveTo(node, data.hitMode);
					console.log(data);
					var sorted_list={}; 
					$.each(data.otherNode.parent.children,function(i,e){
						sorted_list[i]=e.key;
					});
					DataSet.POST('resort/'+DataSet.module,	{
															'list':sorted_list,
															'parent':data.otherNode.parent.key,															
															'el':data.otherNode.key															
															},function(){
						$('.jsmodal_module_form').modal('hide');						
						return false;
					});	 
				},
				dragExpand: function(node, data) {
					return true;
			      // return false to prevent auto-expanding parents on hover
			    },
			},
			glyph: Tree.glyph_opts,
			source: {url:  DataSet.url_base+'gettree/'+DataSet.module, debugDelay: 200},
			table: {
				checkboxColumnIdx: 1,
				nodeColumnIdx: 2
			},

			activate: function(event, data) {
				return false;
				//console.log(data.node.key);
				//HTML.openModalModuleForm(data.node.key);
			},
			select: function(event, data) {
		    	//console.log(data);
		    	if(Tree.allow_update_active){
			    	if(data.node.selected){
			    		DataSet.GET('activate/'+DataSet.module+'/'+data.node.key,function(){
						//обновляем список записей
						}); 
			    	}
			    	else{
			    		DataSet.GET('deactivate/'+DataSet.module+'/'+data.node.key,function(){
						//обновляем список записей
						});
			    	}
		    	}		   
		    },
			// lazyLoad: function(event, data) {
			//   data.result = {url: "ajax-sub2.json", debugDelay: 1000};
			// },
			renderColumns: function(event, data) {
				var node = data.node,
				$tdList = $(node.tr).find(">td");
				$(node.tr).attr('data-id',node.key);
				Tree.allow_update_active=false;
				if(node.data.check_active=='1')node.setSelected(true);
				Tree.allow_update_active=true;				
				//$tdList.eq(0).text('#'+node.getIndexHier());
				$tdList.eq(0).text('id'+node.key);
				//$tdList.eq(3).text(!!node.folder);
				var s='<div class="btn-group pull-right" role="group" aria-label="...">'
						+'<button title="Редактировать запись" type="button" class="btn btn-default btn-xs jsbtn_record_edit" data-id="'+node.key+'">'
							+'<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'
						+'</button>';
				if(DataSet.current_conf.tree && !DataSet.current_conf.editonly){						
						s+='<button  title="Создать новую вложенную запись" type="button" class="btn btn-default btn-xs jsbtn_record_new" data-parent="'+node.key+'">'
							+'<span class="glyphicon glyphicon-file" aria-hidden="true"></span>'
						+'</button>';
				}
				if(!DataSet.current_conf.editonly){	
						s+='<button  title="Удалить запись" type="button" class="btn btn-default btn-xs jsbtn_record_del" data-id="'+node.key+'">'	
							+'<span class="glyphicon glyphicon-glyphicon glyphicon-remove" aria-hidden="true"></span>'
						+'</button>';
				}
				s+='</div>';
				$tdList.eq(3).html(s);
			},
			edit: {
				     // Available options with their default:
				    adjustWidthOfs: 4,   // null: don't adjust input size to content
				    inputCss: {minWidth: "3em"},
				    triggerCancel: ["esc", "tab", "click"],
				    triggerStart: ["f2",  "shift+click", "mac+enter"],//"f2", "dblclick", "shift+click", "mac+enter"				  
				    beforeEdit: function(event, data){
				    	if(!DataSet.current_conf.quickedit)  	return false;
				      // `data.node` is about to be edited.
				      // Return false to prevent this.
				    },
				    edit: function(event, data){
				      // `data.node` switched into edit mode.
				      // The <input> element was created (available as jQuery object `data.input`) 
				      // and contains the original `data.node.title`.
				    },
				    beforeClose: function(event, data){console.log(data);
				      // Editing is about to end (either cancel or save).
				      // Additional information is available:
				      // - `data.orgTitle`: The previous node title text.
				      // - `data.input`:    The input element (jQuery object).
				      //                    `data.input.val()` returns the new node title.
				      // - `data.save`:     false if saving is not required, i.e. user pressed  
				      //                    cancel or text is unchanged.
				      // - `data.dirty`:    true if text was modified by user.
				      // - `data.isNew`:    true if this node was newly created using `editCreateNode()`.
				      // Return false to prevent this (keep the editor open), for example when 
				      // validations fail.
				    },
				    save: function(event, data){
				    	var newName=data.input.val();
				    	DataSet.POST('quickedit/'+DataSet.module,	{
															'id':data.node.key,
															'name':newName																																										
															},function(){
						$('.jsmodal_module_form').modal('hide');						
						return false;
					});
				      // Only called when the text was modified and the user pressed enter or
				      // the <input> lost focus.
				      // Additional information is available (see `beforeClose`).
				      // Return false to keep editor open, for example when validations fail.
				      // Otherwise the user input is accepted as `node.title` and the <input> 
				      // is removed.
				      // Typically we would also issue an Ajax request here to send the new data 
				      // to the server (and handle potential errors when the asynchronous request 
				      // returns). 
				    },
				    close: function(event, data){
				      // Editor was removed.
				      // Additional information is available (see `beforeClose`).
				    }
			},
			persist: {
			    // Available options with their default:
			    cookieDelimiter: "~",    // character used to join key strings
			    cookiePrefix: "ava-"+DataSet.module+"-", // 'fancytree-<treeId>-' by default
			    cookie: { // settings passed to jquery.cookie plugin
			      raw: false,
			      expires: "",
			      path: "",
			      domain: "",
			      secure: false
			    },
			    expandLazy: false, // true: recursively expand and load lazy nodes
			    overrideSource: true,  // true: cookie takes precedence over `source` data attributes.
			    store: "auto",     // 'cookie': use cookie, 'local': use localStore, 'session': use sessionStore
			    types: "active expanded focus"  // which status types to store
			}
		});
  	},
  	reload:function(){
  		var tree = $("#treetable").fancytree("getTree");
  		tree.reload().done(function(){
		  	//
		});
  	}
}

