Ext.util.DelayedTask=function(e,d,b,g){var f=this,a,c=function(){clearInterval(f.id);f.id=null;e.apply(d,b||[]);Ext.EventManager.idleEvent.fire()};g=typeof g==="boolean"?g:true;f.id=null;f.delay=function(i,k,j,h){if(g){f.cancel()}a=i||a,e=k||e;d=j||d;b=h||b;if(!f.id){f.id=setInterval(c,a)}};f.cancel=function(){if(f.id){clearInterval(f.id);f.id=null}}};