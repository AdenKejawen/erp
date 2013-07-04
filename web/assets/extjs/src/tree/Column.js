Ext.define("Ext.tree.Column",{extend:"Ext.grid.column.Column",alias:"widget.treecolumn",tdCls:Ext.baseCSSPrefix+"grid-cell-treecolumn",autoLock:true,lockable:false,draggable:false,hideable:false,iconCls:Ext.baseCSSPrefix+"tree-icon",checkboxCls:Ext.baseCSSPrefix+"tree-checkbox",elbowCls:Ext.baseCSSPrefix+"tree-elbow",expanderCls:Ext.baseCSSPrefix+"tree-expander",textCls:Ext.baseCSSPrefix+"tree-node-text",innerCls:Ext.baseCSSPrefix+"grid-cell-inner-treecolumn",isTreeColumn:true,cellTpl:['<tpl for="lines">','<img src="{parent.blankUrl}" class="{parent.childCls} {parent.elbowCls}-img ','{parent.elbowCls}-<tpl if=".">line<tpl else>empty</tpl>"/>',"</tpl>",'<img src="{blankUrl}" class="{childCls} {elbowCls}-img {elbowCls}','<tpl if="isLast">-end</tpl><tpl if="expandable">-plus {expanderCls}</tpl>"/>','<tpl if="checked !== null">','<input type="button" role="checkbox" <tpl if="checked">aria-checked="true" </tpl>','class="{childCls} {checkboxCls}<tpl if="checked"> {checkboxCls}-checked</tpl>"/>',"</tpl>",'<img src="{blankUrl}" class="{childCls} {baseIconCls} ','{baseIconCls}-<tpl if="leaf">leaf<tpl else>parent</tpl> {iconCls}"','<tpl if="icon">style="background-image:url({icon})"</tpl>/>','<tpl if="href">','<a href="{href}" target="{hrefTarget}" class="{textCls} {childCls}">{value}</a>',"<tpl else>",'<span class="{textCls} {childCls}">{value}</span>',"</tpl>"],initComponent:function(){var a=this;a.origRenderer=a.renderer;a.origScope=a.scope||window;a.renderer=a.treeRenderer;a.scope=a;a.callParent()},treeRenderer:function(k,a,e,b,d,l,i){var h=this,n=e.get("cls"),g=h.origRenderer,c=e.data,j=e.parentNode,m=i.rootVisible,o=[],f;if(n){a.tdCls+=" "+n}while(j&&(m||j.data.depth>0)){f=j.data;o[m?f.depth:f.depth-1]=f.isLast?0:1;j=j.parentNode}return h.getTpl("cellTpl").apply({record:e,baseIconCls:h.iconCls,iconCls:c.iconCls,icon:c.icon,checkboxCls:h.checkboxCls,checked:c.checked,elbowCls:h.elbowCls,expanderCls:h.expanderCls,textCls:h.textCls,leaf:c.leaf,expandable:e.isExpandable(),isLast:c.isLast,blankUrl:Ext.BLANK_IMAGE_URL,href:c.href,hrefTarget:c.hrefTarget,lines:o,metaData:a,childCls:h.getChildCls?h.getChildCls()+" ":"",value:g?g.apply(h.origScope,arguments):k})}});