Ext.define("Ext.resizer.Handle",{extend:"Ext.Component",handleCls:"",baseHandleCls:Ext.baseCSSPrefix+"resizable-handle",region:"",beforeRender:function(){var a=this;a.callParent();a.protoEl.unselectable();a.addCls(a.baseHandleCls,a.baseHandleCls+"-"+a.region,a.handleCls)}});