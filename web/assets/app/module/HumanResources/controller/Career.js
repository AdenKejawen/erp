Ext.define("GatotKacaErp.module.HumanResources.controller.Career",{extend:"GatotKacaErp.controller.Base",views:["GatotKacaErp.module.HumanResources.view.Career"],store:"GatotKacaErp.module.HumanResources.store.Career",fmSelector:"formcareer",init:function(){var b=this;var a=b.getStore(b.store);a.addListener("load",b.onStoreLoad,b);b.loadStore(a);b.getStore("GatotKacaErp.module.HumanResources.store.CareerHistory");b.getStore("GatotKacaErp.store.Company").load();b.getStore("GatotKacaErp.store.CareerOldJobTitle");b.getStore("GatotKacaErp.store.CareerNewJobTitle");b.getStore("GatotKacaErp.store.CareerOldSupervisor");b.getStore("GatotKacaErp.store.CareerNewSupervisor");b.control({"gridcareer textfield[action=search]":{keypress:b.search},"gridcareer button[action=refresh]":{click:b.reloadStore},gridcareer:{itemclick:b.view},"formcareer button[action=reset]":{click:b.resetForm},"formcareer button[action=save]":{click:b.save},"formcareer combo[action=jobtitle]":{select:b.selectedJobtitle}});b.callParent(arguments)},search:function(d,a,c){var b=this;if(a.ENTER==a.getKey()){b.loadStore(b.store,{query:d.getValue()})}},reloadStore:function(){this.loadStore(this.store)},view:function(d,c,h,a,b,g){var f=this;var e=f.getForm(f.fmSelector);f.loadStore("GatotKacaErp.module.HumanResources.store.CareerHistory",{employee_id:c.data.employee_id},function(){e.setValues(c.data);f.setUpForm(e,c.data)})},setUpForm:function(b,c){var a=this;a.loadStore("GatotKacaErp.store.CareerOldJobTitle",{query:c.employee_jobtitlename},function(d){b.findField("career_old_company").setValue(c.employee_companyid);b.findField("career_old_jobtitle").setValue(c.employee_jobtitleid);a.setLevel(d[0].data.level);a.getEmployeeByJobTitle(d[0].data.jobtitle_id,"GatotKacaErp.store.CareerOldSupervisor",function(){b.findField("career_old_supervisor").setValue(c.employee_supervisorid)})})},resetForm:function(b,a,c){b.up("form").getForm().reset()},save:function(b,a,e){var d=this;var c=b.up("form").getForm();if(c.isValid()){d.ajaxRequest(BASE_URL+"human_resources/employee/savecareer",{career:Ext.JSON.encode(c.getValues())},function(f){d.showMessage({title:"SERVER MESSAGE",msg:f.msg,icon:Ext.MessageBox.INFO,buttons:Ext.MessageBox.OK});d.getStore(d.store).removeAll();d.reloadStore();d.resetForm(b,a,e)})}else{d.showMessage({title:"ERROR MESSAGE",msg:"Form is not valid",icon:Ext.MessageBox.WARNING,buttons:Ext.MessageBox.OK})}},selectedJobtitle:function(d,a,b){var c=this.getForm(this.fmSelector).findField("career_supervisor");this.setLevel(a[0].data.level);this.getEmployeeByJobTitle(a[0].data.jobtitle_id,"GatotKacaErp.store.CareerNewSupervisor")},getEmployeeByJobTitle:function(a,b,d){var c=this;c.loadStore(b,{jobtitle_id:a},function(){if(d&&typeof(d)==="function"){d()}})},setLevel:function(b){var a=this.getForm(this.fmSelector).findField("career_supervisor");if(b===1){a.setValue(null);a.setReadOnly(true);a.allowBlank=true}else{a.setReadOnly(false);a.allowBlank=false}}});