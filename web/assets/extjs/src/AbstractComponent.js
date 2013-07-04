Ext.define("Ext.AbstractComponent",{requires:["Ext.ComponentQuery","Ext.ComponentManager","Ext.util.ProtoElement","Ext.dom.CompositeElement","Ext.PluginManager"],mixins:{positionable:"Ext.util.Positionable",observable:"Ext.util.Observable",animate:"Ext.util.Animate",elementCt:"Ext.util.ElementContainer",renderable:"Ext.util.Renderable",state:"Ext.state.Stateful"},uses:["Ext.PluginManager","Ext.Element","Ext.DomHelper","Ext.XTemplate","Ext.ComponentLoader","Ext.EventManager","Ext.layout.Context","Ext.layout.Layout","Ext.layout.component.Auto","Ext.LoadMask","Ext.ZIndexManager"],statics:{AUTO_ID:1000,pendingLayouts:null,layoutSuspendCount:0,cancelLayout:function(a,c){var b=this.runningLayoutContext||this.pendingLayouts;if(b){b.cancelComponent(a,false,c)}},flushLayouts:function(){var b=this,a=b.pendingLayouts;if(a&&a.invalidQueue.length){b.pendingLayouts=null;b.runningLayoutContext=a;Ext.override(a,{runComplete:function(){b.runningLayoutContext=null;var c=this.callParent();if(Ext.globalEvents.hasListeners.afterlayout){Ext.globalEvents.fireEvent("afterlayout")}return c}});a.run()}},resumeLayouts:function(a){if(this.layoutSuspendCount&&!--this.layoutSuspendCount){if(a){this.flushLayouts()}if(Ext.globalEvents.hasListeners.resumelayouts){Ext.globalEvents.fireEvent("resumelayouts")}}},suspendLayouts:function(){++this.layoutSuspendCount},updateLayout:function(b,e){var c=this,a=c.runningLayoutContext,d;if(a){a.queueInvalidate(b)}else{d=c.pendingLayouts||(c.pendingLayouts=new Ext.layout.Context());d.queueInvalidate(b);if(!e&&!c.layoutSuspendCount&&!b.isLayoutSuspended()){c.flushLayouts()}}}},isComponent:true,getAutoId:function(){this.autoGenId=true;return ++Ext.AbstractComponent.AUTO_ID},deferLayouts:false,autoGenId:false,renderTpl:"{%this.renderContent(out,values)%}",frameSize:null,tplWriteMode:"overwrite",baseCls:Ext.baseCSSPrefix+"component",disabledCls:Ext.baseCSSPrefix+"item-disabled",ui:"default",uiCls:[],hidden:false,disabled:false,draggable:false,floating:false,hideMode:"display",autoShow:false,autoRender:false,allowDomMove:true,rendered:false,componentLayoutCounter:0,shrinkWrap:2,weight:0,maskOnDisable:true,_isLayoutRoot:false,contentPaddingProperty:"padding",horizontalPosProp:"left",borderBoxCls:Ext.baseCSSPrefix+"border-box",constructor:function(c){var e=this,d,a,b;if(c){Ext.apply(e,c);b=e.xhooks;if(b){delete e.xhooks;Ext.override(e,b)}}else{c={}}e.initialConfig=c;e.mixins.elementCt.constructor.call(e);e.addEvents("beforeactivate","activate","beforedeactivate","deactivate","added","disable","enable","beforeshow","show","beforehide","hide","removed","beforerender","render","afterrender","boxready","beforedestroy","destroy","resize","move","focus","blur");e.getId();e.setupProtoEl();if(e.cls){e.initialCls=e.cls;e.protoEl.addCls(e.cls)}if(e.style){e.initialStyle=e.style;e.protoEl.setStyle(e.style)}e.renderData=e.renderData||{};e.renderSelectors=e.renderSelectors||{};if(e.plugins){e.plugins=e.constructPlugins()}if(!e.hasListeners){e.hasListeners=new e.HasListeners()}e.initComponent();Ext.ComponentManager.register(e);e.mixins.observable.constructor.call(e);e.mixins.state.constructor.call(e,c);this.addStateEvents("resize");if(e.plugins){for(d=0,a=e.plugins.length;d<a;d++){e.plugins[d]=e.initPlugin(e.plugins[d])}}e.loader=e.getLoader();if(e.renderTo){e.render(e.renderTo)}if(e.autoShow&&!e.isContained){e.show()}if(Ext.isDefined(e.disabledClass)){if(Ext.isDefined(Ext.global.console)){Ext.global.console.warn("Ext.Component: disabledClass has been deprecated. Please use disabledCls.")}e.disabledCls=e.disabledClass;delete e.disabledClass}},initComponent:function(){this.plugins=this.constructPlugins();this.setSize(this.width,this.height)},getState:function(){var b=this,c=null,a=b.getSizeModel();if(a.width.configured){c=b.addPropertyToState(c,"width")}if(a.height.configured){c=b.addPropertyToState(c,"height")}return c},addPropertyToState:function(e,d,c){var b=this,a=arguments.length;if(a==3||b.hasOwnProperty(d)){if(a<3){c=b[d]}if(c!==b.initialConfig[d]){(e||(e={}))[d]=c}}return e},show:Ext.emptyFn,animate:function(c){var s=this,f,k,j,a,d,b,r,o,l,e,p,m,g,n,q,i;c=c||{};d=c.to||{};if(Ext.fx.Manager.hasFxBlock(s.id)){return s}f=Ext.isDefined(d.width);if(f){a=Ext.Number.constrain(d.width,s.minWidth,s.maxWidth)}k=Ext.isDefined(d.height);if(k){j=Ext.Number.constrain(d.height,s.minHeight,s.maxHeight)}if(!c.dynamic&&(f||k)){o=(c.from?c.from.width:undefined)||s.getWidth();l=o;e=(c.from?c.from.height:undefined)||s.getHeight();p=e;m=false;if(k&&j>e){p=j;m=true}if(f&&a>o){l=a;m=true}if(k||f){i=s.el.getStyle("overtflow");if(i!=="hidden"){s.el.setStyle("overflow","hidden")}}if(m){b=!Ext.isNumber(s.width);r=!Ext.isNumber(s.height);s.setSize(l,p);s.el.setSize(o,e);if(b){delete s.width}if(r){delete s.height}}if(f){d.width=a}if(k){d.height=j}}g=s.constrain;n=s.constrainHeader;if(g||n){s.constrain=s.constrainHeader=false;q=c.callback;c.callback=function(){s.constrain=g;s.constrainHeader=n;if(q){q.call(c.scope||s,arguments)}if(i!=="hidden"){s.el.setStyle("overflow",i)}}}return s.mixins.animate.animate.apply(s,arguments)},setHiddenState:function(a){var b=this.getHierarchyState();this.hidden=a;if(a){b.hidden=true}else{delete b.hidden}},onHide:function(){if(this.ownerLayout){this.updateLayout({isRoot:false})}},onShow:function(){this.updateLayout({isRoot:false})},constructPlugin:function(b){var a=this;if(typeof b=="string"){b=Ext.PluginManager.create({},b,a)}else{b=Ext.PluginManager.create(b,null,a)}return b},constructPlugins:function(){var e=this,c=e.plugins,b,d,a;if(c){b=[];if(!Ext.isArray(c)){c=[c]}for(d=0,a=c.length;d<a;d++){b[d]=e.constructPlugin(c[d])}}e.pluginsInitialized=true;return b},initPlugin:function(a){a.init(this);return a},addPlugin:function(b){var a=this;b=a.constructPlugin(b);if(a.plugins){a.plugins.push(b)}else{a.plugins=[b]}if(a.pluginsInitialized){a.initPlugin(b)}return b},removePlugin:function(a){Ext.Array.remove(this.plugins,a);a.destroy()},findPlugin:function(d){var b,a=this.plugins,c=a&&a.length;for(b=0;b<c;b++){if(a[b].ptype===d){return a[b]}}},getPlugin:function(b){var c,a=this.plugins,d=a&&a.length;for(c=0;c<d;c++){if(a[c].pluginId===b){return a[c]}}},beforeLayout:Ext.emptyFn,updateAria:Ext.emptyFn,registerFloatingItem:function(b){var a=this;if(!a.floatingDescendants){a.floatingDescendants=new Ext.ZIndexManager(a)}a.floatingDescendants.register(b)},unregisterFloatingItem:function(b){var a=this;if(a.floatingDescendants){a.floatingDescendants.unregister(b)}},layoutSuspendCount:0,suspendLayouts:function(){var a=this;if(!a.rendered){return}if(++a.layoutSuspendCount==1){a.suspendLayout=true}},resumeLayouts:function(b){var a=this;if(!a.rendered){return}if(!--a.layoutSuspendCount){a.suspendLayout=false;if(b&&!a.isLayoutSuspended()){a.updateLayout(b)}}},setupProtoEl:function(){var a=this.initCls();this.protoEl=new Ext.util.ProtoElement({cls:a.join(" ")})},initCls:function(){var b=this,a=[b.baseCls,b.getComponentLayout().targetCls];if(Ext.isDefined(b.cmpCls)){if(Ext.isDefined(Ext.global.console)){Ext.global.console.warn("Ext.Component: cmpCls has been deprecated. Please use componentCls.")}b.componentCls=b.cmpCls;delete b.cmpCls}if(b.componentCls){a.push(b.componentCls)}else{b.componentCls=b.baseCls}return a},setUI:function(c){var b=this,e=b.uiCls,d=b.activeUI,a;if(c===d){return}if(d){a=b.removeClsWithUI(e,true);if(a.length){b.removeCls(a)}b.removeUIFromElement()}else{b.uiCls=[]}b.ui=c;b.activeUI=c;b.addUIToElement();a=b.addClsWithUI(e,true);if(a.length){b.addCls(a)}if(b.rendered){b.updateLayout()}},addClsWithUI:function(c,h){var g=this,f=[],e=0,d=g.uiCls=Ext.Array.clone(g.uiCls),b=g.activeUI,a,j;if(typeof c==="string"){c=(c.indexOf(" ")<0)?[c]:Ext.String.splitWords(c)}a=c.length;for(;e<a;e++){j=c[e];if(j&&!g.hasUICls(j)){d.push(j);if(b){f=f.concat(g.addUIClsToElement(j))}}}if(h!==true&&b){g.addCls(f)}return f},removeClsWithUI:function(d,k){var j=this,h=[],f=0,a=Ext.Array,g=a.remove,e=j.uiCls=a.clone(j.uiCls),c=j.activeUI,b,l;if(typeof d==="string"){d=(d.indexOf(" ")<0)?[d]:Ext.String.splitWords(d)}b=d.length;for(f=0;f<b;f++){l=d[f];if(l&&j.hasUICls(l)){g(e,l);if(c){h=h.concat(j.removeUIClsFromElement(l))}}}if(k!==true&&c){j.removeCls(h)}return h},hasUICls:function(a){var b=this,c=b.uiCls||[];return Ext.Array.contains(c,a)},frameElementsArray:["tl","tc","tr","ml","mc","mr","bl","bc","br"],addUIClsToElement:function(h){var g=this,b=g.baseCls+"-"+g.ui+"-"+h,j=[Ext.baseCSSPrefix+h,g.baseCls+"-"+h,b],f,e,d,a,c;if(g.rendered&&g.frame&&!Ext.supports.CSS3BorderRadius){f=g.frameElementsArray;e=f.length;for(d=0;d<e;d++){c=f[d];a=g["frame"+c.toUpperCase()];if(a){a.addCls(b+"-"+c)}}}return j},removeUIClsFromElement:function(h){var g=this,b=g.baseCls+"-"+g.ui+"-"+h,j=[Ext.baseCSSPrefix+h,g.baseCls+"-"+h,b],f,e,d,a,c;if(g.rendered&&g.frame&&!Ext.supports.CSS3BorderRadius){f=g.frameElementsArray;e=f.length;for(d=0;d<e;d++){c=f[d];a=g["frame"+c.toUpperCase()];if(a){a.removeCls(b+"-"+c)}}}return j},addUIToElement:function(){var f=this,b=f.baseCls+"-"+f.ui,a,e,c,d,g;f.addCls(b);if(f.rendered&&f.frame&&!Ext.supports.CSS3BorderRadius){a=f.frameElementsArray;e=a.length;for(c=0;c<e;c++){g=a[c];d=f["frame"+g.toUpperCase()];if(d){d.addCls(b+"-"+g)}}}},removeUIFromElement:function(){var f=this,b=f.baseCls+"-"+f.ui,a,e,c,d,g;f.removeCls(b);if(f.rendered&&f.frame&&!Ext.supports.CSS3BorderRadius){a=f.frameElementsArray;e=a.length;for(c=0;c<e;c++){g=a[c];d=f["frame"+g.toUpperCase()];if(d){d.removeCls(b+"-"+g)}}}},getTpl:function(a){return Ext.XTemplate.getTpl(this,a)},initStyles:function(j){var f=this,c=Ext.Element,d=f.margin,e=f.border,k=f.cls,a=f.style,h=f.x,g=f.y,b,i;f.initPadding(j);if(d!=null){j.setStyle("margin",this.unitizeBox((d===true)?5:d))}if(e!=null){f.setBorder(e,j)}if(k&&k!=f.initialCls){j.addCls(k);f.cls=f.initialCls=null}if(a&&a!=f.initialStyle){j.setStyle(a);f.style=f.initialStyle=null}if(h!=null){j.setStyle(f.horizontalPosProp,(typeof h=="number")?(h+"px"):h)}if(g!=null){j.setStyle("top",(typeof g=="number")?(g+"px"):g)}if(Ext.isBorderBox&&(!f.ownerCt||f.floating)){j.addCls(f.borderBoxCls)}if(!f.getFrameInfo()){b=f.width;i=f.height;if(b!=null){if(typeof b==="number"){if(Ext.isBorderBox){j.setStyle("width",b+"px")}}else{j.setStyle("width",b)}}if(i!=null){if(typeof i==="number"){if(Ext.isBorderBox){j.setStyle("height",i+"px")}}else{j.setStyle("height",i)}}}},initPadding:function(c){var a=this,b=a.padding;if(b!=null){if(a.layout&&a.layout.managePadding&&a.contentPaddingProperty==="padding"){c.setStyle("padding",0)}else{c.setStyle("padding",this.unitizeBox((b===true)?5:b))}}},parseBox:function(a){return Ext.dom.Element.parseBox(a)},unitizeBox:function(a){return Ext.dom.Element.unitizeBox(a)},setMargin:function(c,b){var a=this;if(a.rendered){if(!c&&c!==0){c=""}else{if(c===true){c=5}c=this.unitizeBox(c)}a.getTargetEl().setStyle("margin",c);if(!b){a.updateLayout()}}else{a.margin=c}},initEvents:function(){var e=this,g=e.afterRenderEvents,b,d,f,c,a;if(g){for(f in g){d=e[f];if(d&&d.on){b=g[f];for(c=0,a=b.length;c<a;++c){e.mon(d,b[c])}}}}e.addFocusListener()},addFocusListener:function(){var c=this,b=c.getFocusEl(),a;if(b){if(b.isComponent){return b.addFocusListener()}a=b.needsTabIndex();if(!c.focusListenerAdded&&(!a||Ext.FocusManager.enabled)){if(a){b.dom.tabIndex=-1}b.on({focus:c.onFocus,blur:c.onBlur,scope:c});c.focusListenerAdded=true}}},getFocusEl:Ext.emptyFn,isFocusable:function(){var b=this,a;if((b.focusable!==false)&&(a=b.getFocusEl())&&b.rendered&&!b.destroying&&!b.isDestroyed&&!b.disabled&&b.isVisible(true)){return a.isFocusable(true)}},beforeFocus:Ext.emptyFn,onFocus:function(d){var c=this,b=c.focusCls,a=c.getFocusEl();if(!c.disabled){c.beforeFocus(d);if(b&&a){a.addCls(c.addClsWithUI(b,true))}if(!c.hasFocus){c.hasFocus=true;c.fireEvent("focus",c,d)}}},beforeBlur:Ext.emptyFn,onBlur:function(d){var c=this,b=c.focusCls,a=c.getFocusEl();if(c.destroying){return}c.beforeBlur(d);if(b&&a){a.removeCls(c.removeClsWithUI(b,true))}if(c.validateOnBlur){c.validate()}c.hasFocus=false;c.fireEvent("blur",c,d);c.postBlur(d)},postBlur:Ext.emptyFn,is:function(a){return Ext.ComponentQuery.is(this,a)},up:function(d,e){var c=this.getRefOwner(),b=typeof e==="string",g=typeof e==="number",a=e&&e.isComponent,f=0;if(d){for(;c;c=c.getRefOwner()){f++;if(d.isComponent){if(c===d){return c}}else{if(Ext.ComponentQuery.is(c,d)){return c}}if(b&&c.is(e)){return}if(g&&f===e){return}if(a&&c===e){return}}}return c},nextSibling:function(b){var f=this.ownerCt,d,e,a,g;if(f){d=f.items;a=d.indexOf(this)+1;if(a){if(b){for(e=d.getCount();a<e;a++){if((g=d.getAt(a)).is(b)){return g}}}else{if(a<d.getCount()){return d.getAt(a)}}}}return null},previousSibling:function(b){var e=this.ownerCt,d,a,f;if(e){d=e.items;a=d.indexOf(this);if(a!=-1){if(b){for(--a;a>=0;a--){if((f=d.getAt(a)).is(b)){return f}}}else{if(a){return d.getAt(--a)}}}}return null},previousNode:function(b,d){var h=this,g=h.ownerCt,a,f,e,c;if(d&&h.is(b)){return h}if(g){for(f=g.items.items,e=Ext.Array.indexOf(f,h)-1;e>-1;e--){c=f[e];if(c.query){a=c.query(b);a=a[a.length-1];if(a){return a}}if(c.is(b)){return c}}return g.previousNode(b,true)}return null},nextNode:function(d,h){var b=this,c=b.ownerCt,j,e,g,f,a;if(h&&b.is(d)){return b}if(c){for(e=c.items.items,f=Ext.Array.indexOf(e,b)+1,g=e.length;f<g;f++){a=e[f];if(a.is(d)){return a}if(a.down){j=a.down(d);if(j){return j}}}return c.nextNode(d)}return null},getId:function(){return this.id||(this.id="ext-comp-"+(this.getAutoId()))},getItemId:function(){return this.itemId||this.id},getEl:function(){return this.el},getTargetEl:function(){return this.frameBody||this.el},getOverflowEl:function(){return this.getTargetEl()},getOverflowStyle:function(){var e=this,b=null,d,c,a;if(typeof e.autoScroll==="boolean"){b={overflow:a=e.autoScroll?"auto":""};e.scrollFlags={overflowX:a,overflowY:a,x:true,y:true,both:true}}else{d=e.overflowX;c=e.overflowY;if(d!==undefined||c!==undefined){b={overflowX:d=d||"",overflowY:c=c||""};e.scrollFlags={overflowX:d,overflowY:c,x:d=(d==="auto"||d==="scroll"),y:c=(c==="auto"||c==="scroll"),both:d&&c}}else{e.scrollFlags={overflowX:"",overflowY:"",x:false,y:false,both:false}}}if(b&&Ext.isIE7m){b.position="relative"}return b},isXType:function(b,a){if(a){return this.xtype===b}else{return this.xtypesMap[b]}},getXTypes:function(){var c=this.self,d,b,a;if(!c.xtypes){d=[];b=this;while(b){a=b.xtypes;if(a!==undefined){d.unshift.apply(d,a)}b=b.superclass}c.xtypeChain=d;c.xtypes=d.join("/")}return c.xtypes},update:function(b,c,a){var e=this,f=(e.tpl&&!Ext.isString(b)),d;if(f){e.data=b}else{e.html=Ext.isObject(b)?Ext.DomHelper.markup(b):b}if(e.rendered){d=e.isContainer?e.layout.getRenderTarget():e.getTargetEl();if(f){e.tpl[e.tplWriteMode](d,b||{})}else{d.update(e.html,c,a)}e.updateLayout()}},setVisible:function(a){return this[a?"show":"hide"]()},isVisible:function(a){var b=this,c;if(b.hidden||!b.rendered||b.isDestroyed){c=true}else{if(a){c=b.isHierarchicallyHidden()}}return !c},isHierarchicallyHidden:function(){var d=this,c=false,b,a;for(;(b=d.ownerCt||d.floatParent);d=b){a=b.getHierarchyState();if(a.hidden){c=true;break}if(d.getHierarchyState().collapseImmune){if(b.collapsed&&!d.collapseImmune){c=true;break}}else{c=!!a.collapsed;break}}return c},onBoxReady:function(b,a){var c=this;if(c.disableOnBoxReady){c.onDisable()}else{if(c.enableOnBoxReady){c.onEnable()}}if(c.resizable){c.initResizable(c.resizable)}if(c.draggable){c.initDraggable()}if(c.hasListeners.boxready){c.fireEvent("boxready",c,b,a)}},enable:function(a){var b=this;delete b.disableOnBoxReady;b.removeCls(b.disabledCls);if(b.rendered){b.onEnable()}else{b.enableOnBoxReady=true}b.disabled=false;delete b.resetDisable;if(a!==true){b.fireEvent("enable",b)}return b},disable:function(a){var b=this;delete b.enableOnBoxReady;b.addCls(b.disabledCls);if(b.rendered){b.onDisable()}else{b.disableOnBoxReady=true}b.disabled=true;if(a!==true){delete b.resetDisable;b.fireEvent("disable",b)}return b},onEnable:function(){if(this.maskOnDisable){this.el.dom.disabled=false;this.unmask()}},onDisable:function(){var c=this,b=c.focusCls,a=c.getFocusEl();if(b&&a){a.removeCls(c.removeClsWithUI(b,true))}if(c.maskOnDisable){c.el.dom.disabled=true;c.mask()}},mask:function(){var b=this.lastBox,c=this.getMaskTarget(),a=[];if(b){a[2]=b.height}c.mask.apply(c,a)},unmask:function(){this.getMaskTarget().unmask()},getMaskTarget:function(){return this.el},isDisabled:function(){return this.disabled},setDisabled:function(a){return this[a?"disable":"enable"]()},isHidden:function(){return this.hidden},addCls:function(a){var c=this,b=c.rendered?c.el:c.protoEl;b.addCls.apply(b,arguments);return c},addClass:function(){return this.addCls.apply(this,arguments)},hasCls:function(a){var c=this,b=c.rendered?c.el:c.protoEl;return b.hasCls.apply(b,arguments)},removeCls:function(a){var c=this,b=c.rendered?c.el:c.protoEl;b.removeCls.apply(b,arguments);return c},removeClass:function(){if(Ext.isDefined(Ext.global.console)){Ext.global.console.warn("Ext.Component: removeClass has been deprecated. Please use removeCls.")}return this.removeCls.apply(this,arguments)},addOverCls:function(){var a=this;if(!a.disabled){a.el.addCls(a.overCls)}},removeOverCls:function(){this.el.removeCls(this.overCls)},addListener:function(b,f,e,a){var g=this,d,c;if(Ext.isString(b)&&(Ext.isObject(f)||a&&a.element)){if(a.element){d=f;f={};f[b]=d;b=a.element;if(e){f.scope=e}for(c in a){if(a.hasOwnProperty(c)){if(g.eventOptionsRe.test(c)){f[c]=a[c]}}}}if(g[b]&&g[b].on){g.mon(g[b],f)}else{g.afterRenderEvents=g.afterRenderEvents||{};if(!g.afterRenderEvents[b]){g.afterRenderEvents[b]=[]}g.afterRenderEvents[b].push(f)}return}return g.mixins.observable.addListener.apply(g,arguments)},removeManagedListenerItem:function(b,a,h,d,f,e){var g=this,c=a.options?a.options.element:null;if(c){c=g[c];if(c&&c.un){if(b||(a.item===h&&a.ename===d&&(!f||a.fn===f)&&(!e||a.scope===e))){c.un(a.ename,a.fn,a.scope);if(!b){Ext.Array.remove(g.managedListeners,a)}}}}else{return g.mixins.observable.removeManagedListenerItem.apply(g,arguments)}},getBubbleTarget:function(){return this.ownerCt},isFloating:function(){return this.floating},isDraggable:function(){return !!this.draggable},isDroppable:function(){return !!this.droppable},onAdded:function(a,c){var b=this;b.ownerCt=a;if(b.hierarchyState){b.hierarchyState.invalid=true;delete b.hierarchyState}if(b.hasListeners.added){b.fireEvent("added",b,a,c)}},onRemoved:function(b){var a=this;if(a.hasListeners.removed){a.fireEvent("removed",a,a.ownerCt)}delete a.ownerCt;delete a.ownerLayout},beforeDestroy:Ext.emptyFn,onResize:function(c,a,b,e){var d=this;if(d.floating&&d.constrain){d.doConstrain()}if(d.hasListeners.resize){d.fireEvent("resize",d,c,a,b,e)}},setSize:function(b,a){var c=this;if(b&&typeof b=="object"){a=b.height;b=b.width}if(typeof b=="number"){c.width=Ext.Number.constrain(b,c.minWidth,c.maxWidth)}else{if(b===null){delete c.width}}if(typeof a=="number"){c.height=Ext.Number.constrain(a,c.minHeight,c.maxHeight)}else{if(a===null){delete c.height}}if(c.rendered&&c.isVisible()){c.updateLayout({isRoot:false})}return c},isLayoutRoot:function(){var a=this,b=a.ownerLayout;if(!b||a._isLayoutRoot||a.floating){return true}return b.isItemLayoutRoot(a)},isLayoutSuspended:function(){var a=this,b;while(a){if(a.layoutSuspendCount||a.suspendLayout){return true}b=a.ownerLayout;if(!b){break}a=b.owner}return false},updateLayout:function(c){var d=this,e,b=d.lastBox,a=c&&c.isRoot;if(b){b.invalid=true}if(!d.rendered||d.layoutSuspendCount||d.suspendLayout){return}if(d.hidden){Ext.AbstractComponent.cancelLayout(d)}else{if(typeof a!="boolean"){a=d.isLayoutRoot()}}if(a||!d.ownerLayout||!d.ownerLayout.onContentChange(d)){if(!d.isLayoutSuspended()){e=(c&&c.hasOwnProperty("defer"))?c.defer:d.deferLayouts;Ext.AbstractComponent.updateLayout(d,e)}}},getSizeModel:function(i){var m=this,a=Ext.layout.SizeModel,d=m.componentLayout.ownerContext,b=m.width,o=m.height,p,c,f,e,g,n,k,l,j,h;if(d){h=d.widthModel;g=d.heightModel}if(!h||!g){f=((p=typeof b)=="number");e=((c=typeof o)=="number");j=m.floating||!(n=m.ownerLayout);if(j){k=Ext.layout.Layout.prototype.autoSizePolicy;l=m.floating?3:m.shrinkWrap;if(f){h=a.configured}if(e){g=a.configured}}else{k=n.getItemSizePolicy(m,i);l=n.isItemShrinkWrap(m)}if(d){d.ownerSizePolicy=k}l=(l===true)?3:(l||0);if(j&&l){if(b&&p=="string"){l&=2}if(o&&c=="string"){l&=1}}if(l!==3){if(!i){i=m.ownerCt&&m.ownerCt.getSizeModel()}if(i){l|=(i.width.shrinkWrap?1:0)|(i.height.shrinkWrap?2:0)}}if(!h){if(!k.setsWidth){if(f){h=a.configured}else{h=(l&1)?a.shrinkWrap:a.natural}}else{if(k.readsWidth){if(f){h=a.calculatedFromConfigured}else{h=(l&1)?a.calculatedFromShrinkWrap:a.calculatedFromNatural}}else{h=a.calculated}}}if(!g){if(!k.setsHeight){if(e){g=a.configured}else{g=(l&2)?a.shrinkWrap:a.natural}}else{if(k.readsHeight){if(e){g=a.calculatedFromConfigured}else{g=(l&2)?a.calculatedFromShrinkWrap:a.calculatedFromNatural}}else{g=a.calculated}}}}return h.pairsByHeightOrdinal[g.ordinal]},isDescendant:function(a){if(a.isContainer){for(var b=this.ownerCt;b;b=b.ownerCt){if(b===a){return true}}}return false},doComponentLayout:function(){this.updateLayout();return this},forceComponentLayout:function(){this.updateLayout()},setComponentLayout:function(b){var a=this.componentLayout;if(a&&a.isLayout&&a!=b){a.setOwner(null)}this.componentLayout=b;b.setOwner(this)},getComponentLayout:function(){var a=this;if(!a.componentLayout||!a.componentLayout.isLayout){a.setComponentLayout(Ext.layout.Layout.create(a.componentLayout,"autocomponent"))}return a.componentLayout},afterComponentLayout:function(c,a,b,e){var d=this;if(++d.componentLayoutCounter===1){d.afterFirstLayout(c,a)}if(c!==b||a!==e){d.onResize(c,a,b,e)}},beforeComponentLayout:function(b,a){return true},setPosition:function(a,e,b){var c=this,d=c.beforeSetPosition.apply(c,arguments);if(d&&c.rendered){a=d.x;e=d.y;if(b){if(a!==c.getLocalX()||e!==c.getLocalY()){c.stopAnimation();c.animate(Ext.apply({duration:1000,listeners:{afteranimate:Ext.Function.bind(c.afterSetPosition,c,[a,e])},to:{x:a,y:e}},b))}}else{c.setLocalXY(a,e);c.afterSetPosition(a,e)}}return c},beforeSetPosition:function(a,e,b){var d,c;if(a){if(Ext.isNumber(c=a[0])){b=e;e=a[1];a=c}else{if((c=a.x)!==undefined){b=e;e=a.y;a=c}}}if(this.constrain||this.constrainHeader){d=this.calculateConstrainedPosition(null,[a,e],true);if(d){a=d[0];e=d[1]}}d={x:this.x=a,y:this.y=e,anim:b,hasX:a!==undefined,hasY:e!==undefined};return(d.hasX||d.hasY)?d:null},afterSetPosition:function(a,c){var b=this;b.onPosition(a,c);if(b.hasListeners.move){b.fireEvent("move",b,a,c)}},onPosition:Ext.emptyFn,setWidth:function(a){return this.setSize(a)},setHeight:function(a){return this.setSize(undefined,a)},getSize:function(){return this.el.getSize()},getWidth:function(){return this.el.getWidth()},getHeight:function(){return this.el.getHeight()},getLoader:function(){var c=this,b=c.autoLoad?(Ext.isObject(c.autoLoad)?c.autoLoad:{url:c.autoLoad}):null,a=c.loader||b;if(a){if(!a.isLoader){c.loader=new Ext.ComponentLoader(Ext.apply({target:c,autoLoad:b},a))}else{a.setTarget(c)}return c.loader}return null},setDocked:function(b,c){var a=this;a.dock=b;if(c&&a.ownerCt&&a.rendered){a.ownerCt.updateLayout()}return a},setBorder:function(b,d){var c=this,a=!!d;if(c.rendered||a){if(!a){d=c.el}if(!b){b=0}else{if(b===true){b="1px"}else{b=this.unitizeBox(b)}}d.setStyle("border-width",b);if(!a){c.updateLayout()}}c.border=b},onDestroy:function(){var a=this;if(a.monitorResize&&Ext.EventManager.resizeEvent){Ext.EventManager.resizeEvent.removeListener(a.setSize,a)}Ext.destroy(a.componentLayout,a.loadMask,a.floatingDescendants)},destroy:function(){var d=this,b=d.renderSelectors,a,c;if(!d.isDestroyed){if(!d.hasListeners.beforedestroy||d.fireEvent("beforedestroy",d)!==false){d.destroying=true;d.beforeDestroy();if(d.floating){delete d.floatParent;if(d.zIndexManager){d.zIndexManager.unregister(d)}}else{if(d.ownerCt&&d.ownerCt.remove){d.ownerCt.remove(d,false)}}d.stopAnimation();d.onDestroy();Ext.destroy(d.plugins);if(d.hasListeners.destroy){d.fireEvent("destroy",d)}Ext.ComponentManager.unregister(d);d.mixins.state.destroy.call(d);d.clearListeners();if(d.rendered){if(!d.preserveElOnDestroy){d.el.remove()}d.mixins.elementCt.destroy.call(d);if(b){for(a in b){if(b.hasOwnProperty(a)){c=d[a];if(c){delete d[a];c.remove()}}}}delete d.el;delete d.frameBody;delete d.rendered}d.destroying=false;d.isDestroyed=true}}},isDescendantOf:function(a){return !!this.findParentBy(function(b){return b===a})},getHierarchyState:function(a){var e=this,h=(a&&e.hierarchyStateInner)||e.hierarchyState,c=e.ownerCt,b,d,f,g;if(!h||h.invalid){b=e.getRefOwner();if(c){g=e.ownerLayout===c.layout}e.hierarchyState=h=Ext.Object.chain(b?b.getHierarchyState(g):Ext.rootHierarchyState);e.initHierarchyState(h);if((d=e.componentLayout).initHierarchyState){d.initHierarchyState(h)}if(e.isContainer){e.hierarchyStateInner=f=Ext.Object.chain(h);d=e.layout;if(d&&d.initHierarchyState){d.initHierarchyState(f,h)}if(a){h=f}}}return h},initHierarchyState:function(b){var a=this;if(a.collapsed){b.collapsed=true}if(a.hidden){b.hidden=true}if(a.collapseImmune){b.collapseImmune=true}},getAnchorToXY:function(d,a,c,b){return d.getAnchorXY(a,c,b)},getBorderPadding:function(){return this.el.getBorderPadding()},getLocalX:function(){return this.el.getLocalX()},getLocalXY:function(){return this.el.getLocalXY()},getLocalY:function(){return this.el.getLocalY()},getX:function(){return this.el.getX()},getXY:function(){return this.el.getXY()},getY:function(){return this.el.getY()},setLocalX:function(a){this.el.setLocalX(a)},setLocalXY:function(a,b){this.el.setLocalXY(a,b)},setLocalY:function(a){this.el.setLocalY(a)},setX:function(a,b){this.el.setX(a,b)},setXY:function(b,a){this.el.setXY(b,a)},setY:function(b,a){this.el.setY(b,a)}},function(){var a=this;a.createAlias({on:"addListener",prev:"previousSibling",next:"nextSibling"});Ext.resumeLayouts=function(b){a.resumeLayouts(b)};Ext.suspendLayouts=function(){a.suspendLayouts()};Ext.batchLayouts=function(c,b){a.suspendLayouts();c.call(b);a.resumeLayouts(true)}});