Ext.define("Ext.grid.plugin.BufferedRendererTableView",{override:"Ext.view.Table",onAdd:function(b,a,c){var d=this,f=d.bufferedRenderer,e=d.all;if(d.rendered&&f&&(e.getCount()+a.length)>f.viewSize){if(c<e.startIndex+f.viewSize&&(c+a.length)>e.startIndex){d.refreshView()}else{f.stretchView(d,f.getScrollHeight())}}else{d.callParent([b,a,c])}},onRemove:function(b,a,d){var c=this,e=c.bufferedRenderer;c.callParent([b,a,d]);if(c.rendered&&e){if(c.dataSource.getCount()>e.viewSize){c.refreshView()}else{e.stretchView(c,e.getScrollHeight())}}},onDataRefresh:function(){var a=this;if(a.bufferedRenderer){a.all.clear();a.bufferedRenderer.onStoreClear()}a.callParent()}});