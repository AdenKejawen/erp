Ext.define("Ext.ux.SlidingPager",{requires:["Ext.slider.Single","Ext.slider.Tip"],constructor:function(a){if(a){Ext.apply(this,a)}},init:function(b){var a=b.items.indexOf(b.child("#inputItem")),c;Ext.each(b.items.getRange(a-2,a+2),function(d){d.hide()});c=Ext.create("Ext.slider.Single",{width:114,minValue:1,maxValue:1,hideLabel:true,tipText:function(d){return Ext.String.format("Page <b>{0}</b> of <b>{1}</b>",d.value,d.slider.maxValue)},listeners:{changecomplete:function(e,d){b.store.loadPage(d)}}});b.insert(a+1,c);b.on({change:function(d,e){c.setMaxValue(e.pageCount);c.setValue(e.currentPage)}})}});