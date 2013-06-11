Ext.define("Ext.chart.axis.Radial",{extend:"Ext.chart.axis.Numeric",position:"radial",alias:"axis.radial",drawAxis:function(t){var k=this.chart,a=k.surface,s=k.chartBBox,p=k.getChartStore(),b=p.getCount(),e=s.x+(s.width/2),c=s.y+(s.height/2),o=Math.min(s.width,s.height)/2,h=[],q,n=this.steps,f,d,g=Math.PI*2,r=Math.cos,m=Math.sin;if(this.sprites&&!k.resizing){this.drawLabel();return}if(!this.sprites){for(f=1;f<=n;f++){q=a.add({type:"circle",x:e,y:c,radius:Math.max(o*f/n,0),stroke:"#ccc"});q.setAttributes({hidden:false},true);h.push(q)}for(f=0;f<b;f++){q=a.add({type:"path",path:["M",e,c,"L",e+o*r(f/b*g),c+o*m(f/b*g),"Z"],stroke:"#ccc"});q.setAttributes({hidden:false},true);h.push(q)}}else{h=this.sprites;for(f=0;f<n;f++){h[f].setAttributes({x:e,y:c,radius:Math.max(o*(f+1)/n,0),stroke:"#ccc"},true)}for(d=0;d<b;d++){h[f+d].setAttributes({path:["M",e,c,"L",e+o*r(d/b*g),c+o*m(d/b*g),"Z"],stroke:"#ccc"},true)}}this.sprites=h;this.drawLabel()},drawLabel:function(){var v=this.chart,c=v.series.items,q,A=v.surface,b=v.chartBBox,k=v.getChartStore(),I=k.data.items,o,h,n=b.x+(b.width/2),m=b.y+(b.height/2),g=Math.min(b.width,b.height)/2,E=Math.max,H=Math.round,w=[],l,y=[],d,z=[],f,u=!this.maximum,G=this.maximum||0,F=this.steps,D=0,C,s,r,x=Math.PI*2,e=Math.cos,a=Math.sin,B=this.label.display,p=B!=="none",t=10;if(!p){return}for(D=0,o=c.length;D<o;D++){q=c[D];y.push(q.yField);f=q.xField}for(C=0,o=I.length;C<o;C++){h=I[C];z.push(h.get(f));if(u){for(D=0,d=y.length;D<d;D++){G=E(+h.get(y[D]),G)}}}if(!this.labelArray){if(B!="categories"){for(D=1;D<=F;D++){l=A.add({type:"text",text:H(D/F*G),x:n,y:m-g*D/F,"text-anchor":"middle","stroke-width":0.1,stroke:"#333"});l.setAttributes({hidden:false},true);w.push(l)}}if(B!="scale"){for(C=0,F=z.length;C<F;C++){s=e(C/F*x)*(g+t);r=a(C/F*x)*(g+t);l=A.add({type:"text",text:z[C],x:n+s,y:m+r,"text-anchor":s*s<=0.001?"middle":(s<0?"end":"start")});l.setAttributes({hidden:false},true);w.push(l)}}}else{w=this.labelArray;if(B!="categories"){for(D=0;D<F;D++){w[D].setAttributes({text:H((D+1)/F*G),x:n,y:m-g*(D+1)/F,"text-anchor":"middle","stroke-width":0.1,stroke:"#333"},true)}}if(B!="scale"){for(C=0,F=z.length;C<F;C++){s=e(C/F*x)*(g+t);r=a(C/F*x)*(g+t);if(w[D+C]){w[D+C].setAttributes({type:"text",text:z[C],x:n+s,y:m+r,"text-anchor":s*s<=0.001?"middle":(s<0?"end":"start")},true)}}}}this.labelArray=w},getRange:function(){var a=this.callParent();a.min=0;return a},processView:function(){var g=this,c=g.chart.series.items,e,f,d,b,a=[];for(e=0,f=c.length;e<f;e++){d=c[e];a.push(d.yField)}g.fields=a;b=g.calcEnds();g.maximum=b.to;g.steps=b.steps}});