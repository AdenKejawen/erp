Ext.define("Com.GatotKaca.ERP.module.Personal.controller.SuperviseOverTime",{extend:"Com.GatotKaca.ERP.module.Personal.controller.OverTimeBase",views:["Com.GatotKaca.ERP.module.Personal.view.SuperviseOverTime"],store:"Com.GatotKaca.ERP.module.Personal.store.SuperviseOverTime",fmSelector:"formspvovertime",startDate:"prSpvOtFilterFrom",endDate:"prSpvOtFilterTo",init:function(){var b=this;var a=b.getStore(b.store);a.addListener("load",b.onStoreLoad,b);a.getProxy().extraParams={supervise:"true",approve:0};b.loadStore(a);b.getStore("Com.GatotKaca.ERP.store.Hour");b.getStore("Com.GatotKaca.ERP.store.Minute");b.getStore("Com.GatotKaca.ERP.store.Agreement");b.control({"formspvovertime button[action=reset]":{click:b.resetForm},"formspvovertime button[action=save]":{click:b.save},"gridspvovertime button[action=refresh]":{click:b.filter},"gridspvovertime datefield[name=prSpvOtFilterFrom]":{change:b.filter},"gridspvovertime datefield[name=prSpvOtFilterTo]":{change:b.filter},gridspvovertime:{select:b.viewDetail}});b.callParent(arguments)},viewDetail:function(d,c,g,a,b,f){var e=this.getForm(this.fmSelector);this.ajaxRequest(BASE_URL+"personal/overtime/getbyid",{overtime_id:c.data.overtime_id},function(h){e.setValues(h.data[0]);e.findField("ot_status").setReadOnly(h.data[0].ot_status);var j=h.data[0].ot_start.split(":");var i=h.data[0].ot_end.split(":");e.findField("ot_start_h").setValue(j[0]);e.findField("ot_start_m").setValue(j[1]);e.findField("ot_end_h").setValue(i[0]);e.findField("ot_end_m").setValue(i[1])})}});