Ext.define("Ext.ux.GroupTabPanel",{extend:"Ext.Container",alias:"widget.grouptabpanel",requires:["Ext.tree.Panel","Ext.ux.GroupTabRenderer"],baseCls:Ext.baseCSSPrefix+"grouptabpanel",initComponent:function(a){var b=this;Ext.apply(b,a);b.store=b.createTreeStore();b.layout={type:"hbox",align:"stretch"};b.defaults={border:false};b.items=[{xtype:"treepanel",cls:"x-tree-panel x-grouptabbar",width:150,rootVisible:false,store:b.store,hideHeaders:true,animate:false,processEvent:Ext.emptyFn,border:false,plugins:[{ptype:"grouptabrenderer"}],viewConfig:{overItemCls:"",getRowClass:b.getRowClass},columns:[{xtype:"treecolumn",sortable:false,dataIndex:"text",flex:1,renderer:function(j,d,i,h,g,f,c){var e="";if(i.parentNode&&i.parentNode.parentNode===null){e+=" x-grouptab-first";if(i.previousSibling){e+=" x-grouptab-prev"}if(!i.get("expanded")||i.firstChild==null){e+=" x-grouptab-last"}}else{if(i.nextSibling===null){e+=" x-grouptab-last"}else{e+=" x-grouptab-center"}}if(i.data.activeTab){e+=" x-active-tab"}d.tdCls="x-grouptab"+e;return j}}]},{xtype:"container",flex:1,layout:"card",activeItem:b.mainItem,baseCls:Ext.baseCSSPrefix+"grouptabcontainer",items:b.cards}];b.addEvents("beforetabchange","tabchange","beforegroupchange","groupchange");b.callParent(arguments);b.setActiveTab(b.activeTab);b.setActiveGroup(b.activeGroup);b.mon(b.down("treepanel").getSelectionModel(),"select",b.onNodeSelect,b)},getRowClass:function(d,e,c,b){var a="";if(d.data.activeGroup){a+=" x-active-group"}return a},onNodeSelect:function(a,e){var d=this,b=d.store.getRootNode(),c;if(e.parentNode&&e.parentNode.parentNode===null){c=e}else{c=e.parentNode}if(d.setActiveGroup(c.get("id"))===false||d.setActiveTab(e.get("id"))===false){return false}while(b){b.set("activeTab",false);b.set("activeGroup",false);b=b.firstChild||b.nextSibling||b.parentNode.nextSibling}c.set("activeGroup",true);c.eachChild(function(f){f.set("activeGroup",true)});e.set("activeTab",true);a.view.refresh()},setActiveTab:function(b){var a=this,d=b,c;if(Ext.isString(b)){d=Ext.getCmp(d)}if(d===a.activeTab){return false}c=a.activeTab;if(a.fireEvent("beforetabchange",a,d,c)!==false){a.activeTab=d;if(a.rendered){a.down("container[baseCls="+Ext.baseCSSPrefix+"grouptabcontainer]").getLayout().setActiveItem(d)}a.fireEvent("tabchange",a,d,c)}return true},setActiveGroup:function(c){var b=this,d=c,a;if(Ext.isString(c)){d=Ext.getCmp(d)}if(d===b.activeGroup){return true}a=b.activeGroup;if(b.fireEvent("beforegroupchange",b,d,a)!==false){b.activeGroup=d;b.fireEvent("groupchange",b,d,a)}else{return false}return true},createTreeStore:function(){var b=this,a=b.prepareItems(b.items),c={text:".",children:[]},d=b.cards=[];b.activeGroup=b.activeGroup||0;Ext.each(a,function(g,e){var h=g.items.items,f=(h[g.mainItem]||h[0]),i={children:[]};i.id=f.id;i.text=f.title;i.iconCls=f.iconCls;i.expanded=true;i.activeGroup=(b.activeGroup===e);i.activeTab=i.activeGroup?true:false;if(i.activeTab){b.activeTab=i.id}if(i.activeGroup){b.mainItem=g.mainItem||0;b.activeGroup=i.id}Ext.each(h,function(j){if(j.id!==i.id){var k={id:j.id,leaf:true,text:j.title,iconCls:j.iconCls,activeGroup:i.activeGroup,activeTab:false};i.children.push(k)}delete j.title;delete j.iconCls;d.push(j)});c.children.push(i)});return Ext.create("Ext.data.TreeStore",{fields:["id","text","activeGroup","activeTab"],root:{expanded:true},proxy:{type:"memory",data:c}})},getActiveTab:function(){return this.activeTab},getActiveGroup:function(){return this.activeGroup}});