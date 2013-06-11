Ext.define("Ext.picker.Month",{extend:"Ext.Component",requires:["Ext.XTemplate","Ext.util.ClickRepeater","Ext.Date","Ext.button.Button"],alias:"widget.monthpicker",alternateClassName:"Ext.MonthPicker",childEls:["bodyEl","prevEl","nextEl","buttonsEl","monthEl","yearEl"],renderTpl:['<div id="{id}-bodyEl" class="{baseCls}-body">','<div id="{id}-monthEl" class="{baseCls}-months">','<tpl for="months">','<div class="{parent.baseCls}-item {parent.baseCls}-month"><a style="{parent.monthStyle}" href="#" hidefocus="on">{.}</a></div>',"</tpl>","</div>",'<div id="{id}-yearEl" class="{baseCls}-years">','<div class="{baseCls}-yearnav">','<button id="{id}-prevEl" class="{baseCls}-yearnav-prev"></button>','<button id="{id}-nextEl" class="{baseCls}-yearnav-next"></button>',"</div>",'<tpl for="years">','<div class="{parent.baseCls}-item {parent.baseCls}-year"><a href="#" hidefocus="on">{.}</a></div>',"</tpl>","</div>",'<div class="'+Ext.baseCSSPrefix+'clear"></div>',"</div>",'<tpl if="showButtons">','<div id="{id}-buttonsEl" class="{baseCls}-buttons">{%',"var me=values.$comp, okBtn=me.okBtn, cancelBtn=me.cancelBtn;","okBtn.ownerLayout = cancelBtn.ownerLayout = me.componentLayout;","okBtn.ownerCt = cancelBtn.ownerCt = me;","Ext.DomHelper.generateMarkup(okBtn.getRenderTree(), out);","Ext.DomHelper.generateMarkup(cancelBtn.getRenderTree(), out);","%}</div>","</tpl>"],okText:"OK",cancelText:"Cancel",baseCls:Ext.baseCSSPrefix+"monthpicker",showButtons:true,width:178,measureWidth:35,measureMaxHeight:20,smallCls:Ext.baseCSSPrefix+"monthpicker-small",totalYears:10,yearOffset:5,monthOffset:6,initComponent:function(){var a=this;a.selectedCls=a.baseCls+"-selected";a.addEvents("cancelclick","monthclick","monthdblclick","okclick","select","yearclick","yeardblclick");if(a.small){a.addCls(a.smallCls)}a.setValue(a.value);a.activeYear=a.getYear(new Date().getFullYear()-4,-4);if(a.showButtons){a.okBtn=new Ext.button.Button({text:a.okText,handler:a.onOkClick,scope:a});a.cancelBtn=new Ext.button.Button({text:a.cancelText,handler:a.onCancelClick,scope:a})}this.callParent()},beforeRender:function(){var f=this,c=0,b=[],a=Ext.Date.getShortMonthName,e=f.monthOffset,g=f.monthMargin,d="";f.callParent();for(;c<e;++c){b.push(a(c),a(c+e))}if(Ext.isDefined(g)){d="margin: 0 "+g+"px;"}Ext.apply(f.renderData,{months:b,years:f.getYears(),showButtons:f.showButtons,monthStyle:d})},afterRender:function(){var b=this,a=b.bodyEl,c=b.buttonsEl;b.callParent();b.mon(a,"click",b.onBodyClick,b);b.mon(a,"dblclick",b.onBodyClick,b);b.years=a.select("."+b.baseCls+"-year a");b.months=a.select("."+b.baseCls+"-month a");b.backRepeater=new Ext.util.ClickRepeater(b.prevEl,{handler:Ext.Function.bind(b.adjustYear,b,[-b.totalYears])});b.prevEl.addClsOnOver(b.baseCls+"-yearnav-prev-over");b.nextRepeater=new Ext.util.ClickRepeater(b.nextEl,{handler:Ext.Function.bind(b.adjustYear,b,[b.totalYears])});b.nextEl.addClsOnOver(b.baseCls+"-yearnav-next-over");b.updateBody();if(!Ext.isDefined(b.monthMargin)){Ext.picker.Month.prototype.monthMargin=b.calculateMonthMargin()}},calculateMonthMargin:function(){var d=this,b=d.monthEl,a=d.months,e=a.first(),c=e.getMargin("l");while(c&&d.getLargest()>d.measureMaxHeight){--c;a.setStyle("margin","0 "+c+"px")}return c},getLargest:function(a){var b=0;this.months.each(function(d){var c=d.getHeight();if(c>b){b=c}});return b},setValue:function(d){var c=this,e=c.activeYear,f=c.monthOffset,b,a;if(!d){c.value=[null,null]}else{if(Ext.isDate(d)){c.value=[d.getMonth(),d.getFullYear()]}else{c.value=[d[0],d[1]]}}if(c.rendered){b=c.value[1];if(b!==null){if((b<e||b>e+c.yearOffset)){c.activeYear=b-c.yearOffset+1}}c.updateBody()}return c},getValue:function(){return this.value},hasSelection:function(){var a=this.value;return a[0]!==null&&a[1]!==null},getYears:function(){var d=this,e=d.yearOffset,f=d.activeYear,a=f+e,c=f,b=[];for(;c<a;++c){b.push(c,c+e)}return b},updateBody:function(){var h=this,e=h.years,b=h.months,l=h.getYears(),m=h.selectedCls,j=h.getYear(null),f=h.value[0],k=h.monthOffset,g,d,i,a,c;if(h.rendered){e.removeCls(m);b.removeCls(m);d=e.elements;a=d.length;for(i=0;i<a;i++){c=Ext.fly(d[i]);g=l[i];c.dom.innerHTML=g;if(g==j){c.dom.className=m}}if(f!==null){if(f<k){f=f*2}else{f=(f-k)*2+1}b.item(f).addCls(m)}}},getYear:function(a,c){var b=this.value[1];c=c||0;return b===null?a:b+c},onBodyClick:function(d,b){var c=this,a=d.type=="dblclick";if(d.getTarget("."+c.baseCls+"-month")){d.stopEvent();c.onMonthClick(b,a)}else{if(d.getTarget("."+c.baseCls+"-year")){d.stopEvent();c.onYearClick(b,a)}}},adjustYear:function(a){if(typeof a!="number"){a=this.totalYears}this.activeYear+=a;this.updateBody()},onOkClick:function(){this.fireEvent("okclick",this,this.value)},onCancelClick:function(){this.fireEvent("cancelclick",this)},onMonthClick:function(c,a){var b=this;b.value[0]=b.resolveOffset(b.months.indexOf(c),b.monthOffset);b.updateBody();b.fireEvent("month"+(a?"dbl":"")+"click",b,b.value);b.fireEvent("select",b,b.value)},onYearClick:function(c,a){var b=this;b.value[1]=b.activeYear+b.resolveOffset(b.years.indexOf(c),b.yearOffset);b.updateBody();b.fireEvent("year"+(a?"dbl":"")+"click",b,b.value);b.fireEvent("select",b,b.value)},resolveOffset:function(a,b){if(a%2===0){return(a/2)}else{return b+Math.floor(a/2)}},beforeDestroy:function(){var a=this;a.years=a.months=null;Ext.destroyMembers(a,"backRepeater","nextRepeater","okBtn","cancelBtn");a.callParent()},finishRenderChildren:function(){var a=this;this.callParent(arguments);if(this.showButtons){a.okBtn.finishRender();a.cancelBtn.finishRender()}},onDestroy:function(){Ext.destroyMembers(this,"okBtn","cancelBtn");this.callParent()}});