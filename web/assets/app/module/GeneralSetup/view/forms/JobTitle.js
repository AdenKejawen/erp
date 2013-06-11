Ext.define("GatotKacaErp.module.GeneralSetup.view.forms.JobTitle",{extend:"Ext.form.Panel",alias:"widget.formjobtitle",id:"formjobtitle",border:true,autoHeight:true,layout:{type:"vbox",align:"stretch"},title:"Job Title Detail",bodyStyle:"padding: 5px; background : transparent;",labelWidth:55,width:"100%",items:[{name:"jobtitle_id",xtype:"hidden"},{xtype:"fieldset",title:"Job Title Information",defaults:{fieldAlign:"left",anchor:"100%",layout:{type:"hbox"}},items:[{xtype:"fieldcontainer",fieldLabel:"Description",combineErrors:true,hideLabel:true,msgTarget:"side",layout:{type:"hbox"},defaults:{hideLabel:false,labelWidth:77,beforeLabelTextTpl:REQUIRED,flex:3},items:[{fieldLabel:"Name",xtype:"textfield",emptyText:"Job Level Name",allowBlank:false,name:"jobtitle_name",margins:"0px 5px 0px 0px"},{fieldLabel:"Level",emptyText:"Job Level",store:"GatotKacaErp.store.JobLevel",name:"jobtitle_level",displayField:"joblevel_name",valueField:"joblevel_id",xtype:"combo",queryMode:"local",editable:false,action:"level",margins:"0px 5px 0px 0px"}]},{xtype:"fieldcontainer",fieldLabel:"Description",combineErrors:true,hideLabel:true,msgTarget:"side",layout:{type:"hbox"},defaults:{hideLabel:false,labelWidth:77},items:[{fieldLabel:"Supervisor",emptyText:"Supervisor",store:"GatotKacaErp.store.JobByLevel",name:"jobtitle_parent",displayField:"jobtitle_name",valueField:"jobtitle_id",xtype:"combo",queryMode:"local",editable:false,flex:3,margins:"0px 5px 0px 0px"},{fieldLabel:"Status",beforeLabelTextTpl:REQUIRED,xtype:"checkboxfield",name:"jobtitle_status",flex:1,checked:true}]}]}],tbar:[{text:"Save",iconCls:"icon-disk",action:"save"},{text:"Reset",iconCls:"icon-error",action:"reset"}]});