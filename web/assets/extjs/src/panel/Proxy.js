Ext.define("Ext.panel.Proxy",{alternateClassName:"Ext.dd.PanelProxy",moveOnDrag:true,constructor:function(a,b){var c=this;c.panel=a;c.id=c.panel.id+"-ddproxy";Ext.apply(c,b)},insertProxy:true,setStatus:Ext.emptyFn,reset:Ext.emptyFn,update:Ext.emptyFn,stop:Ext.emptyFn,sync:Ext.emptyFn,getEl:function(){return this.ghost.el},getGhost:function(){return this.ghost},getProxy:function(){return this.proxy},hide:function(){var a=this;if(a.ghost){if(a.proxy){a.proxy.remove();delete a.proxy}a.panel.unghost(null,a.moveOnDrag);delete a.ghost}},show:function(){var b=this,a;if(!b.ghost){a=b.panel.getSize();b.panel.el.setVisibilityMode(Ext.Element.DISPLAY);b.ghost=b.panel.ghost();if(b.insertProxy){b.proxy=b.panel.el.insertSibling({cls:Ext.baseCSSPrefix+"panel-dd-spacer"});b.proxy.setSize(a)}}},repair:function(b,c,a){this.hide();Ext.callback(c,a||this)},moveProxy:function(a,b){if(this.proxy){a.insertBefore(this.proxy.dom,b)}}});