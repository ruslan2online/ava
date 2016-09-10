{literal}
<!-- (Irrelevant source removed.) -->

<style type="text/css">
  /* Define custom width and alignment of table columns */
  #treetable {
    table-layout: fixed;
  }
  #treetable tr td:nth-of-type(1) {
    text-align: right;
  }
  #treetable tr td:nth-of-type(2) {
    text-align: center;
  }
  #treetable tr td:nth-of-type(3) {
    min-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>


<!-- Add code to initialize the tree when the document is loaded: -->
<script type="text/javascript">
  glyph_opts = {
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
  };
  $(function(){
    //console.log( DataSet.url_base);

    $("#treetable").fancytree({
      extensions: ["dnd", "edit", "glyph", "table"],
      checkbox: true,
      dnd: {
        focusOnClick: true,
        dragStart: function(node, data) { return true; },
        dragEnter: function(node, data) { return true; },
        dragDrop: function(node, data) { data.otherNode.moveTo(node, data.hitMode); }
      },
      glyph: glyph_opts,
      source: {url:  DataSet.url_base+'gettree/pages', debugDelay: 1000},
      table: {
        checkboxColumnIdx: 1,
        nodeColumnIdx: 2
      },

      activate: function(event, data) {
      		console.log(data.node.key);
      		HTML.openModalModuleForm(data.node.key);
      },
      // lazyLoad: function(event, data) {
      //   data.result = {url: "ajax-sub2.json", debugDelay: 1000};
      // },
      renderColumns: function(event, data) {
        var node = data.node,
          $tdList = $(node.tr).find(">td");
        $tdList.eq(0).text('#'+node.getIndexHier());
        //$tdList.eq(3).text(!!node.folder);
        $tdList.eq(3).html('<div class="btn-group pull-right" role="group" aria-label="..."><button type="button" class="btn btn-primary btn-xs jsbtn_record_edit ignore-dragging" data-id="'+node.getIndexHier()+'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ред.</button><button type="button" class="btn btn-default btn-xs jsbtn_record_del ignore-dragging" data-id="'+node.getIndexHier()+'"> <span class="glyphicon glyphicon-glyphicon glyphicon-remove" aria-hidden="true"></span> уд.</button></div>');
      }
    });
  });
</script>

<!-- (Irrelevant source removed.) -->



  <h3> Список </h3>

  

  <table id="treetable" class="table table-condensed table-hover table-striped fancytree-fade-expander ">
    <colgroup>
      <col width="80px"></col>
      <col width="30px"></col>
      <col width="*"></col>
      <col width="200px"></col>
      <col width="50px"></col>
      <col width="50px"></col>
    </colgroup>
    <!-- <thead>
      <tr> <th></th> <th></th> <th>Classification</th> <th>Folder</th> <th></th> <th></th> </tr>
    </thead> -->
    <tbody>
      <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> </tr>
    </tbody>
  </table>

{/literal}
  <!-- (Irrelevant source removed.) -->