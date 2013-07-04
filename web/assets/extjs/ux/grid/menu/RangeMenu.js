Ext.define("Ext.ux.grid.menu.RangeMenu",{extend:"Ext.menu.Menu",fieldCls:"Ext.form.field.Number",itemIconCls:{gt:"ux-rangemenu-gt",lt:"ux-rangemenu-lt",eq:"ux-rangemenu-eq"},fieldLabels:{gt:"Greater Than",lt:"Less Than",eq:"Equal To"},menuItemCfgs:{emptyText:"Enter Number...",selectOnFocus:false,width:155},menuItems:["lt","gt","-","eq"],plain:true,constructor:function(a){var f=this,c,g,b,e,h,d,j;f.callParent(arguments);c=f.fields=f.fields||{};g=f.fieldCfg=f.fieldCfg||{};f.addEvents("update");f.updateTask=Ext.create("Ext.util.DelayedTask",f.fireUpdate,f);for(b=0,e=f.menuItems.length;b<e;b++){h=f.menuItems[b];if(h!=="-"){d={itemId:"range-"+h,enableKeyEvents:true,hideEmptyLabel:false,labelCls:"ux-rangemenu-icon "+f.itemIconCls[h],labelSeparator:"",labelWidth:29,listeners:{scope:f,change:f.onInputChange,keyup:f.onInputKeyUp,el:{click:this.stopFn}},activate:Ext.emptyFn,deactivate:Ext.emptyFn};Ext.apply(d,Ext.applyIf(c[h]||{},g[h]),f.menuItemCfgs);j=d.fieldCls||f.fieldCls;h=c[h]=Ext.create(j,d)}f.add(h)}},stopFn:function(a){a.stopPropagation()},fireUpdate:function(){this.fireEvent("update",this)},getValue:function(){var b={},a=this.fields,c,d;for(c in a){if(a.hasOwnProperty(c)){d=a[c];if(d.isValid()&&d.getValue()!==null){b[c]=d.getValue()}}}return b},setValue:function(d){var c=this,a=c.fields,b,e;for(b in a){if(a.hasOwnProperty(b)){e=a[b];e.suspendEvents();e.setValue(b in d?d[b]:"");e.resumeEvents()}}c.fireEvent("update",c)},onInputKeyUp:function(b,a){if(a.getKey()===a.RETURN&&b.isValid()){a.stopEvent();this.hide()}},onInputChange:function(f){var e=this,c=e.fields,b=c.eq,d=c.gt,a=c.lt;if(f==b){if(d){d.setValue(null)}if(a){a.setValue(null)}}else{b.setValue(null)}this.updateTask.delay(this.updateBuffer)}});