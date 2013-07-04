Ext.define("Ext.grid.plugin.RowEditing",{extend:"Ext.grid.plugin.Editing",alias:"plugin.rowediting",requires:["Ext.grid.RowEditor"],lockableScope:"top",editStyle:"row",autoCancel:true,errorSummary:true,constructor:function(){var a=this;a.callParent(arguments);if(!a.clicksToMoveEditor){a.clicksToMoveEditor=a.clicksToEdit}a.autoCancel=!!a.autoCancel},destroy:function(){Ext.destroy(this.editor);this.callParent(arguments)},startEdit:function(a,e){var d=this,c=d.getEditor(),b;if(c.beforeEdit()!==false){b=d.callParent(arguments);if(b){d.context=b;if(d.lockingPartner){d.lockingPartner.cancelEdit()}c.startEdit(b.record,b.column,b);return true}}return false},cancelEdit:function(){var a=this;if(a.editing){a.getEditor().cancelEdit();a.callParent(arguments);return}return true},completeEdit:function(){var a=this;if(a.editing&&a.validateEdit()){a.editing=false;a.fireEvent("edit",a,a.context)}},validateEdit:function(){var j=this,g=j.editor,b=j.context,f=b.record,l={},d={},i=g.query(">[isFormField]"),h,c=i.length,a,k;for(h=0;h<c;h++){k=i[h];a=k.name;l[a]=k.getValue();d[a]=f.get(a)}Ext.apply(b,{newValues:l,originalValues:d});return j.callParent(arguments)&&j.getEditor().completeEdit()},getEditor:function(){var a=this;if(!a.editor){a.editor=a.initEditor()}return a.editor},initEditor:function(){return new Ext.grid.RowEditor(this.initEditorConfig())},initEditorConfig:function(){var g=this,c=g.grid,h=g.view,d=c.headerCt,e=["saveBtnText","cancelBtnText","errorsText","dirtyText"],i,a=e.length,f={autoCancel:g.autoCancel,errorSummary:g.errorSummary,fields:d.getGridColumns(),hidden:true,view:h,editingPlugin:g},j;for(i=0;i<a;i++){j=e[i];if(Ext.isDefined(g[j])){f[j]=g[j]}}return f},initEditTriggers:function(){var b=this,a=b.view,c=b.clicksToMoveEditor===1?"click":"dblclick";b.callParent(arguments);if(b.clicksToMoveEditor!==b.clicksToEdit){b.mon(a,"cell"+c,b.moveEditorByClick,b)}a.on({render:function(){b.mon(b.grid.headerCt,{scope:b,columnresize:b.onColumnResize,columnhide:b.onColumnHide,columnshow:b.onColumnShow})},single:true})},startEditByClick:function(){var a=this;if(!a.editing||a.clicksToMoveEditor===a.clicksToEdit){a.callParent(arguments)}},moveEditorByClick:function(){var a=this;if(a.editing){a.superclass.onCellClick.apply(a,arguments)}},onColumnAdd:function(a,c){if(c.isHeader){var d=this,b;d.initFieldAccessors(c);b=d.editor;if(b&&b.onColumnAdd){b.onColumnAdd(c)}}},onColumnRemove:function(a,c){if(c.isHeader){var d=this,b=d.getEditor();if(b&&b.onColumnRemove){b.onColumnRemove(a,c)}d.removeFieldAccessors(c)}},onColumnResize:function(a,d,c){if(d.isHeader){var e=this,b=e.getEditor();if(b&&b.onColumnResize){b.onColumnResize(d,c)}}},onColumnHide:function(a,c){var d=this,b=d.getEditor();if(b&&b.onColumnHide){b.onColumnHide(c)}},onColumnShow:function(a,c){var d=this,b=d.getEditor();if(b&&b.onColumnShow){b.onColumnShow(c)}},onColumnMove:function(a,d,c,f){var e=this,b=e.getEditor();e.initFieldAccessors(d);if(b&&b.onColumnMove){b.onColumnMove(d,c,f)}},setColumnField:function(b,d){var c=this,a=c.getEditor();a.removeField(b);c.callParent(arguments);c.getEditor().setField(b)}});