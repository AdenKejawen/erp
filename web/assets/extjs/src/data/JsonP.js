Ext.define("Ext.data.JsonP",{singleton:true,requestCount:0,requests:{},timeout:30000,disableCaching:true,disableCachingParam:"_dc",callbackKey:"callback",request:function(m){m=Ext.apply({},m);if(!m.url){Ext.Error.raise("A url must be specified for a JSONP request.")}var i=this,d=Ext.isDefined(m.disableCaching)?m.disableCaching:i.disableCaching,g=m.disableCachingParam||i.disableCachingParam,c=++i.requestCount,k=m.callbackName||"callback"+c,h=m.callbackKey||i.callbackKey,l=Ext.isDefined(m.timeout)?m.timeout:i.timeout,e=Ext.apply({},m.params),b=m.url,a=Ext.name,f,j;if(d&&!e[g]){e[g]=Ext.Date.now()}m.params=e;e[h]=a+".data.JsonP."+k;j=i.createScript(b,e,m);i.requests[c]=f={url:b,params:e,script:j,id:c,scope:m.scope,success:m.success,failure:m.failure,callback:m.callback,callbackKey:h,callbackName:k};if(l>0){f.timeout=setTimeout(Ext.bind(i.handleTimeout,i,[f]),l)}i.setupErrorHandling(f);i[k]=Ext.bind(i.handleResponse,i,[f],true);i.loadScript(f);return f},abort:function(c){var b=this,d=b.requests,a;if(c){if(!c.id){c=d[c]}b.handleAbort(c)}else{for(a in d){if(d.hasOwnProperty(a)){b.abort(d[a])}}}},setupErrorHandling:function(a){a.script.onerror=Ext.bind(this.handleError,this,[a])},handleAbort:function(a){a.errorType="abort";this.handleResponse(null,a)},handleError:function(a){a.errorType="error";this.handleResponse(null,a)},cleanupErrorHandling:function(a){a.script.onerror=null},handleTimeout:function(a){a.errorType="timeout";this.handleResponse(null,a)},handleResponse:function(a,b){var c=true;if(b.timeout){clearTimeout(b.timeout)}delete this[b.callbackName];delete this.requests[b.id];this.cleanupErrorHandling(b);Ext.fly(b.script).remove();if(b.errorType){c=false;Ext.callback(b.failure,b.scope,[b.errorType])}else{Ext.callback(b.success,b.scope,[a])}Ext.callback(b.callback,b.scope,[c,a,b.errorType]);Ext.EventManager.idleEvent.fire()},createScript:function(c,d,b){var a=document.createElement("script");a.setAttribute("src",Ext.urlAppend(c,Ext.Object.toQueryString(d)));a.setAttribute("async",true);a.setAttribute("type","text/javascript");return a},loadScript:function(a){Ext.getHead().appendChild(a.script)}});