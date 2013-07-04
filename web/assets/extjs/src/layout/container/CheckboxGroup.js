Ext.define("Ext.layout.container.CheckboxGroup",{extend:"Ext.layout.container.Container",alias:["layout.checkboxgroup"],autoFlex:true,type:"checkboxgroup",createsInnerCt:true,childEls:["innerCt"],renderTpl:['<table id="{ownerId}-innerCt" class="'+Ext.plainTableCls+'" cellpadding="0"','role="presentation" style="{tableStyle}"><tbody><tr>','<tpl for="columns">','<td class="{parent.colCls}" valign="top" style="{style}">',"{% this.renderColumn(out,parent,xindex-1) %}","</td>","</tpl>","</tr></tbody></table>"],lastOwnerItemsGeneration:null,beginLayout:function(b){var j=this,e,d,g,a,h,f=0,l=0,k=j.autoFlex,c=j.innerCt.dom.style;j.callParent(arguments);e=j.columnNodes;b.innerCtContext=b.getEl("innerCt",j);if(!b.widthModel.shrinkWrap){d=e.length;if(j.columnsArray){for(g=0;g<d;g++){a=j.owner.columns[g];if(a<1){f+=a;l++}}for(g=0;g<d;g++){a=j.owner.columns[g];if(a<1){h=((a/f)*100)+"%"}else{h=a+"px"}e[g].style.width=h}}else{for(g=0;g<d;g++){h=k?(1/d*100)+"%":"";e[g].style.width=h;l++}}if(!l){c.tableLayout="fixed";c.width=""}else{if(l<d){c.tableLayout="fixed";c.width="100%"}else{c.tableLayout="auto";if(k){c.width="100%"}else{c.width=""}}}}else{c.tableLayout="auto";c.width=""}},cacheElements:function(){var a=this;a.callParent();a.rowEl=a.innerCt.down("tr");a.columnNodes=a.rowEl.dom.childNodes},calculate:function(g){var e=this,c,b,a,h,d,f;if(!g.getDomProp("containerChildrenSizeDone")){e.done=false}else{c=g.innerCtContext;b=g.widthModel.shrinkWrap;a=g.heightModel.shrinkWrap;h=a||b;d=c.el.dom;f=h&&c.getPaddingInfo();if(b){g.setContentWidth(d.offsetWidth+f.width,true)}if(a){g.setContentHeight(d.offsetHeight+f.height,true)}}},doRenderColumn:function(d,k,f){var h=k.$layout,c=h.owner,e=k.columnCount,g=c.items.items,b=g.length,l,a,i,j,m;if(c.vertical){i=Math.ceil(b/e);a=f*i;b=Math.min(b,a+i);j=1}else{a=f;j=e}for(;a<b;a+=j){l=g[a];h.configureItem(l);m=l.getRenderTree();Ext.DomHelper.generateMarkup(m,d)}},getColumnCount:function(){var b=this,a=b.owner,c=a.columns;if(b.columnsArray){return c.length}if(Ext.isNumber(c)){return c}return a.items.length},getItemSizePolicy:function(a){return this.autoSizePolicy},getRenderData:function(){var j=this,f=j.callParent(),b=j.owner,g,d=j.getColumnCount(),a,c,h,k=j.autoFlex,e=0,l=0;if(j.columnsArray){for(g=0;g<d;g++){a=j.owner.columns[g];if(a<1){e+=a;l++}}}f.colCls=b.groupCls;f.columnCount=d;f.columns=[];for(g=0;g<d;g++){c=(f.columns[g]={});if(j.columnsArray){a=j.owner.columns[g];if(a<1){h=((a/e)*100)+"%"}else{h=a+"px"}c.style="width:"+h}else{c.style="width:"+(1/d*100)+"%";l++}}f.tableStyle=!l?"table-layout:fixed;":(l<d)?"table-layout:fixed;width:100%":(k)?"table-layout:auto;width:100%":"table-layout:auto;";return f},initLayout:function(){var b=this,a=b.owner;b.columnsArray=Ext.isArray(a.columns);b.autoColumns=!a.columns||a.columns==="auto";b.vertical=a.vertical;b.callParent()},isValidParent:function(){return true},setupRenderTpl:function(a){this.callParent(arguments);a.renderColumn=this.doRenderColumn},renderChildren:function(){var a=this,b=a.owner.items.generation;if(a.lastOwnerItemsGeneration!==b){a.lastOwnerItemsGeneration=b;a.renderItems(a.getLayoutItems())}},renderItems:function(e){var f=this,a=e.length,b,j,h,d,g,c;if(a){Ext.suspendLayouts();if(f.autoColumns){f.addMissingColumns(a)}d=f.columnNodes.length;h=Math.ceil(a/d);for(b=0;b<a;b++){j=e[b];g=f.getRenderRowIndex(b,h,d);c=f.getRenderColumnIndex(b,h,d);if(!j.rendered){f.renderItem(j,g,c)}else{if(!f.isItemAtPosition(j,g,c)){f.moveItem(j,g,c)}}}if(f.autoColumns){f.removeExceedingColumns(a)}Ext.resumeLayouts(true)}},isItemAtPosition:function(b,c,a){return b.el.dom===this.getNodeAt(c,a)},getRenderColumnIndex:function(b,a,c){if(this.vertical){return Math.floor(b/a)}else{return b%c}},getRenderRowIndex:function(b,a,d){var c=this;if(c.vertical){return b%a}else{return Math.floor(b/d)}},getNodeAt:function(b,a){return this.columnNodes[a].childNodes[b]},addMissingColumns:function(a){var f=this,c=f.columnNodes.length,e,g,b,d;if(c<a){e=a-c;g=f.rowEl;b=f.owner.groupCls;for(d=0;d<e;d++){g.createChild({cls:b,tag:"td",vAlign:"top"})}}},removeExceedingColumns:function(a){var e=this,b=e.columnNodes.length,d,f,c;if(b>a){d=b-a;f=e.rowEl;for(c=0;c<d;c++){f.last().remove()}}},renderItem:function(c,d,a){var b=this;b.configureItem(c);c.render(Ext.get(b.columnNodes[a]),d);b.afterRenderItem(c)},moveItem:function(d,f,b){var c=this,a=c.columnNodes[b],e=a.childNodes[f];a.insertBefore(d.el.dom,e||null)}});