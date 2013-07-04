Ext.define("Ext.ComponentLoader",{extend:"Ext.ElementLoader",statics:{Renderer:{Data:function(a,b,d){var f=true;try{a.getTarget().update(Ext.decode(b.responseText))}catch(c){f=false}return f},Component:function(a,c,g){var h=true,f=a.getTarget(),b=[];if(!f.isContainer){Ext.Error.raise({target:f,msg:"Components can only be loaded into a container"})}try{b=Ext.decode(c.responseText)}catch(d){h=false}if(h){f.suspendLayouts();if(g.removeAll){f.removeAll()}f.add(b);f.resumeLayouts(true)}return h}}},target:null,loadMask:false,renderer:"html",setTarget:function(b){var a=this;if(Ext.isString(b)){b=Ext.getCmp(b)}if(a.target&&a.target!=b){a.abort()}a.target=b},removeMask:function(){this.target.setLoading(false)},addMask:function(a){this.target.setLoading(a)},setOptions:function(b,a){b.removeAll=Ext.isDefined(a.removeAll)?a.removeAll:this.removeAll},getRenderer:function(b){if(Ext.isFunction(b)){return b}var a=this.statics().Renderer;switch(b){case"component":return a.Component;case"data":return a.Data;default:return Ext.ElementLoader.Renderer.Html}}});