Ext.define("Com.GatotKaca.ERP.module.Personal.controller.ChangePassword",{extend:"Com.GatotKaca.ERP.controller.Base",views:["Com.GatotKaca.ERP.module.Personal.view.ChangePassword"],store:"Com.GatotKaca.ERP.module.Personal.store.ChangePassword",fmSelector:"formchangepassword",init:function(){var b=this;var a=b.getStore(b.store);a.addListener("load",b.onStoreLoad,b);b.loadStore(a);b.control({"formchangepassword button[action=save]":{click:b.save}});b.callParent(arguments)},save:function(b,a,e){var d=this;var c=b.up("form").getForm();if(c.isValid()){d.ajaxRequest(BASE_URL+"utilities/user/updatepassword",{password:Ext.JSON.encode(c.getValues())},function(f){d.showMessage({title:"SERVER MESSAGE",msg:f.msg,icon:Ext.MessageBox.INFO,buttons:Ext.MessageBox.OK});c.reset()})}else{d.showMessage({title:"ERROR MESSAGE",msg:"Form is not valid",icon:Ext.MessageBox.WARNING,buttons:Ext.MessageBox.OK})}}});