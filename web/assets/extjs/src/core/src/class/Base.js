(function(a){var d=[],b=function(){},c=function(i,f,h,g){var e=function(){var j=this.callParent(arguments);i.apply(this,arguments);return j};e.$name=h;e.$owner=g;if(f){e.$previous=f.$previous;f.$previous=e}return e};Ext.apply(b,{$className:"Ext.Base",$isClass:true,create:function(){return Ext.create.apply(Ext,[this].concat(Array.prototype.slice.call(arguments,0)))},extend:function(j){var e=j.prototype,m,g,h,k,f,l;g=this.prototype=Ext.Object.chain(e);g.self=this;this.superclass=g.superclass=e;if(!j.$isClass){m=Ext.Base.prototype;for(h in m){if(h in g){g[h]=m[h]}}}l=e.$inheritableStatics;if(l){for(h=0,k=l.length;h<k;h++){f=l[h];if(!this.hasOwnProperty(f)){this[f]=j[f]}}}if(j.$onExtended){this.$onExtended=j.$onExtended.slice()}g.config=new g.configClass();g.initConfigList=g.initConfigList.slice();g.initConfigMap=Ext.clone(g.initConfigMap);g.configMap=Ext.Object.chain(g.configMap)},$onExtended:[],triggerExtended:function(){var g=this.$onExtended,f=g.length,e,h;if(f>0){for(e=0;e<f;e++){h=g[e];h.fn.apply(h.scope||this,arguments)}}},onExtended:function(f,e){this.$onExtended.push({fn:f,scope:e});return this},addConfig:function(h,l){var n=this.prototype,m=Ext.Class.configNameCache,i=n.configMap,j=n.initConfigList,g=n.initConfigMap,k=n.config,e,f,o;for(f in h){if(h.hasOwnProperty(f)){if(!i[f]){i[f]=true}o=h[f];e=m[f].initialized;if(!g[f]&&o!==null&&!n[e]){g[f]=true;j.push(f)}}}if(l){Ext.merge(k,h)}else{Ext.mergeIf(k,h)}n.configClass=Ext.Object.classify(k)},addStatics:function(e){var g,f;for(f in e){if(e.hasOwnProperty(f)){g=e[f];if(typeof g=="function"&&!g.$isClass&&g!==Ext.emptyFn&&g!==Ext.identityFn){g.$owner=this;g.$name=f;g.displayName=Ext.getClassName(this)+"."+f}this[f]=g}}return this},addInheritableStatics:function(f){var i,e,h=this.prototype,g,j;i=h.$inheritableStatics;e=h.$hasInheritableStatics;if(!i){i=h.$inheritableStatics=[];e=h.$hasInheritableStatics={}}for(g in f){if(f.hasOwnProperty(g)){j=f[g];if(typeof j=="function"){j.displayName=Ext.getClassName(this)+"."+g}this[g]=j;if(!e[g]){e[g]=true;i.push(g)}}}return this},addMembers:function(f){var h=this.prototype,e=Ext.enumerables,l=[],j,k,g,m;for(g in f){l.push(g)}if(e){l.push.apply(l,e)}for(j=0,k=l.length;j<k;j++){g=l[j];if(f.hasOwnProperty(g)){m=f[g];if(typeof m=="function"&&!m.$isClass&&m!==Ext.emptyFn&&m!==Ext.identityFn){m.$owner=this;m.$name=g;m.displayName=(this.$className||"")+"#"+g}h[g]=m}}return this},addMember:function(e,f){if(typeof f=="function"&&!f.$isClass&&f!==Ext.emptyFn&&f!==Ext.identityFn){f.$owner=this;f.$name=e;f.displayName=(this.$className||"")+"#"+e}this.prototype[e]=f;return this},implement:function(){this.addMembers.apply(this,arguments)},borrow:function(j,g){var o=this.prototype,n=j.prototype,l=Ext.getClassName(this),h,k,f,m,e;g=Ext.Array.from(g);for(h=0,k=g.length;h<k;h++){f=g[h];e=n[f];if(typeof e=="function"){m=Ext.Function.clone(e);if(l){m.displayName=l+"#"+f}m.$owner=this;m.$name=f;o[f]=m}else{o[f]=e}}return this},override:function(f){var m=this,o=Ext.enumerables,k=m.prototype,h=Ext.Function.clone,e,j,g,n,l,i;if(arguments.length===2){e=f;f={};f[e]=arguments[1];o=null}do{l=[];n=null;for(e in f){if(e=="statics"){n=f[e]}else{if(e=="inheritableStatics"){m.addInheritableStatics(f[e])}else{if(e=="config"){m.addConfig(f[e],true)}else{l.push(e)}}}}if(o){l.push.apply(l,o)}for(j=l.length;j--;){e=l[j];if(f.hasOwnProperty(e)){g=f[e];if(typeof g=="function"&&!g.$className&&g!==Ext.emptyFn&&g!==Ext.identityFn){if(typeof g.$owner!="undefined"){g=h(g)}if(m.$className){g.displayName=m.$className+"#"+e}g.$owner=m;g.$name=e;i=k[e];if(i){g.$previous=i}}k[e]=g}}k=m;f=n}while(f);return this},callParent:function(e){var f;return(f=this.callParent.caller)&&(f.$previous||((f=f.$owner?f:f.caller)&&f.$owner.superclass.self[f.$name])).apply(this,e||d)},callSuper:function(e){var f;return(f=this.callSuper.caller)&&((f=f.$owner?f:f.caller)&&f.$owner.superclass.self[f.$name]).apply(this,e||d)},mixin:function(f,g){var k=this,r=g.prototype,m=k.prototype,q,l,h,j,p,o,n,e;if(typeof r.onClassMixedIn!="undefined"){r.onClassMixedIn.call(g,k)}if(!m.hasOwnProperty("mixins")){if("mixins" in m){m.mixins=Ext.Object.chain(m.mixins)}else{m.mixins={}}}for(q in r){o=r[q];if(q==="mixins"){Ext.merge(m.mixins,o)}else{if(q==="xhooks"){for(n in o){e=o[n];e.$previous=Ext.emptyFn;if(m.hasOwnProperty(n)){c(e,m[n],n,k)}else{m[n]=c(e,null,n,k)}}}else{if(!(q==="mixinId"||q==="config")&&(m[q]===undefined)){m[q]=o}}}}l=r.$inheritableStatics;if(l){for(h=0,j=l.length;h<j;h++){p=l[h];if(!k.hasOwnProperty(p)){k[p]=g[p]}}}if("config" in r){k.addConfig(r.config,false)}m.mixins[f]=r;return k},getName:function(){return Ext.getClassName(this)},createAlias:a(function(f,e){this.override(f,function(){return this[e].apply(this,arguments)})}),addXtype:function(i){var f=this.prototype,h=f.xtypesMap,g=f.xtypes,e=f.xtypesChain;if(!f.hasOwnProperty("xtypesMap")){h=f.xtypesMap=Ext.merge({},f.xtypesMap||{});g=f.xtypes=f.xtypes?[].concat(f.xtypes):[];e=f.xtypesChain=f.xtypesChain?[].concat(f.xtypesChain):[];f.xtype=i}if(!h[i]){h[i]=true;g.push(i);e.push(i);Ext.ClassManager.setAlias(this,"widget."+i)}return this}});b.implement({isInstance:true,$className:"Ext.Base",configClass:Ext.emptyFn,initConfigList:[],configMap:{},initConfigMap:{},statics:function(){var f=this.statics.caller,e=this.self;if(!f){return e}return f.$owner},callParent:function(g){var i,e=(i=this.callParent.caller)&&(i.$previous||((i=i.$owner?i:i.caller)&&i.$owner.superclass[i.$name]));if(!e){i=this.callParent.caller;var h,f;if(!i.$owner){if(!i.caller){throw new Error("Attempting to call a protected method from the public scope, which is not allowed")}i=i.caller}h=i.$owner.superclass;f=i.$name;if(!(f in h)){throw new Error("this.callParent() was called but there's no such method ("+f+") found in the parent class ("+(Ext.getClassName(h)||"Object")+")")}}return e.apply(this,g||d)},callSuper:function(g){var i,e=(i=this.callSuper.caller)&&((i=i.$owner?i:i.caller)&&i.$owner.superclass[i.$name]);if(!e){i=this.callSuper.caller;var h,f;if(!i.$owner){if(!i.caller){throw new Error("Attempting to call a protected method from the public scope, which is not allowed")}i=i.caller}h=i.$owner.superclass;f=i.$name;if(!(f in h)){throw new Error("this.callSuper() was called but there's no such method ("+f+") found in the parent class ("+(Ext.getClassName(h)||"Object")+")")}}return e.apply(this,g||d)},self:b,constructor:function(){return this},initConfig:function(g){var m=g,l=Ext.Class.configNameCache,j=new this.configClass(),p=this.initConfigList,h=this.configMap,o,k,n,f,e;this.initConfig=Ext.emptyFn;this.initialConfig=m||{};this.config=g=(m)?Ext.merge(j,g):j;if(m){p=p.slice();for(f in m){if(h[f]){if(m[f]!==null){p.push(f);this[l[f].initialized]=false}}}}for(k=0,n=p.length;k<n;k++){f=p[k];o=l[f];e=o.initialized;if(!this[e]){this[e]=true;this[o.set].call(this,g[f])}}return this},hasConfig:function(e){return Boolean(this.configMap[e])},setConfig:function(h,l){if(!h){return this}var g=Ext.Class.configNameCache,e=this.config,k=this.configMap,j=this.initialConfig,f,i;l=Boolean(l);for(f in h){if(l&&j.hasOwnProperty(f)){continue}i=h[f];e[f]=i;if(k[f]){this[g[f].set](i)}}return this},getConfig:function(f){var e=Ext.Class.configNameCache;return this[e[f].get]()},getInitialConfig:function(f){var e=this.config;if(!f){return e}else{return e[f]}},onConfigUpdate:function(l,n,o){var p=this.self,k=p.$className,g,j,e,h,m,f;l=Ext.Array.from(l);o=o||this;for(g=0,j=l.length;g<j;g++){e=l[g];h="update"+Ext.String.capitalize(e);m=this[h]||Ext.emptyFn;f=function(){m.apply(this,arguments);o[n].apply(o,arguments)};f.$name=h;f.$owner=p;f.displayName=k+"#"+h;this[h]=f}},destroy:function(){this.destroy=Ext.emptyFn}});b.prototype.callOverridden=b.prototype.callParent;Ext.Base=b}(Ext.Function.flexSetter));