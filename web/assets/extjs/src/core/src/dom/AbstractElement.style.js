(function(){var p=Ext.dom.AbstractElement,n=document.defaultView,m=Ext.Array,l=/^\s+|\s+$/g,b=/\w/g,o=/\s+/,s=/^(?:transparent|(?:rgba[(](?:\s*\d+\s*[,]){3}\s*0\s*[)]))$/i,g=Ext.supports.ClassList,e="padding",d="margin",r="border",j="-left",q="-right",k="-top",c="-bottom",h="-width",i={l:r+j+h,r:r+q+h,t:r+k+h,b:r+c+h},f={l:e+j,r:e+q,t:e+k,b:e+c},a={l:d+j,r:d+q,t:d+k,b:d+c};p.override({styleHooks:{},addStyles:function(A,z){var v=0,y=(A||"").match(b),x,t=y.length,w,u=[];if(t==1){v=Math.abs(parseFloat(this.getStyle(z[y[0]]))||0)}else{if(t){for(x=0;x<t;x++){w=y[x];u.push(z[w])}u=this.getStyle(u);for(x=0;x<t;x++){w=y[x];v+=Math.abs(parseFloat(u[z[w]])||0)}}}return v},addCls:g?function(w){if(String(w).indexOf("undefined")>-1){Ext.Logger.warn("called with an undefined className: "+w)}var y=this,A=y.dom,z,x,v,t,u;if(typeof(w)=="string"){w=w.replace(l,"").split(o)}if(A&&w&&!!(t=w.length)){if(!A.className){A.className=w.join(" ")}else{z=A.classList;for(v=0;v<t;++v){u=w[v];if(u){if(!z.contains(u)){if(x){x.push(u)}else{x=A.className.replace(l,"");x=x?[x,u]:[u]}}}}if(x){A.className=x.join(" ")}}}return y}:function(u){if(String(u).indexOf("undefined")>-1){Ext.Logger.warn("called with an undefined className: '"+u+"'")}var v=this,x=v.dom,w,t;if(x&&u&&u.length){t=Ext.Element.mergeClsList(x.className,u);if(t.changed){x.className=t.join(" ")}}return v},removeCls:function(v){var w=this,x=w.dom,t,u;if(typeof(v)=="string"){v=v.replace(l,"").split(o)}if(x&&x.className&&v&&!!(t=v.length)){if(t==1&&g){if(v[0]){x.classList.remove(v[0])}}else{u=Ext.Element.removeCls(x.className,v);if(u.changed){x.className=u.join(" ")}}}return w},radioCls:function(x){var y=this.dom.parentNode.childNodes,u,w,t;x=Ext.isArray(x)?x:[x];for(w=0,t=y.length;w<t;w++){u=y[w];if(u&&u.nodeType==1){Ext.fly(u,"_internal").removeCls(x)}}return this.addCls(x)},toggleCls:g?function(t){var u=this,v=u.dom;if(v){t=t.replace(l,"");if(t){v.classList.toggle(t)}}return u}:function(t){var u=this;return u.hasCls(t)?u.removeCls(t):u.addCls(t)},hasCls:g?function(t){var u=this.dom;return(u&&t)?u.classList.contains(t):false}:function(t){var u=this.dom;return u?t&&(" "+u.className+" ").indexOf(" "+t+" ")!=-1:false},replaceCls:function(u,t){return this.removeCls(u).addCls(t)},isStyle:function(t,u){return this.getStyle(t)==u},getStyle:function(F,A){var B=this,w=B.dom,I=typeof F!="string",G=B.styleHooks,u=F,C=u,z=1,y,H,E,D,v,t,x;if(I){E={};u=C[0];x=0;if(!(z=C.length)){return E}}if(!w||w.documentElement){return E||""}y=w.style;if(A){t=y}else{t=w.ownerDocument.defaultView.getComputedStyle(w,null);if(!t){A=true;t=y}}do{D=G[u];if(!D){G[u]=D={name:p.normalize(u)}}if(D.get){v=D.get(w,B,A,t)}else{H=D.name;v=t[H]}if(!I){return v}E[u]=v;u=C[++x]}while(x<z);return E},getStyles:function(){var u=Ext.Array.slice(arguments),t=u.length,v;if(t&&typeof u[t-1]=="boolean"){v=u.pop()}return this.getStyle(u,v)},isTransparent:function(u){var t=this.getStyle(u);return t?s.test(t):false},setStyle:function(A,y){var w=this,z=w.dom,t=w.styleHooks,v=z.style,u=A,x;if(typeof u=="string"){x=t[u];if(!x){t[u]=x={name:p.normalize(u)}}y=(y==null)?"":y;if(x.set){x.set(z,y,w)}else{v[x.name]=y}if(x.afterSet){x.afterSet(z,y,w)}}else{for(u in A){if(A.hasOwnProperty(u)){x=t[u];if(!x){t[u]=x={name:p.normalize(u)}}y=A[u];y=(y==null)?"":y;if(x.set){x.set(z,y,w)}else{v[x.name]=y}if(x.afterSet){x.afterSet(z,y,w)}}}}return w},getHeight:function(u){var v=this.dom,t=u?(v.clientHeight-this.getPadding("tb")):v.offsetHeight;return t>0?t:0},getWidth:function(t){var v=this.dom,u=t?(v.clientWidth-this.getPadding("lr")):v.offsetWidth;return u>0?u:0},setWidth:function(t){var u=this;u.dom.style.width=p.addUnits(t);return u},setHeight:function(t){var u=this;u.dom.style.height=p.addUnits(t);return u},getBorderWidth:function(t){return this.addStyles(t,i)},getPadding:function(t){return this.addStyles(t,f)},margins:a,applyStyles:function(v){if(v){var u,t,w=this.dom;if(typeof v=="function"){v=v.call()}if(typeof v=="string"){v=Ext.util.Format.trim(v).split(/\s*(?::|;)\s*/);for(u=0,t=v.length;u<t;){w.style[p.normalize(v[u++])]=v[u++]}}else{if(typeof v=="object"){this.setStyle(v)}}}},setSize:function(v,t){var w=this,u=w.dom.style;if(Ext.isObject(v)){t=v.height;v=v.width}u.width=p.addUnits(v);u.height=p.addUnits(t);return w},getViewSize:function(){var t=document,u=this.dom;if(u==t||u==t.body){return{width:p.getViewportWidth(),height:p.getViewportHeight()}}else{return{width:u.clientWidth,height:u.clientHeight}}},getSize:function(u){var t=this.dom;return{width:Math.max(0,u?(t.clientWidth-this.getPadding("lr")):t.offsetWidth),height:Math.max(0,u?(t.clientHeight-this.getPadding("tb")):t.offsetHeight)}},repaint:function(){var t=this.dom;this.addCls(Ext.baseCSSPrefix+"repaint");setTimeout(function(){Ext.fly(t).removeCls(Ext.baseCSSPrefix+"repaint")},1);return this},getMargin:function(u){var v=this,x={t:"top",l:"left",r:"right",b:"bottom"},t,y,w;if(!u){w=[];for(t in v.margins){if(v.margins.hasOwnProperty(t)){w.push(v.margins[t])}}y=v.getStyle(w);if(y&&typeof y=="object"){for(t in v.margins){if(v.margins.hasOwnProperty(t)){y[x[t]]=parseFloat(y[v.margins[t]])||0}}}return y}else{return v.addStyles.call(v,u,v.margins)}},mask:function(u,y,C){var z=this,v=z.dom,w=(z.$cache||z.getCache()).data,t=w.mask,D,B,A="",x=Ext.baseCSSPrefix;z.addCls(x+"masked");if(z.getStyle("position")=="static"){z.addCls(x+"masked-relative")}if(t){t.remove()}if(y&&typeof y=="string"){A=" "+y}else{A=" "+x+"mask-gray"}D=z.createChild({cls:x+"mask"+((C!==false)?"":(" "+x+"mask-gray")),html:u?('<div class="'+(y||(x+"mask-message"))+'">'+u+"</div>"):""});B=z.getSize();w.mask=D;if(v===document.body){B.height=window.innerHeight;if(z.orientationHandler){Ext.EventManager.unOrientationChange(z.orientationHandler,z)}z.orientationHandler=function(){B=z.getSize();B.height=window.innerHeight;D.setSize(B)};Ext.EventManager.onOrientationChange(z.orientationHandler,z)}D.setSize(B);if(Ext.is.iPad){Ext.repaint()}},unmask:function(){var u=this,w=(u.$cache||u.getCache()).data,t=w.mask,v=Ext.baseCSSPrefix;if(t){t.remove();delete w.mask}u.removeCls([v+"masked",v+"masked-relative"]);if(u.dom===document.body){Ext.EventManager.unOrientationChange(u.orientationHandler,u);delete u.orientationHandler}}});p.populateStyleMap=function(A,t){var z=["margin-","padding-","border-width-"],y=["before","after"],v,x,u,w;for(v=z.length;v--;){for(w=2;w--;){x=z[v]+y[w];A[p.normalize(x)]=A[x]={name:p.normalize(z[v]+t[w])}}}};Ext.onReady(function(){var B=Ext.supports,t,z,x,u,A;function y(G,D,F,C){var E=C[this.name]||"";return s.test(E)?"transparent":E}function w(I,F,H,E){var C=E.marginRight,D,G;if(C!="0px"){D=I.style;G=D.display;D.display="inline-block";C=(H?E:I.ownerDocument.defaultView.getComputedStyle(I,null)).marginRight;D.display=G}return C}function v(J,G,I,F){var C=F.marginRight,E,D,H;if(C!="0px"){E=J.style;D=p.getRightMarginFixCleaner(J);H=E.display;E.display="inline-block";C=(I?F:J.ownerDocument.defaultView.getComputedStyle(J,"")).marginRight;E.display=H;D()}return C}t=p.prototype.styleHooks;p.populateStyleMap(t,["left","right"]);if(B.init){B.init()}if(!B.RightMargin){t.marginRight=t["margin-right"]={name:"marginRight",get:(B.DisplayChangeInputSelectionBug||B.DisplayChangeTextAreaSelectionBug)?v:w}}if(!B.TransparentColor){z=["background-color","border-color","color","outline-color"];for(x=z.length;x--;){u=z[x];A=p.normalize(u);t[u]=t[A]={name:A,get:y}}}})}());