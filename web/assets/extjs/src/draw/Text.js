Ext.define("Ext.draw.Text",{extend:"Ext.draw.Component",uses:["Ext.util.CSS"],alias:"widget.text",text:"",focusable:false,viewBox:false,autoSize:true,baseCls:Ext.baseCSSPrefix+"surface "+Ext.baseCSSPrefix+"draw-text",initComponent:function(){var a=this;a.textConfig=Ext.apply({type:"text",text:a.text,rotate:{degrees:a.degrees||0}},a.textStyle);Ext.apply(a.textConfig,a.getStyles(a.styleSelectors||a.styleSelector));a.initialConfig.items=[a.textConfig];a.callParent(arguments)},getStyles:function(d){d=Ext.Array.from(d);var c=0,b=d.length,f,e,g,a={};for(;c<b;c++){f=Ext.util.CSS.getRule(d[c]);if(f){e=f.style;if(e){Ext.apply(a,{"font-family":e.fontFamily,"font-weight":e.fontWeight,"line-height":e.lineHeight,"font-size":e.fontSize,fill:e.color})}}}return a},setAngle:function(d){var c=this,a,b;if(c.rendered){a=c.surface;b=a.items.items[0];c.degrees=d;b.setAttributes({rotate:{degrees:d}},true);if(c.autoSize||c.viewBox){c.updateLayout()}}else{c.degrees=d}},setText:function(d){var c=this,a,b;if(c.rendered){a=c.surface;b=a.items.items[0];c.text=d||"";a.remove(b);c.textConfig.type="text";c.textConfig.text=c.text;b=a.add(c.textConfig);b.setAttributes({rotate:{degrees:c.degrees}},true);if(c.autoSize||c.viewBox){c.updateLayout()}}else{c.on({render:function(){c.setText(d)},single:true})}}});