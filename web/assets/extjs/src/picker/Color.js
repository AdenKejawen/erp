Ext.define("Ext.picker.Color",{extend:"Ext.Component",requires:"Ext.XTemplate",alias:"widget.colorpicker",alternateClassName:"Ext.ColorPalette",componentCls:Ext.baseCSSPrefix+"color-picker",selectedCls:Ext.baseCSSPrefix+"color-picker-selected",itemCls:Ext.baseCSSPrefix+"color-picker-item",value:null,clickEvent:"click",allowReselect:false,colors:["000000","993300","333300","003300","003366","000080","333399","333333","800000","FF6600","808000","008000","008080","0000FF","666699","808080","FF0000","FF9900","99CC00","339966","33CCCC","3366FF","800080","969696","FF00FF","FFCC00","FFFF00","00FF00","00FFFF","00CCFF","993366","C0C0C0","FF99CC","FFCC99","FFFF99","CCFFCC","CCFFFF","99CCFF","CC99FF","FFFFFF"],colorRe:/(?:^|\s)color-(.{6})(?:\s|$)/,renderTpl:['<tpl for="colors">','<a href="#" class="color-{.} {parent.itemCls}" hidefocus="on">','<span class="{parent.itemCls}-inner" style="background:#{.}">&#160;</span>',"</a>","</tpl>"],initComponent:function(){var a=this;a.callParent(arguments);a.addEvents("select");if(a.handler){a.on("select",a.handler,a.scope,true)}},initRenderData:function(){var a=this;return Ext.apply(a.callParent(),{itemCls:a.itemCls,colors:a.colors})},onRender:function(){var b=this,a=b.clickEvent;b.callParent(arguments);b.mon(b.el,a,b.handleClick,b,{delegate:"a"});if(a!="click"){b.mon(b.el,"click",Ext.emptyFn,b,{delegate:"a",stopEvent:true})}},afterRender:function(){var a=this,b;a.callParent(arguments);if(a.value){b=a.value;a.value=null;a.select(b,true)}},handleClick:function(c,d){var b=this,a;c.stopEvent();if(!b.disabled){a=d.className.match(b.colorRe)[1];b.select(a.toUpperCase())}},select:function(b,a){var d=this,f=d.selectedCls,e=d.value,c;b=b.replace("#","");if(!d.rendered){d.value=b;return}if(b!=e||d.allowReselect){c=d.el;if(d.value){c.down("a.color-"+e).removeCls(f)}c.down("a.color-"+b).addCls(f);d.value=b;if(a!==true){d.fireEvent("select",d,b)}}},clear:function(){var b=this,c=b.value,a;if(c&&b.rendered){a=b.el.down("a.color-"+c);a.removeCls(b.selectedCls)}b.value=null},getValue:function(){return this.value||null}});