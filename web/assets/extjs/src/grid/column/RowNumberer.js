Ext.define("Ext.grid.column.RowNumberer",{extend:"Ext.grid.column.Column",alternateClassName:"Ext.grid.RowNumberer",alias:"widget.rownumberer",text:"&#160",width:23,sortable:false,draggable:false,autoLock:true,lockable:false,align:"right",constructor:function(a){var b=this;b.width=b.width;b.callParent(arguments);b.scope=b},resizable:false,hideable:false,menuDisabled:true,dataIndex:"",cls:Ext.baseCSSPrefix+"row-numberer",tdCls:Ext.baseCSSPrefix+"grid-cell-row-numberer "+Ext.baseCSSPrefix+"grid-cell-special",innerCls:Ext.baseCSSPrefix+"grid-cell-inner-row-numberer",rowspan:undefined,renderer:function(g,a,e,b,d,h){var c=this.rowspan,f=h.currentPage,i=e.index;if(c){a.tdAttr='rowspan="'+c+'"'}if(i==null){i=b;if(f>1){i+=(f-1)*h.pageSize}}return i+1}});