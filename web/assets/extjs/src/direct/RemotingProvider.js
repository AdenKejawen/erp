Ext.define("Ext.direct.RemotingProvider",{alias:"direct.remotingprovider",extend:"Ext.direct.JsonProvider",requires:["Ext.util.MixedCollection","Ext.util.DelayedTask","Ext.direct.Transaction","Ext.direct.RemotingMethod"],enableBuffer:10,maxRetries:1,timeout:undefined,constructor:function(a){var b=this;b.callParent(arguments);b.addEvents("beforecall","call");b.namespace=(Ext.isString(b.namespace))?Ext.ns(b.namespace):b.namespace||window;b.transactions=new Ext.util.MixedCollection();b.callBuffer=[]},initAPI:function(){var g=this.actions,e=this.namespace,f,b,c,d,a,h;for(f in g){if(g.hasOwnProperty(f)){b=e[f];if(!b){b=e[f]={}}c=g[f];for(d=0,a=c.length;d<a;++d){h=new Ext.direct.RemotingMethod(c[d]);b[h.name]=this.createHandler(f,h)}}}},createHandler:function(c,d){var b=this,a;if(!d.formHandler){a=function(){b.configureRequest(c,d,Array.prototype.slice.call(arguments,0))}}else{a=function(f,g,e){b.configureFormRequest(c,d,f,g,e)}}a.directCfg={action:c,method:d};return a},isConnected:function(){return !!this.connected},connect:function(){var a=this;if(a.url){a.initAPI();a.connected=true;a.fireEvent("connect",a)}else{if(!a.url){Ext.Error.raise("Error initializing RemotingProvider, no url configured.")}}},disconnect:function(){var a=this;if(a.connected){a.connected=false;a.fireEvent("disconnect",a)}},runCallback:function(e,b){var d=!!b.status,c=d?"success":"failure",f,a;if(e&&e.callback){f=e.callback;a=Ext.isDefined(b.result)?b.result:b.data;if(Ext.isFunction(f)){f(a,b,d)}else{Ext.callback(f[c],f.scope,[a,b,d]);Ext.callback(f.callback,f.scope,[a,b,d])}}},onData:function(k,h,c){var f=this,d=0,e,j,a,b,g;if(h){j=f.createEvents(c);for(e=j.length;d<e;++d){a=j[d];b=f.getTransaction(a);f.fireEvent("data",f,a);if(b){f.runCallback(b,a,true);Ext.direct.Manager.removeTransaction(b)}}}else{g=[].concat(k.transaction);for(e=g.length;d<e;++d){b=f.getTransaction(g[d]);if(b&&b.retryCount<f.maxRetries){b.retry()}else{a=new Ext.direct.ExceptionEvent({data:null,transaction:b,code:Ext.direct.Manager.exceptions.TRANSPORT,message:"Unable to connect to the server.",xhr:c});f.fireEvent("data",f,a);if(b){f.runCallback(b,a,false);Ext.direct.Manager.removeTransaction(b)}}}}},getTransaction:function(a){return a&&a.tid?Ext.direct.Manager.getTransaction(a.tid):null},configureRequest:function(d,a,f){var g=this,c=a.getCallData(f),e=c.data,h=c.callback,i=c.scope,b;b=new Ext.direct.Transaction({provider:g,args:f,action:d,method:a.name,data:e,callback:i&&Ext.isFunction(h)?Ext.Function.bind(h,i):h});if(g.fireEvent("beforecall",g,b,a)!==false){Ext.direct.Manager.addTransaction(b);g.queueTransaction(b);g.fireEvent("call",g,b,a)}},getCallData:function(a){return{action:a.action,method:a.method,data:a.data,type:"rpc",tid:a.id}},sendRequest:function(g){var f=this,e={url:f.url,callback:f.onData,scope:f,transaction:g,timeout:f.timeout},b,d=f.enableUrlEncode,c=0,a,h;if(Ext.isArray(g)){b=[];for(a=g.length;c<a;++c){b.push(f.getCallData(g[c]))}}else{b=f.getCallData(g)}if(d){h={};h[Ext.isString(d)?d:"data"]=Ext.encode(b);e.params=h}else{e.jsonData=b}Ext.Ajax.request(e)},queueTransaction:function(c){var b=this,a=b.enableBuffer;if(c.form){b.sendFormRequest(c);return}b.callBuffer.push(c);if(a){if(!b.callTask){b.callTask=new Ext.util.DelayedTask(b.combineAndSend,b)}b.callTask.delay(Ext.isNumber(a)?a:10)}else{b.combineAndSend()}},combineAndSend:function(){var b=this.callBuffer,a=b.length;if(a>0){this.sendRequest(a==1?b[0]:b);this.callBuffer=[]}},configureFormRequest:function(e,a,b,h,i){var g=this,c=new Ext.direct.Transaction({provider:g,action:e,method:a.name,args:[b,h,i],callback:i&&Ext.isFunction(h)?Ext.Function.bind(h,i):h,isForm:true}),f,d;if(g.fireEvent("beforecall",g,c,a)!==false){Ext.direct.Manager.addTransaction(c);f=String(b.getAttribute("enctype")).toLowerCase()=="multipart/form-data";d={extTID:c.id,extAction:e,extMethod:a.name,extType:"rpc",extUpload:String(f)};Ext.apply(c,{form:Ext.getDom(b),isUpload:f,params:h&&Ext.isObject(h.params)?Ext.apply(d,h.params):d});g.fireEvent("call",g,c,a);g.sendFormRequest(c)}},sendFormRequest:function(a){Ext.Ajax.request({url:this.url,params:a.params,callback:this.onData,scope:this,form:a.form,isUpload:a.isUpload,transaction:a})}});