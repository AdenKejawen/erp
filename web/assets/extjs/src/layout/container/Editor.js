Ext.define("Ext.layout.container.Editor",{alias:"layout.editor",extend:"Ext.layout.container.Container",autoSizeDefault:{width:"field",height:"field"},sizePolicies:{$:{$:{readsWidth:1,readsHeight:1,setsWidth:0,setsHeight:0},boundEl:{readsWidth:1,readsHeight:0,setsWidth:0,setsHeight:1}},boundEl:{$:{readsWidth:0,readsHeight:1,setsWidth:1,setsHeight:0},boundEl:{readsWidth:0,readsHeight:0,setsWidth:1,setsHeight:1}}},getItemSizePolicy:function(d){var c=this,a=c.owner.autoSize,b=a&&a.width,e=c.sizePolicies;e=e[b]||e.$;b=a&&a.height;e=e[b]||e.$;return e},calculate:function(f){var e=this,b=e.owner,a=b.autoSize,d,c;if(a===true){a=e.autoSizeDefault}if(a){d=e.getDimension(b,a.width,"getWidth",b.width);c=e.getDimension(b,a.height,"getHeight",b.height)}f.childItems[0].setSize(d,c);f.setWidth(d);f.setHeight(c);f.setContentSize(d||b.field.getWidth(),c||b.field.getHeight())},getDimension:function(a,b,d,c){switch(b){case"boundEl":return a.boundEl[d]();case"field":return undefined;default:return c}}});